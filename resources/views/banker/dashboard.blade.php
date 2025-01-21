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
        ul {
            list-style-type: none;
            padding : 0;
            margin : 0;
            li{
                padding: 10px 15px;
            }
        }
    }

</style>
<div class="container">
    <h1 class="py-2 text-white">Banker Dashboard</h1>
    
    <div class="row">
        <!-- Pending Loans -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Pending Loans</div>
                <div class="card-body">
                    <h3>{{ $pendingLoans }}</h3>
                    <a href="{{ route('banker.loans') }}" class="btn btn-primary">View Loans</a>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Recent Transactions</div>
                <div class="card-body">
                    <ul class="border rounded">
                        @foreach ($recentTransactions as $transaction)
                            <li class="{{ $loop->first ? 'border-none' : 'border-top' }}">
                                {{ $transaction->transaction_type }}: ${{ number_format($transaction->amount, 2) }}
                                ({{ $transaction->status }})
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('banker.transactions') }}" class="btn btn-primary mt-3">View All Transactions</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
