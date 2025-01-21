<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Loan;
use App\Models\Transaction;
use App\Models\Account;


class BankerController extends Controller
{
    // Dashboard view
    public function index()
    {
        $pendingLoans = Loan::where('status', 'pending')->count();
        $recentTransactions = Transaction::latest()->take(5)->get();
        return view('banker.dashboard', compact('pendingLoans', 'recentTransactions'));
    }

    // View and manage loans
    public function viewLoans()
    {
        $loans = Loan::where('status', 'pending')->orderBy('created_at', 'desc')->paginate(10);
        return view('banker.loans', compact('loans'));
    }

    public function approveLoan(Loan $loan)
    {

        $loan->update(['status' => 'approved']);
        $original_balance=Account::where('user_id', $loan->user_id)->first('balance');
        $new_balance=$original_balance->balance+$loan->loan_amount;
        Account::where('user_id', $loan->user_id)->update(['balance' => $new_balance]);
        #dd(Account::where('user_id', $loan->user_id)->update(['balance' => $new_balance]));
        return redirect()->route('banker.loans')->with('success', 'Loan approved successfully.');
    }

    public function rejectLoan(Loan $loan)
    {
        $loan->update(['status' => 'rejected']);
        return redirect()->route('banker.loans')->with('error', 'Loan rejected successfully.');
    }

    // View and undo transactions
    public function viewTransactions()
    {
        $transactions = Transaction::paginate(10);
        return view('banker.transactions', compact('transactions'));
    }

    public function undoTransaction(Transaction $transaction)
    {
        // Ensure the transaction has been completed before it can be reversed
        if ($transaction->status !== 'completed') {
            return redirect()->route('banker.transactions')->with('error', 'Transaction cannot be reversed.');
        }

        // Retrieve the sender and receiver accounts
        $sender = $transaction->sender_id ? Account::find($transaction->sender_id) : null;
        $receiver = $transaction->receiver_id ? Account::find($transaction->receiver_id) : null;

        // Handle based on transaction type
        switch ($transaction->transaction_type) {
            case 'deposit':
                if ($receiver) {
                    // Deduct the amount from the receiver's balance for a reversed deposit
                    $receiver->update(['balance' => $receiver->balance - $transaction->amount]);
                }
                break;

            case 'withdrawal':
                if ($sender) {
                    // Add the amount back to the sender's balance for a reversed withdrawal
                    $sender->update(['balance' => $sender->balance + $transaction->amount]);
                }
                break;

            case 'transfer':
                if ($sender && $receiver) {
                    // Add the amount back to the sender and deduct it from the receiver
                    $sender->update(['balance' => $sender->balance + $transaction->amount]);
                    $receiver->update(['balance' => $receiver->balance - $transaction->amount]);
                }
                break;

            default:
                return redirect()->route('banker.transactions')->with('error', 'Invalid transaction type.');
        }

        // Update the transaction status to "reversed"
        $transaction->update(['status' => 'reversed']);

        return redirect()->route('banker.transactions')->with('success', 'Transaction reversed successfully.');
    }

    // View accounts
    public function viewAccounts()
    {
        $accounts = Account::paginate(10);
        return view('banker.accounts', compact('accounts'));
    }

    public function approveTransaction(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return redirect()->route('banker.transactions')->with('error', 'Transaction cannot be approved.');
        }

        // Retrieve the sender and receiver accounts
        $sender = $transaction->sender_id ? Account::find($transaction->sender_id) : null;
        $receiver = $transaction->receiver_id ? Account::find($transaction->receiver_id) : null;

        // Process based on transaction type
        switch ($transaction->transaction_type) {
            case 'deposit':
                if ($receiver) {
                    $receiver->update(['balance' => $receiver->balance + $transaction->amount]);
                }
                break;

            case 'withdrawal':
                if ($sender && $sender->balance >= $transaction->amount) {
                    $sender->update(['balance' => $sender->balance - $transaction->amount]);
                } else {
                    return redirect()->route('banker.transactions')
                        ->with('error', 'Insufficient balance for withdrawal.');
                }
                break;

            case 'transfer':
                if ($sender && $receiver) {
                    if ($sender->balance >= $transaction->amount) {
                        $sender->update(['balance' => $sender->balance - $transaction->amount]);
                        $receiver->update(['balance' => $receiver->balance + $transaction->amount]);
                    } else {
                        return redirect()->route('banker.transactions')
                            ->with('error', 'Insufficient balance for transfer.');
                    }
                }
                break;

            default:
                return redirect()->route('banker.transactions')->with('error', 'Invalid transaction type.');
        }

        // Update transaction status
        $transaction->update(['status' => 'completed']);

        return redirect()->route('banker.transactions')->with('success', 'Transaction approved successfully.');
    }

    public function rejectTransaction(Transaction $transaction)
    {
        if ($transaction->status === 'pending') {
            $transaction->update(['status' => 'rejected']);
            return redirect()->route('banker.transactions')->with('success', 'Transaction rejected successfully.');
        }
        return redirect()->route('banker.transactions')->with('error', 'Transaction cannot be rejected.');
    }
}

