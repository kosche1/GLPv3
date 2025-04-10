<?php

namespace App\Http\Controllers;

use App\Models\HelpCategory;
use App\Models\HelpArticle;
use App\Models\Faq;
use Illuminate\Http\Request;

class HelpCenterController extends Controller
{
    /**
     * Display the help center home page.
     */
    public function index()
    {
        // Get active categories
        $categories = HelpCategory::where('is_active', true)
            ->orderBy('order')
            ->get();

        // Get featured articles
        $featuredArticles = HelpArticle::where('is_published', true)
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Get popular articles based on view count
        $popularArticles = HelpArticle::where('is_published', true)
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        // Get FAQs
        $faqs = Faq::where('is_active', true)
            ->orderBy('order')
            ->take(4)
            ->get();

        return view('help-center', compact('categories', 'featuredArticles', 'popularArticles', 'faqs'));
    }

    /**
     * Display a specific help category and its articles.
     */
    public function category(HelpCategory $category)
    {
        // Ensure the category is active
        if (!$category->is_active) {
            abort(404);
        }

        // Get articles for this category
        $articles = $category->articles()
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('help-category', compact('category', 'articles'));
    }

    /**
     * Display a specific help article.
     */
    public function article(HelpCategory $category, HelpArticle $article)
    {
        // Ensure the article belongs to the specified category and is published
        if ($article->help_category_id !== $category->id || !$article->is_published) {
            abort(404);
        }

        // Increment view count
        $article->incrementViewCount();

        // Get related articles from the same category
        $relatedArticles = HelpArticle::where('help_category_id', $category->id)
            ->where('id', '!=', $article->id)
            ->where('is_published', true)
            ->orderBy('views_count', 'desc')
            ->take(3)
            ->get();

        return view('help-article', compact('category', 'article', 'relatedArticles'));
    }

    /**
     * Display all FAQs.
     */
    public function faqs()
    {
        // Get all active FAQs grouped by category
        $categories = HelpCategory::where('is_active', true)
            ->with(['faqs' => function ($query) {
                $query->where('is_active', true)->orderBy('order');
            }])
            ->orderBy('order')
            ->get();

        return view('help-faqs', compact('categories'));
    }

    /**
     * Search for help content.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Search in articles
        $articles = HelpArticle::where('is_published', true)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->orderBy('views_count', 'desc')
            ->take(10)
            ->get();

        // Search in FAQs
        $faqs = Faq::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('question', 'like', "%{$query}%")
                  ->orWhere('answer', 'like', "%{$query}%");
            })
            ->orderBy('order')
            ->take(10)
            ->get();

        return view('help-search', compact('query', 'articles', 'faqs'));
    }
}
