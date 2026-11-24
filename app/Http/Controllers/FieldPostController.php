<?php

namespace App\Http\Controllers;

use App\Models\FieldPost;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FieldPostController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $projectSlug = trim((string) $request->query('proyek', ''));

        $query = FieldPost::published()
            ->with('project')
            ->latest('activity_date')
            ->latest('id');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($projectSlug !== '') {
            $query->whereHas('project', function ($q) use ($projectSlug) {
                $q->where('slug', $projectSlug);
            });
        }

        $posts = $query->paginate(9)->withQueryString();

        $projects = Project::published()
            ->whereHas('fieldPosts', function ($q) {
                $q->where('is_published', true);
            })
            ->orderByDesc('year')
            ->orderBy('title')
            ->get(['id', 'title', 'slug', 'year']);

        return view('field-posts.index', [
            'posts' => $posts,
            'projects' => $projects,
            'search' => $search,
            'selectedProjectSlug' => $projectSlug,
        ]);
    }

    public function show(string $slug): View
    {
        $post = FieldPost::published()
            ->with('project')
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedPosts = FieldPost::published()
            ->with('project')
            ->where('id', '!=', $post->id)
            ->latest('activity_date')
            ->latest('id')
            ->take(3)
            ->get();

        return view('field-posts.show', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ]);
    }
}
