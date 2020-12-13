<x-admin-layout title="User create">

    <x-slot name="styles">

    </x-slot>

    <div class="container-fluid">
        @if (count($errors) > 0)
            <x-error-message />
        @endif
        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-9">
                    <div class="card-box">
                        <h4>Personal Details</h4>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="fullname" class="col-form-label">fullname</label>
                                <input type="text" name="name" class="form-control" id="fullname"
                                    placeholder="Enter name" value="{{ old('name') }}">
                            </div>
                            <div class="form-group col-12">
                                <label for="email" class="col-form-label">email</label>
                                <input type="text" name="email" class="form-control" id="email"
                                    placeholder="Enter email" value="{{ old('email') }}">
                            </div>
                            <div class="form-group col-12">
                                <label for="password" class="col-form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="Enter password" value="{{ old('password') }}">
                            </div>
                            <div class="form-group col-12">
                                <label for="password" class="col-form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" id="password"
                                    placeholder="Enter password again" value="{{ old('password_confirmation') }}">
                            </div>
                            <div class="form-group col-12">
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" id="is_published"
                                        value="is_published" name="is_published">
                                    <label class="custom-control-label" for="is_published">Publish</label>
                                </div>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-box">
                        <h4 class="mb-3">Permissions</h4>

                        @if (isset($access_options) && count($access_options))
                            @foreach ($access_options as $key => $option)
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" id="{{ $key }}"
                                        value="{{ $key }}" name="access[]">
                                    <label class="custom-control-label" for="{{ $key }}">{{ $option }}</label>
                                </div>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
            <!-- end row -->
        </form>

    </div>

    <x-slot name="scripts">

    </x-slot>

</x-admin-layout>
