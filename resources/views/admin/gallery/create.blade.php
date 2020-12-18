<x-admin-layout title="Gallery create">

    <x-slot name="styles">
        <link rel="stylesheet" href="/admin/css/jquery.Jcrop.min.css">
        <style>
            .hidden {
                display: none !important;
            }

        </style>
    </x-slot>

    <div class="container-fluid">
        @if (count($errors) > 0)
            <x-error-message />
        @endif
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data" id="form">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card-box">
                                <h4>Add a new gallery</h4>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="title" class="col-form-label">Gallery title</label>
                                        <input type="text" name="title" class="form-control" id="title"
                                            placeholder="Gallery title" value="{{ old('title') }}">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="slug" class="col-form-label">Gallery slug</label>
                                        <input type="text" name="slug" class="form-control" id="slug"
                                            placeholder="Gallery slug" value="{{ old('slug') }}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="upload_file" class="col-form-label">Gallery Images</label>
                                        <input type="file" class="form-control" name="image[]" multiple
                                            id="upload_file">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div id="image_preview" class="row"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box">
                                <h4 class="mb-3">Images</h4>
                                <div class="form-group">
                                    <label for="list_image" class="col-form-label">Upload Image for listing</label>
                                    <input type="file" class="form-control" name="list_image" id="list_image">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="is_published"
                                            id="is_published">
                                        <label class="custom-control-label" for="is_published">Publish</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
        <!-- end row -->

    </div>

    @include('include.imageCropModal')

    <x-slot name="scripts">
        <script src="{{ asset('/admin/js/jquery.Jcrop.min.js') }}"></script>

        <script>
            // ajaxSetup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            /****image upload****/
            var _URL = window.URL || window.webkitURL;
            var count = 0;
            var _URL = window.URL || window.webkitURL;
            $(document).ready(function() {
                $('#upload_file').change(function() {
                    var file, img;
                    var i;
                    for (i = 0; i < this.files.length; i++) {
                        if ((file = this.files[i])) {
                            img = new Image();
                            img.onload = function() {
                                var width = this.width;
                                var height = this.height;
                                if (height < 600 && width < 600) {
                                    alert('you must upload image more than 600*600');
                                    return true;
                                }
                            }; // img onload
                            img.onerror = function() {
                                alert("not a valid file: " + file.type);
                            };
                            img.src = _URL.createObjectURL(file);
                            img = "";
                        } //if
                    } //for loop
                    var formData = new FormData($('#form')[0]);
                    $.ajax({
                        url: "{{ route('gallery.galleryImage') }}",
                        type: 'POST',
                        data: formData,
                        async: true,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $("#image_preview").append(response.html);
                        }
                    });
                });
            });

            /**showing modal**/
            $(document).ready(function() {
                $(document).on("click", "button[data-index]", function(e) {
                    console.log('clicked');
                    var name = $(this).data('image');
                    var index = $(this).data('index');
                    $.ajax({
                        url: "{{ route('gallery.crop') }}",
                        method: 'post',
                        async: true,
                        data: {
                            name: name,
                            index: index
                        },
                        success: function(data) {
                            $('#myModal .modal-body').html(data);
                            $('#myModal').modal('show');
                        }
                    });
                });
            });


            //deleting image block
            $(document).on("click", "button.del-btn", function() {
                var name = $(this).data('image');
                var delConfirm = confirm('Are you sure you want to delete?');
                var _this = this;
                if (delConfirm) {
                    $.ajax({
                        method: 'post',
                        url: "{{ route('gallery.removeImage') }}",
                        data: {
                            name: name
                        },
                        success: function(data) {
                            $(_this).closest('.img-block').remove();
                        }
                    });
                }
                return false;
            });

        </script>
    </x-slot>

</x-admin-layout>
