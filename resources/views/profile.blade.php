@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="background-color: #1a7c46; color: white">{{ __('Profile') }}</div>
                </div>
                <div class="shadow-lg">
                    <section class="">
                        <div class="container py-5">
                            <div class="row d-flex justify-content-center align-items-center">
                                <div class="col mb-4 mb-lg-0">
                                    <div class="card mb-3" style="border-radius: .5rem;">
                                        <div class="row g-0">
                                            <div class="col-md-4 gradient-custom text-center text-white"
                                                style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                                <img src="/images/man.jpg" alt="" class="img-fluid my-5"
                                                    style="width: 80px;" />
                                                <h5 style="color: black">{{ Auth::user()->name }}</h5>

                                                <p style="color: black">

                                                </p>

                                                <i class="far fa-edit mb-5"></i>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body p-4">
                                                    <h6>Information</h6>
                                                    <hr class="mt-0 mb-4">
                                                    <div class="row pt-1">
                                                        <div class="col-6 mb-3">
                                                            <h6>Email</h6>
                                                            <p class="text-muted">{{ Auth::user()->email }}</p>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <h6>Designation</h6>
                                                            <p class="text-muted">{{ Auth::user()->designation }}</p>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <h6>Company</h6>
                                                            {{-- <p class="text-muted">{{ Auth::user()->company }}</p> --}}
                                                            @php
                                                                $var = Auth::user()->company;
                                                                $companyName = DB::table('companies')
                                                                    ->select('company_name')
                                                                    ->where('company_id', $var)
                                                                    ->value('company_name');
                                                            @endphp
                                                            <p class="text-muted">{{ $companyName }}</p>

                                                        </div>

                                                        <div class="col-6 mb-3">
                                                          <h6>Department</h6>
                                                          {{-- <p class="text-muted">{{ Auth::user()->company }}</p> --}}
                                                          @php
                                                              $var = Auth::user()->department;
                                                              $departmentName = DB::table('departments')
                                                                  ->select('department_name')
                                                                  ->where('department_id', $var)
                                                                  ->value('department_name');
                                                          @endphp
                                                          <p class="text-muted">{{ $departmentName }}</p>

                                                      </div>
                                                        <div class="col-6 mb-3">
                                                            <h6>Signature</h6>
                                                            <div class="col-6 mb-3">
                                                                @php
                                                                    $var = Auth::user()->signature;
                                                                @endphp
                                                                <img src="{{ asset('signatures/' . $var) }}" alt=""
                                                                    style="height: 50px; width: 190px">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="{{ url('/change-password') }}" class="btn" style="background-color: #1a7c46; color: white">Click
                                                        Here to Change Password</a>

                                                    <div class="d-flex justify-content-start">
                                                        <a href="#!"><i class="fab fa-facebook-f fa-lg me-3"></i></a>
                                                        <a href="#!"><i class="fab fa-twitter fa-lg me-3"></i></a>
                                                        <a href="#!"><i class="fab fa-instagram fa-lg"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
