<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreGuestbookRequest extends FormRequest
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
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'string', 'in:L,P'],
            'usia' => ['required', 'integer', 'min:1', 'max:120'],
            'telepon' => ['nullable', 'string', 'max:20'],
            'pendidikan' => ['required', 'string', 'max:50'],
            'pekerjaan' => ['required', 'string', 'max:50'],
            'status_kepegawaian' => ['required', 'string', 'max:50'],
            'asal_instansi' => ['required', 'string', 'max:255'],
            'asal_kabupaten' => ['required', 'string', 'max:100'],
            'jenis_layanan' => ['required', 'string', 'max:255'],
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
            'nama' => 'Nama Lengkap',
            'jenis_kelamin' => 'Jenis Kelamin',
            'usia' => 'Usia',
            'telepon' => 'Nomor Telepon/WhatsApp',
            'pendidikan' => 'Pendidikan Terakhir',
            'pekerjaan' => 'Pekerjaan/Profesi',
            'status_kepegawaian' => 'Status Kepegawaian',
            'asal_instansi' => 'Asal Instansi/Sekolah',
            'asal_kabupaten' => 'Asal Kabupaten/Kota',
            'jenis_layanan' => 'Jenis Layanan',
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
            'integer' => ':attribute harus berupa angka bulat.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'min' => ':attribute minimal bernilai :min.',
            'in' => ':attribute yang dipilih tidak valid (gunakan L untuk Laki-laki atau P untuk Perempuan).',
        ];
    }
}
