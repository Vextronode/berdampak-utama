<?php

namespace App\Http\Controllers\Apanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apanel\StoreProjectRequest;
use App\Models\Project;
use App\Models\TechStack;
use App\Support\FeatureIcons;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectManagementController extends Controller
{
    /** File lama yang baru dihapus setelah transaksi berhasil di-commit. */
    private array $filesToDelete = [];

    /** File upload baru yang dibersihkan bila transaksi gagal. */
    private array $storedUploads = [];

    public function create(): View
    {
        return view('apanel.projects.create', [
            'techStacks' => TechStack::orderBy('name')->get(),
            'user' => auth()->user(),
        ]);
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $dashboardThumbnailPath = null;
            if ($request->hasFile('dashboard_thumbnail')) {
                $dashboardThumbnailPath = $this->storeUpload($request->file('dashboard_thumbnail'), 'projects/thumbnails');
            }

            $supervisorPhotoPath = null;
            if ($request->hasFile('supervisor_photo')) {
                $supervisorPhotoPath = $this->storeUpload($request->file('supervisor_photo'), 'projects/supervisors');
            }

            $galleryData = $this->buildGalleryData($request);
            $techData = $this->resolveTechStacks($request);
            $featuresData = $this->buildFeaturesData($request);

            $project = Project::create([
                'title' => $request->input('title'),
                'slug' => $request->input('slug'),
                'year' => (int) $request->input('year'),
                'summary' => $request->input('summary'),
                'description' => $request->input('description') ?? $request->input('problem_statement'),
                'problem_statement' => $request->input('problem_statement'),
                'features' => $featuresData,
                'gallery_images' => $galleryData,
                'partner_name' => $request->input('partner_name'),
                'category' => $request->input('category'),
                'tech_stacks' => $techData['names'],
                'dashboard_thumbnail' => $dashboardThumbnailPath,
                'live_url' => $request->input('live_url'),
                'supervisor_name' => $request->input('supervisor_name'),
                'supervisor_title' => $request->input('supervisor_title'),
                'supervisor_photo_url' => $supervisorPhotoPath,
                'is_published' => $request->boolean('is_published', true),
            ]);

            $project->techStackItems()->sync($techData['ids']);
            $this->syncContributors($request, $project);

            DB::commit();
            $this->deleteQueuedFiles();

            $statusText = $project->is_published ? 'dipublikasikan ke katalog publik' : 'disimpan sebagai draft';

            return redirect()
                ->route('apanel.dashboard')
                ->with('status', "Proyek '{$project->title}' berhasil {$statusText}.");
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->discardStoredUploads();

            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal menyimpan data proyek: '.$e->getMessage()]);
        }
    }

    public function edit(Project $project): View
    {
        $project->load(['contributors', 'techStackItems']);

        return view('apanel.projects.edit', [
            'project' => $project,
            'techStacks' => TechStack::orderBy('name')->get(),
            'user' => auth()->user(),
        ]);
    }

    public function update(StoreProjectRequest $request, Project $project): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $dashboardThumbnailPath = $project->dashboard_thumbnail;
            if ($request->boolean('remove_thumbnail')) {
                $this->queueFileDeletion($dashboardThumbnailPath);
                $dashboardThumbnailPath = null;
            }
            if ($request->hasFile('dashboard_thumbnail')) {
                $this->queueFileDeletion($project->dashboard_thumbnail);
                $dashboardThumbnailPath = $this->storeUpload($request->file('dashboard_thumbnail'), 'projects/thumbnails');
            }

            $supervisorPhotoPath = $project->supervisor_photo_url;
            if ($request->boolean('remove_supervisor_photo')) {
                $this->queueFileDeletion($supervisorPhotoPath);
                $supervisorPhotoPath = null;
            }
            if ($request->hasFile('supervisor_photo')) {
                $this->queueFileDeletion($project->supervisor_photo_url);
                $supervisorPhotoPath = $this->storeUpload($request->file('supervisor_photo'), 'projects/supervisors');
            }

            $galleryData = $this->buildGalleryData($request, $project->gallery_images ?? []);
            $techData = $this->resolveTechStacks($request);
            $featuresData = $this->buildFeaturesData($request);

            $project->update([
                'title' => $request->input('title'),
                'slug' => $request->input('slug'),
                'year' => (int) $request->input('year'),
                'summary' => $request->input('summary'),
                'description' => $request->input('description') ?? $request->input('problem_statement'),
                'problem_statement' => $request->input('problem_statement'),
                'features' => $featuresData,
                'gallery_images' => $galleryData,
                'partner_name' => $request->input('partner_name'),
                'category' => $request->input('category'),
                'tech_stacks' => $techData['names'],
                'dashboard_thumbnail' => $dashboardThumbnailPath,
                'live_url' => $request->input('live_url'),
                'supervisor_name' => $request->input('supervisor_name'),
                'supervisor_title' => $request->input('supervisor_title'),
                'supervisor_photo_url' => $supervisorPhotoPath,
                'is_published' => $request->boolean('is_published', $project->is_published),
            ]);

            $project->techStackItems()->sync($techData['ids']);
            $this->syncContributors($request, $project);

            DB::commit();
            $this->deleteQueuedFiles();

            $statusText = $project->is_published ? 'diperbarui dan ditayangkan' : 'diperbarui dan disimpan sebagai draft';

            return redirect()
                ->route('apanel.dashboard')
                ->with('status', "Proyek '{$project->title}' berhasil {$statusText}.");
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->discardStoredUploads();

            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal memperbarui data proyek: '.$e->getMessage()]);
        }
    }

    public function togglePublish(Project $project): RedirectResponse
    {
        $project->update([
            'is_published' => ! $project->is_published,
        ]);

        $statusText = $project->is_published ? 'ditayangkan ke katalog publik' : 'dipindahkan ke draft';

        return redirect()
            ->route('apanel.dashboard')
            ->with('status', "Status proyek '{$project->title}' berhasil {$statusText}.");
    }

    public function destroy(Project $project): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $projectTitle = $project->title;

            $this->queueFileDeletion($project->dashboard_thumbnail);
            $this->queueFileDeletion($project->supervisor_photo_url);

            foreach ($project->gallery_images ?? [] as $item) {
                $this->queueFileDeletion($item['image_url'] ?? $item['url'] ?? null);
            }

            foreach ($project->contributors as $contributor) {
                $this->queueFileDeletion($contributor->avatar_url);
            }

            $project->techStackItems()->detach();
            $project->contributors()->delete();
            $project->delete();

            DB::commit();
            $this->deleteQueuedFiles();

            return redirect()
                ->route('apanel.dashboard')
                ->with('status', "Proyek '{$projectTitle}' beserta seluruh datanya berhasil dihapus.");
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->discardStoredUploads();

            return back()
                ->withErrors(['error' => 'Gagal menghapus proyek: '.$e->getMessage()]);
        }
    }

    private function resolveTechStacks(StoreProjectRequest $request): array
    {
        $selectedTechIds = $request->input('tech_stack_ids', []) ?? [];

        if ($request->filled('custom_tech_stacks')) {
            $customNames = array_map('trim', explode(',', $request->input('custom_tech_stacks')));
            foreach ($customNames as $cName) {
                if ($cName !== '') {
                    $slug = Str::slug($cName);
                    $tech = TechStack::firstOrCreate(
                        ['slug' => $slug],
                        [
                            'name' => $cName,
                            'icon_type' => 'monogram',
                            'icon_value' => null,
                            'brand_color' => '#1E1B64',
                        ]
                    );
                    $selectedTechIds[] = $tech->id;
                }
            }
        }

        $selectedTechIds = array_values(array_unique(array_filter($selectedTechIds)));
        $techStackNames = TechStack::whereIn('id', $selectedTechIds)->pluck('name')->toArray();

        return [
            'ids' => $selectedTechIds,
            'names' => $techStackNames,
        ];
    }

    private function buildGalleryData(StoreProjectRequest $request, array $previousGallery = []): array
    {
        $uploadedFiles = $request->file('gallery_images', []);
        $captions = $request->input('gallery_captions', []);
        $existingUrls = $request->input('existing_gallery_urls', []);

        $allowedUrls = array_filter(array_map(fn ($prev) => $prev['image_url'] ?? $prev['url'] ?? null, $previousGallery));
        $maxSlots = max(4, count($uploadedFiles), count($existingUrls), count($previousGallery));
        $galleryData = [];
        $keptUrls = [];

        for ($idx = 0; $idx < $maxSlots; $idx++) {
            $caption = $captions[$idx] ?? 'Dokumentasi kegiatan implementasi proyek';
            $file = $uploadedFiles[$idx] ?? null;

            if ($file && $file->isValid()) {
                $url = $this->storeUpload($file, 'projects/gallery');
                $galleryData[] = [
                    'image_url' => $url,
                    'caption' => $caption,
                ];
                $keptUrls[] = $url;
            } elseif (! empty($existingUrls[$idx]) && in_array($existingUrls[$idx], $allowedUrls, true)) {
                $url = $existingUrls[$idx];
                $galleryData[] = [
                    'image_url' => $url,
                    'caption' => $caption,
                ];
                $keptUrls[] = $url;
            }
        }

        foreach ($previousGallery as $prev) {
            $prevUrl = $prev['image_url'] ?? $prev['url'] ?? null;
            if ($prevUrl && ! in_array($prevUrl, $keptUrls, true)) {
                $this->queueFileDeletion($prevUrl);
            }
        }

        return $galleryData;
    }

    private function syncContributors(StoreProjectRequest $request, Project $project): void
    {
        $contributorsInput = $request->input('contributors', []);
        $existingAvatarsToKeep = [];
        $newRows = [];
        $allowedAvatars = $project->contributors->pluck('avatar_url')->filter()->all();

        if (is_array($contributorsInput)) {
            foreach ($contributorsInput as $index => $cItem) {
                if (! empty($cItem['name'])) {
                    $cAvatarUrl = in_array($cItem['existing_avatar'] ?? null, $allowedAvatars, true)
                        ? $cItem['existing_avatar']
                        : null;

                    if ($request->hasFile("contributors.{$index}.photo")) {
                        $cFile = $request->file("contributors.{$index}.photo");
                        if ($cFile && $cFile->isValid()) {
                            $this->queueFileDeletion($cAvatarUrl);
                            $cAvatarUrl = $this->storeUpload($cFile, 'projects/contributors');
                        }
                    }

                    if ($cAvatarUrl) {
                        $existingAvatarsToKeep[] = $cAvatarUrl;
                    }

                    $newRows[] = [
                        'name' => $cItem['name'],
                        'npm' => $cItem['npm'] ?? '',
                        'class_year' => $cItem['class_year'] ?? null,
                        'major' => $cItem['major'] ?? '',
                        'role' => $cItem['role'] ?? '',
                        'avatar_url' => $cAvatarUrl,
                        'sort_order' => (int) $index,
                    ];
                }
            }
        }

        foreach ($project->contributors as $oldContributor) {
            if ($oldContributor->avatar_url && ! in_array($oldContributor->avatar_url, $existingAvatarsToKeep, true)) {
                $this->queueFileDeletion($oldContributor->avatar_url);
            }
        }

        $project->contributors()->delete();

        foreach ($newRows as $row) {
            $project->contributors()->create($row);
        }
    }

    private function buildFeaturesData(StoreProjectRequest $request): array
    {
        $featuresInput = $request->input('features', []);
        $allowedKeys = array_keys(FeatureIcons::all());
        $features = [];

        if (is_array($featuresInput)) {
            foreach ($featuresInput as $fItem) {
                $title = trim((string) ($fItem['title'] ?? ''));
                if ($title !== '') {
                    $icon = (string) ($fItem['icon'] ?? 'check');
                    if (! in_array($icon, $allowedKeys, true)) {
                        $icon = 'check';
                    }

                    $features[] = [
                        'icon' => $icon,
                        'title' => $title,
                        'description' => trim((string) ($fItem['description'] ?? '')),
                    ];
                }
            }
        }

        return $features;
    }

    private function storeUpload(UploadedFile $file, string $directory): string
    {
        $publicPath = '/storage/'.$file->store($directory, 'public');
        $this->storedUploads[] = $publicPath;

        return $publicPath;
    }

    private function queueFileDeletion(?string $publicPath): void
    {
        if ($publicPath) {
            $this->filesToDelete[] = $publicPath;
        }
    }

    private function deleteQueuedFiles(): void
    {
        foreach ($this->filesToDelete as $publicPath) {
            $this->deleteStorageFile($publicPath);
        }
    }

    private function discardStoredUploads(): void
    {
        foreach ($this->storedUploads as $publicPath) {
            $this->deleteStorageFile($publicPath);
        }
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
