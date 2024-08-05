<?php

// app/Console/Commands/ProcessRecurringTransactions.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Income;
use App\Models\Expense;
use Carbon\Carbon;

class ProcessRecurringTransactions extends Command
{
    protected $signature = 'transactions:process-recurring';
    protected $description = 'Process recurring transactions';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Processing recurring transactions...');

        $today = Carbon::today();

        // Process Recurring Incomes
        $recurringIncomes = Income::whereNotNull('recurrence_type')->where('type','income')
            ->where(function($query) use ($today) {
                $query->where('recurrence_end_date', '>=', $today)
                    ->orWhereNull('recurrence_end_date');
            })
            ->get();

        foreach ($recurringIncomes as $income) {
            if ($this->shouldCreateTransaction($income->recurrence_type)) {
                Income::create([
                    'user_id' => $income->user_id,
                    'amount' => $income->amount,
                    'category' => $income->category,
                ]);
            }
        }

        // Process Recurring Expenses
        $recurringExpenses = Income::whereNotNull('recurrence_type')->where('type','expense')
            ->where(function($query) use ($today) {
                $query->where('recurrence_end_date', '>=', $today)
                    ->orWhereNull('recurrence_end_date');
            })
            ->get();

        foreach ($recurringExpenses as $expense) {
            if ($this->shouldCreateTransaction($expense->recurrence_type)) {
                Income::create([
                    'user_id' => $expense->user_id,
                    'amount' => $expense->amount,
                    'category' => $expense->category,
                ]);
            }
        }
    }

    private function shouldCreateTransaction($recurrenceType)
    {
        $lastTransactionDate = Carbon::now()->sub($this->getInterval($recurrenceType));
        return Carbon::now()->greaterThanOrEqualTo($lastTransactionDate);
    }

    private function getInterval($recurrenceType)
    {
        switch ($recurrenceType) {
            case 'daily':
                return '1 day';
            case 'weekly':
                return '1 week';
            case 'monthly':
                return '1 month';
            default:
                return '1 day';
        }
    }
}
