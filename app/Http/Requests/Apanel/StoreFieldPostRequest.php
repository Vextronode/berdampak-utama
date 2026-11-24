<?php

namespace App\Http\Requests\Apanel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFieldPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $postId = $this->route('fieldPost')?->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('field_posts', 'slug')->ignore($postId)],
            'activity_date' => ['required', 'date'],
            'project_id' => ['nullable', 'exists:projects,id'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'remove_cover_image' => ['nullable', 'boolean'],
            'summary' => ['nullable', 'string', 'max:300'],
            'content' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul catatan kegiatan wajib diisi.',
            'slug.required' => 'Slug URL catatan wajib diisi.',
            'slug.unique' => 'Slug URL catatan sudah pernah digunakan.',
            'activity_date.required' => 'Tanggal kegiatan wajib diisi.',
            'activity_date.date' => 'Format tanggal kegiatan tidak valid.',
            'project_id.exists' => 'Proyek yang dipilih tidak ditemukan.',
            'cover_image.image' => 'File sampul harus berupa gambar.',
            'cover_image.max' => 'Ukuran gambar sampul maksimal 3MB.',
            'summary.max' => 'Ringkasan maksimal 300 karakter.',
            'content.required' => 'Isi cerita kegiatan wajib diisi.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('slug')) {
            $rawSlug = (string) $this->input('slug');
            $cleanSlug = str_replace('/catatan/', '', $rawSlug);
            $cleanSlug = trim($cleanSlug, '/');
            $cleanSlug = preg_replace('/[^a-z0-9\-]/i', '', $cleanSlug);
            $cleanSlug = strtolower(trim($cleanSlug));

            $this->merge([
                'slug' => $cleanSlug,
            ]);
        }

        if ($this->has('project_id') && $this->input('project_id') === '') {
            $this->merge(['project_id' => null]);
        }

        if ($this->has('is_published')) {
            $this->merge([
                'is_published' => filter_var($this->input('is_published'), FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }
}
