<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->where('role', '!=', 'admin')->where('role', '!=', 'banker')->get(); // Exclude the logged-in user
        return view('user.transfer', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $sender = Auth::user();
        $senderAccount = Account::where('user_id', $sender->id)->first();

        // Ensure the sender has enough balance
        if ($senderAccount->balance < $request->amount) {
            return back()->withErrors(['amount' => 'Insufficient funds.']);
        }

        // Get the receiver's account using the user ID
        $receiver = User::findOrFail($request->receiver_id);
        $receiverAccount = Account::where('user_id', $receiver->id)->first();

        // Perform the transfer
        $senderAccount->balance -= $request->amount;
        $receiverAccount->balance += $request->amount;

        $senderAccount->save();
        $receiverAccount->save();

        // Log the transaction
        Transaction::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'amount' => $request->amount,
            'transaction_type' => 'transfer',
            'status' => 'completed',
        ]);

        return redirect()->route('dashboard')->with('success', 'Transfer completed successfully!');
    }
}
