@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="background-color: #1a7c46; color: white">{{ __('Company Management') }}
                    </div>
                </div>
                <div class="shadow-lg">
                    <section class="">
                        <div class="container py-5">
                            <div class="row px-5">

                                <div class="row d-flex justify-content-center align-items-center">
                                    <table class="table table-striped table-bordered table-hover table-sm ">

                                        <thead class="">
                                            <tr class="" style="color: ; text-align:left">
                                                <th scope="col" class="">Name</th>
                                                <th scope="col" class="">Inserted by</th>
                                                <th scope="col" class="">Inserted at</th>
                                            </tr>
                                        </thead>

                                        @foreach ($allCompanies as $item)
                                            <tbody>
                                                <tr>
                                                    <td>{{ $item->company_name }}</td>
                                                    <td></td>
                                                    <td>{{ $item->created_at }}</td>
                                                </tr>
                                            </tbody>
                                        @endforeach
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
