<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;


class PDFBillApprovalNoteController extends Controller
{
    public function generatePDFBillApprovalNote($id = null)
    {
        $bill_approval_note_details = DB::table('approvals')
            ->join('bill_approvals', 'approvals.approval_note_id', '=', 'bill_approvals.approval_note_id')
            // ->join('users', 'approvals.addressed_to_id', '=', 'users.id')
            ->where('approvals.approval_note_id', $id)
            ->get();
        $final_arr = array();
        foreach ($bill_approval_note_details as $key => $value) {

            $bill_details = DB::table('approvals')
                ->select(
                    'bill_approvals.bill_approval_description',
                    'bill_approvals.bill_approval_narration'
                )
                ->Join('bill_approvals', 'approvals.approval_note_id', '=', 'bill_approvals.approval_note_id')
                ->where('bill_approvals.approval_note_id', $value->approval_note_id)
                ->get();

            $supports = DB::table('users')
                ->select(
                    'supported_bies.supported_by_id as si',
                    'supported_bies.approval_status as supported_by_approval_status',
                    'users.name as uname',
                    'users.email as uemail',
                    'users.designation as udesignation',
                    'users.signature as usignature',
                )
                ->Join('supported_bies', 'users.id', '=', 'supported_bies.supported_by_id')
                ->where('supported_bies.approval_note_id', $value->approval_note_id)
                ->get();

            $checks = DB::table('users')
                ->select(
                    'checked_bies.checked_by_id as ci',
                    'checked_bies.approval_status as checked_by_approval_status',
                    'users.name as uname',
                    'users.designation as udesignation',
                    'users.signature as usignature',
                )
                ->Join('checked_bies', 'users.id', '=', 'checked_bies.checked_by_id')
                ->where('checked_bies.approval_note_id', $value->approval_note_id)
                ->get();

            $reviews = DB::table('users')
                ->select(
                    'reviewed_bies.reviewed_by_id as ri',
                    'reviewed_bies.approval_status as reviewed_by_approval_status',
                    'users.name as uname',
                    'users.designation as udesignation',
                    'users.signature as usignature',
                )
                ->Join('reviewed_bies', 'users.id', '=', 'reviewed_bies.reviewed_by_id')
                ->where('reviewed_bies.approval_note_id', $value->approval_note_id)
                ->get();

            $recommends = DB::table('users')
                ->select(
                    'recommended_bies.recommended_by_id as rri',
                    'recommended_bies.approval_status as recommended_by_approval_status',
                    'users.name as uname',
                    'users.designation as udesignation',
                    'users.signature as usignature',
                )
                ->Join('recommended_bies', 'users.id', '=', 'recommended_bies.recommended_by_id')
                ->where('recommended_bies.approval_note_id', $value->approval_note_id)
                ->get();

            $approves = DB::table('users')
                ->select(
                    'approved_bies.approved_by_id as api',
                    'approved_bies.approval_status as approved_by_approval_status',
                    'users.name as uname',
                    'users.designation as udesignation',
                    'users.signature as usignature',
                )
                ->Join('approved_bies', 'users.id', '=', 'approved_bies.approved_by_id')
                ->where('approved_bies.approval_note_id', $value->approval_note_id)
                ->get();

            $prepared_by = DB::table('users')
                ->select(
                    'approvals.prepared_by_id as ppi',
                    'users.name as uname',
                    'users.signature as usignature',
                )
                ->Join('approvals', 'users.id', '=', 'approvals.prepared_by_id')
                ->where('approvals.approval_note_id', $value->approval_note_id)
                ->get();

            $temp['approvalDetails'] = $bill_approval_note_details[$key];
            $temp['billDetails'] = $bill_details;
            $temp['supports'] = $supports;
            $temp['checks'] = $checks;
            $temp['reviews'] = $reviews;
            $temp['recommends'] = $recommends;
            $temp['approves'] = $approves;
            $temp['prepared_by'] = $prepared_by;
            array_push($final_arr, $temp);
        }

        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('pdf-bill-approval-note', compact('final_arr')));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("name", array('Attachment' => false));
    }

    public static function getBangladeshCurrency($number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(
            0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
        );
        $digits = array('', 'hundred', 'thousand', 'lac', 'crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else $str[] = null;
        }
        $Taka = implode('', array_reverse($str));
        $poysa = ($decimal) ? " and " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' paisa' : '';
        return ($Taka ? $Taka . 'taka ' : '') . $poysa;
    }
}
