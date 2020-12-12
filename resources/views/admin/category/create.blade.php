<x-admin-layout title="category create">

    <x-slot name="styles">

    </x-slot>

    <div class="container-fluid">
        @if (count($errors) > 0)
            <x-error-message />
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">

                    <form action="{{ route('category.store') }}" method="POST">
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label for="title" class="col-form-label">category title</label>
                                <input type="text" name="title" class="form-control" id="title"
                                    placeholder="category title" value="{{ old('title') }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="slug" class="col-form-label">category slug</label>
                                <input type="text" name="slug" class="form-control" id="slug"
                                    placeholder="category slug" value="{{ old('slug') }}">
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

    </x-slot>

</x-admin-layout>
