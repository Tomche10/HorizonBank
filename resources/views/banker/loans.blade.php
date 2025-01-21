@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="my-3">
        <a href="{{ route('banker.dashboard') }}" class="btn btn-success">Back to Dashboard</a>
    </div>
     {{-- Display Success and Error Messages --}}
     @if(session('success'))
     <div class="alert alert-success">
         {{ session('success') }}
     </div>
 @endif

 @if(session('error'))
     <div class="alert alert-danger">
         {{ session('error') }}
     </div>
 @endif
    <h1>Pending Loans</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Amount</th>
                <th>Interest Rate</th>
                <th>Repayment Period</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loans as $loan)
            <tr>
                <td>{{ $loan->user->name }}</td>
                <td>${{ number_format($loan->loan_amount, 2) }}</td>
                <td>{{ $loan->interest_rate }}%</td>
                <td>{{ $loan->repayment_period }} months</td>
                <td>
                    <form action="{{ route('banker.loans.approve', $loan) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                    <form action="{{ route('banker.loans.reject', $loan) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $loans->links() }}
</div>
@endsection
