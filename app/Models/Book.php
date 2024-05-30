<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    use HasFactory;

    // relationship with review table
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // events
    protected static function booted() : void
    {
        // forget the cache of the book when it is updated or deleted
        static::updated(fn(Book $book) => cache()->forget('book_'.$book->id) );
        static::deleted(fn(Book $book) => cache()->forget('book_'.$book->id) );
    }

    // search by title
    public function scopeTitle(Builder $query , string $title) : Builder 
    {
        return $query->where('title' , 'LIKE' , '%'. $title .'%');
    }

    // retrieve book with review_count & reviews_avg_rating
    public function scopeWithReviewsCount(Builder $query, $from = null , $to = null) : Builder
    {
        return $query->withCount(['reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from , $to)]);
    }
    public function scopeWithAvgRating(Builder $query, $from = null , $to = null) : Builder
    {
        return $query->withAvg(['reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from , $to) ] , 'rating');
    }

    // private function to filter retrieved data between two given dates
    private function dateRangeFilter(Builder $query , $from = null, $to = null) 
    {
        if(!$from && $to){
            $query->where('created_at', '<=' , $to);
        }elseif($from && !$to){
            $query->where('created_at', '>=' , $from);
        }elseif($from && $to){
            $query->whereBetween('created_at', [$from, $to] );
        }
    }

    // retrieve ordered books based on reviews_count & reviews_avg_rating
    public function scopePopular(Builder $query , $from = null , $to = null) : Builder
    {
        return $query->withReviewsCount($from , $to)->orderBy('reviews_count','desc');
    }
    public function scopeHighestRated(Builder $query, $from = null , $to = null) : Builder
    {
        return $query->withAvgRating($from , $to)->orderBy('reviews_avg_rating','desc');
    }

    // retrieve books with a given minimum reviews_count
    public function scopeMinReviews(Builder $query , $min) : Builder
    {
        return $query->having('reviews_count','>=', $min);
    }

    // retrieve popular/ highest rated books 
    public function scopePopularLastMonth(Builder $query) : Builder
    {
        return $query->popular(now()->subMonth() , now())
            ->highestRated(now()->subMonth() , now())
            ->minReviews(2);
    }
    public function scopePopularLast6Months(Builder $query) : Builder
    {
        return $query->popular(now()->subMonths(6) , now())
            ->highestRated(now()->subMonths(6) , now())
            ->minReviews(5);
    }
    public function scopeHighestRatedLastMonth(Builder $query) : Builder
    {
        return $query->highestRated(now()->subMonth() , now())
            ->popular(now()->subMonth() , now())
            ->minReviews(2);
    }
    public function scopeHighestRatedLast6Months(Builder $query) : Builder
    {
        return $query->highestRated(now()->subMonths(6) , now())
            ->popular(now()->subMonths(6) , now())
            ->minReviews(5);
    }

}
