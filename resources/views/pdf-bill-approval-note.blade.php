<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="path-to-bootstrap-css/bootstrap.min.css">
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

        .header-table-td {
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
                        <h1>Bill Approval</h1>
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
            <div class="" style="margin-bottom: 30px">
                <table class="header-table">
                    <tr>
                        <td>Date: {{ $items['approvalDetails']->approval_note_date }}</td>
                        <td>Reference no: {{ $items['approvalDetails']->approval_note_reference_no }}</td>
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
                @if ($items['approvalDetails']->bill_approval_description != null)
                    <div class="">
                        <p class=""><span style="font-weight: 100">Description:</span>
                            {{ $items['approvalDetails']->bill_approval_description }}</p>
                    </div>
                @endif

                @if ($items['approvalDetails']->bill_approval_narration != null)
                    <div class="">
                        <p class=""><span style="font-weight: 100">Narration</span> :
                            {{ $items['approvalDetails']->bill_approval_narration }}</p>
                    </div>
                @endif

                <div class="">
                    <p class=""><span style="font-weight: 100">Amount</span> :
                        {{ number_format($items['approvalDetails']->amount, 2) }} BDT
                    </p>
                </div>
                <div class="">
                    <p class=""><span style="font-weight: 100">In word</span> :
                        @php
                            $moneyInWord = App\Http\Controllers\PDFBillApprovalNoteController::getBangladeshCurrency($items['approvalDetails']->amount);
                            echo $moneyInWord;
                        @endphp
                    </p>
                </div>
            </div>

            <table class="header-table">
                <tr>
                    <td class="header-table-td">Prepared By
                        <br>
                        @foreach ($items['prepared_by'] as $ppitem)
                            @php
                                $image = "signatures/$ppitem->usignature";
                            @endphp

                            <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(@$image)) }}"
                                alt="" style="height: 50px; width: 200px; ">
                        @endforeach
                        <br>
                        <br>
                        {{ $items['approvalDetails']->approval_request_from }}
                    </td>
                </tr> <br>
            </table>

            <table class="header-table">
                <tr>
                    @foreach ($items['supports'] as $pitem)
                        @if ($pitem != null)
                            <td class="header-table-td">Supported By
                                <br>
                                <br>
                                <br>
                                @php
                                    $image = "signatures/$pitem->usignature";
                                @endphp
                                @if ($pitem->supported_by_approval_status == 0)
                                @elseif ($pitem->supported_by_approval_status == 1)
                                    <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(@$image)) }}"
                                        alt="" style="height: 50px; width: 200px; ">
                                @elseif ($pitem->supported_by_approval_status == 2)
                                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/rejected.png'))) }}"
                                        alt="" style="height: 50px; width: 200px;">
                                @endif
                                <br>
                                <br>
                                <br>
                                {{ $pitem->uname }}, <br> {{ $pitem->udesignation }}
                            </td>
                        @endif
                    @endforeach

                    @foreach ($items['checks'] as $pitem)
                        @if ($pitem != null)
                            <td class="header-table-td">Checked By
                                <br>
                                <br>
                                <br>
                                @php
                                    $image = "signatures/$pitem->usignature";
                                @endphp
                                @if ($pitem->checked_by_approval_status == 0)
                                @elseif ($pitem->checked_by_approval_status == 1)
                                    <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(@$image)) }}"
                                        alt="" style="height: 50px; width: 200px; ">
                                @elseif ($pitem->checked_by_approval_status == 2)
                                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/rejected.png'))) }}"
                                        alt="" style="height: 50px; width: 200px;">
                                @endif
                                <br>
                                <br>
                                <br>
                                {{ $pitem->uname }}, <br> {{ $pitem->udesignation }}
                            </td>
                        @endif
                    @endforeach

                    @foreach ($items['reviews'] as $pitem)
                        @if ($pitem != null)
                            <td class="header-table-td">Reviewed By
                                <br>
                                <br>
                                <br>
                                @php
                                    $image = "signatures/$pitem->usignature";
                                @endphp
                                @if ($pitem->reviewed_by_approval_status == 0)
                                @elseif ($pitem->reviewed_by_approval_status == 1)
                                    <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(@$image)) }}"
                                        alt="" style="height: 50px; width: 200px; ">
                                @elseif ($pitem->reviewed_by_approval_status == 2)
                                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/rejected.png'))) }}"
                                        alt="" style="height: 50px; width: 200px;">
                                @endif
                                <br>
                                <br>
                                <br>
                                {{ $pitem->uname }}, <br> {{ $pitem->udesignation }}
                            </td>
                        @endif
                    @endforeach

                    @foreach ($items['recommends'] as $pitem)
                        @if ($pitem != null)
                            <td class="header-table-td">Recommended By
                                <br>
                                <br>
                                <br>
                                @php
                                    $image = "signatures/$pitem->usignature";
                                @endphp
                                @if ($pitem->recommended_by_approval_status == 0)
                                @elseif ($pitem->recommended_by_approval_status == 1)
                                    <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(@$image)) }}"
                                        alt="" style="height: 50px; width: 200px; ">
                                @elseif ($pitem->recommended_by_approval_status == 2)
                                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/rejected.png'))) }}"
                                        alt="" style="height: 50px; width: 200px;">
                                @endif
                                <br>
                                <br>
                                <br>
                                {{ $pitem->uname }}, <br> {{ $pitem->udesignation }}
                            </td>
                        @endif
                    @endforeach

                    @foreach ($items['approves'] as $pitem)
                        @if ($pitem != null)
                            <td class="header-table-td">Approved By
                                <br>
                                <br>
                                <br>
                                @php
                                    $image = "signatures/$pitem->usignature";
                                @endphp
                                @if ($pitem->approved_by_approval_status == 0)
                                @elseif ($pitem->approved_by_approval_status == 1)
                                    <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(@$image)) }}"
                                        alt="" style="height: 50px; width: 200px; ">
                                @elseif ($pitem->approved_by_approval_status == 2)
                                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/rejected.png'))) }}"
                                        alt="" style="height: 50px; width: 200px;">
                                @endif
                                <br>
                                <br>
                                <br>
                                {{ $pitem->uname }}, <br> {{ $pitem->udesignation }}
                            </td>
                        @endif
                    @endforeach
                </tr>
            </table>
        </div>
    </header>
@endforeach

</html>
