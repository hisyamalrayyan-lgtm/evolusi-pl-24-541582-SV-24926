<?php

namespace Database\Seeders;

use App\Models\Tugas;
use Illuminate\Database\Seeder;

class TugasSeeder extends Seeder
{
    /**
     * Isi tabel tugas dengan beberapa data contoh.
     * Tidak memakai factory/faker supaya bisa jalan di image produksi (--no-dev).
     */
    public function run(): void
    {
        $data = [
            ['judul' => 'Belajar Laravel', 'deskripsi' => 'Membuat CRUD tugas', 'status' => 'selesai'],
            ['judul' => 'Setup CI/CD', 'deskripsi' => 'GitHub Actions empat tahap', 'status' => 'selesai'],
            ['judul' => 'Frontend Vue 3', 'deskripsi' => 'Menampilkan data dari API', 'status' => 'selesai'],
            ['judul' => 'Containerisasi Docker', 'deskripsi' => 'Dockerfile dengan layer cache', 'status' => 'pending'],
        ];

        foreach ($data as $item) {
            Tugas::firstOrCreate(['judul' => $item['judul']], $item);
        }
    }
}
