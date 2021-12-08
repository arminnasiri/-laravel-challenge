<?php

namespace App\Services\Transaction\Traits;

use Illuminate\Database\Eloquent\Model;

trait ResponseTrait
{
    public function getResult(Model $transaction): array
    {
        if( $transaction ) {
            return [
                "success" => true,
                "data" => $transaction
            ];
        }
        return [
            "success" => false,
            "error" => "could not crate transaction"
        ];
    }
}