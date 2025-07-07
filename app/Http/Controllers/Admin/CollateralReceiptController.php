<?php

namespace App\Http\Controllers\Admin;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CollateralReceiptController extends Controller
{
    public function index(Request $request)
    {
        $data = Loan::with(['loan_documents'])->where('status', '!=', 'draft')->paginate(25);
        // dd($data);
        return view('pages.admin.customer-collateral', compact('data'));
    }

}
