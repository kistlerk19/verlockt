<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rules\File;

class StorePostRequest extends FormRequest
{
    public static array $extensions = ['jpg', 'jpeg', 'png', 'webp',
        'gif', 'mp3', 'mp4', 'wav', 'doc', 'docx', 'ppt',
        'pdf', 'csv', 'xls', 'xlsx', 'pptx', 'zip'];
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'body' => ['nullable', 'string'],
            'attachments' => [
                'array',
                'max:10',
                ],
            'attachments.*' => [
                'file',
                File::types(self::$extensions)->max(500 * 1024 * 1024),
            ],
            'user_id' => ['numeric'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => auth()->user()->id,
            'body' => $this->input('body') ?: "",
        ]);
    }
}
// function ($attribute, $value, $fail) {
//     $totalSize = collect($value)->sum(fn(UploadedFile $file) => $file->getSize());
//     if ($totalSize > 1000000) {
//         $fail('The total size of all files must not exceed 1GB.');
//     }
// },
