<?php

namespace App\Services\Transaction\Providers;

use App\Models\Transaction;
use App\Services\Transaction\Contracts\TransactionMethod;
use App\Services\Transaction\Helper\TransactionType;
use App\Services\Transaction\Traits\ResponseTrait;

class MobileTransaction implements TransactionMethod
{
   use ResponseTrait;
    public function pay(array $data): array
    {
        $data ["type"] = TransactionType::MOBILE;
        $transaction = Transaction::createItem(
           $data
       );
       return $this->getResult($transaction);
    }
}