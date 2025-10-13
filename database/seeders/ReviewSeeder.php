<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Book;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get some users and books to create reviews
        $users = User::where('role', 'user')->take(5)->get();
        $books = Book::take(10)->get();

        if ($users->isEmpty() || $books->isEmpty()) {
            $this->command->warn('No users or books found. Please run UserSeeder and BookSeeder first.');
            return;
        }

        $reviews = [
            [
                'comment' => 'This book was absolutely amazing! The plot was engaging and the characters were well-developed. I couldn\'t put it down.',
                'rating' => 5,
            ],
            [
                'comment' => 'A good read overall, though it started a bit slow. The ending made up for it.',
                'rating' => 4,
            ],
            [
                'comment' => 'Interesting concept but the execution could have been better. Some parts were confusing.',
                'rating' => 3,
            ],
            [
                'comment' => 'Not my cup of tea. The writing style didn\'t resonate with me.',
                'rating' => 2,
            ],
            [
                'comment' => 'One of the best books I\'ve read this year! Highly recommend to everyone.',
                'rating' => 5,
            ],
            [
                'comment' => 'Decent book with some memorable moments. Worth reading if you have time.',
                'rating' => 3,
            ],
            [
                'comment' => 'The author\'s writing style is beautiful and poetic. The story touched my heart.',
                'rating' => 4,
            ],
            [
                'comment' => 'A masterpiece of modern literature. Every page was a delight to read.',
                'rating' => 5,
            ],
            [
                'comment' => 'Good book but nothing extraordinary. It\'s an okay read.',
                'rating' => 3,
            ],
            [
                'comment' => 'I had high expectations but was disappointed. The plot was predictable.',
                'rating' => 2,
            ],
            [
                'comment' => 'Fantastic world-building and character development. Couldn\'t recommend it more!',
                'rating' => 5,
            ],
            [
                'comment' => 'An enjoyable read with some flaws. The pacing was inconsistent.',
                'rating' => 3,
            ],
            [
                'comment' => 'The book had potential but fell flat in the second half.',
                'rating' => 2,
            ],
            [
                'comment' => 'Brilliant storytelling with unexpected twists. Loved every moment!',
                'rating' => 5,
            ],
            [
                'comment' => 'A solid read with good character development and interesting themes.',
                'rating' => 4,
            ],
        ];

        $reviewCount = 0;
        foreach ($books as $book) {
            // Create 1-3 reviews per book
            $numReviews = rand(1, 3);
            
            for ($i = 0; $i < $numReviews && $reviewCount < count($reviews); $i++) {
                $user = $users->random();
                $reviewData = $reviews[$reviewCount];
                
                // Check if this user already reviewed this book
                $existingReview = Review::where('user_id', $user->id)
                    ->where('book_id', $book->id)
                    ->exists();
                
                if (!$existingReview) {
                    Review::create([
                        'user_id' => $user->id,
                        'book_id' => $book->id,
                        'rating' => $reviewData['rating'],
                        'comment' => $reviewData['comment'],
                    ]);
                    $reviewCount++;
                }
            }
        }

        $this->command->info('Created ' . $reviewCount . ' reviews successfully!');
    }
}