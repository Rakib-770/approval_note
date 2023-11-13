@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="background-color: #1a7c46; color: white">{{ __('Register') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }} <span
                                        style="color: red">*</span> </label>
                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}
                                    <span style="color: red">*</span> </label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="designation" class="col-md-4 col-form-label text-md-end">{{ __('Designation') }}
                                    <span style="color: red">*</span> </label>
                                <div class="col-md-6">
                                    <input id="designation" type="text"
                                        class="form-control @error('designation') is-invalid @enderror" name="designation"
                                        value="{{ old('designation') }}" required autocomplete="designation" autofocus>
                                    @error('designation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="department" class="col-md-4 col-form-label text-md-end">{{ __('Department') }}
                                    <span style="color: red">*</span> </label>

                                <div class="col-md-6">
                                    <select name="department" value="" id="department" class="form-control" required>
                                        <option value="" disabled selected>select department</option>
                                        <option value="0">Not Applicable</option>
                                        @foreach ($departments as $list)
                                            <option value="{{ $list->department_id }}">{{ $list->department_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="company" class="col-md-4 col-form-label text-md-end">{{ __('Company') }} <span
                                        style="color: red">*</span> </label>

                                <div class="col-md-6">
                                    <select name="company" id="company" class="form-control" required>
                                        <option value="" disabled selected>select department</option>
                                        <option value="0">Not Applicable</option>
                                        @foreach ($companies as $list)
                                            <option value="{{ $list->company_id }}">{{ $list->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="signature" class="col-md-4 col-form-label text-md-end">{{ __('Upload Signature') }} <span
                                        style="color: red">*</span> </label>

                                <div class="col-md-6">
                                    <input class="form-control" name="signature" type="file" id="exampleInputSignature">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}
                                    <span style="color: red">*</span> </label>
                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }} <span
                                        style="color: red">*</span> </label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
