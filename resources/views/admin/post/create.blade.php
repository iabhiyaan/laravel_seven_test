<form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <select name="category_id" id="">
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->title }}</option>
        @endforeach
    </select>
    <input type="text" name="title">
    <input type="text" name="slug">
    <button>submit</button>
</form>
