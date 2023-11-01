<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;



use Illuminate\Http\Request;

class PDFApprovalNoteController extends Controller
{
    public function generatePDFApprovalNote($id = null)
    {
        $approval_note_details = DB::table('approvals')
            ->join('objectives', 'approvals.approval_note_id', '=', 'objectives.approval_note_id')
            ->join('backgrounds', 'approvals.approval_note_id', '=', 'backgrounds.approval_note_id')
            ->join('proposals', 'approvals.approval_note_id', '=', 'proposals.approval_note_id')
            ->join('justifications', 'approvals.approval_note_id', '=', 'justifications.approval_note_id')
            ->join('recommendations', 'approvals.approval_note_id', '=', 'recommendations.approval_note_id')
            ->join('users', 'approvals.addressed_to_id', '=', 'users.id')
            ->where('approvals.approval_note_id', $id)
            ->get();

            // print_r($approval_note_details);
            // exit();


        $final_arr = array();
        foreach ($approval_note_details as $key => $value) {

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

            $temp['approvalDetails'] = $approval_note_details[$key];
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
        $dompdf->loadHtml(view('pdf-approval-note', compact('final_arr')));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("name", array('Attachment' => false));
    }
}
