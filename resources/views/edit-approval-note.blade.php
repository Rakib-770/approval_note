@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Generate Approval Note') }}</div>
                    <div class="card-body">
                        <form action="{{ url('/update-approval-note/' . $editApprovalsID->approval_note_id) }}" class="mt-4 p-5" method="POST">
                            @csrf
                            <div class="row">
                                  
                                <div class="col mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Addressed To</label>
                                    <select name="addressedTo" id="addressedTo" class="form-control" required disabled>
                                        <option value="" disabled selected>--select addressed to--</option>
                                        @foreach ($userData as $list)
                                            @foreach ($editApprovals as $approval)
                                                <option value="{{ $list->id }}"
                                                    {{ $approval->addressed_to_id == $list->id ? 'selected' : '' }}>
                                                    {{ $list->name }}</option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Date</label>
                                    @foreach ($editApprovals as $approval)
                                        <input type="date" name="date" value="{{ $approval->approval_note_date }}"
                                            class="form-control" id="exampleInputEmail1" required>
                                    @endforeach
                                </div>
                                <div class="col mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Company</label>
                                    <select name="company" id="company" class="form-control" required disabled>
                                        <option value="" disabled selected>--select company--</option>
                                        @foreach ($companyData as $company)
                                            @foreach ($editApprovals as $approval)
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
                                <label for="exampleInputEmail1" class="form-label">Subject</label>
                                @foreach ($editApprovals as $approval)
                                    <textarea type="textarea" class="form-control" value="{{ $approval->approval_note_subject }}" name="subject"
                                        id="exampleInputEmail1" rows="2" required>{{ $approval->approval_note_subject }}</textarea>
                                @endforeach
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Objective</label>
                                @foreach ($editObjectives as $objective)
                                    <textarea type="textarea" class="form-control"
                                        value="{{ $objective->objective_description }}" name="objective_description" id="exampleInputEmail1" rows="3"
                                        required>{{ $objective->objective_description }}</textarea>
                                @endforeach

                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Background</label>
                                @foreach ($editBackgrounds as $background)
                                    <textarea type="textarea" class="form-control" value="{{ $background->background_description }}"
                                        name="background_description" id="exampleInputEmail1" rows="4" required>{{ $background->background_description }}</textarea>
                                @endforeach
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Proposal</label>
                                @foreach ($editProposals as $proposal)
                                    <textarea type="textarea" class="form-control" name="proposal_description"
                                        value="{{ $proposal->proposal_description }}" id="exampleInputEmail1" rows="5" required>{{ $proposal->proposal_description }}</textarea>
                                @endforeach
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Justification</label>
                                @foreach ($editJustifications as $justification)
                                    <textarea type="textarea" class="form-control" value="{{ $justification->justification_description }}"
                                        name="justification_description" id="exampleInputEmail1" rows="5" required>{{ $justification->justification_description }}</textarea>
                                @endforeach
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Recommendation</label>
                                @foreach ($editRecommendations as $recommendation)
                                    <textarea type="textarea" class="form-control" value="{{ $recommendation->recommendation_description }}"
                                        name="recommendation_description" id="exampleInputEmail1" rows="5" required>{{ $recommendation->recommendation_description }}</textarea>
                                @endforeach
                            </div>

                            {{-- <table class="table-sm w-75">
                                <thead>
                                    <tr class="fw-normal">
                                        <th scope="col">Supported By</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="supported_by_tbody">
                                    <tr>
                                        <td class="w-50">
                                            <select class="form-select-sm w-75" id="exampleSelect1"
                                                name="supportedByArray[]" required>
                                                <option value="" disabled selected hidden>--select supported by--
                                                </option>
                                                @foreach ($userData as $list)
                                                    @foreach ($editSupportedBies as $supportedBy)
                                                        @if (count($editSupportedBies) == 1)
                                                            <option value="{{ $list->id }}"
                                                                {{ $supportedBy->supported_by_id == $list->id ? 'selected' : '' }}>
                                                                {{ $list->name }}</option>
                                                        @else
                                                            <option value="{{ $list->id }}"
                                                                {{ $supportedBy->supported_by_id == $list->id ? 'selected' : '' }}>
                                                                {{ $list->name }}</option>
                                                        @endif
                                                    @break;
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="button" class="btn btn-info fw-bold" id="supported_by_add_btn"
                                            value="+"></td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table-sm w-75">
                            <thead>
                                <tr class="fw-normal">
                                    <th scope="col">Checked By</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="checked_by_tbody">
                                <tr>
                                    <td class="w-50">
                                        <select class="form-select-sm w-75" id="exampleSelect1"
                                            name="checkedByArray[]" required>
                                            <option value="" disabled selected hidden>--select checked by--
                                            </option>
                                            @foreach ($userData as $list)
                                                @foreach ($editCheckedBies as $checkedBy)
                                                    @if (count($editCheckedBies) == 1)
                                                        <option value="{{ $list->id }}"
                                                            {{ $checkedBy->checked_by_id == $list->id ? 'selected' : '' }}>
                                                            {{ $list->name }}</option>
                                                    @else
                                                        <option value="{{ $list->id }}"
                                                            {{ $checkedBy->checked_by_id == $list->id ? 'selected' : '' }}>
                                                            {{ $list->name }}</option>
                                                    @endif
                                                @break;
                                            @endforeach
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="button" class="btn btn-info fw-bold" id="checked_by_add_btn"
                                        value="+"></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table-sm w-75">
                        <thead>
                            <tr class="fw-normal">
                                <th scope="col">Reviewed By</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="reviewed_by_tbody">
                            <tr>
                                <td class="w-50">
                                    <select class="form-select-sm w-75" id="exampleSelect1"
                                        name="reviewedByArray[]" required>
                                        <option value="" disabled selected hidden>--select reviewed by--
                                        </option>
                                        @foreach ($userData as $list)
                                            @foreach ($editReviewedBies as $reviewedBy)
                                                @if (count($editReviewedBies) == 1)
                                                    <option value="{{ $list->id }}"
                                                        {{ $reviewedBy->reviewed_by_id == $list->id ? 'selected' : '' }}>
                                                        {{ $list->name }}</option>
                                                @else
                                                    <option value="{{ $list->id }}"
                                                        {{ $reviewedBy->reviewed_by_id == $list->id ? 'selected' : '' }}>
                                                        {{ $list->name }}</option>
                                                @endif
                                            @break;
                                        @endforeach
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="button" class="btn btn-info fw-bold" id="reviewed_by_add_btn"
                                    value="+"></td>
                        </tr>
                    </tbody>
                </table>

                <table class="table-sm w-75">
                    <thead>
                        <tr class="fw-normal">
                            <th scope="col">Recommended By</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="recommended_by_tbody">
                        <tr>
                            <td class="w-50">
                                <select class="form-select-sm w-75" id="exampleSelect1"
                                    name="recommendedByArray[]" required>
                                    <option value="" disabled selected hidden>--select recommended by--
                                    </option>
                                    @foreach ($userData as $list)
                                        @foreach ($editRecommendedBies as $recommendedBy)
                                            @if (count($editRecommendedBies) == 1)
                                                <option value="{{ $list->id }}"
                                                    {{ $recommendedBy->recommended_by_id == $list->id ? 'selected' : '' }}>
                                                    {{ $list->name }}</option>
                                            @else
                                                <option value="{{ $list->id }}"
                                                    {{ $recommendedBy->recommended_by_id == $list->id ? 'selected' : '' }}>
                                                    {{ $list->name }}</option>
                                            @endif
                                        @break;
                                    @endforeach
                                @endforeach
                            </select>
                        </td>
                        <td><input type="button" class="btn btn-info fw-bold"
                                id="recommended_by_add_btn" value="+">
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table-sm w-75">
                <thead>
                    <tr class="fw-normal">
                        <th scope="col">Approved By</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="approved_by_tbody">
                    <tr>
                        <td class="w-50">
                            <select class="form-select-sm w-75" id="exampleSelect1"
                                name="approvedByArray[]" required>
                                <option value="" disabled selected hidden>--select approved by--
                                </option>
                                @foreach ($userData as $list)
                                    @foreach ($editApprovedBies as $approvedBy)
                                        @if (count($editApprovedBies) == 1)
                                            <option value="{{ $list->id }}"
                                                {{ $approvedBy->approved_by_id == $list->id ? 'selected' : '' }}>
                                                {{ $list->name }}</option>
                                        @else
                                            <option value="{{ $list->id }}"
                                                {{ $approvedBy->approved_by_id == $list->id ? 'selected' : '' }}>
                                                {{ $list->name }}</option>
                                        @endif
                                        @break;
                                    @endforeach
                                @endforeach
                            </select>
                        </td>
                        <td><input type="button" class="btn btn-info fw-bold" id="approved_by_add_btn"
                                value="+"></td>
                    </tr>
                </tbody>
            </table> --}}
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
                                        <option value="{{ $list->id }}" {{ $supportedBy->supported_by_id == $list->id ? 'selected' : '' }}>
                                            {{ $list->name }}
                                        </option>
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
                                        <option value="{{ $list->id }}" {{ $checkedBy->checked_by_id == $list->id ? 'selected' : '' }}>
                                            {{ $list->name }}
                                        </option>
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
                                        <option value="{{ $list->id }}" {{ $reviewedBy->reviewed_by_id == $list->id ? 'selected' : '' }}>
                                            {{ $list->name }}
                                        </option>
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
                                        <option value="{{ $list->id }}" {{ $recommendedBy->recommended_by_id == $list->id ? 'selected' : '' }}>
                                            {{ $list->name }}
                                        </option>
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
                                        <option value="{{ $list->id }}" {{ $approvedBy->approved_by_id == $list->id ? 'selected' : '' }}>
                                            {{ $list->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" value="submit" class="btn btn-primary mt-3">Submit</button>
        </form>
    </div>
</div>

</div>
</div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
{{-- <script type="text/javascript">
    $(document).ready(function() {
        $('#supported_by_add_btn').on('click', function() {
            var html = '';
            html += '<tr>';
            html +=
                '<td> <select class="form-select-sm w-75" id="exampleSelect1" name="supportedByArray[]" required> <option value="" disabled selected hidden>--select supported by--</option> @foreach ($userData as $list) <option value="{{ $list->id }}">{{ $list->name }}</option> @endforeach </select> </td>';
            html += '<td><input type="button" class="btn btn-danger" id="remove" value="-"></td>';
            html += '</tr>';
            $('#supported_by_tbody').append(html);
        })
    });

    $(document).on('click', '#remove', function() {
        $(this).closest('tr').remove();
    });

    

    $(document).ready(function() {
        $('#checked_by_add_btn').on('click', function() {
            var html = '';
            html += '<tr>';
            html +=
                '<td> <select class="form-select-sm w-75" id="exampleSelect1" name="checkedByArray[]" required> <option value="" disabled selected hidden>--select checked by--</option> @foreach ($userData as $list) <option value="{{ $list->id }}">{{ $list->name }}</option> @endforeach </select> </td>';
            html += '<td><input type="button" class="btn btn-danger" id="remove" value="-"></td>';
            html += '</tr>';
            $('#checked_by_tbody').append(html);
        })
    });

    $(document).on('click', '#remove', function() {
        $(this).closest('tr').remove();
    });


    $(document).ready(function() {
        $('#reviewed_by_add_btn').on('click', function() {
            var html = '';
            html += '<tr>';
            html +=
                '<td> <select class="form-select-sm w-75" id="exampleSelect1" name="reviewedByArray[]" required> <option value="" disabled selected hidden>--select reviewed by--</option> @foreach ($userData as $list) <option value="{{ $list->id }}">{{ $list->name }}</option> @endforeach </select> </td>';
            html += '<td><input type="button" class="btn btn-danger" id="remove" value="-"></td>';
            html += '</tr>';
            $('#reviewed_by_tbody').append(html);
        })
    });

    $(document).on('click', '#remove', function() {
        $(this).closest('tr').remove();
    });


    $(document).ready(function() {
        $('#recommended_by_add_btn').on('click', function() {
            var html = '';
            html += '<tr>';
            html +=
                '<td> <select class="form-select-sm w-75" id="exampleSelect1" name="recommendedByArray[]" required> <option value="" disabled selected hidden>--select recommended by--</option> @foreach ($userData as $list) <option value="{{ $list->id }}">{{ $list->name }}</option> @endforeach </select> </td>';
            html += '<td><input type="button" class="btn btn-danger" id="remove" value="-"></td>';
            html += '</tr>';
            $('#recommended_by_tbody').append(html);
        })
    });

    $(document).on('click', '#remove', function() {
        $(this).closest('tr').remove();
    });


    $(document).ready(function() {
        $('#approved_by_add_btn').on('click', function() {
            var html = '';
            html += '<tr>';
            html +=
                '<td> <select class="form-select-sm w-75" id="exampleSelect1" name="approvedByArray[]" required> <option value="" disabled selected hidden>--select approved by--</option> @foreach ($userData as $list) <option value="{{ $list->id }}">{{ $list->name }}</option> @endforeach </select> </td>';
            html += '<td><input type="button" class="btn btn-danger" id="remove" value="-"></td>';
            html += '</tr>';
            $('#approved_by_tbody').append(html);
        })
    });

    $(document).on('click', '#remove', function() {
        $(this).closest('tr').remove();
    });
</script> --}}
