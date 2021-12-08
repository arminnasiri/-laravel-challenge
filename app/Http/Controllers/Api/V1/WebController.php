<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Contracts\ApiController;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Services\Transaction\Helper\TransactionType;
use App\Services\Transaction\TransactionService;

class WebController extends ApiController
{
   public function __invoke(TransactionRequest $request)
   {
       $transaction = new TransactionService();
       $result = $transaction->doPayment(
           $request->validated() ,
           TransactionType::WEB
       );
       if( $result["success"])
           return $this->respondData(new TransactionResource($result["data"]));
       return $this->respondInternalError($result["message"]);
   }
}