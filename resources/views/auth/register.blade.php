@extends('layouts.authapp')

@section('content')

    <div class="auth-box register-box">
        <!-- Start row -->
        <div class="row no-gutters align-items-center justify-content-center">
            <!-- Start col -->
            <div class="col-md-12 col-lg-4">
                <!-- Start Auth Box -->
                <div class="auth-box-right">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('store') }}" method="post">
                                @csrf
                                <div class="form-head">
                                    <a href="index.html" class="logo"><img src="{{ asset('/') }}assets/images/logo.png" class="img-fluid" alt="logo"></a>
                                </div>
                                <h4 class="text-info my-4"><strong>Laravel 10</strong>, Sign Up !</h4>
                                <div class="form-group mb-2">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Name here">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-2">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Enter Email here">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-2">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter Password here">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-Type Password">
                                </div>
                                {{-- <div class="form-row mb-3">
                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox text-start">
                                            <input type="checkbox" class="form-check-input me-1" id="terms">
                                            <label class="custom-control-label font-14" for="terms">I Agree to Terms & Conditions of Orbiter</label>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="d-grid gap-2">
                                    <button class="btn btn-info  font-18" type="submit">Register</button>
                                  </div>

                            </form>
                            <p class="mb-0 mt-3">Already have an account? <a href="{{ route('login') }}"">Log in</a></p>
                            <p class="mb-0 mt-3">
                                <small class="text-muted"><b>@ {{ now()->year }}</b>, Laravel Ver 10.0</small>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End Auth Box -->
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>

@endsection
