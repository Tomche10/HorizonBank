<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        // Get loan and transaction statistics for the past month
        $startOfMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $loanStatistics = Loan::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $transactionStatistics = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        // Fetch all users
        $users = User::all();

        // Pass loan statistics, transaction statistics, and users to the view
        return view('admin.dashboard', compact('loanStatistics', 'transactionStatistics', 'users'));
    }

    public function deleteUser(User $user)
    {
        if ($user->role !== 'admin') {
            $user->delete();
            return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
        }
        return redirect()->route('admin.dashboard')->with('error', 'Admin user cannot be deleted.');
    }

    public function createBanker(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:banker,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.dashboard')->with('success', $request->role . ' created successfully.');
    }
}
