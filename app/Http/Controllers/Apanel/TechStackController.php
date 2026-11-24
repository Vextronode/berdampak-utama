<?php

namespace App\Http\Controllers\Apanel;

use App\Http\Controllers\Controller;
use App\Models\TechStack;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TechStackController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'icon_type' => ['nullable', 'in:svg_raw,cdn_url,custom_upload,monogram'],
            'brand_color' => ['nullable', 'string', 'max:7'],
            'custom_icon' => ['nullable', 'file', 'mimes:svg,png,jpg,webp', 'max:512'],
        ]);

        $name = trim($validated['name']);
        $slug = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($name);
        $brandColor = $validated['brand_color'] ?? '#1E1B64';
        $iconType = $validated['icon_type'] ?? 'monogram';
        $iconValue = null;

        // Cek apakah sudah ada dengan slug ini
        $existing = TechStack::where('slug', $slug)->first();
        if ($existing) {
            return response()->json([
                'success' => true,
                'message' => 'Teknologi sudah terdaftar dalam katalog.',
                'tech_stack' => [
                    'id' => $existing->id,
                    'name' => $existing->name,
                    'slug' => $existing->slug,
                    'icon_type' => $existing->icon_type,
                    'icon_value' => $existing->icon_value,
                    'brand_color' => $existing->brand_color,
                    'monogram' => $existing->monogram,
                ],
            ]);
        }

        // Handle custom upload icon
        if ($request->hasFile('custom_icon')) {
            $file = $request->file('custom_icon');
            $extension = strtolower($file->getClientOriginalExtension());

            if ($extension === 'svg') {
                $rawSvg = file_get_contents($file->getRealPath());
                // Sanitasi SVG sederhana: hapus script dan foreignObject
                $cleanSvg = preg_replace('/<\s*script\b[^>]*>(.*?)<\s*\/\s*script\s*>/is', '', $rawSvg);
                $cleanSvg = preg_replace('/<\s*foreignobject\b[^>]*>(.*?)<\s*\/\s*foreignobject\s*>/is', '', $cleanSvg);
                $cleanSvg = preg_replace('/\bon\w+\s*=\s*["\'][^"\']*["\']/i', '', $cleanSvg);

                $iconType = 'svg_raw';
                $iconValue = $cleanSvg;
            } else {
                $path = $file->store('tech-stacks', 'public');
                $iconType = 'custom_upload';
                $iconValue = '/storage/' . $path;
            }
        } elseif ($iconType === 'cdn_url') {
            $iconValue = "https://cdn.jsdelivr.net/npm/simple-icons/icons/{$slug}.svg";
        }

        $techStack = TechStack::create([
            'name' => $name,
            'slug' => $slug,
            'icon_type' => $iconType,
            'icon_value' => $iconValue,
            'brand_color' => $brandColor,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Stack teknologi baru berhasil ditambahkan.',
            'tech_stack' => [
                'id' => $techStack->id,
                'name' => $techStack->name,
                'slug' => $techStack->slug,
                'icon_type' => $techStack->icon_type,
                'icon_value' => $techStack->icon_value,
                'brand_color' => $techStack->brand_color,
                'monogram' => $techStack->monogram,
            ],
        ], 201);
    }

    public function search(Request $request): JsonResponse
    {
        $q = trim((string) $request->input('q', ''));
        if ($q === '') {
            $results = TechStack::orderBy('name')->limit(30)->get();
        } else {
            $results = TechStack::where('name', 'like', "%{$q}%")
                ->orWhere('slug', 'like', "%{$q}%")
                ->orderBy('name')
                ->limit(30)
                ->get();
        }

        return response()->json([
            'success' => true,
            'data' => $results,
        ]);
    }
}
