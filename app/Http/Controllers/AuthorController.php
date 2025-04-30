<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::with('books')->paginate(10);
        return view('authors.index', compact('authors'));
    }

    public function show(Author $author)
    {
        $author->load('books');
        return view('authors.show', compact('author'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('authors.index')->with('error', 'Bạn không có quyền thêm tác giả mới.');
        }

        return view('authors.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Bạn không có quyền thêm tác giả mới.'], 403);
            }
            return redirect()->route('authors.index')->with('error', 'Bạn không có quyền thêm tác giả mới.');
        }

        $validator = validator()->make($request->all(), [
            'name' => 'required|max:255',
            'biography' => 'required|string',
            'nationality' => 'required|string|max:100',
            'birth_date' => 'required|date|before_or_equal:today',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $author = Author::create([
            'name' => $request->name,
            'biography' => $request->biography,
            'nationality' => $request->nationality,
            'birth_date' => $request->birth_date,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Tác giả đã được thêm thành công!',
                'author' => $author
            ]);
        }

        return redirect()->route('authors.index')->with('success', 'Tác giả mới đã được thêm thành công!');
    }

    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'nationality' => 'required|string|max:100',
            'birth_date' => 'required|date|before_or_equal:today',
            'biography' => 'required|string'
        ], [
            'name.required' => 'Tên tác giả là bắt buộc.',
            'nationality.required' => 'Quốc tịch là bắt buộc.',
            'birth_date.required' => 'Ngày sinh là bắt buộc.',
            'birth_date.before_or_equal' => 'Ngày sinh không thể là ngày trong tương lai.',
            'biography.required' => 'Tiểu sử là bắt buộc.'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $author->update([
            'name' => $request->name,
            'nationality' => $request->nationality,
            'birth_date' => $request->birth_date,
            'biography' => $request->biography
        ]);

        return redirect()->route('authors.show', $author->id)
            ->with('success', 'Tác giả đã được cập nhật thành công!');
    }

    public function destroy(Author $author)
    {
        $author->books()->detach();
        $author->delete();

        return redirect()->route('authors.index')
            ->with('success', 'Tác giả đã được xóa thành công!');
    }
}
