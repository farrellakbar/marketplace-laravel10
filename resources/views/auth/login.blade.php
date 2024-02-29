@extends('layouts.authapp')

@section('content')
    <div class="auth-box login-box">
        <!-- Start row -->
        <div class="row no-gutters align-items-center justify-content-center">
            <!-- Start col -->
            <div class="col-md-6 col-lg-4">
                <!-- Start Auth Box -->
                <div class="auth-box-right">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('authenticate') }}" method="post">
                                @csrf
                                <div class="form-head">
                                    <a href="index.html" class="logo"><img src="{{ asset('/') }}assets/images/logo.png" class="img-fluid" alt="logo"></a>
                                </div>
                                <h4 class="text-info mt-4 mb-4"><strong>Laravel 10</strong>, Log in !</h4>
                                <div class="form-group mb-3">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Enter Email here">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-4">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"  placeholder="Enter Password here">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                {{-- <div class="row mb-4">
                                    <div class="col">
                                        <div class="custom-control custom-checkbox text-start">
                                            <input type="checkbox" class="form-check-input me-1" id="rememberme">
                                            <label class="custom-control-label font-14" for="rememberme">Remember Me</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="forgot-psw">
                                            <a id="forgot-psw" href="user-forgotpsw.html" class="font-14">Forgot
                                                Password?</a>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="d-grid mb-4">
                                    <button class="btn btn-info  font-18" type="submit">Log in</button>
                                </div>

                            </form>
                            <div class="login-or">
                                <h6 class="text-muted">OR</h6>
                            </div>
                            <div class="social-login text-center mb-4">
                                <a href="/" type="button" class="btn btn-primary-rgba font-18 w-100"><i
                                        class="fa fa-home me-2"></i>Beranda</a>
                            </div>
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
