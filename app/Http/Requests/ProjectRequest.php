<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tech_stack' => 'nullable|array',
            'tech_stack.*' => 'string|max:100',
            'project_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'featured_image' => 'nullable|file|image|max:5120',
            'status' => 'nullable|in:published,draft',
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id',
        ];

        if ($this->isMethod('post')) {
            // on create, ensure title/description present (already required)
        }

        return $rules;
    }
}
