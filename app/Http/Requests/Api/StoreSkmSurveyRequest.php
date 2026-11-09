<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSkmSurveyRequest extends FormRequest
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
            'guestbook_id' => ['required', 'integer', 'exists:guestbooks,id'],
            'q1' => ['required', 'integer', 'min:1', 'max:4'],
            'q2' => ['required', 'integer', 'min:1', 'max:4'],
            'q3' => ['required', 'integer', 'min:1', 'max:4'],
            'q4' => ['required', 'integer', 'min:1', 'max:4'],
            'q5' => ['required', 'integer', 'min:1', 'max:4'],
            'q6' => ['required', 'integer', 'min:1', 'max:4'],
            'q7' => ['required', 'integer', 'min:1', 'max:4'],
            'q8' => ['required', 'integer', 'min:1', 'max:4'],
            'q9' => ['required', 'integer', 'min:1', 'max:4'],
            'saran' => ['nullable', 'string', 'max:2000'],
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
            'guestbook_id' => 'ID Buku Tamu',
            'q1' => 'Kesesuaian Persyaratan',
            'q2' => 'Kemudahan Prosedur',
            'q3' => 'Kecepatan Waktu Pelayanan',
            'q4' => 'Biaya / Tarif Pelayanan',
            'q5' => 'Kesesuaian Produk Pelayanan',
            'q6' => 'Kompetensi Petugas Pelayanan',
            'q7' => 'Perilaku & Keramahan Petugas',
            'q8' => 'Kualitas Sarana & Prasarana',
            'q9' => 'Penanganan Pengaduan & Masukan',
            'saran' => 'Saran & Masukan',
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
            'integer' => ':attribute harus berupa angka penilaian (1-4).',
            'min' => 'Nilai minimal :attribute adalah :min.',
            'max' => 'Nilai maksimal :attribute adalah :max.',
            'exists' => ':attribute tidak ditemukan dalam sistem.',
            'saran.max' => 'Saran & masukan maksimal 2000 karakter.',
        ];
    }
}
