<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Background;
use App\Models\BillApproval;
use App\Models\Justification;
use App\Models\Objective;
use App\Models\Proposal;
use App\Models\Recommendation;
use Illuminate\Support\Facades\File;

class SentRequestController extends Controller
{
    public function index()
    {
        return view('sent-request');
    }

    public function getSentRequests()
    {
        $userId = Auth::user()->id;

        $sentRequests = DB::table('Approvals')
            ->where('prepared_by_id', $userId)
            ->orderBy('approval_note_id', 'desc')
            ->paginate(10);
        return view('sent-request', compact('sentRequests'));
    }

    public function deleteData($id = null)
    {
        // $deleteData = Approval::find($id);
        $deleteData = DB::table('Approvals')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteData = DB::table('approved_bies')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteData = DB::table('backgrounds')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteData = DB::table('checked_bies')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteData = DB::table('justifications')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteData = DB::table('objectives')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteData = DB::table('proposals')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteData = DB::table('recommendations')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteData = DB::table('recommended_bies')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteData = DB::table('reviewed_bies')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteData = DB::table('supported_bies')
            ->where('approval_note_id', $id)
            ->delete();

        Session::flash('msg', 'Approval note Successfully Deleted');
        return redirect('/sent-request');
    }


    public function editApprovalNote($id = null)
    {

        $userData = DB::table('users')->get();

        $companyData = DB::table('companies')->get();

        $editApprovalsID = DB::table('approvals')
            ->where('approval_note_id', $id)->first();

        $editApprovals = DB::table('approvals')
            ->where('approval_note_id', $id)->get();

        $editObjectives = DB::table('objectives')
            ->where('approval_note_id', $id)->get();

        $editBackgrounds = DB::table('backgrounds')
            ->where('approval_note_id', $id)->get();

        $editProposals = DB::table('proposals')
            ->where('approval_note_id', $id)->get();

        $editJustifications = DB::table('justifications')
            ->where('approval_note_id', $id)->get();

        $editRecommendations = DB::table('recommendations')
            ->where('approval_note_id', $id)->get();

        $editSupportedBies = DB::table('supported_bies')
            ->where('approval_note_id', $id)->get();
            // print_r($editSupportedBies);
            // exit();

        $editCheckedBies = DB::table('checked_bies')
            ->where('approval_note_id', $id)->get();

        $editReviewedBies = DB::table('reviewed_bies')
            ->where('approval_note_id', $id)->get();

        $editRecommendedBies = DB::table('recommended_bies')
            ->where('approval_note_id', $id)->get();

        $editApprovedBies = DB::table('approved_bies')
            ->where('approval_note_id', $id)->get();

        return view('edit-approval-note', compact('editApprovalsID', 'userData', 'companyData', 'editApprovals', 'editObjectives', 'editBackgrounds', 'editProposals', 'editJustifications', 'editRecommendations', 'editSupportedBies', 'editCheckedBies', 'editReviewedBies', 'editRecommendedBies', 'editApprovedBies'));
    }

    public function editBill($id = null)
    {
        $userData = DB::table('users')->get();

        $companyData = DB::table('companies')->get();

        $editBillsID = DB::table('approvals')
            ->where('approval_note_id', $id)->first();

        $editBills = DB::table('approvals')
            ->join('bill_approvals', 'approvals.approval_note_id', '=', 'bill_approvals.approval_note_id')
            ->where('approvals.approval_note_id', $id)
            ->get();

        $editObjectives = DB::table('objectives')
            ->where('approval_note_id', $id)->get();

        $editBackgrounds = DB::table('backgrounds')
            ->where('approval_note_id', $id)->get();

        $editProposals = DB::table('proposals')
            ->where('approval_note_id', $id)->get();

        $editJustifications = DB::table('justifications')
            ->where('approval_note_id', $id)->get();

        $editRecommendations = DB::table('recommendations')
            ->where('approval_note_id', $id)->get();

        $editSupportedBies = DB::table('supported_bies')
            ->where('approval_note_id', $id)->get();

        $editCheckedBies = DB::table('checked_bies')
            ->where('approval_note_id', $id)->get();

        $editReviewedBies = DB::table('reviewed_bies')
            ->where('approval_note_id', $id)->get();

        $editRecommendedBies = DB::table('recommended_bies')
            ->where('approval_note_id', $id)->get();

        $editApprovedBies = DB::table('approved_bies')
            ->where('approval_note_id', $id)->get();

        return view('edit-bill', compact('editBillsID', 'userData', 'companyData', 'editBills', 'editObjectives', 'editBackgrounds', 'editProposals', 'editJustifications', 'editRecommendations', 'editSupportedBies', 'editCheckedBies', 'editReviewedBies', 'editRecommendedBies', 'editApprovedBies'));
    }

