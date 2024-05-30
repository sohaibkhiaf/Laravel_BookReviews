@extends('layouts.app')

@section('content')

    <h1 class="books-header">Books</h1>

    <form class="search-form" method="GET" action="{{ route('books.index') }}">
        <input class="search-field" type="text" name="title" placeholder="Search by title" value="{{ request('title') }}" />
        <input class="filter-field" type="hidden" name="filter" value="{{ request('filter') }}"/>
        <button class="search-button" type="submit">Search</button>
        <a class="clear-button" href=" {{ route('books.index') }} ">Clear</a>
    </form>

    <div class="filter-container">
        @php
            $filter = [
                "" => "Latest",
                "popular_last_month" => "Popular Last Month",
                "popular_last_6months" => "Popular Last 6 Months",
                "highest_rated_last_month" => "Highest Rated Last Month",
                "highest_rated_last_6months" => "Highest Rated Last 6 Months",
            ];
        @endphp

        @foreach ($filter as $key => $label)
            
            @if (request('filter') === $key || request('filter') === null && $key === '')
                <a class="applied-filter" href="{{ route('books.index' , [...request()->query() , 'filter' => $key]) }}">
                    {{ $label }}
                </a>
            @else
                <a class="unapplied-filter" href="{{ route('books.index' , [...request()->query() , 'filter' => $key]) }}">
                    {{ $label }}
                </a>
            @endif
            
        @endforeach

    </div>

    <ul class="books-list">
        @forelse ($books as $book)
            <li class="book-list-item">
                <a class="book-item-container" href="{{ route('books.show' , ['book' => $book->id]) }}">
                    <div class="title-and-author">
                        {{-- <a class="book-title" href="{{ route('books.show' , ['book' => $book->id]) }}" > {{ $book->title }} </a> --}}
                        <p class="book-title"> {{ $book->title }} </p>
                        <span class="book-author">by {{ $book->author }}</span>
                    </div>
                    <div class="rating-and-count">
                        <div class="book-rating">
                            <x-star-rating rating="{{ round($book->reviews_avg_rating) }}" />
                            ({{ number_format( $book->reviews_avg_rating , 1)}})
                        </div>
                        <div class="book-review-count">
                            out of {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
                        </div>
                    </div>
                </a>
            </li>
        @empty
            <li class="empty-list-item">
                <div class="empty-book-item">
                    <p class="empty-text">No books found</p>
                    <a class="reset-link" href="{{ route('books.index') }}">Reset criteria</a>
                </div>
            </li>
        @endforelse
    </ul>
@endsection