<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSpmbReportRequest extends FormRequest
{
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category' => ['nullable', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:25'],
            'address' => ['required', 'string', 'max:1000'],
            'message' => ['required', 'string', 'max:5000'],
            'evidence_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'category' => 'Kategori Pengaduan SPMB',
            'name' => 'Nama Lengkap Pelapor',
            'email' => 'Alamat Email',
            'phone' => 'Nomor HP / WhatsApp',
            'address' => 'Alamat Lengkap',
            'message' => 'Uraian Isi Pengaduan',
            'evidence_file' => 'Berkas Bukti Lampiran',
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'email' => 'Format :attribute tidak valid.',
            'max' => ':attribute maksimal :max karakter.',
            'evidence_file.mimes' => 'Berkas bukti lampiran harus berupa file PDF, JPG, JPEG, atau PNG.',
            'evidence_file.max' => 'Ukuran berkas bukti lampiran maksimal 5 MB.',
        ];
    }
}
