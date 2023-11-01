<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .container {
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 10px;
        }

        .letter-head {
            border-bottom: 3px solid black;
        }

        .letter-head {
            column-count: 2;
        }

        .header-table {
            width: 100%;
        }

        td {
            border: .5px solid black;
            padding: 10px;
        }

        .page_break {
            page-break-before: always;
        }

        .table-td {
            height: 50px
        }

        .subject-line {
            background-color: rgb(179, 177, 177);
            padding: 1px;
            padding-left: 10px;
            margin-top: 10px;
        }

        body {
            margin-top: 300px;
        }

        #footer .page:after {
            content: counter(page, decimal);
        }

        @page {
            margin: 20px 30px 40px 50px;
        }

        @page {
            margin: 100px 25px;
        }

        header {
            position: fixed;
            top: 0px;
            left: 20px;
            right: 20px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
        }

        p {
            page-break-after: always;
        }

        p:last-child {
            page-break-after: never;
        }

        .hcol {
            float: left;
            width: 75%;
            /* padding: 10px;
            height: 300px; */
            /* Should be removed. Only for demonstration */
        }

        /* Clear floats after the columns */
        .hrow:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>

@foreach ($final_arr as $items)
    <header>
        <div style="position: ">
            <div class="">
                <div class="letter-headm hrow">
                    <div class="hcol">
                        <h1>Approval Note</h1>
                    </div>
                    <div class="hcol">
                        @php
                            if ($items['approvalDetails']->approval_for_company_id == 1) {
                                $image = 'images/company_logos/MTL.png';
                            } elseif ($items['approvalDetails']->approval_for_company_id == 2) {
                                $image = 'images/company_logos/Coloasia.png';
                            } elseif ($items['approvalDetails']->approval_for_company_id == 3) {
                                $image = 'images/company_logos/MirCloud.png';
                            } elseif ($items['approvalDetails']->approval_for_company_id == 4) {
                                $image = 'images/company_logos/BTL.png';
                            } elseif ($items['approvalDetails']->approval_for_company_id == 5) {
                                $image = 'images/company_logos/orange_pie.png';
                            }
                        @endphp
                        <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(@$image)) }}"
                            alt="" style="height: 50px; width: 150px; ">
                    </div>
                </div>
            </div>
            <div class="">
                <table class="header-table">
                    <tr>
                        <td>Date: {{ $items['approvalDetails']->approval_note_date }}</td>
                        <td>Reference no: {{ $items['approvalDetails']->approval_note_reference_no }}</td>
                    </tr>
                    <tr>
                        <td>To: {{ $items['approvalDetails']->name }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>From: {{ $items['approvalDetails']->approval_request_from }}</td>
                        <td id="footer">No. of page:
                            <span class="page"> </span>
                        </td>
                    </tr>
                </table>
                <div class="subject-line">
                    <h4 class="">Subject: {{ $items['approvalDetails']->approval_note_subject }} </h4>
                </div>
            </div>
        </div>
    </header>

    <body>
        <div class="container">

            <div class="approval-note-body">
                <div>
                    <h4>1. OBJECTIVE</h4>
                    <p>{{ $items['approvalDetails']->objective_description }}</p>
                </div>
                <div>
                    <h4>2. BACKGROUND</h4>
                    <p>{{ $items['approvalDetails']->background_description }}</p>
                </div>
                <div>
                    <h4>3. PROPOSAL</h4>
                    <p>{{ $items['approvalDetails']->proposal_description }}</p>
                </div>
                <div>
                    <h4>4. JUSTIFICATION</h4>
                    <p>{{ $items['approvalDetails']->justification_description }}</p>
                </div>
                <div>
                    <h4>5. RECOMMENDATION</h4>
                    <p>{{ $items['approvalDetails']->recommendation_description }}</p>
                </div>
            </div>
            <div class="page_break">
                <div class="prepared-by">
                    <table class="prepared-by-table" style="width: 100%; border: 1px solid black;">
                        <thead>
                            <tr style="background-color: rgb(179, 177, 177)">
                                <th style="width: 40%">Prepared by </th>
                                <th style="width: 30%">Signature </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="table-td"> {{ $items['approvalDetails']->approval_request_from }} </td>
                                @foreach ($items['prepared_by'] as $ppitem)
                                    @php
                                        $image = "signatures/$ppitem->usignature";
                                    @endphp
                                    <td class="table-td">
                                        <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(@$image)) }}"
                                            alt="" style="height: 50px; width: 200px; ">
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
                @foreach ($items['supports'] as $pitem)
                    <div class="supported-by" style="margin-top: 5px">
                        <table class="supported-by-table" style="width: 100%; border: 1px solid black;">
                            <tr style="background-color: rgb(179, 177, 177)">
                                <th style="width: 40%">Supported by </th>
                                <th style="width: 30%">Signature </th>
                            </tr>
                            <tr>
                                <td class="table-td">{{ $pitem->uname }}, <br> {{ $pitem->udesignation }} </td>
                                @php
                                    $image = "signatures/$pitem->usignature";
                                @endphp
                                <td class="table-td">
                                    @if ($pitem->supported_by_approval_status == 0)
                                    @elseif ($pitem->supported_by_approval_status == 1)
                                        <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(@$image)) }}"
                                            alt="" style="height: 50px; width: 200px; ">
                                    @elseif ($pitem->supported_by_approval_status == 2)
                                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/rejected.png'))) }}"
                                            alt="" style="height: 50px; width: 200px;">
                                    @endif

                                </td>
                            </tr>
                        </table>
                    </div>
                @endforeach

                @foreach ($items['checks'] as $pitem)
                    <div class="checked-by" style="margin-top: 5px">
                        <table class="checked-by-table" style="width: 100%">
                            <tr style="background-color: rgb(179, 177, 177)">
                                <th style="width: 40%">Checked by</th>
                                {{-- <th style="width: 30%">Remarks </th> --}}
                                <th style="width: 30%">Signature </th>
                            </tr>
                            <tr>
                                <td class="table-td">{{ $pitem->uname }}, <br> {{ $pitem->udesignation }} </td>
                                {{-- <td class="table-td"></td> --}}
                                @php
                                    $image = "signatures/$pitem->usignature";
                                @endphp
                                <td class="table-td">
                                    @if ($pitem->checked_by_approval_status == 0)
                                    @elseif ($pitem->checked_by_approval_status == 1)
                                        <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(@$image)) }}"
                                            alt="" style="height: 50px; width: 200px; ">
                                    @elseif ($pitem->checked_by_approval_status == 2)
                                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/rejected.png'))) }}"
                                            alt="" style="height: 50px; width: 200px;">
                                    @endif

                                </td>
                            </tr>
                        </table>
                    </div>
                @endforeach

                @foreach ($items['reviews'] as $pitem)
                    <div class="reviewed-by" style="margin-top: 5px">
                        <table class="reviewed-by-table" style="width: 100%">
                            <tr style="background-color: rgb(179, 177, 177)">
                                <th style="width: 40%">Reviewed by </th>
                                {{-- <th style="width: 30%">Remarks </th> --}}
                                <th style="width: 30%">Signature </th>
                            </tr>
                            <tr>
                                <td class="table-td">{{ $pitem->uname }}, <br> {{ $pitem->udesignation }}</td>
                                {{-- <td class="table-td"></td> --}}
                                @php
                                    $image = "signatures/$pitem->usignature";
                                @endphp
                                <td class="table-td">
                                    @if ($pitem->reviewed_by_approval_status == 0)
                                    @elseif ($pitem->reviewed_by_approval_status == 1)
                                        <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(@$image)) }}"
                                            alt="" style="height: 50px; width: 200px; ">
                                    @elseif ($pitem->reviewed_by_approval_status == 2)
                                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/rejected.png'))) }}"
                                            alt="" style="height: 50px; width: 200px;">
                                    @endif

                                </td>
                            </tr>
                        </table>
                    </div>
                @endforeach

                @foreach ($items['recommends'] as $pitem)
                    <div class="recommended-by" style="margin-top: 5px">
                        <table class="recommended-by-table" style="width: 100%">
                            <tr style="background-color: rgb(179, 177, 177)">
                                <th style="width: 40%">Recommended by </th>
                                {{-- <th style="width: 30%">Remarks </th> --}}
                                <th style="width: 30%">Signature </th>
                            </tr>
                            <tr>
                                <td class="table-td">{{ $pitem->uname }}, <br> {{ $pitem->udesignation }}</td>
                                {{-- <td class="table-td"></td> --}}
                                @php
                                    $image = "signatures/$pitem->usignature";
                                @endphp
                                <td class="table-td">
                                    @if ($pitem->recommended_by_approval_status == 0)
                                    @elseif ($pitem->recommended_by_approval_status == 1)
                                        <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(@$image)) }}"
                                            alt="" style="height: 50px; width: 200px; ">
                                    @elseif ($pitem->recommended_by_approval_status == 2)
                                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/rejected.png'))) }}"
                                            alt="" style="height: 50px; width: 200px;">
                                    @endif

                                </td>
                            </tr>
                        </table>
                    </div>
                @endforeach

                @foreach ($items['approves'] as $pitem)
                    <div class="approved-by border border-dark" style="margin-top: 5px;">
                        <table class="approved-by-table" style="width: 100%;">
                            <tr style="background-color: rgb(179, 177, 177)">
                                <th style="width: 40%">Approved by </th>
                                {{-- <th style="width: 30%">Remarks </th> --}}
                                <th style="width: 30%">Signature </th>
                            </tr>
                            <tr>
                                <td class="table-td">{{ $pitem->uname }}, <br> {{ $pitem->udesignation }}</td>
                                {{-- <td class="table-td"></td> --}}
                                @php
                                    $image = "signatures/$pitem->usignature";
                                @endphp
                                <td class="table-td">
                                    @if ($pitem->approved_by_approval_status == 0)
                                    @elseif ($pitem->approved_by_approval_status == 1)
                                        <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(@$image)) }}"
                                            alt="" style="height: 50px; width: 200px; ">
                                    @elseif ($pitem->approved_by_approval_status == 2)
                                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/rejected.png'))) }}"
                                            alt="" style="height: 50px; width: 200px;">
                                    @endif

                                </td>
                            </tr>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    </body>
@endforeach

</html>
