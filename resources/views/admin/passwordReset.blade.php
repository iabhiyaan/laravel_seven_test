<x-auth-layout title="Password Reset">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h4 class="text-uppercase mt-0">Password Reset</h4>
                    </div>
                    @if (count($errors) > 0)
                        <x-error-message errorMessages="{{ $errors->all() }}">
                        </x-error-message>
                    @endif

                    @if (session('message'))
                        <x-alert type="success" message="{{ session('message') }}"></x-alert>
                    @endif

                    <form action="{{ route('updatePassword') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="emailaddress">Email address</label>
                            <input class="form-control" name="email" type="email" id="emailaddress" required=""
                                placeholder="Enter your email" value="{{ $data->email }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="Enter Password">
                        </div>
                        <div class="form-group mb-3">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" id="confirm_password"
                                placeholder="Enter Password Again">
                        </div>
                        <div class="form-group mb-0 text-center">
                            <button class="btn btn-primary btn-block" type="submit"> Submit </button>
                        </div>

                    </form>

                </div> <!-- end card-body -->
            </div>
            <!-- end card -->
        </div> <!-- end col -->
    </div>
</x-auth-layout>
