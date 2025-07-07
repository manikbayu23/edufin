<?php

namespace App\Http\Controllers\Admin;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerArreasController extends Controller
{
    public function index(Request $request)
    {
        $today = now()->format('Y-m-d');
        $data = Loan::with('repayments')->where('status', 'approved')
            ->whereHas('repayments', function ($query) use ($today) {
                $query->where('status', 'pending')
                    ->whereDate('due_date', '<=', $today);
            })
            ->paginate(25);
        // dd($data);
        return view('pages.admin.customer-arrears', compact('data'));
    }
}
