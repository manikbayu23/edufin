<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\Borrow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $loanId = Loan::where('status', 'approved')->value('id');
        return view('pages.user.dashboard', compact(['loanId']));
    }
    public function guide()
    {
        return view('pages.user.guide');
    }
}

