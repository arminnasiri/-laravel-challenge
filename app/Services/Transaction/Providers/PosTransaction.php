<?php

namespace App\Services\Transaction\Providers;


use App\Models\Transaction;
use App\Services\Transaction\Contracts\TransactionMethod;
use App\Services\Transaction\Helper\TransactionType;
use App\Services\Transaction\Traits\ResponseTrait;

class PosTransaction implements TransactionMethod
{
    use ResponseTrait;

    public function pay(array $data): array
    {
        $data ["type"] = TransactionType::POS;
        $data ["amount"] =  $data ["amount"] / 10; //convert rial to tooman
        $transaction = Transaction::createItem(
            $data
        );
        return $this->getResult($transaction);
    }
}