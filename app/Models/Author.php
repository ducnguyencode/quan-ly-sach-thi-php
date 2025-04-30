<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'biography',
        'birth_date',
        'nationality'
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_authors');
    }
}
