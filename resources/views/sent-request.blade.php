@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow bg-white rounded">
                    <div class="card-header" style="background-color: #1a7c46; color: white">{{ __('Sent Items') }}</div>

                    <div class="card-body">
                        @if (session('msg'))
                            <div class="alert alert-danger" role="alert">
                                <img class="my-icon" src="/images/success.svg" alt="">
                                {{ session('msg') }}
                            </div>
                        @elseif (session('updateMsg'))
                            <div class="alert alert-success" role="alert">
                                <img class="my-icon" src="/images/success.svg" alt="">
                                {{ session('updateMsg') }}
                            </div>
                        @endif
                    </div>


                    <table id="my-table" class="table table-striped table-bordered table-hover table-sm ">
                        @if (count($sentRequests) === 0)
                            <h3 style="margin-left: 20px">No items available</h3>
                        @else
                            <thead class="">
                                @foreach ($sentRequests as $item)
                                    <tr class="" style="color: ; text-align:left">
                                        <th scope="col">ID</th>
                                        <th scope="col" class="w-50">Subject</th>
                                        <th scope="col" class="">Date</th>
                                        <th scope="col" class="">Status</th>
                                        <th scope="col" class="">Type</th>
                                        <th scope="col" class="w-25">Action</th>
                                    </tr>
                                @break;
                            @endforeach
                        </thead>
                    @endif

                    @foreach ($sentRequests as $item)
                        <tbody>
                            <tr>
                                <th>{{ $item->approval_note_id }}</th>
                                <td>{{ $item->approval_note_subject }}</td>
                                <td>{{ $item->approval_note_date }}</td>

                                @php
                                    $approvalStatusValues = DB::table('approved_bies')
                                        ->where('approval_note_id', $item->approval_note_id)
                                        ->pluck('approval_status')
                                        ->toArray();

                                    $supportStatusValues = DB::table('supported_bies')
                                        ->where('approval_note_id', $item->approval_note_id)
                                        ->pluck('approval_status')
                                        ->toArray();

                                    $checkStatusValues = DB::table('checked_bies')
                                        ->where('approval_note_id', $item->approval_note_id)
                                        ->pluck('approval_status')
                                        ->toArray();

                                    $reviewStatusValues = DB::table('reviewed_bies')
                                        ->where('approval_note_id', $item->approval_note_id)
                                        ->pluck('approval_status')
                                        ->toArray();

                                    $recommendedStatusValues = DB::table('recommended_bies')
                                        ->where('approval_note_id', $item->approval_note_id)
                                        ->pluck('approval_status')
                                        ->toArray();
                                @endphp

                                <td>
                                    @if (in_array(2, $approvalStatusValues) ||
                                            in_array(2, $supportStatusValues) ||
                                            in_array(2, $checkStatusValues) ||
                                            in_array(2, $reviewStatusValues) ||
                                            in_array(2, $recommendedStatusValues))
                                        <span class="badge bg-danger">Rejected</span>
                                    @elseif (
                                        (array_sum($approvalStatusValues) === 5 &&
                                            array_sum($supportStatusValues) === 5 &&
                                            array_sum($checkStatusValues) === 5 &&
                                            array_sum($reviewStatusValues) === 5 &&
                                            array_sum($recommendedStatusValues) === 5) ||
                                            (in_array(1, $approvalStatusValues) &&
                                                (in_array(1, $supportStatusValues) || in_array(200, $supportStatusValues)) &&
                                                (in_array(1, $checkStatusValues) || in_array(200, $checkStatusValues)) &&
                                                (in_array(1, $reviewStatusValues) || in_array(200, $reviewStatusValues)) &&
                                                (in_array(1, $recommendedStatusValues) || in_array(200, $recommendedStatusValues))))
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($item->is_bill == 1)
                                        <span class="badge bg-secondary">Bill</span>
                                    @else
                                        <span class="badge bg-secondary">Approval</span>
                                    @endif
                                </td>

                                @if ($item->is_bill == 0)
                                    <td>
                                        <button type="button" class="btn btn-outline-dark btn-sm"
                                            disabled>Bill</button>

                                        <a href="{{ url('pdf-approval-note/' . $item->approval_note_id) }}"
                                            target="_blank" title="View" style="text-decoration: none">
                                            <button type="button" class="btn btn-info btn-sm">Note</button>
                                        </a>
                                        @php
                                            $user_ID = Auth::user()->id;
                                            $approvalStatusValues = DB::table('approved_bies')
                                                ->where('approval_note_id', $item->approval_note_id)
                                                ->pluck('approval_status')
                                                ->toArray();

                                            $supportStatusValues = DB::table('supported_bies')
                                                ->where('approval_note_id', $item->approval_note_id)
                                                ->pluck('approval_status')
                                                ->toArray();

                                            $checkStatusValues = DB::table('checked_bies')
                                                ->where('approval_note_id', $item->approval_note_id)
                                                ->pluck('approval_status')
                                                ->toArray();

                                            $reviewStatusValues = DB::table('reviewed_bies')
                                                ->where('approval_note_id', $item->approval_note_id)
                                                ->pluck('approval_status')
                                                ->toArray();

                                            $recommendedStatusValues = DB::table('recommended_bies')
                                                ->where('approval_note_id', $item->approval_note_id)
                                                ->pluck('approval_status')
                                                ->toArray();
                                        @endphp

                                        @if (in_array(2, $approvalStatusValues) ||
                                                in_array(2, $supportStatusValues) ||
                                                in_array(2, $checkStatusValues) ||
                                                in_array(2, $reviewStatusValues) ||
                                                in_array(2, $recommendedStatusValues) ||
                                                in_array(1, $approvalStatusValues) ||
                                                in_array(1, $supportStatusValues) ||
                                                in_array(1, $checkStatusValues) ||
                                                in_array(1, $reviewStatusValues) ||
                                                in_array(1, $recommendedStatusValues))
                                            <a href="" onclick="return confirm('You can\'t edit this file');">
                                                <button type="button" class="btn btn-dark btn-sm">Edit</button>
                                            </a>
                                        @else
                                            <a href="{{ url('edit-approval-note/' . $item->approval_note_id) }}">
                                                <button type="button" class="btn btn-dark btn-sm">Edit</button>
                                            </a>
                                        @endif

                                        @if (in_array(2, $approvalStatusValues) ||
                                                in_array(2, $supportStatusValues) ||
                                                in_array(2, $checkStatusValues) ||
                                                in_array(2, $reviewStatusValues) ||
                                                in_array(2, $recommendedStatusValues) ||
                                                in_array(1, $approvalStatusValues) ||
                                                in_array(1, $supportStatusValues) ||
                                                in_array(1, $checkStatusValues) ||
                                                in_array(1, $reviewStatusValues) ||
                                                in_array(1, $recommendedStatusValues))
                                            <a href="" onclick="return confirm('You can\'t delete this file');">
                                                <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                            </a>
                                        @else
                                            <a href="{{ url('delete-data/' . $item->approval_note_id) }}"
                                                onclick="return confirm('Are you sure?');">
                                                <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                            </a>
                                        @endif
                                    </td>
                                @else
                                    <td>
                                        @php
                                            $filename = $item->approval_note_date . '-' . $item->approval_note_id;

                                            // Define the allowed extensions
                                            $allowedExtensions = ['pdf', 'xlsx', 'xls', 'docx', 'doc'];

                                            // Initialize the extension as null
                                            $extension = null;

                                            // Search for the file in the bills folder
                                            foreach ($allowedExtensions as $ext) {
                                                $filePath = public_path("bills/{$filename}.{$ext}");
                                                if (file_exists($filePath)) {
                                                    $extension = $ext;
                                                    break; // Stop searching if the file is found
                                                }
                                            }
                                        @endphp

                                        @if ($extension)
                                            <a style="text-decoration: none"
                                                href="{{ asset("bills/{$filename}.{$extension}") }}" target="_blank"
                                                title="View">
                                                @if ($extension == 'xls' || $extension == 'xlsx')
                                                    <button type="button" class="btn btn-success btn-sm">Bill</button>
                                                @elseif ($extension == 'pdf')
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-sm">Bill</button>
                                                @elseif ($extension == 'doc' || $extension == 'docx')
                                                    <button type="button" class="btn btn-primary btn-sm">Bill</button>
                                                @endif
                                            </a>
                                            <a style="text-decoration: none"
                                                href="{{ url('pdf-bill-approval-note/' . $item->approval_note_id) }}"
                                                target="_blank" title="View">
                                                <button type="button" class="btn btn-info btn-sm">Note</button>
                                            </a>
                                            @php
                                                $user_ID = Auth::user()->id;
                                                $approvalStatusValues = DB::table('approved_bies')
                                                    ->where('approval_note_id', $item->approval_note_id)
                                                    ->pluck('approval_status')
                                                    ->toArray();

                                                $supportStatusValues = DB::table('supported_bies')
                                                    ->where('approval_note_id', $item->approval_note_id)
                                                    ->pluck('approval_status')
                                                    ->toArray();

                                                $checkStatusValues = DB::table('checked_bies')
                                                    ->where('approval_note_id', $item->approval_note_id)
                                                    ->pluck('approval_status')
                                                    ->toArray();

                                                $reviewStatusValues = DB::table('reviewed_bies')
                                                    ->where('approval_note_id', $item->approval_note_id)
                                                    ->pluck('approval_status')
                                                    ->toArray();

                                                $recommendedStatusValues = DB::table('recommended_bies')
                                                    ->where('approval_note_id', $item->approval_note_id)
                                                    ->pluck('approval_status')
                                                    ->toArray();

                                                
                                            @endphp

                                            @if (in_array(2, $approvalStatusValues) ||
                                                in_array(2, $supportStatusValues) ||
                                                in_array(2, $checkStatusValues) ||
                                                in_array(2, $reviewStatusValues) ||
                                                in_array(2, $recommendedStatusValues) ||
                                                in_array(1, $approvalStatusValues) ||
                                                in_array(1, $supportStatusValues) ||
                                                in_array(1, $checkStatusValues) ||
                                                in_array(1, $reviewStatusValues) ||
                                                in_array(1, $recommendedStatusValues))
                                            <a href="" onclick="return confirm('You can\'t edit this file');">
                                                <button type="button" class="btn btn-dark btn-sm">Edit</button>
                                            </a>
                                        @else
                                            <a href="{{ url('edit-bill/' . $item->approval_note_id) }}">
                                                <button type="button" class="btn btn-dark btn-sm">Edit</button>
                                            </a>
                                        @endif

                                        @if (in_array(2, $approvalStatusValues) ||
                                                in_array(2, $supportStatusValues) ||
                                                in_array(2, $checkStatusValues) ||
                                                in_array(2, $reviewStatusValues) ||
                                                in_array(2, $recommendedStatusValues) ||
                                                in_array(1, $approvalStatusValues) ||
                                                in_array(1, $supportStatusValues) ||
                                                in_array(1, $checkStatusValues) ||
                                                in_array(1, $reviewStatusValues) ||
                                                in_array(1, $recommendedStatusValues))
                                            <a href="" onclick="return confirm('You can\'t delete this file');">
                                                <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                            </a>
                                        @else
                                            <a href="{{ url('delete-bill/' . $item->approval_note_id) }}"
                                                onclick="return confirm('Are you sure?');">
                                                <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                            </a>
                                        @endif

                                        @else
                                            <p>No attachment found</p>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        </tbody>
                    @endforeach
                </table>
                <div class="mt-4">
                    {{ $sentRequests->links('custom') }} <!-- Add a custom CSS class -->
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
