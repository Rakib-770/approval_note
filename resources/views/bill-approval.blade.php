@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow bg-white rounded">
                    <div class="card-header" style="background-color: #1a7c46; color: white">{{ __('Send Bill') }}</div>
                    <div class="card-body">
                        @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                        @endif
                        <form action="{{ route('store-bill-approval-data') }}" class="mt-4 p-5" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row w-75">
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
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->company_id }}">{{ $company->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Total Amount <span
                                            style="color: red">*</span></label>
                                    <input type="number" name="amount" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3 w-75">
                                <label for="exampleInputEmail1" class="form-label">Subject <span
                                        style="color: red">*</span></label>
                                <textarea type="textarea" class="form-control" name="subject" id="exampleInputEmail1" rows="2" required></textarea>
                            </div>

                            <div class="mb-3 w-75">
                                <label for="description" class="form-label">Description</label>
                                <textarea type="textarea" class="form-control" name="description" id="description" rows="4"
                                    oninput="enforceCharacterLimit(this, 500)"></textarea>
                                <span id="charCountDescription">500/500</span>
                            </div>

                            <div class="mb-3 w-75">
                                <label for="narration" class="form-label">Narration</label>
                                <textarea type="textarea" class="form-control" name="narration" id="narration" rows="4"
                                    oninput="enforceCharacterLimit(this, 500)"></textarea>
                                <span id="charCountNarration">500/500</span>
                            </div>
                            <div class="mb-3 w-75">
                                <label for="file" class="form-label">Upload File (pdf, doc, docx, xls, xlsx) <span
                                        style="color: red">*</span></label>
                                <input type="file" class="form-control" name="file" id="file"
                                    accept=".pdf, .doc, .docx, .xls, .xlsx" required>
                            </div>

                            <table class="table-sm w-75">
                                <thead>
                                    <tr class="fw-normal">
                                        <th scope="col">Supported By <span style="color: red">*</span></th>
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
                                                <option value="404" >Not Applicable
                                                </option>
                                                @foreach ($users as $list)
                                                    <option value="{{ $list->id }}">{{ $list->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="button" class="btn fw-bold" id="supported_by_add_btn"
                                                value="+" style="background-color: #1a7c46; color: white"></td>
                                    </tr>
                                </tbody>
                            </table>


                            <table class="table-sm w-75">
                                <thead>
                                    <tr class="fw-normal">
                                        <th scope="col">Checked By <span style="color: red">*</span></th>
                                    </tr>
                                </thead>
                                <tbody id="checked_by_tbody">
                                    <tr>
                                        <td class="w-50">
                                            <select class="form-select-sm w-75" id="exampleSelect1" name="checkedByArray[]" required>
                                                <option value="" disabled selected hidden>--select checked by--
                                                </option>
                                                <option value="404" >Not Applicable
                                                </option>
                                                @foreach ($users as $list)
                                                    <option value="{{ $list->id }}">{{ $list->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="button" class="btn fw-bold" id="checked_by_add_btn" value="+"
                                                style="background-color: #1a7c46; color: white"></td>
                                    </tr>
                                </tbody>
                            </table>
                        
                            <table class="table-sm w-75">
                                <thead>
                                    <tr class="fw-normal">
                                        <th scope="col">Reviewed By <span style="color: red">*</span></th>
                                    </tr>
                                </thead>
                                <tbody id="reviewed_by_tbody">
                                    <tr>
                                        <td class="w-50">
                                            <select class="form-select-sm w-75" id="exampleSelect1"
                                                name="reviewedByArray[]" required>
                                                <option value="" disabled selected hidden>--select reviewed by--
                                                </option>
                                                <option value="404" >Not Applicable
                                                </option>
                                                @foreach ($users as $list)
                                                    <option value="{{ $list->id }}">{{ $list->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="button" class="btn fw-bold" id="reviewed_by_add_btn"
                                                value="+" style="background-color: #1a7c46; color: white"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table-sm w-75">
                                <thead>
                                    <tr class="fw-normal">
                                        <th scope="col">Recommended By <span style="color: red">*</span></th>
                                    </tr>
                                </thead>
                                <tbody id="recommended_by_tbody">
                                    <tr>
                                        <td class="w-50">
                                            <select class="form-select-sm w-75" id="exampleSelect1"
                                                name="recommendedByArray[]" required>
                                                <option value="" disabled selected hidden>--select recommended by--
                                                </option>
                                                <option value="404" >Not Applicable
                                                </option>
                                                @foreach ($users as $list)
                                                    <option value="{{ $list->id }}">{{ $list->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="button" class="btn fw-bold" id="recommended_by_add_btn"
                                                value="+" style="background-color: #1a7c46; color: white"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table-sm w-75">
                                <thead>
                                    <tr class="fw-normal">
                                        <th scope="col">Approved By <span style="color: red">*</span></th>
                                    </tr>
                                </thead>
                                <tbody id="approved_by_tbody">
                                    <tr>
                                        <td class="w-50">
                                            <select class="form-select-sm w-75" id="exampleSelect1"
                                                name="approvedByArray[]" required>
                                                <option value="" disabled selected hidden>--select approved by--
                                                </option>
                                                @foreach ($users as $list)
                                                    <option value="{{ $list->id }}">{{ $list->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="button" class="btn fw-bold" id="approved_by_add_btn"
                                                value="+" style="background-color: #1a7c46; color: white"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="submit" value="submit" class="btn mt-3"
                                style="background-color: #1a7c46; color: white">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#supported_by_add_btn').on('click', function() {
                    var html = '';
                    html += '<tr>';
                    html +=
                        '<td> <select class="form-select-sm w-75" id="exampleSelect1" name="supportedByArray[]" required> <option value="" disabled selected hidden>--select supported by--</option> @foreach ($users as $list) <option value="{{ $list->id }}">{{ $list->name }}</option> @endforeach </select> </td>';
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
                        `'<td> <select class="form-select-sm w-75" id="exampleSelect1" name="checkedByArray[]" required> <option value="" disabled selected hidden>--select checked by--</option> @foreach ($users as $list) <option value="{{ $list->id }}">{{ $list->name }}</option> @endforeach </select> </td>'`;
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
                        `'<td> <select class="form-select-sm w-75" id="exampleSelect1" name="reviewedByArray[]" required> <option value="" disabled selected hidden>--select reviewed by--</option> @foreach ($users as $list) <option value="{{ $list->id }}">{{ $list->name }}</option> @endforeach </select> </td>'`;
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
                        `'<td> <select class="form-select-sm w-75" id="exampleSelect1" name="recommendedByArray[]" required> <option value="" disabled selected hidden>--select recommended by--</option> @foreach ($users as $list) <option value="{{ $list->id }}">{{ $list->name }}</option> @endforeach </select> </td>'`;
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
                        `'<td> <select class="form-select-sm w-75" id="exampleSelect1" name="approvedByArray[]" required> <option value="" disabled selected hidden>--select approved by--</option> @foreach ($users as $list) <option value="{{ $list->id }}">{{ $list->name }}</option> @endforeach </select> </td>'`;
                    html += '<td><input type="button" class="btn btn-danger" id="remove" value="-"></td>';
                    html += '</tr>';
                    $('#approved_by_tbody').append(html);
                })
            });

            $(document).on('click', '#remove', function() {
                $(this).closest('tr').remove();
            });

            function enforceCharacterLimit(textarea, maxLength) {
                // Get the current text in the textarea
                const text = textarea.value;
                // Check if the text exceeds the character limit
                if (text.length > maxLength) {
                    // Truncate the text to the character limit
                    textarea.value = text.slice(0, maxLength);
                    // Optionally, you can provide user feedback about the character limit.
                    // Here, I'm displaying the remaining character count.
                    const remainingChars = maxLength - textarea.value.length;
                    // Determine which textarea is being used
                    const charCountId = (textarea.id === "description") ? "charCountDescription" : "charCountNarration";
                    document.getElementById(charCountId).textContent = remainingChars + '/' + maxLength;
                } else {
                    // If the text is within the character limit, update the character count.
                    const remainingChars = maxLength - text.length;
                    // Determine which textarea is being used
                    const charCountId = (textarea.id === "description") ? "charCountDescription" : "charCountNarration";
                    document.getElementById(charCountId).textContent = remainingChars + '/' + maxLength;
                }
            }
        </script>
    @endsection
