<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\AbstractSubmission;
use App\Models\ResearchSubmission;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function dashboard()
    {
        $admin = Auth::user();

        $totalReviewers = DB::table('role_user')
            ->whereIn('role_id', [2])
            ->count();
        $totalUsers = DB::table('role_user')
            ->whereIn('role_id', [3])
            ->count();
        
        $totalAbstracts = AbstractSubmission::distinct('serial_number')->count();
        $totalProposals = ResearchSubmission::distinct('serial_number')->count();

        $submissions = AbstractSubmission::all();
        $researchSubmissions = ResearchSubmission::all();

        return view('admin.partials.dashboard', compact('totalUsers', 'totalAbstracts',
                    'totalProposals', 'totalReviewers', 'submissions', 'researchSubmissions'));
    }
    public function users()
    {
        return view('admin.partials.users');
    }

    public function submissions()
    {
        return view('admin.partials.submissions');
    }

    public function reports()
    {
        return view('admin.partials.reports');
    }

    public function documents()
    {   
        $admin = Auth::user();

        $submissions = AbstractSubmission::all();
        $researchSubmissions = ResearchSubmission::all();
        return view('admin.partials.documents', compact('submissions', 'researchSubmissions'));
    }

    public function profile()
    {
        return view('admin.partials.profile');
    }

    public function settings()
    {
        return view('admin.partials.settings');
    }
}
