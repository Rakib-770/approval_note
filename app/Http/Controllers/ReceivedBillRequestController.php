<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReceivedBillRequestController extends Controller
{
    public function index()
    {
        return view('received-bill-request');
    }

    public function getReceivedBillRequests()
    {
        $userId = Auth::user()->id;
        $receivedBillRequests = DB::table('approvals')
            ->select(
                'approvals.approval_note_id',
                'approvals.approval_note_subject',
                'approvals.approval_note_date',
                'approvals.approval_request_from',
            )
            ->join('supported_bies', 'approvals.approval_note_id', '=', 'supported_bies.approval_note_id')
            ->leftJoin('checked_bies', function ($join) {
                $join->on('approvals.approval_note_id', '=', 'checked_bies.approval_note_id')
                    ->where('supported_bies.approval_status', '=', 1)
                    ->orWhere('supported_bies.approval_status', '=', 200);
            })
            ->leftJoin('reviewed_bies', function ($join) {
                $join->on('approvals.approval_note_id', '=', 'reviewed_bies.approval_note_id')
                    ->where('checked_bies.approval_status', '=', 1)
                    ->orWhere('checked_bies.approval_status', '=', 200);
            })
            ->leftJoin('recommended_bies', function ($join) {
                $join->on('approvals.approval_note_id', '=', 'recommended_bies.approval_note_id')
                    ->where('reviewed_bies.approval_status', '=', 1)
                    ->orWhere('reviewed_bies.approval_status', '=', 200);
            })
            ->leftJoin('approved_bies', function ($join) {
                $join->on('approvals.approval_note_id', '=', 'approved_bies.approval_note_id')
                    ->where('recommended_bies.approval_status', '=', 1)
                    ->orWhere('recommended_bies.approval_status', '=', 200);
            })
            ->where(function ($query) use ($userId) {
                $query->where('supported_bies.supported_by_id', $userId)
                    ->orWhere('checked_bies.checked_by_id', $userId)
                    ->orWhere('reviewed_bies.reviewed_by_id', $userId)
                    ->orWhere('recommended_bies.recommended_by_id', $userId)
                    ->orWhere('approved_bies.approved_by_id', $userId);
            })
            ->where('approvals.is_bill', '=', 1)
            ->groupBy('approvals.approval_note_id')
            ->groupBy('approvals.approval_note_subject')
            ->groupBy('approvals.approval_note_date')
            ->groupBy('approvals.approval_request_from')
            ->orderBy('approvals.approval_note_id', 'desc')
            ->paginate(10);

        return view('received-bill-request', compact('receivedBillRequests'));
    }

    public function acceptBillApprovalNote($id = null)
    {
        $userId = Auth::user()->id;
        $varSupport = DB::table('supported_bies')
            ->where('approval_note_id', $id)
            ->where([
                ['approval_note_id', '=', $id],
                ['supported_by_id', '=', $userId]
            ])
            ->update(
                ['approval_status' => 1],
                ['updated_at' => now()]
            );

        $varChecked = DB::table('checked_bies')
            ->where('approval_note_id', $id)
            ->where([
                ['approval_note_id', '=', $id],
                ['checked_by_id', '=', $userId]
            ])
            ->update(
                ['approval_status' => 1],
                ['updated_at' => now()]
            );

        $varReviewed = DB::table('reviewed_bies')
            ->where('approval_note_id', $id)
            ->where([
                ['approval_note_id', '=', $id],
                ['reviewed_by_id', '=', $userId]
            ])
            ->update(
                ['approval_status' => 1],
                ['updated_at' => now()]
            );

        $varRecommend = DB::table('recommended_bies')
            ->where('approval_note_id', $id)
            ->where([
                ['approval_note_id', '=', $id],
                ['recommended_by_id', '=', $userId]
            ])
            ->update(
                ['approval_status' => 1],
                ['updated_at' => now()]
            );

        $varRecommend = DB::table('approved_bies')
            ->where('approval_note_id', $id)
            ->where([
                ['approval_note_id', '=', $id],
                ['approved_by_id', '=', $userId]
            ])
            ->update(
                ['approval_status' => 1],
                ['updated_at' => now()]
            );
        Session::flash('msg', 'Bill Successfully Approved');
        return redirect('/received-bill-request');
    }


    public function rejectBillApprovalNote($id = null)
    {
        $userId = Auth::user()->id;
        $varSupport = DB::table('supported_bies')
            ->where('approval_note_id', $id)
            ->where([
                ['approval_note_id', '=', $id],
                ['supported_by_id', '=', $userId]
            ])
            ->update(
                ['approval_status' => 2],
                ['updated_at' => now()]
            );

        $varChecked = DB::table('checked_bies')
            ->where('approval_note_id', $id)
            ->where([
                ['approval_note_id', '=', $id],
                ['checked_by_id', '=', $userId]
            ])
            ->update(
                ['approval_status' => 2],
                ['updated_at' => now()]
            );

        $varReviewed = DB::table('reviewed_bies')
            ->where('approval_note_id', $id)
            ->where([
                ['approval_note_id', '=', $id],
                ['reviewed_by_id', '=', $userId]
            ])
            ->update(
                ['approval_status' => 2],
                ['updated_at' => now()]
            );

        $varRecommend = DB::table('recommended_bies')
            ->where('approval_note_id', $id)
            ->where([
                ['approval_note_id', '=', $id],
                ['recommended_by_id', '=', $userId]
            ])
            ->update(
                ['approval_status' => 2],
                ['updated_at' => now()]
            );

        $varRecommend = DB::table('approved_bies')
            ->where('approval_note_id', $id)
            ->where([
                ['approval_note_id', '=', $id],
                ['approved_by_id', '=', $userId]
            ])
            ->update(
                ['approval_status' => 2],
                ['updated_at' => now()]
            );
        Session::flash('msgReject', 'Bill Successfully Rejected');
        return redirect('/received-bill-request');
    }
}
