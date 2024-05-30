<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;

class Review extends Model
{
    use HasFactory;

    // for mass assignement
    protected $fillable = ['review' , 'rating' ];

    // relationship with book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // events
    protected static function booted() : void
    {
        // forget the cache of the book when a review belongs to it is updated, deleted or created
        static::updated(fn(Review $review) => cache()->forget('book_'.$review->book_id));
        static::deleted(fn(Review $review) => cache()->forget('book_'.$review->book_id));
        static::created(fn(Review $review) => cache()->forget('book_'.$review->book_id));
    }

}
