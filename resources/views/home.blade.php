@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="background-color: #1a7c46; color: white">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Approval Request Generator</h5>
                                        <p class="card-text">Welcome to the Approval Note Generator, your one-stop solution
                                            for creating professional and well-structured approval notes. Whether it's a
                                            project proposal, purchase request, or any other type of approval, our intuitive
                                            tool simplifies the process.</p>
                                        <a href="{{ url('/generate-approval-note') }}" class="btn w-100"
                                            style="background-color: #1a7c46; color: white">Generate Approval Note</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Bill Review and Approval</h5>
                                        <p class="card-text">Welcome to the Bill Review Center, your centralized platform
                                            for meticulously examining and approving bills with precision and efficiency.
                                            This module streamlines the bill approval process, ensuring accuracy and
                                            compliance at every step.</p>
                                        <a href="{{ url('/bill-approval') }}" class="btn w-100"
                                            style="background-color: #1a7c46; color: white">Bill Review and Approval</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
