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
                    <table class="table table-striped table-bordered table-hover table-sm ">
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
                                    {{-- @if (count($approvalStatusValues) === 1 && $approvalStatusValues[0] === 1 && count($supportStatusValues) === 1 && $supportStatusValues[0] === 1 && count($checkStatusValues) === 1 && $checkStatusValues[0] === 1 && count($reviewStatusValues) === 1 && $reviewStatusValues[0] === 1 && count($recommendedStatusValues) === 1 && $recommendedStatusValues[0] === 1)
                                        <span class="badge bg-success">Approved</span> --}}
                                    @if (in_array(2, $approvalStatusValues) ||
                                            in_array(2, $supportStatusValues) ||
                                            in_array(2, $checkStatusValues) ||
                                            in_array(2, $reviewStatusValues) ||
                                            in_array(2, $recommendedStatusValues))
                                        <span class="badge bg-danger">Rejected</span>
                                    @elseif (in_array(0, $approvalStatusValues) ||
                                            empty($approvalStatusValues) ||
                                            in_array(0, $supportStatusValues) ||
                                            empty($supportStatusValues) ||
                                            in_array(0, $checkStatusValues) ||
                                            empty($checkStatusValues) ||
                                            in_array(0, $reviewStatusValues) ||
                                            empty($reviewStatusValues) ||
                                            in_array(0, $recommendedStatusValues) ||
                                            empty($recommendedStatusValues))
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge bg-success">Approved</span>
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
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                            disabled>Bill</button>

                                        <a href="{{ url('pdf-approval-note/' . $item->approval_note_id) }}"
                                            target="_blank" title="View" style="text-decoration: none">
                                            <button type="button" class="btn btn-info btn-sm">Approval</button>

                                        </a>
                                        @php
                                            $user_ID = Auth::user()->id;
                                            $approvalStatusValues = DB::table('approved_bies')
                                                ->where('approval_note_id', $item->approval_note_id)
                                                ->where('approved_by_id', $user_ID)
                                                ->pluck('approval_status')
                                                ->toArray();

                                            $supportStatusValues = DB::table('supported_bies')
                                                ->where('approval_note_id', $item->approval_note_id)
                                                ->where('supported_by_id', $user_ID)
                                                ->pluck('approval_status')
                                                ->toArray();

                                            $checkStatusValues = DB::table('checked_bies')
                                                ->where('approval_note_id', $item->approval_note_id)
                                                ->where('checked_by_id', $user_ID)
                                                ->pluck('approval_status')
                                                ->toArray();

                                            $reviewStatusValues = DB::table('reviewed_bies')
                                                ->where('approval_note_id', $item->approval_note_id)
                                                ->where('reviewed_by_id', $user_ID)
                                                ->pluck('approval_status')
                                                ->toArray();

                                            $recommendedStatusValues = DB::table('recommended_bies')
                                                ->where('approval_note_id', $item->approval_note_id)
                                                ->where('recommended_by_id', $user_ID)
                                                ->pluck('approval_status')
                                                ->toArray();
                                        @endphp

                                        <a href="{{ in_array(0, $approvalStatusValues) && in_array(0, $supportStatusValues) && in_array(0, $checkStatusValues) && in_array(0, $reviewStatusValues) && in_array(0, $recommendedStatusValues) ? url('edit-approval-note/' . $item->approval_note_id) : 'javascript:void(0);' }}"
                                            class="mr-4" style="text-decoration: none"
                                            @unless (in_array(0, $approvalStatusValues) &&
                                                    in_array(0, $supportStatusValues) &&
                                                    in_array(0, $checkStatusValues) &&
                                                    in_array(0, $reviewStatusValues) &&
                                                    in_array(0, $recommendedStatusValues))
                                        onclick="return confirm('The letter is already approved or rejected. You cannot edit this file.');"
                                        @endunless
                                            title="Edit">
                                            <button type="button" class="btn btn-dark btn-sm">Edit</button>

                                        </a>

                                        <a style="text-decoration: none"
                                            href="{{ in_array(0, $approvalStatusValues) && in_array(0, $supportStatusValues) && in_array(0, $checkStatusValues) && in_array(0, $reviewStatusValues) && in_array(0, $recommendedStatusValues) ? url('delete-data/' . $item->approval_note_id) : 'javascript:void(0);' }}"
                                            onclick="return confirm('Warning! Are you sure to delete approval note?"
                                            @if (
                                                !(in_array(0, $approvalStatusValues) &&
                                                    in_array(0, $supportStatusValues) &&
                                                    in_array(0, $checkStatusValues) &&
                                                    in_array(0, $reviewStatusValues) &&
                                                    in_array(0, $recommendedStatusValues)
                                                )) disabled @endif title="Delete">
                                            <button type="button" class="btn btn-danger btn-sm">Delete</button>

                                        </a>

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
                                                <button type="button" class="btn btn-info btn-sm">Approval</button>
                                            </a>
                                        @else
                                            <p>No attachment found</p>
                                        @endif

                                        <a style="text-decoration: none"
                                            href="{{ url('edit-bill/' . $item->approval_note_id) }}" title="Edit">
                                            <button type="button" class="btn btn-dark btn-sm">Edit</button>
                                        </a>
                                        <a style="text-decoration: none"
                                            href="{{ url('delete-bill/' . $item->approval_note_id) }}"
                                            onclick="return confirm('Are you sure you want to delete this record?');"
                                            title="Delete">
                                            <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                        </a>
                                        </a>
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
