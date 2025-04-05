<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use App\Models\ForumTopic;
use App\Models\ForumComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ForumController extends Controller
{
    /**
     * Display the forum index page with categories.
     */
    public function index()
    {
        $categories = ForumCategory::where('is_active', true)
            ->orderBy('order')
            ->get();

        $trendingTopics = ForumTopic::orderBy('views_count', 'desc')
            ->orderBy('likes_count', 'desc')
            ->orderBy('comments_count', 'desc')
            ->with('user', 'category')
            ->take(3)
            ->get();

        return view('forums', compact('categories', 'trendingTopics'));
    }

    /**
     * Display the topics in a specific category.
     */
    public function category(ForumCategory $category, Request $request)
    {
        $sort = $request->input('sort', 'latest');

        $topics = $category->topics()
            ->with('user')
            ->when($sort === 'latest', function ($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->when($sort === 'hot', function ($query) {
                return $query->orderBy('likes_count', 'desc')
                    ->orderBy('comments_count', 'desc');
            })
            ->when($sort === 'top', function ($query) {
                return $query->orderBy('likes_count', 'desc');
            })
            ->paginate(10);

        return view('forum.category', compact('category', 'topics', 'sort'));
    }

    /**
     * Display a specific topic with its comments.
     */
    public function topic(ForumCategory $category, ForumTopic $topic)
    {
        // Record view for authenticated user
        if (Auth::check()) {
            $topic->recordView(Auth::id());
        } else {
            // For guests, just increment the view count directly
            // You could also track by IP address if you want
            $topic->increment('views_count');
        }

        // Get the topic with its comments
        $topic->load(['user', 'comments' => function ($query) {
            $query->whereNull('parent_id')
                ->with(['user', 'replies.user'])
                ->orderBy('created_at', 'asc');
        }]);

        return view('forum.topic', compact('category', 'topic'));
    }

    /**
     * Show the form for creating a new topic.
     */
    public function createTopic(ForumCategory $category = null)
    {
        $categories = ForumCategory::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('forum.create-topic', compact('categories', 'category'));
    }

    /**
     * Store a newly created topic.
     */
    public function storeTopic(Request $request)
    {
        $request->validate([
            'title' => 'required|min:5|max:255',
            'content' => 'required|min:10',
            'forum_category_id' => 'required|exists:forum_categories,id',
        ]);

        $topic = new ForumTopic();
        $topic->title = $request->title;
        $topic->slug = Str::slug($request->title) . '-' . Str::random(5);
        $topic->content = $request->content;
        $topic->user_id = Auth::id();
        $topic->forum_category_id = $request->forum_category_id;
        $topic->save();

        $category = ForumCategory::find($request->forum_category_id);

        return redirect()->route('forum.topic', [$category->slug, $topic->slug])
            ->with('success', 'Topic created successfully!');
    }

    /**
     * Store a new comment.
     */
    public function storeComment(Request $request, $topic)
    {
        $request->validate([
            'content' => 'required|min:2',
            'parent_id' => 'nullable|exists:forum_comments,id',
        ]);

        // Find the topic by ID
        $topicModel = ForumTopic::findOrFail($topic);

        $comment = new ForumComment();
        $comment->content = $request->content;
        $comment->user_id = Auth::id();
        $comment->forum_topic_id = $topicModel->id;
        $comment->parent_id = $request->parent_id;
        $comment->save();

        return back()->with('success', 'Comment added successfully!');
    }

    /**
     * Like or unlike a topic or comment.
     */
    public function like(Request $request)
    {
        $request->validate([
            'likeable_id' => 'required|integer',
            'likeable_type' => 'required|in:topic,comment',
            'is_like' => 'required|boolean',
        ]);

        $user = Auth::user();
        $likeableType = $request->likeable_type === 'topic'
            ? ForumTopic::class
            : ForumComment::class;
        $likeableId = $request->likeable_id;

        // Check if the likeable item exists
        $likeable = $likeableType::find($likeableId);
        if (!$likeable) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        // Check if the user has already liked/disliked this item
        $existingLike = $likeable->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            if ($existingLike->is_like === $request->is_like) {
                // User is toggling the like/dislike off
                $existingLike->delete();
                $action = 'removed';
            } else {
                // User is changing from like to dislike or vice versa
                $existingLike->is_like = $request->is_like;
                $existingLike->save();
                $action = $request->is_like ? 'liked' : 'disliked';
            }
        } else {
            // User is adding a new like/dislike
            $likeable->likes()->create([
                'user_id' => $user->id,
                'is_like' => $request->is_like,
            ]);
            $action = $request->is_like ? 'liked' : 'disliked';
        }

        // Return the updated likes count
        return response()->json([
            'likes_count' => $likeable->likes_count,
            'action' => $action,
        ]);
    }

    /**
     * Search for topics.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return redirect()->route('forum.index');
        }

        $topics = ForumTopic::where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->with('user', 'category')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('forum.search', compact('topics', 'query'));
    }
}
