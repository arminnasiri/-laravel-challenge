<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Contracts\ApiController;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Services\Transaction\Helper\TransactionType;
use App\Services\Transaction\TransactionService;
use Symfony\Component\HttpFoundation\Response;

class PosController extends ApiController
{
   public function __invoke(TransactionRequest $request)
   {
       $transaction = new TransactionService();
       $result = $transaction->doPayment(
           $request->validated(),
           TransactionType::POS
       );
       if( $result["success"])
           return $this->respondData(new TransactionResource($result["data"]));
       return $this->respondInternalError($result["message"]);
   }
}