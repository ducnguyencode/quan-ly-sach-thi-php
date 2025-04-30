<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function home(Request $request)
    {
        $sortBy = $request->input('sort_by', 'title');
        $direction = $request->input('direction', 'asc');

        $booksQuery = Book::with('authors', 'reviews');

        switch ($sortBy) {
            case 'title':
                $booksQuery->orderBy('title', $direction);
                break;
            case 'year':
                $booksQuery->orderBy('published_year', $direction);
                break;
            case 'rating':
                $booksQuery->withCount(['reviews as average_rating' => function($query) {
                    $query->select(\DB::raw('coalesce(avg(rating),0)'));
                }])->orderBy('average_rating', $direction);
                break;
            case 'reviews_count':
                $booksQuery->withCount('reviews')->orderBy('reviews_count', $direction);
                break;
            default:
                $booksQuery->orderBy('title', 'asc');
        }

        $books = $booksQuery->paginate(9);

        $books->appends([
            'sort_by' => $sortBy,
            'direction' => $direction
        ]);

        return view('home', compact('books', 'sortBy', 'direction'));
    }

    public function index(Request $request)
    {
        $sortBy = $request->query('sort_by', 'title');
        $sortOrder = $request->query('sort_order', 'asc');

        $validSortColumns = ['title', 'ratings_count', 'average_rating'];
        if (!in_array($sortBy, $validSortColumns)) {
            $sortBy = 'title';
        }

        $query = Book::with('authors');

        if ($sortBy === 'title') {
            $query->orderBy($sortBy, $sortOrder);
        } elseif ($sortBy === 'ratings_count') {
            $query->orderBy($sortBy, $sortOrder);
        } elseif ($sortBy === 'average_rating') {
            $query->orderBy($sortBy, $sortOrder);
        }

        $books = $query->paginate(10);

        return view('books.index', compact('books', 'sortBy', 'sortOrder'));
    }

    public function show(Book $book)
    {
        $book->load('authors', 'reviews.user');
        $userReview = null;

        if (Auth::check()) {
            $userReview = $book->reviews()->where('user_id', Auth::id())->first();
        }

        return view('books.show', compact('book', 'userReview'));
    }

    public function create()
    {
        // Kiểm tra quyền admin
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('books.index')->with('error', 'Bạn không có quyền thêm sách mới.');
        }

        $authors = Author::orderBy('name')->get();
        return view('books.create', compact('authors'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('books.index')->with('error', 'Bạn không có quyền thêm sách mới.');
        }
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'published_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'cover_image' => 'required|image|max:2048',
            'authors' => 'array',
            'authors.*' => 'exists:authors,id'
        ]);

        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $filename = Str::slug($validated['title']) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('covers', $filename, 'public');
            $coverImagePath = $path;
        }

        $book = Book::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'published_year' => $validated['published_year'] ?? null,
            'cover_image' => $coverImagePath,
        ]);

        if (isset($validated['authors'])) {
            $book->authors()->attach($validated['authors']);
        }

        return redirect()->route('books.index')->with('success', 'Sách mới đã được thêm thành công!');
    }

    public function edit(Book $book)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Unauthorized. Only admins can edit books.');
        }

        $authors = Author::orderBy('name')->get();
        $book->load('authors');
        $selectedAuthors = $book->authors->pluck('id')->toArray();

        return view('books.edit', compact('book', 'authors', 'selectedAuthors'));
    }

    public function update(Request $request, Book $book)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Unauthorized. Only admins can update books.');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'cover_image' => 'nullable|image|max:2048',
            'authors' => 'required|array|min:1',
            'authors.*' => 'exists:authors,id',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
        ]);

        $book->title = $validated['title'];
        $book->description = $validated['description'] ?? null;
        $book->published_year = $validated['published_year'] ?? null;

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $image = $request->file('cover_image');
            $filename = Str::slug($validated['title']) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('covers', $filename, 'public');
            $book->cover_image = $path;
        }

        $book->save();

        $book->authors()->sync($validated['authors']);

        return redirect()->route('books.show', $book)->with('success', 'Sách đã được cập nhật thành công!');
    }

    public function destroy(Book $book)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Unauthorized. Only admins can delete books.');
        }

        if ($book->cover_image) {
            Storage::delete('public/' . $book->cover_image);
        }
        $book->reviews()->delete();
        $book->authors()->detach();
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Sách đã được xóa thành công!');
    }

    private function stripVNAccent($str) {
        $unicode = [
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'đ',
            'D' => 'Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
        ];

        foreach ($unicode as $nonAccent => $accent) {
            $str = preg_replace("/($accent)/u", $nonAccent, $str);
        }

        return $str;
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $books = [];

        if ($query) {
            $queryCapitalized = ucfirst($query);
            $directSearch = Book::where('title', 'like', "%{$query}%")
                        ->orWhere('title', 'like', "%{$queryCapitalized}%")
                        ->orWhere('description', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$queryCapitalized}%")
                        ->orWhereHas('authors', function($q) use ($query, $queryCapitalized) {
                            $q->where('name', 'like', "%{$query}%")
                              ->orWhere('name', 'like', "%{$queryCapitalized}%");
                        });

            $allBooks = Book::with('authors')->get();
            $filteredBooks = $allBooks->filter(function ($book) use ($query) {
                $title = $this->stripVNAccent($book->title);
                $query_no_accent = $this->stripVNAccent($query);
                return str_contains(mb_strtolower($title), mb_strtolower($query_no_accent)) ||
                       str_contains(mb_strtolower($book->title), mb_strtolower($query));
            });

            $books = $directSearch->get()->merge($filteredBooks)->unique('id');
            $books = new \Illuminate\Pagination\LengthAwarePaginator(
                $books->forPage($request->input('page', 1), 10),
                $books->count(),
                10,
                $request->input('page', 1),
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } else {
            $books = Book::with('authors')->paginate(10);
        }

        return view('books.search', compact('books', 'query'));
    }
}
