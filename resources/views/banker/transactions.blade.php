@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="my-3">
        <a href="{{ route('banker.dashboard') }}" class="btn btn-success">Back to Dashboard</a>
    </div>
    <h1>Banker Dashboard: Manage Transactions</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($transactions->isEmpty())
        <p>No transactions available.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sender</th>
                    <th>Receiver</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->sender ? $transaction->sender->name : 'N/A' }}</td>
                    <td>{{ $transaction->receiver ? $transaction->receiver->name : 'N/A' }}</td>
                    <td>${{ number_format($transaction->amount, 2) }}</td>
                    <td>{{ ucfirst($transaction->transaction_type) }}</td>
                    <td>{{ ucfirst($transaction->status) }}</td>
                    <td>{{ $transaction->created_at->format('d M Y, h:i A') }}</td>
                    <td>
                        @if($transaction->status === 'completed')
                            <form action="{{ route('banker.transactions.undo', $transaction) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Undo</button>
                            </form>
                        @elseif($transaction->status === 'pending')
                            <form action="{{ route('banker.transactions.approve', $transaction) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                            </form>
                            <form action="{{ route('banker.transactions.reject', $transaction) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm">Reject</button>
                            </form>
                        @else
                            <span class="text-muted">No Actions</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $transactions->links() }}
    @endif
</div>
@endsection
