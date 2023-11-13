@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow bg-white rounded">
                    <div class="card-header" style="background-color: #1a7c46; color: white">
                        {{ __('Bill Review and Approval') }}</div>

                    <div class="card-body">
                        @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                <img class="my-icon" src="/images/success.svg" alt="">
                                {{ session('msg') }}
                            </div>
                        @elseif (session('msgReject'))
                            <div class="alert alert-danger" role="alert">
                                <img class="my-icon" src="/images/success.svg" alt="">
                                {{ session('msgReject') }}
                            </div>
                        @endif
                    </div>

                    <table class="table table-striped table-bordered table-hover table-sm">

                        @if (count($receivedBillRequests) === 0)
                            <h3 style="margin-left: 20px">No items available</h3>
                        @else
                            <thead class="" style="">
                                @foreach ($receivedBillRequests as $item)
                                    <tr style=" text-align:left">
                                        <th scope="col">ID</th>
                                        <th scope="col" class="w-25">Subject</th>
                                        <th scope="col" class="w-25">Request From</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" class="w-25">Action</th>
                                    </tr>
                                @break;
                            @endforeach
                        </thead>
                    @endif

                    @foreach ($receivedBillRequests as $item)
                        <tbody>
                            <tr>
                                <th>{{ $item->approval_note_id }}</th>
                                <td>{{ $item->approval_note_subject }}</td>
                                <td>{{ $item->approval_request_from }}</td>
                                <td>{{ $item->approval_note_date }}</td>
                                @php
                                    $userId = Auth::user()->id;
                                    $approvalStatusValues = DB::table('approved_bies')
                                        ->where('approval_note_id', $item->approval_note_id)
                                        ->where('approved_by_id', $userId)
                                        ->pluck('approval_status')
                                        ->toArray();

                                    $supportStatusValues = DB::table('supported_bies')
                                        ->where('approval_note_id', $item->approval_note_id)
                                        ->where('supported_by_id', $userId)
                                        ->pluck('approval_status')
                                        ->toArray();

                                    $checkStatusValues = DB::table('checked_bies')
                                        ->where('approval_note_id', $item->approval_note_id)
                                        ->where('checked_by_id', $userId)
                                        ->pluck('approval_status')
                                        ->toArray();

                                    $reviewStatusValues = DB::table('reviewed_bies')
                                        ->where('approval_note_id', $item->approval_note_id)
                                        ->where('reviewed_by_id', $userId)
                                        ->pluck('approval_status')
                                        ->toArray();

                                    $recommendedStatusValues = DB::table('recommended_bies')
                                        ->where('approval_note_id', $item->approval_note_id)
                                        ->where('recommended_by_id', $userId)
                                        ->pluck('approval_status')
                                        ->toArray();

                                    $hasApprovalStatus = !empty($approvalStatusValues);
                                    $hasSupportStatus = !empty($supportStatusValues);
                                    $hasCheckStatus = !empty($checkStatusValues);
                                    $hasReviewStatus = !empty($reviewStatusValues);
                                    $hasRecommendedStatus = !empty($recommendedStatusValues);
                                @endphp
                                <td>
                                    @if (in_array(1, $approvalStatusValues) ||
                                            in_array(1, $supportStatusValues) ||
                                            in_array(1, $checkStatusValues) ||
                                            in_array(1, $reviewStatusValues) ||
                                            in_array(1, $recommendedStatusValues))
                                        <span class="badge bg-success">Approved</span>
                                    @elseif (in_array(2, $approvalStatusValues) ||
                                            in_array(2, $supportStatusValues) ||
                                            in_array(2, $checkStatusValues) ||
                                            in_array(2, $reviewStatusValues) ||
                                            in_array(2, $recommendedStatusValues))
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
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
                                                <button type="button"
                                                    class="btn btn-outline-success btn-sm">Bill</button>
                                            @elseif ($extension == 'pdf')
                                                <button type="button"
                                                    class="btn btn-outline-danger btn-sm">Bill</button>
                                            @elseif ($extension == 'doc' || $extension == 'docx')
                                                <button type="button" class="btn btn-outline-info btn-sm">Bill</button>
                                            @endif
                                        </a>
                                        <a style="text-decoration: none"
                                            href="{{ url('pdf-bill-approval-note/' . $item->approval_note_id) }}"
                                            target="_blank" title="View Approval">
                                            <button type="button" class="btn btn-info btn-sm">Note</button>
                                        </a>
                                    @else
                                        <p>No attachment found</p>
                                    @endif

                                    @php

                                        $userId = Auth::user()->id;
                                        $approvalStatusValues = DB::table('approved_bies')
                                            ->where('approval_note_id', $item->approval_note_id)
                                            ->where('approved_by_id', $userId)
                                            ->pluck('approval_status')
                                            ->toArray();

                                        $supportStatusValues = DB::table('supported_bies')
                                            ->where('approval_note_id', $item->approval_note_id)
                                            ->where('supported_by_id', $userId)
                                            ->pluck('approval_status')
                                            ->toArray();

                                        $checkStatusValues = DB::table('checked_bies')
                                            ->where('approval_note_id', $item->approval_note_id)
                                            ->where('checked_by_id', $userId)
                                            ->pluck('approval_status')
                                            ->toArray();

                                        $reviewStatusValues = DB::table('reviewed_bies')
                                            ->where('approval_note_id', $item->approval_note_id)
                                            ->where('reviewed_by_id', $userId)
                                            ->pluck('approval_status')
                                            ->toArray();

                                        $recommendedStatusValues = DB::table('recommended_bies')
                                            ->where('approval_note_id', $item->approval_note_id)
                                            ->where('recommended_by_id', $userId)
                                            ->pluck('approval_status')
                                            ->toArray();
                                    @endphp

                                    <a style="text-decoration: none"
                                        href="{{ in_array(0, $approvalStatusValues) || in_array(0, $supportStatusValues) || in_array(0, $checkStatusValues) || in_array(0, $reviewStatusValues) || in_array(0, $recommendedStatusValues) ? url('accept-bill-approval-note/' . $item->approval_note_id) : 'javascript:void(0);' }}"
                                        class=""
                                        @unless (in_array(0, $approvalStatusValues) ||
                                                in_array(0, $supportStatusValues) ||
                                                in_array(0, $checkStatusValues) ||
                                                in_array(0, $reviewStatusValues) ||
                                                in_array(0, $recommendedStatusValues))
                                                onclick="return confirm('The letter is already approved or rejected. Please view the PDF');"
                                                @endunless
                                        onclick="return confirm('Are you sure to Approve the letter?');"
                                        title="Approve">
                                        <button type="button" class="btn btn-success btn-sm">Approve</button>
                                    </a>

                                    <a style="text-decoration: none"
                                        href="{{ in_array(0, $approvalStatusValues) || in_array(0, $supportStatusValues) || in_array(0, $checkStatusValues) || in_array(0, $reviewStatusValues) || in_array(0, $recommendedStatusValues) ? url('reject-approval-note/' . $item->approval_note_id) : 'javascript:void(0);' }}"
                                        class=""
                                        @unless (in_array(0, $approvalStatusValues) ||
                                                in_array(0, $supportStatusValues) ||
                                                in_array(0, $checkStatusValues) ||
                                                in_array(0, $reviewStatusValues) ||
                                                in_array(0, $recommendedStatusValues))
                                        onclick="return confirm('The letter is already approved or rejected. Please view the PDF');"
                                        @endunless
                                        onclick="return confirm('Are you sure to Reject the letter?');" title="Reject">
                                        <button type="button" class="btn btn-danger btn-sm">Reject</button>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
                <div class="mt-4">
                    {{ $receivedBillRequests->links('custom') }} <!-- Pagination links -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
