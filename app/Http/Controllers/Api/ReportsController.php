<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReportUser;
use App\Models\User;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        $users = ReportUser::all();
        return view('admin.reports', compact('users'));
    }
}
