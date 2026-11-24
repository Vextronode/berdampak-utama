<?php

namespace App\Http\Controllers\Apanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apanel\StoreFieldPostRequest;
use App\Models\FieldPost;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class FieldPostManagementController extends Controller
{
    public function index(): View
    {
        $posts = FieldPost::with('project')
            ->orderByDesc('activity_date')
            ->orderByDesc('id')
            ->get();

        $projects = Project::orderByDesc('year')->orderBy('title')->get(['id', 'title', 'year']);

        return view('apanel.field-posts.index', [
            'posts' => $posts,
            'projects' => $projects,
            'postCount' => $posts->count(),
            'publishedCount' => $posts->where('is_published', true)->count(),
            'draftCount' => $posts->where('is_published', false)->count(),
        ]);
    }

    public function create(): View
    {
        return view('apanel.field-posts.create', [
            'projects' => Project::orderByDesc('year')->orderBy('title')->get(['id', 'title', 'year']),
        ]);
    }

    public function store(StoreFieldPostRequest $request): RedirectResponse
    {
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('field-posts/covers', 'public');
            $coverPath = '/storage/' . $path;
        }

        $post = FieldPost::create([
            'project_id' => $request->input('project_id'),
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'activity_date' => $request->input('activity_date'),
            'cover_image' => $coverPath,
            'summary' => $request->input('summary'),
            'content' => $request->input('content'),
            'is_published' => $request->boolean('is_published', true),
        ]);

        $statusText = $post->is_published ? 'dipublikasikan ke halaman publik' : 'disimpan sebagai draft';

        return redirect()
            ->route('apanel.field-posts.index')
            ->with('status', "Catatan lapangan '{$post->title}' berhasil {$statusText}.");
    }

    public function edit(FieldPost $fieldPost): View
    {
        return view('apanel.field-posts.edit', [
            'post' => $fieldPost,
            'projects' => Project::orderByDesc('year')->orderBy('title')->get(['id', 'title', 'year']),
        ]);
    }

    public function update(StoreFieldPostRequest $request, FieldPost $fieldPost): RedirectResponse
    {
        $coverPath = $fieldPost->cover_image;
        if ($request->boolean('remove_cover_image')) {
            $this->deleteStorageFile($coverPath);
            $coverPath = null;
        }
        if ($request->hasFile('cover_image')) {
            $this->deleteStorageFile($fieldPost->cover_image);
            $path = $request->file('cover_image')->store('field-posts/covers', 'public');
            $coverPath = '/storage/' . $path;
        }

        $fieldPost->update([
            'project_id' => $request->input('project_id'),
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'activity_date' => $request->input('activity_date'),
            'cover_image' => $coverPath,
            'summary' => $request->input('summary'),
            'content' => $request->input('content'),
            'is_published' => $request->boolean('is_published', $fieldPost->is_published),
        ]);

        $statusText = $fieldPost->is_published ? 'diperbarui dan ditayangkan' : 'diperbarui dan disimpan sebagai draft';

        return redirect()
            ->route('apanel.field-posts.index')
            ->with('status', "Catatan lapangan '{$fieldPost->title}' berhasil {$statusText}.");
    }

    public function togglePublish(FieldPost $fieldPost): RedirectResponse
    {
        $fieldPost->update([
            'is_published' => ! $fieldPost->is_published,
        ]);

        $statusText = $fieldPost->is_published ? 'ditayangkan ke halaman publik' : 'dipindahkan ke draft';

        return redirect()
            ->route('apanel.field-posts.index')
            ->with('status', "Status catatan '{$fieldPost->title}' berhasil {$statusText}.");
    }

    public function destroy(FieldPost $fieldPost): RedirectResponse
    {
        $title = $fieldPost->title;
        $this->deleteStorageFile($fieldPost->cover_image);
        $fieldPost->delete();

        return redirect()
            ->route('apanel.field-posts.index')
            ->with('status', "Catatan lapangan '{$title}' berhasil dihapus.");
    }

    private function deleteStorageFile(?string $publicPath): void
    {
        if (! $publicPath || ! str_starts_with($publicPath, '/storage/')) {
            return;
        }

        $relativePath = Str::after($publicPath, '/storage/');
        if ($relativePath !== '' && Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}
