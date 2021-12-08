<?php

namespace App\Http\Controllers\Api\Contracts;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    protected $statusCode;

    public function respondData($data, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return $this->setStatusCode($statusCode)
            ->respondWithData($data);
    }
    public function respondNoFound($message): JsonResponse
    {
        return $this
            ->setStatusCode(Response::HTTP_NOT_FOUND)
            ->respondWithError($message);
    }

    public function respondInvalidParams($message): JsonResponse
    {
        return $this
            ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->respondWithError($message);
    }

    public function respondInternalError($message): JsonResponse
    {
        return $this
            ->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->respondWithError($message);
    }

    public function respondItemCreated($message): JsonResponse
    {
        return $this
            ->setStatusCode(Response::HTTP_OK)
            ->respondWithSuccess($message);
    }

    /**
     * @return mixed
     */
    private function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     */
    private function setStatusCode($statusCode): ApiController
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    private function respondWithData($data): JsonResponse
    {
        return $this->respond($data);
    }
    private function respondWithError($message): JsonResponse
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }

    private function respondWithSuccess($message): JsonResponse
    {
        return $this->respond([
            'success' => true,
            'message' => $message
        ]);
    }

    private function respond($data, $headers = []): JsonResponse
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

}
