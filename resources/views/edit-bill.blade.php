@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow bg-white rounded">
                    <div class="card-header" style="background-color: #1a7c46; color: white">{{ __('Update Bill') }}</div>
                    <div class="card-body">
                        @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                        @endif
                        <form action="{{ url('/update-bill/' . $editBillsID->approval_note_id) }}" class="mt-4 p-5"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Date <span
                                            style="color: red">*</span></label>
                                    <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" class="form-control"
                                        id="exampleInputEmail1" required>
                                </div>
                                <div class="col mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Company <span
                                            style="color: red">*</span></label>
                                    <select name="company" id="company" class="form-control" required>
                                        <option value="" disabled selected>--select company--</option>
                                        @foreach ($companyData as $company)
                                            @foreach ($editBills as $approval)
                                                <option value="{{ $company->company_id }}"
                                                    {{ $approval->approval_for_company_id == $company->company_id ? 'selected' : '' }}>
                                                    {{ $company->company_name }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Subject <span
                                        style="color: red">*</span></label>
                                <textarea type="textarea" class="form-control" name="subject" id="exampleInputEmail1" rows="2" required>{{ $approval->approval_note_subject }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Description</label>
                                <textarea type="textarea" class="form-control" name="description" id="exampleInputEmail1" rows="3">{{ $approval->bill_approval_description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Narration</label>
                                <textarea type="textarea" class="form-control" name="narration" id="exampleInputEmail1" rows="3">{{ $approval->bill_approval_narration }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="file" class="form-label">Upload File (pdf, doc, docx, xls, xlsx) <span
                                        style="color: red">*</span></label>
                                <input type="file" class="form-control" name="file" id="file"
                                    accept=".pdf, .doc, .docx, .xls, .xlsx" required>
                            </div>
                            <table class="table-sm w-75">
                                <thead>
                                    <tr class="fw-normal">
                                        <th scope="col">Supported By</th>
                                    </tr>
                                </thead>
                                <tbody id="supported_by_tbody">
                                    @foreach ($editSupportedBies as $supportedBy)
                                        <tr>
                                            <td>
                                                <select class="form-select-sm w-75" name="supportedByArray[]" disabled>
                                                    @foreach ($userData as $list)
                                                        @if ($supportedBy->supported_by_id == 404)
                                                            <option value="404">
                                                                Not Applicable
                                                            </option>
                                                        @else
                                                            <option value="{{ $list->id }}"
                                                                {{ $supportedBy->supported_by_id == $list->id ? 'selected' : '' }}>
                                                                {{ $list->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <table class="table-sm w-75">
                                <thead>
                                    <tr class="fw-normal">
                                        <th scope="col">Checked By</th>
                                    </tr>
                                </thead>
                                <tbody id="checked_by_tbody">
                                    @foreach ($editCheckedBies as $checkedBy)
                                        <tr>
                                            <td>
                                                <select class="form-select-sm w-75" name="checkedByArray[]" disabled>
                                                    @foreach ($userData as $list)
                                                        @if ($checkedBy->checked_by_id == 404)
                                                            <option value="{{ $list->id }}">
                                                                Not Applicable
                                                            </option>
                                                        @else
                                                            <option value="{{ $list->id }}"
                                                                {{ $checkedBy->checked_by_id == $list->id ? 'selected' : '' }}>
                                                                {{ $list->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <table class="table-sm w-75">
                                <thead>
                                    <tr class="fw-normal">
                                        <th scope="col">Reviewed By</th>
                                    </tr>
                                </thead>
                                <tbody id="reviewed_by_tbody">
                                    @foreach ($editReviewedBies as $reviewedBy)
                                        <tr>
                                            <td>
                                                <select class="form-select-sm w-75" name="reviewedByArray[]" disabled>
                                                    @foreach ($userData as $list)
                                                        @if ($reviewedBy->reviewed_by_id == 404)
                                                            <option value="404">
                                                                Not Applicable
                                                            </option>
                                                        @else
                                                            <option value="{{ $list->id }}"
                                                                {{ $reviewedBy->reviewed_by_id == $list->id ? 'selected' : '' }}>
                                                                {{ $list->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <table class="table-sm w-75">
                                <thead>
                                    <tr class="fw-normal">
                                        <th scope="col">Recommended By</th>
                                    </tr>
                                </thead>
                                <tbody id="recommended_by_tbody">
                                    @foreach ($editRecommendedBies as $recommendedBy)
                                        <tr>
                                            <td>
                                                <select class="form-select-sm w-75" name="recommendedByArray[]" disabled>
                                                    @foreach ($userData as $list)
                                                        @if ($recommendedBy->recommended_by_id == 404)
                                                            <option value="404">
                                                                Not Applicable
                                                            </option>
                                                        @else
                                                            <option value="{{ $list->id }}"
                                                                {{ $recommendedBy->recommended_by_id == $list->id ? 'selected' : '' }}>
                                                                {{ $list->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <table class="table-sm w-75">
                                <thead>
                                    <tr class="fw-normal">
                                        <th scope="col">Approved By</th>
                                    </tr>
                                </thead>
                                <tbody id="approved_by_tbody">
                                    @foreach ($editApprovedBies as $approvedBy)
                                        <tr>
                                            <td>
                                                <select class="form-select-sm w-75" name="approvedByArray[]" disabled>
                                                    @foreach ($userData as $list)
                                                        <option value="{{ $list->id }}"
                                                            {{ $approvedBy->approved_by_id == $list->id ? 'selected' : '' }}>
                                                            {{ $list->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="submit" value="submit" class="btn btn-primary mt-3"
                                style="background-color: #1a7c46; color: white">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
