<x-admin-layout title="Post Edit">

    <x-slot name="styles">
        <link rel="stylesheet" href="/admin/css/jquery.Jcrop.min.css">
        <style>
            .hidden {
                display: none !important;
            }

        </style>
    </x-slot>
    @include('include.imageCropModal')
    <div class="container-fluid">
        @if (count($errors) > 0)
            <x-error-message />
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">

                    <form id="form" action="{{ route('updatePostWithImage', $detail->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="category_id" class="col-form-label">Category </label>
                                <select name="category_id" class="form-control">
                                    @foreach ($categories as $category)
                                        <option {{ $category->id == $detail->category_id ? 'selected' : null }}
                                            value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="title" class="col-form-label">Post title</label>
                                <input type="text" name="title" class="form-control" id="title" placeholder="Post title"
                                    value="{{ $detail->title }}">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="image" class="col-form-label">Post Image</label>
                                <input type="file" class="form-control" name="filename" id="image">
                            </div>
                            <div id="cropButton" class="form-group col-12">
                                <div id="image-holder" class="my-3">
                                    <img src="/images/main/{{ $detail->image }}"
                                        class="thumb-image img-responsive img-fluid">
                                    <input type="hidden" name="image" id="name" value="{{ $detail->image }}">
                                </div>
                                <button value="crop" type="button" id="crop"
                                    class="btn btn-success waves-effect waves-light hidden">Crop</button>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="slug" class="col-form-label">Post slug</label>
                                <input type="text" name="slug" value="{{ $detail->slug }}" class="form-control"
                                    id="slug" placeholder="Post slug">
                            </div>
                            <div class="form-group col-12">
                                <label for="description" class="col-form-label">description</label>
                                <textarea id="my-editor" id="description" name="description">
                                    {!!  $detail->description !!}
                                 </textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="is_published" class="custom-control-input"
                                    id="is_published" {{ $detail->is_published == 1 ? 'checked' : null }}>
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
        <script src="{{ asset('/admin/js/jquery.Jcrop.min.js') }}"></script>
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
            /****image upload****/
            var _URL = window.URL || window.webkitURL;
            var _URL = window.URL || window.webkitURL;
            $(document).ready(function() {
                $('#image').change(function() {
                    $('#crop').removeClass('hidden');
                    var file, img;
                    if ((file = this.files[0])) {
                        img = new Image();
                        img.onload = function() {
                            var width = this.width;
                            var height = this.height;
                            if (height < 400 || width < 800) {
                                alert('you must upload image more than 800*400');
                            } else {
                                var formData = new FormData($('#form')[0]);
                                $.ajax({
                                    url: "{{ route('imageProcess') }}",
                                    method: 'POST',
                                    data: formData,
                                    async: false,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    success: function(data) {
                                        jQuery.each(data.errors, function(key, value) {
                                            jQuery('.alert-danger').show();
                                            jQuery('.alert-danger').append(
                                                '<p>' + value + '</p>');
                                        });
                                        if (data['success'] == 'success') {
                                            console.log(data);
                                            $(".thumb-image").attr('src', data['path'] +
                                                '/' + data['name']);
                                            $(document).find('#crop').attr('data-image',
                                                data['name']);
                                            $("#name").val(data['name']);
                                        }
                                    },
                                    error: function(status) {
                                        console.log(status);
                                    }
                                });
                            }
                        };
                        img.onerror = function() {
                            alert("not a valid file: " + file.type);
                        };
                        img.src = _URL.createObjectURL(file);
                    }
                });
            });

            $(document).ready(function() {
                $("#crop").click(function() {
                    var name = $("#name").val();
                    $.ajax({
                        url: "{{ route('imageCropModal') }}",
                        data: {
                            name: name
                        },
                        method: "post",
                        success: function(data) {
                            $('#myModal .modal-body').html(data);
                            $('#myModal').modal('show');
                        }
                    });
                });
            });

        </script>
    </x-slot>

</x-admin-layout>
