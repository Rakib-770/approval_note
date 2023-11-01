@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8">
                {{-- <div class="container" style="margin-bottom: 50px">
                    <div class="row">
                        <div class="col-sm">
                            <img src="images/company_logos/MTL.png" alt="" style="height: 50px; width: 80px;">
                        </div>
                        <div class="col-sm">
                            <img src="images/company_logos/BTL.png" alt="" style="height: 50px; width: 130px;">
                        </div>
                        <div class="col-sm">
                            <img src="images/company_logos/coloasia.png" alt="" style="height: 50px; width: 100px;">
                        </div>
                        <div class="col-sm">
                            <img src="images/company_logos/MirCloud.png" alt="" style="height: 80px; width: 100px;">
                        </div>
                        <div class="col-sm">
                            <img src="images/company_logos/Orange_pie.png" alt="" style="height: 80px; width: 130px;">
                        </div>
                    </div>
                </div> --}}
                <div class="card">
                    <div class="card-header" style="background-color: #1a7c46; color: white">{{ __('Please Login To Continue') }}</div>

                    <div class="card-body" >
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> --}}

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Login') }}
                                    </button>

                                    {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection