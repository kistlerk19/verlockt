<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rules\File;

class StorePostRequest extends FormRequest
{
    public static array $extensions = ['jpg', 'jpeg', 'png', 'webp', 'svg',
        'gif', 'mp3', 'mp4', 'wav', 'doc', 'docx', 'ppt', 'epub',
        'pdf', 'csv', 'xls', 'xlsx', 'pptx', 'zip'];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'body' => ['nullable', 'string'],
            'attachments' => [
                'array',
                'max:50',
                // function ($value, $fail) {
                //     $totalSize = collect($value)->sum(fn(UploadedFile $file) => $file->getSize());
                //     dd($totalSize);
                //     if ($totalSize > 1 * 1024 * 1024 * 1024) {
                //         $fail("The total size of all files must not exceed 1GB.");
                //     }
                // }
            ],
            'attachments.*' => [
                'file',
                File::types(self::$extensions),
                'max:1048576'
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

    public function messages()
    {
        return [
            'attachments.*.file' => 'Each attachment must be a file.',
            'attachments.*.mimes' => 'Invalid file type.',
            'attachments.*.max' => 'Attachment file must not exceed 1GB.',
        ];
    }
}
