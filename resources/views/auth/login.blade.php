<x-auth-layout title="Admin Login">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h4 class="text-uppercase mt-0">Login In</h4>
                    </div>
                    @if (count($errors) > 0)
                        <x-error-message />
                    @endif

                    @if (session('message'))
                        <x-alert type="success" message="{{ session('message') }}" />
                    @endif

                    <form action="{{ route('postLogin') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="emailaddress">Email address</label>
                            <input class="form-control" name="email" type="email" id="emailaddress" required=""
                                placeholder="Enter your email">
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input class="form-control" name="password" type="password" required="" id="password"
                                placeholder="Enter your password">
                        </div>
                        <div class="form-group mb-0 text-center">
                            <button class="btn btn-primary btn-block" type="submit"> Log In </button>
                        </div>

                    </form>

                </div> <!-- end card-body -->
            </div>
            <!-- end card -->

            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p> <a href="{{ route('password-reset') }}" class="text-muted ml-1"><i
                                class="fa fa-lock mr-1"></i>Forgot your
                            password?</a></p>
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- end col -->
    </div>
</x-auth-layout>
