<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'published_year',
        'isbn'
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_authors');
    }

    public function reviews()
    {
        return $this->hasMany(BookReview::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }
}
