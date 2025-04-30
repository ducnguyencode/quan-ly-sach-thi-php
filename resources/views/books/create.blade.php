@extends('layouts.app')

@section('title', 'Thêm sách mới')

@section('content')
    <div class="mb-6">
        <a href="{{ route('home') }}" class="text-blue-500 hover:text-blue-700 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Quay lại danh sách
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Thêm sách mới</h1>

        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" id="bookForm" onsubmit="return validateForm()">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Tiêu đề <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500
                        @error('title') border-red-500 @enderror"
                        required>
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="published_year" class="block text-gray-700 text-sm font-bold mb-2">Năm xuất bản <span class="text-red-500">*</span></label>
                    <input type="number" name="published_year" id="published_year" value="{{ old('published_year') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500
                        @error('published_year') border-red-500 @enderror"
                        min="1000" max="{{ date('Y') }}" required>
                    @error('published_year')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="isbn" class="block text-gray-700 text-sm font-bold mb-2">ISBN</label>
                    <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500
                        @error('isbn') border-red-500 @enderror">
                    @error('isbn')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="cover_image" class="block text-gray-700 text-sm font-bold mb-2">Ảnh bìa <span class="text-red-500">*</span></label>
                    <input type="file" name="cover_image" id="cover_image"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500
                        @error('cover_image') border-red-500 @enderror" required>
                    @error('cover_image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Mô tả <span class="text-red-500">*</span></label>
                <textarea name="description" id="description" rows="5"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500
                    @error('description') border-red-500 @enderror"
                    required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tác giả <span class="text-red-500">*</span></label>
                    <button type="button" onclick="toggleAuthorForm()" class="text-blue-500 hover:text-blue-700 text-sm flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Thêm tác giả mới
                    </button>
                </div>
                <div id="authorFormContainer" class="hidden border border-blue-200 rounded-md p-4 mb-4 bg-blue-50">
                    <h3 class="text-lg font-semibold mb-3 text-blue-800">Thêm tác giả mới</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="new_author_name" class="block text-gray-700 text-sm font-bold mb-2">Tên tác giả <span class="text-red-500">*</span></label>
                            <input type="text" id="new_author_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label for="new_author_nationality" class="block text-gray-700 text-sm font-bold mb-2">Quốc tịch <span class="text-red-500">*</span></label>
                            <input type="text" id="new_author_nationality" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label for="new_author_birth_date" class="block text-gray-700 text-sm font-bold mb-2">Ngày sinh <span class="text-red-500">*</span></label>
                            <input type="date" id="new_author_birth_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="new_author_biography" class="block text-gray-700 text-sm font-bold mb-2">Tiểu sử <span class="text-red-500">*</span></label>
                        <textarea id="new_author_biography" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"></textarea>
                    </div>
                    <div class="text-right">
                        <button type="button" onclick="addNewAuthor()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm">
                            Thêm vào danh sách
                        </button>
                    </div>
                </div>
                <div class="border border-gray-300 rounded-md p-4">
                    <div id="authors-container">
                        @if($authors->isEmpty())
                            <p class="text-gray-500" id="no-authors-message">Chưa có tác giả nào.</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($authors as $author)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="authors[]" id="author_{{ $author->id }}" value="{{ $author->id }}"
                                            {{ in_array($author->id, old('authors', [])) ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="author_{{ $author->id }}" class="ml-2 text-gray-700">
                                            {{ $author->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Thêm sách
                </button>
            </div>
        </form>
    </div>

    <script>
        function toggleAuthorForm() {
            const authorForm = document.getElementById('authorFormContainer');
            authorForm.classList.toggle('hidden');
        }

        function validateForm() {
            // Kiểm tra xem có ít nhất một tác giả được chọn không
            const authorCheckboxes = document.querySelectorAll('input[name="authors[]"]:checked');
            if (authorCheckboxes.length === 0) {
                alert('Vui lòng chọn ít nhất một tác giả cho sách này!');
                return false;
            }
            return true;
        }

        function isValidDate(dateStr) {
            // Kiểm tra định dạng ngày và ngày có hợp lệ không
            const date = new Date(dateStr);
            if (isNaN(date.getTime())) return false;

            // Kiểm tra xem ngày có phải trong tương lai không
            const today = new Date();
            if (date > today) return false;

            // Kiểm tra xem ngày có quá xa trong quá khứ không (150 năm)
            const minDate = new Date();
            minDate.setFullYear(today.getFullYear() - 150);
            if (date < minDate) return false;

            return true;
        }

        function addNewAuthor() {
            const name = document.getElementById('new_author_name').value.trim();
            const nationality = document.getElementById('new_author_nationality').value.trim();
            const birthDate = document.getElementById('new_author_birth_date').value.trim();
            const biography = document.getElementById('new_author_biography').value.trim();

            // Kiểm tra tất cả các trường bắt buộc
            if (!name) {
                alert('Vui lòng nhập tên tác giả');
                return;
            }
            if (!nationality) {
                alert('Vui lòng nhập quốc tịch tác giả');
                return;
            }
            if (!birthDate) {
                alert('Vui lòng nhập ngày sinh tác giả');
                return;
            }
            if (!biography) {
                alert('Vui lòng nhập tiểu sử tác giả');
                return;
            }

            // Kiểm tra ngày sinh hợp lệ
            if (!isValidDate(birthDate)) {
                alert('Ngày sinh không hợp lệ. Vui lòng kiểm tra lại (không được là ngày trong tương lai hoặc quá xa trong quá khứ).');
                return;
            }

            // Hiển thị trạng thái đang xử lý
            const addButton = document.querySelector('#authorFormContainer button');
            const originalButtonText = addButton.innerHTML;
            addButton.disabled = true;
            addButton.innerHTML = `<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg> Đang xử lý...`;

            // Thêm thông báo trạng thái
            const statusDiv = document.createElement('div');
            statusDiv.id = 'author-status-message';
            statusDiv.className = 'mt-2 text-center';
            document.getElementById('authorFormContainer').appendChild(statusDiv);

            // Gửi AJAX request để tạo tác giả mới
            fetch('{{ route("authors.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    name: name,
                    nationality: nationality,
                    birth_date: birthDate,
                    biography: biography
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Có lỗi xảy ra khi thêm tác giả');
                    });
                }
                return response.json();
            })
            .then(data => {
                addButton.disabled = false;
                addButton.innerHTML = originalButtonText;

                if (data.success) {
                    // Hiển thị thông báo thành công
                    statusDiv.innerHTML = '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded">Thêm tác giả thành công!</div>';

                    // Thêm tác giả mới vào danh sách
                    const authorsContainer = document.getElementById('authors-container');
                    const noAuthorsMessage = document.getElementById('no-authors-message');

                    // Ẩn thông báo nếu không có tác giả
                    if (noAuthorsMessage) {
                        noAuthorsMessage.style.display = 'none';
                    }

                    // Kiểm tra nếu grid container chưa tồn tại
                    let gridContainer = authorsContainer.querySelector('.grid');
                    if (!gridContainer) {
                        gridContainer = document.createElement('div');
                        gridContainer.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4';
                        authorsContainer.appendChild(gridContainer);
                    }

                    // Tạo checkbox cho tác giả mới
                    const authorDiv = document.createElement('div');
                    authorDiv.className = 'flex items-center';
                    authorDiv.innerHTML = `
                        <input type="checkbox" name="authors[]" id="author_${data.author.id}" value="${data.author.id}"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                        <label for="author_${data.author.id}" class="ml-2 text-gray-700">
                            ${data.author.name}
                        </label>
                    `;

                    gridContainer.appendChild(authorDiv);

                    // Reset form sau 1.5 giây để người dùng thấy thông báo
                    setTimeout(() => {
                        // Ẩn form thêm tác giả
                        document.getElementById('authorFormContainer').classList.add('hidden');

                        // Reset form
                        document.getElementById('new_author_name').value = '';
                        document.getElementById('new_author_nationality').value = '';
                        document.getElementById('new_author_birth_date').value = '';
                        document.getElementById('new_author_biography').value = '';

                        // Xóa thông báo
                        if (statusDiv) statusDiv.remove();
                    }, 1500);
                } else {
                    // Hiển thị lỗi
                    statusDiv.innerHTML = `<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">${data.message || 'Có lỗi xảy ra'}</div>`;

                    setTimeout(() => {
                        if (statusDiv) statusDiv.remove();
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                addButton.disabled = false;
                addButton.innerHTML = originalButtonText;

                // Hiển thị lỗi chi tiết
                statusDiv.innerHTML = `<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">Có lỗi xảy ra: ${error.message}</div>`;

                setTimeout(() => {
                    if (statusDiv) statusDiv.remove();
                }, 3000);
            });
        }
    </script>
@endsection
