@extends('layouts.app')

@section('title', $book->title)

@section('content')
    <div class="mb-6">
        <a href="{{ route('home') }}" class="text-blue-500 hover:text-blue-700 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Quay lại danh sách
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="md:flex">
            <div class="md:w-1/3 p-4 flex items-center justify-center bg-gray-100">
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="max-w-full max-h-96 object-contain">
                @else
                    <div class="w-full h-64 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                @endif
            </div>

            <div class="md:w-2/3 p-6">
                <div class="flex justify-between items-start">
                    <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $book->title }}</h1>

                    @if(auth()->user()->isAdmin())
                    <div class="flex space-x-2">
                        <a href="{{ route('books.edit', $book->id) }}" class="text-yellow-500 hover:text-yellow-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa sách này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>

                <div class="mb-4">
                    <div class="flex items-center">
                        <div class="flex items-center mr-2">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $book->average_rating)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-gray-600 text-sm">
                            {{ number_format($book->average_rating, 1) }} ({{ $book->reviews_count }} đánh giá)
                        </span>
                    </div>
                </div>

                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-2 text-gray-700">Thông tin sách</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-600">
                        @if($book->published_year)
                            <div>
                                <span class="font-medium">Năm xuất bản:</span> {{ $book->published_year }}
                            </div>
                        @endif

                        @if($book->isbn)
                            <div>
                                <span class="font-medium">ISBN:</span> {{ $book->isbn }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-2 text-gray-700">Tác giả</h2>
                    @if($book->authors->isNotEmpty())
                        <div class="flex flex-wrap gap-2">
                            @foreach($book->authors as $author)
                                <a href="{{ route('authors.show', $author->id) }}" class="inline-block bg-blue-100 text-blue-800 rounded-full px-3 py-1 text-sm font-semibold hover:bg-blue-200">
                                    {{ $author->name }}
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Chưa có thông tin tác giả</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="p-6 border-t border-gray-200">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Nội dung</h2>
            <div class="prose max-w-none text-gray-600">
                {{ $book->description }}
            </div>
        </div>

        <!-- Phần đánh giá sách -->
        <div class="p-6 border-t border-gray-200">
            <h2 class="text-xl font-semibold mb-6 text-gray-700">Đánh giá sách</h2>

            <!-- Form đánh giá -->
            <div class="mb-8 bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-3 text-gray-700">Đánh giá của bạn</h3>

                @php
                    $userReview = $book->reviews->where('user_id', auth()->id())->first();
                @endphp

                <form action="{{ route('reviews.store', $book->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Xếp hạng</label>
                        <div class="flex space-x-2 mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer">
                                    <input type="radio" name="rating" value="{{ $i }}" class="sr-only" {{ $userReview && $userReview->rating == $i ? 'checked' : '' }} required>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 star-rating {{ $userReview && $userReview->rating >= $i ? 'text-yellow-500' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </label>
                            @endfor
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="comment" class="block text-gray-700 text-sm font-medium mb-2">Nhận xét (tùy chọn)</label>
                        <textarea id="comment" name="comment" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="Chia sẻ ý kiến của bạn về cuốn sách này">{{ $userReview ? $userReview->comment : '' }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="py-2 px-4 bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white rounded-md shadow-sm">
                            {{ $userReview ? 'Cập nhật đánh giá' : 'Gửi đánh giá' }}
                        </button>
                    </div>
                </form>

                @if ($userReview)
                    <form action="{{ route('reviews.destroy', $userReview->id) }}" method="POST" class="mt-2 text-right">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="py-2 px-4 bg-red-600 hover:bg-red-700 focus:ring-red-500 focus:ring-offset-red-200 text-white rounded-md shadow-sm"
                            onclick="return confirm('Bạn có chắc muốn xóa đánh giá này?')">
                            Xóa đánh giá
                        </button>
                    </form>
                @endif
            </div>

            <!-- Danh sách đánh giá -->
            <div>
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Tất cả đánh giá ({{ $book->reviews_count }})</h3>

                @if($book->reviews->isEmpty())
                    <p class="text-gray-500 italic">Chưa có đánh giá nào cho cuốn sách này. Hãy là người đầu tiên đánh giá!</p>
                @else
                    <div class="space-y-4">
                        @foreach($book->reviews as $review)
                            <div class="border-b border-gray-200 pb-4 mb-4 last:border-0">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="flex items-center">
                                            <p class="font-medium text-gray-800">{{ $review->user->name }}</p>
                                            <span class="mx-2 text-gray-300">•</span>
                                            <p class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                        </div>
                                        <div class="flex mt-1 mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $i <= $review->rating ? 'text-yellow-500' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>

                                    @if($review->user_id === auth()->id())
                                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm"
                                                onclick="return confirm('Bạn có chắc muốn xóa đánh giá này?')">
                                                Xóa
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                @if($review->comment)
                                    <p class="text-gray-600">{{ $review->comment }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý hiệu ứng chọn sao đánh giá
            const stars = document.querySelectorAll('.star-rating');
            const ratingInputs = document.querySelectorAll('input[name="rating"]');

            ratingInputs.forEach((input, index) => {
                input.addEventListener('change', function() {
                    const rating = parseInt(this.value);

                    stars.forEach((star, starIndex) => {
                        if (starIndex < rating) {
                            star.classList.remove('text-gray-300');
                            star.classList.add('text-yellow-500');
                        } else {
                            star.classList.remove('text-yellow-500');
                            star.classList.add('text-gray-300');
                        }
                    });
                });
            });

            // Hiệu ứng hover
            stars.forEach((star, index) => {
                star.addEventListener('mouseenter', function() {
                    for (let i = 0; i <= index; i++) {
                        stars[i].classList.remove('text-gray-300');
                        stars[i].classList.add('text-yellow-500');
                    }
                    for (let i = index + 1; i < stars.length; i++) {
                        stars[i].classList.remove('text-yellow-500');
                        stars[i].classList.add('text-gray-300');
                    }
                });

                star.addEventListener('click', function() {
                    ratingInputs[index].checked = true;
                    ratingInputs[index].dispatchEvent(new Event('change'));
                });
            });

            // Container hover out - reset to selected rating
            const ratingContainer = document.querySelector('.flex.space-x-2.mb-2');
            if (ratingContainer) {
                ratingContainer.addEventListener('mouseleave', function() {
                    let selectedRating = 0;
                    ratingInputs.forEach((input, index) => {
                        if (input.checked) {
                            selectedRating = parseInt(input.value);
                        }
                    });

                    stars.forEach((star, starIndex) => {
                        if (starIndex < selectedRating) {
                            star.classList.remove('text-gray-300');
                            star.classList.add('text-yellow-500');
                        } else {
                            star.classList.remove('text-yellow-500');
                            star.classList.add('text-gray-300');
                        }
                    });
                });
            }
        });
    </script>
@endsection
