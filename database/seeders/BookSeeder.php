<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::insert([
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'description' => 'Kisah inspiratif anak-anak dari Belitung yang penuh semangat dan harapan.',
                'cover_image' => 'cover1.jpg',
                'quantity' => 10,
                'published_date' => '2005-09-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'description' => 'Panduan membangun kebiasaan baik dan menghilangkan kebiasaan buruk.',
                'cover_image' => 'cover2.jpg',
                'quantity' => 7,
                'published_date' => '2018-10-16',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => "Harry Potter and the Sorcerer's Stone",
                'author' => 'J.K. Rowling',
                'description' => 'Petualangan pertama Harry Potter di Hogwarts.',
                'cover_image' => 'cover3.jpg',
                'quantity' => 5,
                'published_date' => '1997-06-26',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Filosofi Teras',
                'author' => 'Henry Manampiring',
                'description' => 'Buku pengantar filsafat Stoa yang mudah dipahami dan relevan untuk kehidupan modern.',
                'cover_image' => null,
                'quantity' => 8,
                'published_date' => '2018-08-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'description' => 'Novel klasik tentang keadilan dan kemanusiaan di Amerika Selatan.',
                'cover_image' => null,
                'quantity' => 6,
                'published_date' => '1960-07-11',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
