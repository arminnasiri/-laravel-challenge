<?php

namespace App\Services\Reporter\Transaction;

use App\Models\Transaction;
use App\Services\Transaction\Helper\TransactionType;
use Carbon\Carbon;

class LastMonthStatisticsReport
{
    /**
     * Get data last month
     * @return array
     */
    public function getReport(): array
    {
        $dateLastMonth = Carbon::now()->subMonth();
        $transactions = Transaction::reportSumAmount($dateLastMonth);
        $data = [];
        foreach ($transactions as $transaction) {
            $data['transactions'][$transaction->classification] = $transaction->sum_val;
        }
        $data['summary']['amount'] = Transaction::ReportSumAmounts($dateLastMonth)->sum;
        $summary = Transaction::reportCountType($dateLastMonth);
        foreach ($summary as $item) {
            $data['summary'][TransactionType::getType($item->type)] = $item->count;
        }
        return $data;
    }
}