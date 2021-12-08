<?php

namespace App\Services\Transaction\Contracts;

interface  TransactionMethod
{
     public function pay(array $data);
}