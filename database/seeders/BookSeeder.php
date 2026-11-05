<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            ['Pemrograman Web dengan Laravel', 'Budi Santoso', 'Informatika', 2023],
            ['Basis Data Lanjut', 'Siti Rahma', 'Andi Offset', 2022],
            ['Algoritma dan Struktur Data', 'Agus Pratama', 'Erlangga', 2021],
            ['Jaringan Komputer', 'Dewi Lestari', 'Graha Ilmu', 2020],
        ];

        foreach ($books as [$judul, $penulis, $penerbit, $tahun]) {
            Book::firstOrCreate(
                ['judul' => $judul],
                ['penulis' => $penulis, 'penerbit' => $penerbit, 'tahun_terbit' => $tahun]
            );
        }
    }
}