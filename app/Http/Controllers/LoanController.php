<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function create()
    {
        return view('user.request-loan');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'loan_amount' => 'required|numeric|min:1',
            'interest_rate' => 'required|numeric|min:0',
            'repayment_period' => 'required|integer|min:1',
        ]);

        Loan::create([
            'user_id' => Auth::user()->id,
            'loan_amount' => $validated['loan_amount'],
            'interest_rate' => $validated['interest_rate'],
            'repayment_period' => $validated['repayment_period'],
            'monthly_installment' => $validated['loan_amount'] / $validated['repayment_period'],
            'status' => 'pending',
        
        ]);

        return redirect()->route('dashboard')->with('success', 'Loan request submitted successfully!');
    }
}