<x-admin-layout title="post create">

    <x-slot name="styles">

    </x-slot>

    <div class="container-fluid">
        @if (count($errors) > 0)
            <x-error-message />
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">

                    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="category_id" class="col-form-label">Category </label>
                                <select name="category_id" class="form-control">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="title" class="col-form-label">Post title</label>
                                <input type="text" name="title" class="form-control" id="title" placeholder="Post title"
                                    value="{{ old('title') }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="slug" class="col-form-label">Post slug</label>
                                <input type="text" name="slug" value="{{ old('slug') }}" class="form-control" id="slug"
                                    placeholder="Post slug">
                            </div>
                            <div class="form-group col-12">
                                <label for="description" class="col-form-label">description</label>
                                <textarea id="my-editor" id="description" name="description"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="is_published"
                                    id="is_published">
                                <label class="custom-control-label" for="is_published">Publish</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div>

    <x-slot name="scripts">
        {{-- CK Editor with photo caption plugin --}}
        <script src="/admin/ckeditor/ckeditor.js"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var options = {
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_field() }}',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{ csrf_field() }}',
                filebrowserUploadMethod: 'form'
            };

            CKEDITOR.replace('my-editor', options);
            CKEDITOR.config.height = 300;
            // CKEDITOR.config.font_defaultLabel = 'Arial';
            // CKEDITOR.config.fontSize_defaultLabel = '26px';

        </script>
    </x-slot>

</x-admin-layout>
