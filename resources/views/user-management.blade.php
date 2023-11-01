@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="background-color: #1a7c46; color: white">{{ __('User Management') }}</div>
                </div>
                <div class="shadow-lg">
                    <section class="">
                        <div class="container py-5">
                            <div class="row px-5">
                                <div class="row d-flex justify-content-center align-items-center">
                                    <table class="table table-striped table-bordered table-hover table-sm ">

                                        <thead class="">
                                            <tr class="" style="color: ; text-align:left">
                                                <th scope="col">ID</th>
                                                <th scope="col" class="">Name</th>
                                                <th scope="col" class="">Email</th>
                                                <th scope="col" class="">Designation</th>
                                                <th scope="col" class="">Department</th>
                                                <th scope="col" class="">Company</th>
                                                <th scope="col" class="">Role</th>
                                            </tr>
                                        </thead>

                                        @foreach ($allUsers as $item)
                                            <tbody>
                                                <tr>
                                                    <th>{{ $item->id }}</th>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->email }}</td>
                                                    <td>{{ $item->designation }}</td>
                                                    @if ($item->department_name != 0)
                                                        <td>{{ $item->department_name }}</td>
                                                    @elseif ($item->department_name == 0)
                                                        <td>Not Applicable</td>
                                                    @endif
                                                    @if ($item->company_name != 0)
                                                        <td>{{ $item->company_name }}</td>
                                                    @elseif ($item->company_name == 0)
                                                        <td>Not Applicable</td>
                                                    @endif
                                                    <td>{{ $item->role }}</td>
                                                </tr>
                                            </tbody>
                                        @endforeach
                                </div>
                                </table>
                            </div>
                        </div>
                </div>
                </section>
            </div>
        </div>
    </div>
    </div>
@endsection
