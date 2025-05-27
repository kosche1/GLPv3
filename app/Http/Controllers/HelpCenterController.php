<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\HelpArticle;
use App\Models\HelpCategory;
use App\Models\HelpSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelpCenterController extends Controller
{
    public function index()
    {
        // Get featured categories with their articles and FAQs
        $categories = HelpCategory::active()
            ->ordered()
            ->with(['publishedArticles' => function ($query) {
                $query->ordered()->limit(4);
            }, 'publishedFaqs' => function ($query) {
                $query->ordered()->limit(4);
            }])
            ->get();

        // Get featured FAQs for the main FAQ section
        $featuredFaqs = Faq::published()
            ->featured()
            ->ordered()
            ->limit(6)
            ->get();

        // Get popular searches for suggestions
        $popularSearches = HelpSearch::getPopularSearches(5);

        // Get featured articles
        $featuredArticles = HelpArticle::published()
            ->featured()
            ->with('category')
            ->ordered()
            ->limit(6)
            ->get();

        return view('help-center', compact(
            'categories',
            'featuredFaqs',
            'popularSearches',
            'featuredArticles'
        ));
    }

    public function search(Request $request)
    {
        $query = $request->input('query', '');
        $category = $request->input('category');

        if (empty($query)) {
            return redirect()->route('help-center');
        }

        // Search in articles
        $articlesQuery = HelpArticle::published()
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%");
            });

        // Search in FAQs
        $faqsQuery = Faq::published()
            ->where(function ($q) use ($query) {
                $q->where('question', 'like', "%{$query}%")
                  ->orWhere('answer', 'like', "%{$query}%");
            });

        // Apply category filter if specified
        if ($category) {
            $categoryModel = HelpCategory::where('slug', $category)->first();
            if ($categoryModel) {
                $articlesQuery->where('help_category_id', $categoryModel->id);
                $faqsQuery->where('help_category_id', $categoryModel->id);
            }
        }

        $articles = $articlesQuery->with('category')->ordered()->get();
        $faqs = $faqsQuery->with('category')->ordered()->get();

        $totalResults = $articles->count() + $faqs->count();

        // Log the search
        HelpSearch::logSearch($query, $totalResults, Auth::id());

        $categories = HelpCategory::active()->ordered()->get();

        return view('help-center.search', compact(
            'query',
            'articles',
            'faqs',
            'totalResults',
            'categories',
            'category'
        ));
    }

    public function article(HelpArticle $article)
    {
        if (!$article->is_published) {
            abort(404);
        }

        // Increment view count
        $article->incrementViewCount();

        // Get related articles from the same category
        $relatedArticles = HelpArticle::published()
            ->where('help_category_id', $article->help_category_id)
            ->where('id', '!=', $article->id)
            ->ordered()
            ->limit(3)
            ->get();

        return view('help-center.article', compact('article', 'relatedArticles'));
    }

    public function category(HelpCategory $category)
    {
        if (!$category->is_active) {
            abort(404);
        }

        $articles = $category->publishedArticles()->ordered()->paginate(12);
        $faqs = $category->publishedFaqs()->ordered()->get();

        return view('help-center.category', compact('category', 'articles', 'faqs'));
    }

    public function markHelpful(Request $request)
    {
        $type = $request->input('type'); // 'article' or 'faq'
        $id = $request->input('id');
        $helpful = $request->boolean('helpful');

        if ($type === 'article') {
            $item = HelpArticle::findOrFail($id);
        } elseif ($type === 'faq') {
            $item = Faq::findOrFail($id);
        } else {
            return response()->json(['error' => 'Invalid type'], 400);
        }

        if ($helpful) {
            $item->markHelpful();
        } else {
            $item->markNotHelpful();
        }

        return response()->json([
            'helpful_count' => $item->helpful_count,
            'not_helpful_count' => $item->not_helpful_count,
        ]);
    }
}
