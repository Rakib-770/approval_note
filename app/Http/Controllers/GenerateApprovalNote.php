<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\ApprovedBy;
use App\Models\Background;
use App\Models\CheckedBy;
use App\Models\Justification;
use App\Models\Objective;
use App\Models\Proposal;
use App\Models\Recommendation;
use App\Models\RecommendedBy;
use App\Models\ReviewedBy;
use App\Models\SupportedBy;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;


class GenerateApprovalNote extends Controller
{
    public function index()
    {
        return view('generate-approval-note');
    }

    public function getUser()
    {
        $userData['users'] = DB::table('users')->get();
        $companyData['companies'] = DB::table('companies')->get();
        return view('generate-approval-note', $userData, $companyData);
    }

    public function storeApprovalData(Request $request)
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
        $approval_table_data->addressed_to_id = $request->addressedTo;
        $approval_table_data->approval_for_company_id = $request->company;
        $approval_table_data->approval_note_date = $request->date;
        $approval_table_data->prepared_by_id = Auth::user()->id;
        $approval_table_data->approval_request_from = Auth::user()->name . ", " . Auth::user()->designation . ", " . $getUserDepartmentName->department_name;
        $approval_table_data->approval_note_subject = $request->subject;
        $approval_table_data->approval_note_reference_no = "Approval" . "/" . $approval_table_data->approval_note_id . "/" . $request->date;
        $approval_table_data->is_bill = 0;
        $approval_table_data->created_at = Carbon::now();
        $approval_table_data->updated_at = now();
        $approval_table_data->save();


        // Store data into Approvals Table--END


        // Store data into Objectives Table--START

        $objective_table_data = new Objective();
        $last_objective_table_id = DB::table('objectives')
            ->select('objective_id')
            ->orderBy('objective_id', 'DESC')
            ->first();
        if ($last_objective_table_id !== null) {
            $objective_table_data->objective_id = $last_objective_table_id->objective_id + 1;
        } else {
            $objective_table_data->objective_id = 1;
        }

        $objective_table_data->approval_note_id = $approval_table_data->approval_note_id;
        $objective_table_data->objective_description = $request->objective_description;
        $objective_table_data->created_at = Carbon::now();
        $objective_table_data->updated_at = now();
        $objective_table_data->save();

        // Store data into Objectives Table--END


        // Store data into Background Table--START

        $background_table_data = new Background();
        $last_background_table_id = DB::table('backgrounds')
            ->select('background_id')
            ->orderBy('background_id', 'DESC')
            ->first();
        if ($last_background_table_id !== null) {
            $background_table_data->background_id = $last_background_table_id->background_id + 1;
        } else {
            $background_table_data->background_id = 1;
        }

        $background_table_data->approval_note_id = $approval_table_data->approval_note_id;
        $background_table_data->background_description = $request->background_description;
        $background_table_data->created_at = Carbon::now();
        $background_table_data->updated_at = now();
        $background_table_data->save();

        // Store data into Background Table--END

        // Store data into Proposal Table--START

        $proposal_table_data = new Proposal();
        $last_proposal_table_id = DB::table('proposals')
            ->select('proposal_id')
            ->orderBy('proposal_id', 'DESC')
            ->first();
        if ($last_proposal_table_id !== null) {
            $proposal_table_data->proposal_id = $last_proposal_table_id->proposal_id + 1;
        } else {
            $proposal_table_data->proposal_id = 1;
        }

        $proposal_table_data->approval_note_id = $approval_table_data->approval_note_id;
        $proposal_table_data->proposal_description = $request->proposal_description;
        $proposal_table_data->created_at = Carbon::now();
        $proposal_table_data->updated_at = now();
        $proposal_table_data->save();

        // Store data into Proposal Table--END

        // Store data into Justification Table--START

        $justification_table_data = new Justification();
        $last_justification_table_id = DB::table('justifications')
            ->select('justification_id')
            ->orderBy('justification_id', 'DESC')
            ->first();
        if ($last_justification_table_id !== null) {
            $justification_table_data->justification_id = $last_justification_table_id->justification_id + 1;
        } else {
            $justification_table_data->justification_id = 1;
        }

        $justification_table_data->approval_note_id = $approval_table_data->approval_note_id;
        $justification_table_data->justification_description = $request->justification_description;
        $justification_table_data->created_at = Carbon::now();
        $justification_table_data->updated_at = now();
        $justification_table_data->save();

        // Store data into Justification Table--END

        // Store data into Recommendation Table--START

        $recommendation_table_data = new Recommendation();
        $last_recommendation_table_id = DB::table('recommendations')
            ->select('recommendation_id')
            ->orderBy('recommendation_id', 'DESC')
            ->first();
        if ($last_recommendation_table_id !== null) {
            $recommendation_table_data->recommendation_id = $last_recommendation_table_id->recommendation_id + 1;
        } else {
            $recommendation_table_data->recommendation_id = 1;
        }

        $recommendation_table_data->approval_note_id = $approval_table_data->approval_note_id;
        $recommendation_table_data->recommendation_description = $request->recommendation_description;
        $recommendation_table_data->created_at = Carbon::now();
        $recommendation_table_data->updated_at = now();
        $recommendation_table_data->save();

        // Store data into Recommendation Table--END


        // Store data into Supported_By Table--START

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

        // Store data into Checked_By Table--START

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

        // Store data into Checked_By Table--END


        // Store data into Reviewed_By Table--START

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

        // Store data into Reviewed_By Table--END


        // Store data into Recommended_By Table--START

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

        Session::flash('msg', 'Approval note Successfully Generated');

        return redirect()->back();
    }
}
