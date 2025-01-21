@extends('layouts.app')

@section('content')
<div class="container mt-2">
    <a  href="{{ route('dashboard') }}" class="btn btn-success mb-5" >Go Back to Dashboard</a>
    <h1>Transfer Money</h1>
    <form action="{{ route('transfer.store') }}" method="POST">
        @csrf

        <!-- Select User -->
        <div class="mb-3">
            <label for="receiver_id" class="form-label">Select Receiver</label>
            <select class="form-control @error('receiver_id') is-invalid @enderror" id="receiver_id" name="receiver_id" required>
                <option value="" disabled selected>-- Select a user --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            @error('receiver_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Amount -->
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount') }}" required>
            @error('amount')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Transfer</button>
    </form>
</div>
@endsection
