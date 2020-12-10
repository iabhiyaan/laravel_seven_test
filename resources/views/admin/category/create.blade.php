<form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="title">
    <input type="text" name="slug">
    <button>submit</button>
</form>
