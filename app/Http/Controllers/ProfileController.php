<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;




use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile');
    }

    public function getUser()
    {
        $userData['users'] = DB::table('users')->get();
        return view('profile', $userData);
    }

    public function userManagement()
    {
        $allUsers = DB::table('Users')
            ->select('users.*', 'departments.department_name', 'companies.company_name')
            ->leftJoin('departments', 'users.department', '=', 'departments.department_id')
            ->leftJoin('companies', 'users.company', '=', 'companies.company_id')
            ->get();
        return view('user-management', compact('allUsers'));
    }

    public function departmentManagement()
    {
        $allDepartments = DB::table('departments')
            ->get();
        return view('department-management', compact('allDepartments'));
    }

    public function addDepartment(Request $request)
    {
        $department_table_data = new Department();
        $last_department_table_id = DB::table('departments')
            ->select('department_id')
            ->orderBy('department_id', 'DESC')
            ->first();
        if ($last_department_table_id !== null) {
            $department_table_data->department_id = $last_department_table_id->department_id + 1;
        } else {
            $department_table_data->department_id = 1;
        }
        $getUserName = Auth::user()->name;
        $department_table_data->department_name = $request->department;
        $department_table_data->inserted_by = $getUserName;
        $department_table_data->created_at = Carbon::now();
        $department_table_data->updated_at = now();
        $department_table_data->save();
        Session::flash('msg', 'New department added');
        return redirect()->back();
    }

    public function companyManagement()
    {
        $allCompanies = DB::table('companies')
            ->get();
        return view('company-management', compact('allCompanies'));
    }
}
