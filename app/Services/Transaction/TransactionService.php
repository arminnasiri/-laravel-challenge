<?php

namespace App\Services\Transaction;


use App\Services\Transaction\Helper\TransactionType;
use App\Services\Transaction\Providers\MobileTransaction;
use App\Services\Transaction\Providers\PosTransaction;
use App\Services\Transaction\Providers\WebTransaction;

class TransactionService
{
    public function doPayment(array $data, int $transactionProvider)
    {
        $paymentProviderClass = $this->getTransactionProvider($transactionProvider);
        $paymentProviderHandler = new $paymentProviderClass();
        return $paymentProviderHandler->pay($data);
     }
    private function getTransactionProvider(int $paymentProvider): string
    {
        return [
            TransactionType::WEB => WebTransaction::class,
            TransactionType::MOBILE => MobileTransaction::class,
            TransactionType::POS => PosTransaction::class
        ][$paymentProvider];
    }
}