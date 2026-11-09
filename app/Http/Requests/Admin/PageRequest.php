<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $editorMode = $this->input('editor_mode');
        $designMethod = $this->input('design_method');

        if (empty($editorMode) && ! empty($designMethod)) {
            $editorMode = ($designMethod === 'builder' || $designMethod === 'visual') ? 'visual' : 'html';
        } elseif (empty($designMethod) && ! empty($editorMode)) {
            $designMethod = $editorMode === 'visual' ? 'builder' : 'html';
        }

        $content = $this->input('content') ?? $this->input('html_content');
        $htmlContent = $this->input('html_content') ?? $this->input('content');

        $mergeData = [
            'editor_mode' => $editorMode ?: 'html',
            'design_method' => $designMethod ?: 'html',
            'content' => $content,
            'html_content' => $htmlContent,
        ];

        if ($this->has('slug') && is_string($this->input('slug'))) {
            $mergeData['slug'] = trim($this->input('slug'), '/');
        }

        $this->merge($mergeData);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $pageId = $this->route('page') ? $this->route('page')->id : null;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\-_\/]+$/',
                Rule::unique('pages', 'slug')->ignore($pageId),
            ],
            'content' => ['nullable', 'string'],
            'html_content' => ['nullable', 'string'],
            'builder_data' => ['nullable', 'string'],
            'editor_mode' => ['nullable', 'string', Rule::in(['visual', 'html'])],
            'design_method' => ['nullable', 'string', Rule::in(['builder', 'html', 'visual'])],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'slug.regex' => 'Format slug hanya boleh berisi huruf, angka, strip (-), garis bawah (_), dan garis miring (/) untuk struktur bersarang (contoh: skm/tw1).',
        ];
    }
}