    public function deleteBill($id = null)
    {
        // $deleteData = Approval::find($id);
        $deleteBill = DB::table('Approvals')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteBill = DB::table('bill_approvals')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteBill = DB::table('approved_bies')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteBill = DB::table('backgrounds')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteBill = DB::table('checked_bies')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteBill = DB::table('justifications')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteBill = DB::table('objectives')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteBill = DB::table('proposals')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteBill = DB::table('recommendations')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteBill = DB::table('recommended_bies')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteBill = DB::table('reviewed_bies')
            ->where('approval_note_id', $id)
            ->delete();

        $deleteBill = DB::table('supported_bies')
            ->where('approval_note_id', $id)
            ->delete();

        Session::flash('msg', 'Bill Successfully Deleted');
        return redirect('/sent-request');
    }

    public function updateBill(Request $request, $id)
    {
        // update approval table
        $approval_table_data = Approval::where('approval_note_id', $id)->first();
        $approval_table_data->approval_for_company_id = $request->company;
        $approval_table_data->approval_note_date = $request->date;
        $approval_table_data->approval_note_subject = $request->subject;
        $approval_table_data->updated_at = now();
        $approval_table_data->save();

        // update bill approval table
        $bill_approval_table_data = BillApproval::where('approval_note_id', $id)->first();
        $bill_approval_table_data->bill_approval_description = $request->description;
        $bill_approval_table_data->bill_approval_narration = $request->narration;


        if ($request->hasFile('file')) {
            // Delete the old file
            $oldFileName = $bill_approval_table_data->file;
            if (File::exists(public_path('bills/' . $oldFileName))) {
                File::delete(public_path('bills/' . $oldFileName));
            }
        
            // Upload and store the new file
            $file = $request->file('file');
            $fileName = $request->date . "-" . $approval_table_data->approval_note_id . "." . $file->getClientOriginalExtension();
            $file->move(public_path('bills'), $fileName);
        
            // Update the 'file' attribute in the model
            $bill_approval_table_data->file = $fileName;
        }
        $bill_approval_table_data->save();
        

        Session::flash('updateMsg', 'Bill Successfully Updated');
        return redirect('/sent-request');
    }


