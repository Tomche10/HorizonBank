@extends('layouts.app')

@section('content')
<style>
    .card {
        background-color: #4C6A73;
        color: white;
        .btn {
            background-color: #2B4E4C;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.3);
        }
    }

</style>
<div class="container">
    <h1 class="py-2 text-white">Welcome, {{ Auth::user()->name }}</h1>
    
    <!-- Account Overview -->
    <div class="card mb-4">
        <div class="card-header">Account Overview</div>
        <div class="card-body">
            <p><strong>Account Number:</strong> {{ $account->account_number ?? 'Not Available' }}</p>
            <p><strong>Balance:</strong> ${{ number_format($account->balance ?? 0, 2) }}</p>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card mb-4" style= "background-color: #4C6A73">
        <div class="card-header">Recent Transactions</div>
        <div class="card-body">
            <div class="mb-4">
                <a href="{{ route('transfer.create') }}" class="btn btn-success">Transfer Money</a>
            </div>

            @if($transactions->isEmpty())
                <p>No recent transactions available.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->transaction_type }}</td>
                            <td>${{ number_format($transaction->amount, 2) }}</td>
                            <td>{{ ucfirst($transaction->status) }}</td>
                            <td>{{ $transaction->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $transactions->links() }}
            @endif
        </div>
    </div>

    <!-- Loan Details -->
    <div class="card mb-4">
        <div class="card-header">Loan Details</div>
        <div class="card-body">
            <div class="mb-4">
                <a href="{{ route('loans.create') }}" class="btn btn-success">Request a Loan</a>
            </div>
            @if($loans->isEmpty())
                <p>No loans available.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Loan Amount</th>
                            <th>Interest Rate</th>
                            <th>Repayment Period</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $loan)
                        <tr>
                            <td>${{ number_format($loan->loan_amount, 2) }}</td>
                            <td>{{ $loan->interest_rate }}%</td>
                            <td>{{ $loan->repayment_period }} months</td>
                            <td>{{ ucfirst($loan->status) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $loans->links() }}
            @endif
        </div>
    </div>
</div>
@endsection
