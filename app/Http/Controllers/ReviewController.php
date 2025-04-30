<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookReview;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $existingReview = BookReview::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->first();

        if ($existingReview) {
            $existingReview->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);

            return back()->with('success', 'Đánh giá của bạn đã được cập nhật!');
        }

        BookReview::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá sách!');
    }

    public function destroy(BookReview $review)
    {
        if ($review->user_id !== Auth::id()) {
            return back()->with('error', 'Bạn không có quyền xóa đánh giá này!');
        }

        $review->delete();
        return back()->with('success', 'Đánh giá đã được xóa!');
    }
}