    public function updateApprovalNote(Request $request, $id)
    {
        // update approval table
        $approval_table_data = Approval::where('approval_note_id', $id)->first();
        // $approval_table_data->addressed_to_id = $request->addressedTo;
        // $approval_table_data->approval_for_company_id = $request->company;
        $approval_table_data->approval_note_date = $request->date;
        $approval_table_data->approval_note_subject = $request->subject;
        $approval_table_data->updated_at = now();
        $approval_table_data->save();

        // Update objective table
        $objective_table_data = Objective::where('approval_note_id', $id)->first();
        $objective_table_data->objective_description = $request->objective_description;
        $objective_table_data->updated_at = now();
        $objective_table_data->save();

        // Update background table
        $background_table_data = Background::where('approval_note_id', $id)->first();
        $background_table_data->background_description = $request->background_description;
        $background_table_data->updated_at = now();
        $background_table_data->save();

        // update proposal table
        $proposal_table_data = Proposal::where('approval_note_id', $id)->first();
        $proposal_table_data->proposal_description = $request->proposal_description;
        $proposal_table_data->updated_at = now();
        $proposal_table_data->save();

        // update justification table
        $justification_table_data = Justification::where('approval_note_id', $id)->first();
        $justification_table_data->justification_description = $request->justification_description;
        $justification_table_data->updated_at = now();
        $justification_table_data->save();

        // update recommendation table
        $recommendation_table_data = Recommendation::where('approval_note_id', $id)->first();
        $recommendation_table_data->recommendation_description = $request->recommendation_description;
        $recommendation_table_data->updated_at = now();
        $recommendation_table_data->save();

        // // update supported by table
        // // Fetch the existing supported by records for the given approval note
        // $supportedByExistingRecords = SupportedBy::where('approval_note_id', $id)->get();
        // $supportedByArray = $request->supportedByArray;
        // // Loop through the existing records and update or delete them
        // foreach ($supportedByExistingRecords as $existingRecord) {
        //     // Check if the existing supported_by_id exists in the updated data
        //     if (in_array($existingRecord->supported_by_id, $supportedByArray)) {
        //         // Update the existing record
        //         $existingRecord->approval_status = 0;
        //         $existingRecord->updated_at = now();
        //         $existingRecord->save();
        //         // Remove the updated supported_by_id from the array to avoid duplicates
        //         $key = array_search($existingRecord->supported_by_id, $supportedByArray);
        //         if ($key !== false) {
        //             unset($supportedByArray[$key]);
        //         }
        //     } else {
        //         // If the existing supported_by_id doesn't exist in the updated data, delete the record
        //         $existingRecord->delete();
        //     }
        // }
        // // Insert new supported by records for the remaining supported_by_ids
        // foreach ($supportedByArray as $newSupportedById) {
        //     $data = [
        //         'approval_note_id' => $id,
        //         'supported_by_id' => $newSupportedById,
        //         'approval_status' => 0,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ];
        //     SupportedBy::create($data);
        // }

        // // update checked by table
        // // Fetch the existing checked by records for the given approval note
        // $checkedByExistingRecords = CheckedBy::where('approval_note_id', $id)->get();
        // $checkedByArray = $request->checkedByArray;
        // // Loop through the existing records and update or delete them
        // foreach ($checkedByExistingRecords as $existingRecord) {
        //     // Check if the existing checked_by_id exists in the updated data
        //     if (in_array($existingRecord->checked_by_id, $checkedByArray)) {
        //         // Update the existing record
        //         $existingRecord->approval_status = 0;
        //         $existingRecord->updated_at = now();
        //         $existingRecord->save();
        //         // Remove the updated checked_by_id from the array to avoid duplicates
        //         $key = array_search($existingRecord->checked_by_id, $checkedByArray);
        //         if ($key !== false) {
        //             unset($checkedByArray[$key]);
        //         }
        //     } else {
        //         // If the existing checked_by_id doesn't exist in the updated data, delete the record
        //         $existingRecord->delete();
        //     }
        // }
        // // Insert new checked by records for the remaining checked_by_ids
        // foreach ($checkedByArray as $newCheckedById) {
        //     $data = [
        //         'approval_note_id' => $id,
        //         'checked_by_id' => $newCheckedById,
        //         'approval_status' => 0,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ];
        //     CheckedBy::create($data);
        // }

        // // update reviewed by table
        // // Fetch the existing reviewed by records for the given approval note
        // $reviewedByExistingRecords = ReviewedBy::where('approval_note_id', $id)->get();
        // $reviewedByArray = $request->reviewedByArray;
        // // Loop through the existing records and update or delete them
        // foreach ($reviewedByExistingRecords as $existingRecord) {
        //     // Check if the existing reviewed_by_id exists in the updated data
        //     if (in_array($existingRecord->reviewed_by_id, $reviewedByArray)) {
        //         // Update the existing record
        //         $existingRecord->approval_status = 0;
        //         $existingRecord->updated_at = now();
        //         $existingRecord->save();
        //         // Remove the updated reviewed_by_id from the array to avoid duplicates
        //         $key = array_search($existingRecord->checked_by_id, $checkedByArray);
        //         if ($key !== false) {
        //             unset($reviewedByArray[$key]);
        //         }
        //     } else {
        //         // If the existing reviewed_by_id doesn't exist in the updated data, delete the record
        //         $existingRecord->delete();
        //     }
        // }
        // // Insert new checked by records for the remaining reviewed_by_ids
        // foreach ($reviewedByArray as $newReviewedById) {
        //     $data = [
        //         'approval_note_id' => $id,
        //         'reviewed_by_id' => $newReviewedById,
        //         'approval_status' => 0,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ];
        //     ReviewedBy::create($data);
        // }


        Session::flash('updateMsg', 'Approval note Successfully Updated');
        return redirect('/sent-request');
    }
}
