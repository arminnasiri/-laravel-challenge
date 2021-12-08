<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Contracts\ApiController;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Services\Transaction\Helper\TransactionType;
use App\Services\Transaction\TransactionService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MobileController extends ApiController
{
    public function __invoke(TransactionRequest $request): JsonResponse
    {
        $transaction = new TransactionService();
        $result = $transaction->doPayment(
            $request->validated(),
            TransactionType::MOBILE
        );
        if( $result["success"])
            return $this->respondData(new TransactionResource($result["data"]), Response::HTTP_CREATED);
        return $this->respondInternalError($result["message"]);
    }

}