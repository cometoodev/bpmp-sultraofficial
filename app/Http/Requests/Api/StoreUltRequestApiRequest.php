<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUltRequestApiRequest extends FormRequest
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
            'layanan_type' => ['nullable', 'string', 'in:online,tatap_muka,keliling'],
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'no_hp' => ['required', 'string', 'max:30'],
            'profesi' => ['nullable', 'string', 'max:100'],
            'instansi' => ['nullable', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:255'],
            'keperluan' => ['required', 'string', 'max:3000'],
            'dokumen' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
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
            'layanan_type' => 'Jenis Layanan ULT',
            'nama' => 'Nama Pemohon',
            'email' => 'Alamat Email',
            'no_hp' => 'Nomor HP / WhatsApp',
            'profesi' => 'Profesi / Jabatan',
            'instansi' => 'Asal Instansi / Sekolah',
            'kategori' => 'Kategori Layanan',
            'keperluan' => 'Maksud & Keperluan',
            'dokumen' => 'Berkas Dokumen Pendukung',
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
            'in' => ':attribute tidak valid. Pilihan: online, tatap_muka, keliling.',
            'max' => ':attribute tidak boleh melebihi :max karakter.',
            'dokumen.mimes' => 'Berkas dokumen harus berformat PDF, DOC, DOCX, JPG, JPEG, atau PNG.',
            'dokumen.max' => 'Ukuran berkas dokumen pendukung maksimal 5 MB.',
        ];
    }
}
