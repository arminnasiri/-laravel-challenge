<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Contracts\ApiController;
use App\Services\Reporter\Transaction\LastMonthStatisticsReport;
use Illuminate\Http\JsonResponse;

class ReportController extends ApiController
{
    public function lastMonth(): JsonResponse
    {
       $report = new LastMonthStatisticsReport();
       return $this->respondData($report->getReport());
    }
}