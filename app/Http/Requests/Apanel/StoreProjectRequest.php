<?php

namespace App\Http\Requests\Apanel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $projectId = $this->route('project')?->id;

        return [
            // Card 1
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('projects', 'slug')->ignore($projectId)],
            'year' => ['required', 'integer', 'min:2020', 'max:2035'],
            'category' => ['required', 'string', 'max:255'],
            'partner_name' => ['required', 'string', 'max:255'],
            'live_url' => ['nullable', 'url', 'max:255'],
            'is_published' => ['nullable', 'boolean'],

            // Card 2
            'summary' => ['required', 'string', 'max:200'],
            'problem_statement' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'features' => ['nullable', 'array'],
            'features.*.icon' => ['nullable', 'string', 'max:50'],
            'features.*.title' => ['required_with:features', 'string', 'max:255'],
            'features.*.description' => ['nullable', 'string', 'max:500'],
            'gallery_images' => ['nullable', 'array', 'max:10'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'gallery_captions' => ['nullable', 'array'],
            'gallery_captions.*' => ['nullable', 'string', 'max:255'],
            'existing_gallery_urls' => ['nullable', 'array'],
            'existing_gallery_urls.*' => ['nullable', 'string', 'max:500'],

            // Card 3
            'dashboard_thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'remove_thumbnail' => ['nullable', 'boolean'],

            // Card 4
            'tech_stack_ids' => ['nullable', 'array'],
            'tech_stack_ids.*' => ['exists:tech_stacks,id'],
            'custom_tech_stacks' => ['nullable', 'string', 'max:500'],

            // Card 5
            'supervisor_name' => ['nullable', 'string', 'max:255'],
            'supervisor_title' => ['nullable', 'string', 'max:255'],
            'supervisor_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'remove_supervisor_photo' => ['nullable', 'boolean'],
            'contributors' => ['nullable', 'array'],
            'contributors.*.name' => ['required_with:contributors', 'string', 'max:255'],
            'contributors.*.npm' => ['required_with:contributors', 'string', 'max:50'],
            'contributors.*.class_year' => ['nullable', 'string', 'max:10'],
            'contributors.*.major' => ['required_with:contributors', 'string', 'max:255'],
            'contributors.*.role' => ['required_with:contributors', 'string', 'max:255'],
            'contributors.*.photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'contributors.*.existing_avatar' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul proyek wajib diisi.',
            'slug.required' => 'Slug URL proyek wajib diisi.',
            'slug.unique' => 'Slug URL proyek sudah pernah digunakan.',
            'year.required' => 'Tahun pengerjaan wajib diisi.',
            'year.integer' => 'Tahun pengerjaan harus berupa angka tahun yang valid.',
            'category.required' => 'Kategori proyek wajib diisi.',
            'partner_name.required' => 'Nama mitra atau desa binaan wajib diisi.',
            'live_url.url' => 'Format URL aplikasi live harus valid (menggunakan https://).',
            'summary.required' => 'Deskripsi singkat proyek wajib diisi.',
            'summary.max' => 'Deskripsi singkat maksimal 200 karakter.',
            'dashboard_thumbnail.image' => 'File thumbnail harus berupa gambar.',
            'dashboard_thumbnail.max' => 'Ukuran thumbnail maksimal 3MB.',
            'gallery_images.*.image' => 'File galeri harus berupa gambar valid.',
            'gallery_images.*.max' => 'Ukuran file galeri maksimal 3MB per foto.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('slug')) {
            $rawSlug = (string) $this->input('slug');
            $cleanSlug = str_replace(['/proyek/', '/projek/'], '', $rawSlug);
            $cleanSlug = trim($cleanSlug, '/');
            $cleanSlug = preg_replace('/\s+/', '-', trim($cleanSlug));
            $cleanSlug = preg_replace('/[^a-z0-9\-]/i', '', $cleanSlug);
            $cleanSlug = strtolower(trim($cleanSlug));

            $this->merge([
                'slug' => $cleanSlug,
            ]);
        }

        if ($this->has('is_published')) {
            $this->merge([
                'is_published' => filter_var($this->input('is_published'), FILTER_VALIDATE_BOOLEAN),
            ]);
        }

        if ($this->has('contributors') && is_array($this->input('contributors'))) {
            $filteredContributors = array_values(array_filter($this->input('contributors'), function ($c) {
                if (! is_array($c)) {
                    return false;
                }

                return ! empty(trim($c['name'] ?? '')) || ! empty(trim($c['npm'] ?? ''));
            }));
            $this->merge([
                'contributors' => $filteredContributors,
            ]);
        }

        if ($this->has('features') && is_array($this->input('features'))) {
            $filteredFeatures = array_values(array_filter($this->input('features'), function ($f) {
                if (! is_array($f)) {
                    return false;
                }

                return ! empty(trim($f['title'] ?? ''));
            }));
            $this->merge([
                'features' => $filteredFeatures,
            ]);
        }
    }
}
