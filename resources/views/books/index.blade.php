@extends('layouts.app')

@section('content')
    <h1>Books</h1>

    <form method="GET" action=" {{ route('books.index') }} ">
        <input type="text" name="title" placeholder="Search by title" value="{{ request('title') }}" />
        <input type="hidden" name="filter" value="{{ request('filter') }}"/>
        <button type="submit">Search</button>
        <a href=" {{ route('books.index') }} ">Clear</a>
    </form>

    <div>
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
                <a href="{{ route('books.index' , [...request()->query() , 'filter' => $key]) }}" style="text-decoration: none; color: #000">
                    {{ $label }}
                </a>
            @else
                <a href="{{ route('books.index' , [...request()->query() , 'filter' => $key]) }}">
                    {{ $label }}
                </a>
            @endif
            
        @endforeach

    </div>

    <ul>
        @forelse ($books as $book)
            <li>
                <div class="book-item">
                <div>
                    <div>
                    <a href="{{ route('books.show' , ['book' => $book->id]) }}" class="book-title"> {{ $book->title }} </a>
                    <span>by {{ $book->author }}</span>
                    </div>
                    <div>
                    <div>
                        {{ number_format( $book->reviews_avg_rating , 1)}}
                    </div>
                    <div class="book-review-count">
                        out of {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
                    </div>
                    </div>
                </div>
                </div>
            </li>
        @empty
            <li>
                <div class="empty-book-item">
                <p class="empty-text">No books found</p>
                <a href="#" class="reset-link">Reset criteria</a>
                </div>
            </li>
        @endforelse
    </ul>
@endsection