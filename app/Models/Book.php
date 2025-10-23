<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
         use HasFactory;

      protected $fillable = [
    'title',
    'author',
    'description',
    'quantity',
    'published_date',
    'cover_image',
];

    public function bookLoans(): HasMany
    {
        return $this->hasMany(BookLoan::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
