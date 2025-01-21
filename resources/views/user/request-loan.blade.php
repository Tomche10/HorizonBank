@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <a  href="{{ route('dashboard') }}" class="btn btn-success mb-5" >Go Back to Dashboard</a>
    <h1>Request a Loan</h1>

    <form action="{{ route('loans.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="loan_amount" class="form-label">Loan Amount</label>
            <input type="number" name="loan_amount" id="loan_amount" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="interest_rate" class="form-label">Interest Rate (%)</label>
            <input type="number" name="interest_rate" id="interest_rate" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="repayment_period" class="form-label">Repayment Period (Months)</label>
            <input type="number" name="repayment_period" id="repayment_period" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit Loan Request</button>
    </form>
</div>
@endsection
