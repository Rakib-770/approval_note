<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Approval;
use App\Models\ApprovedBy;
use App\Models\Background;
use App\Models\BillApproval;
use App\Models\CheckedBy;
use App\Models\Enclosure;
use App\Models\Justification;
use App\Models\Objective;
use App\Models\Proposal;
use App\Models\Recommendation;
use App\Models\RecommendedBy;
use App\Models\ReviewedBy;
use App\Models\SupportedBy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BillApprovalController extends Controller
{
    public function index()
    {
        return view('bill-approval');
    }

    public function getUserCompany()
    {
        $userData['users'] = DB::table('users')->get();
        $companyData['companies'] = DB::table('companies')->get();
        return view('bill-approval', $userData, $companyData);
    }

    public function storeBillApprovalData(Request $request)
    {
        // Store data into Approvals Table--START

        $approval_table_data = new Approval();
        $last_approval_table_id = DB::table('approvals')
            ->select('approval_note_id')
            ->orderBy('approval_note_id', 'DESC')
            ->first();
        if ($last_approval_table_id !== null) {
            $approval_table_data->approval_note_id = $last_approval_table_id->approval_note_id + 1;
        } else {
            $approval_table_data->approval_note_id = 1;
        }
        $getUserDepartment = Auth::user()->department;
        $getUserDepartmentName = DB::table('departments')
            ->select('department_name')
            ->where('department_id', $getUserDepartment)
            ->first();
        $approval_table_data->addressed_to_id = NULL;
        $approval_table_data->approval_for_company_id = $request->company;
        $approval_table_data->approval_note_date = $request->date;
        $approval_table_data->prepared_by_id = Auth::user()->id;
        $approval_table_data->approval_request_from = Auth::user()->name . ", " . Auth::user()->designation . ", " . $getUserDepartmentName->department_name;
        $approval_table_data->approval_note_subject = $request->subject;
        $approval_table_data->approval_note_reference_no = "Approval" . "/" . $approval_table_data->approval_note_id . "/" . $request->date;
        $approval_table_data->is_bill = 1;
        $approval_table_data->created_at = Carbon::now();
        $approval_table_data->updated_at = now();
        $approval_table_data->save();

        // Store data into Approvals Table--END

        // Store data into bill_approval

        $bill_approval_table_data = new BillApproval();

        // Get the last ID from the 'bill_approvals' table
        $last_bill_approval_table_id = DB::table('bill_approvals')
            ->select('id')
            ->orderBy('id', 'DESC')
            ->first();

        // Calculate the new ID based on the last ID
        if ($last_bill_approval_table_id !== null) {
            $bill_approval_table_data->id = $last_bill_approval_table_id->id + 1;
        } else {
            $bill_approval_table_data->id = 1;
        }

        // Set other attributes of the model
        $bill_approval_table_data->approval_note_id = $approval_table_data->approval_note_id;
        $bill_approval_table_data->bill_approval_description = $request->description;
        $bill_approval_table_data->bill_approval_narration = $request->narration;
        $bill_approval_table_data->amount = $request->amount;

        // Handle file upload

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $request->date . "-" . $approval_table_data->approval_note_id . "." . $file->getClientOriginalExtension();

            // Store the file in the "bills" directory
            $file->move(public_path('bills'), $fileName);

            // Set the 'file' attribute in the model
            $bill_approval_table_data->file = $fileName;
        }
        $bill_approval_table_data->save();


        // Store data into Bill_Approvals Table--END


        // Store data into Supported_By Table--START
        if ($request->supportedByArray != NULL) {
            $supportedBy_table_data = new SupportedBy();
            $supported_by_array = $request->supportedByArray;
            for ($i = 0; $i < count($supported_by_array); $i++) {
                $last_supportedBy_table_id = DB::table('supported_bies')
                    ->select('id')
                    ->orderBy('id', 'DESC')
                    ->first();

                $next_id = $last_supportedBy_table_id !== null ? $last_supportedBy_table_id->id + 1 : 1;

                $datasave = [
                    'id' => $next_id,
                    'approval_note_id' => $approval_table_data->approval_note_id,
                    'supported_by_id' => $request->supportedByArray[$i],
                    'approval_status' => ($request->supportedByArray[$i] == 404) ? 200 : 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => now(),
                ];
                DB::table('supported_bies')->insert($datasave);
            }
        }

        // Store data into Checked_By Table--START
        if ($request->checkedByArray != NULL) {
            $checkedBy_table_data = new CheckedBy();
            $checked_by_array = $request->checkedByArray;
            for ($i = 0; $i < count($checked_by_array); $i++) {
                $last_checkedBy_table_id = DB::table('checked_bies')
                    ->select('id')
                    ->orderBy('id', 'DESC')
                    ->first();
                $next_id = $last_checkedBy_table_id !== null ? $last_checkedBy_table_id->id + 1 : 1;

                $datasave = [
                    'id' => $next_id,
                    'approval_note_id' => $approval_table_data->approval_note_id,
                    'checked_by_id' => $request->checkedByArray[$i],
                    'approval_status' => ($request->checkedByArray[$i] == 404) ? 200 : 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => now(),
                ];
                DB::table('checked_bies')->insert($datasave);
            }
        }

        // Store data into Checked_By Table--END


        // Store data into Reviewed_By Table--START
        if ($request->reviewedByArray != NULL) {
            $reviewedBy_table_data = new ReviewedBy();
            $reviewed_by_array = $request->reviewedByArray;
            for ($i = 0; $i < count($reviewed_by_array); $i++) {
                $last_reviewedBy_table_id = DB::table('reviewed_bies')
                    ->select('id')
                    ->orderBy('id', 'DESC')
                    ->first();
                $next_id = $last_reviewedBy_table_id !== null ? $last_reviewedBy_table_id->id + 1 : 1;

                $datasave = [
                    'id' => $next_id,
                    'approval_note_id' => $approval_table_data->approval_note_id,
                    'reviewed_by_id' => $request->reviewedByArray[$i],
                    'approval_status' => ($request->reviewedByArray[$i] == 404) ? 200 : 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => now(),
                ];
                DB::table('reviewed_bies')->insert($datasave);
            }
        }

        // Store data into Reviewed_By Table--END


        // Store data into Recommended_By Table--START
        if ($request->recommendedByArray != NULL) {
            $recommendedBy_table_data = new RecommendedBy();
            $recommended_by_array = $request->recommendedByArray;
            for ($i = 0; $i < count($recommended_by_array); $i++) {
                $last_recommendedBy_table_id = DB::table('recommended_bies')
                    ->select('id')
                    ->orderBy('id', 'DESC')
                    ->first();
                $next_id = $last_recommendedBy_table_id !== null ? $last_recommendedBy_table_id->id + 1 : 1;

                $datasave = [
                    'id' => $next_id,
                    'approval_note_id' => $approval_table_data->approval_note_id,
                    'recommended_by_id' => $request->recommendedByArray[$i],
                    'approval_status' => ($request->recommendedByArray[$i] == 404) ? 200 : 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => now(),
                ];
                DB::table('recommended_bies')->insert($datasave);
            }
        }

        // Store data into Recommended_By Table--END


        // Store data into Approved_By Table--START

        $approvedBy_table_data = new ApprovedBy();
        $approved_by_array = $request->approvedByArray;
        for ($i = 0; $i < count($approved_by_array); $i++) {
            $last_approvedBy_table_id = DB::table('approved_bies')
                ->select('id')
                ->orderBy('id', 'DESC')
                ->first();
            $next_id = $last_approvedBy_table_id !== null ? $last_approvedBy_table_id->id + 1 : 1;

            $datasave = [
                'id' => $next_id,
                'approval_note_id' => $approval_table_data->approval_note_id,
                'approved_by_id' => $request->approvedByArray[$i],
                'approval_status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => now(),
            ];
            DB::table('approved_bies')->insert($datasave);
        }

        // Store data into Approved_By Table--END

        Session::flash('msg', 'Bill Successfully Sent');

        return redirect()->back();
    }
}
