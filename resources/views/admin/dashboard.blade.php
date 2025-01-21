@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Admin Dashboard</h1>

    {{-- Display Success and Error Messages --}}
    <div class="row mb-4">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    {{-- Pie Charts for Loans and Transactions --}}
    <div class="row mb-5">
        <div class="col-md-6">
            <h3 class="text-center mb-4">Loan Statistics (Past Month)</h3>
            <canvas id="loanChart" class="shadow-sm" width="250" height="250"></canvas>
        </div>
        <div class="col-md-6">
            <h3 class="text-center mb-4">Transaction Statistics (Past Month)</h3>
            <canvas id="transactionChart" class="shadow-sm" width="250" height="250"></canvas>
        </div>
    </div>

    {{-- Create Banker Form --}}
    <div class="card mb-4">
        <div class="card-header">
            <h4>Create New Banker</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.createBanker') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                </div>
            
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-control" name="role" id="role" required>
                    <option value="banker">Banker</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
                <button type="submit" class="btn btn-primary">Create Banker</button>
            </form>
        </div>
    </div>

    {{-- Users List --}}
    <div class="card">
        <div class="card-header">
            <h4>Users List</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                @if($user->role !== 'admin')
                                    <form action="{{ route('admin.deleteUser', $user) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Include Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Pie Chart for Loan Statistics
    var loanCtx = document.getElementById('loanChart').getContext('2d');
    var loanChart = new Chart(loanCtx, {
        type: 'pie',
        data: {
            labels: ['Loans Approved', 'Loans Pending'],
            datasets: [{
                data: [{{ $loanStatistics }}, 100 - {{ $loanStatistics }}], // Example data
                backgroundColor: ['#4CAF50', '#FF9800'],
                borderColor: ['#388E3C', '#F57C00'],
                borderWidth: 2
            }]
        }
    });

    // Pie Chart for Transaction Statistics
    var transactionCtx = document.getElementById('transactionChart').getContext('2d');
    var transactionChart = new Chart(transactionCtx, {
        type: 'pie',
        data: {
            labels: ['Transactions Completed', 'Transactions Pending'],
            datasets: [{
                data: [{{ $transactionStatistics }}, 100 - {{ $transactionStatistics }}], // Example data
                backgroundColor: ['#2196F3', '#FF5722'],
                borderColor: ['#1976D2', '#D32F2F'],
                borderWidth: 2
            }]
        }
    });
</script>
@endsection
