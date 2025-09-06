@php
    $newsItems = \App\Models\News::published()->recent()->get();
@endphp

<div class="news-list">
    <h2>Latest News</h2>
    <ul>
        @foreach ($newsItems as $news)
            <li>
                <a href="/news/{{ $news->slug }}">
                    {{ $news->title }}
                </a>
                <span>{{ $news->published_at->format('M d, Y') }}</span>
            </li>
        @endforeach
    </ul>
</div>
