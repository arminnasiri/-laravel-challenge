<?php

namespace App\Models;

use App\Services\Transaction\Helper\TransactionType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    /**
     * create Transaction
     * @param array $data
     * @return mixed
     */
    public static function createItem(array $data)
    {
        return static::create(
            [
                "webservice_id" => $data["webservice_id"],
                "amount" => $data["amount"],
                "type" => $data["type"]
            ]
        );
    }

    /**
     * get report count type transaction
     * @param Carbon $date
     * @return array
     */
    public static function reportCountType(Carbon $date): array
    {
        return DB::select("
        select type,count(*) from (select * from transactions where created_at >= ?) as \"t\" group by \"type\"
        ",[$date]);

    }

    /**
     * get data whit portions
     * @return array
     */
    public static function reportSumAmount(Carbon $date): array
    {
        return DB::select(DB::raw("
        WITH _0TO5000 AS(
                SELECT amount FROM TRANSACTIONS WHERE AMOUNT BETWEEN 0 AND 5000 and
                created_at >= '$date'
                      ),
            _5000TO10000 AS (
                SELECT amount FROM TRANSACTIONS WHERE AMOUNT BETWEEN 5000 AND 10000 and
                  created_at >= '$date'
                           ),
           _10000TO100000 AS (
                SELECT amount FROM TRANSACTIONS WHERE AMOUNT BETWEEN 10000 AND 100000 and 
                  created_at >= '$date'
                             ),
           _100000TOUP AS (
                SELECT amount FROM TRANSACTIONS WHERE AMOUNT > 100000 and 
                  created_at >= '$date'                         )
           SELECT '0to5000' CLASSIFICATION,
                      SUM(_0TO5000.AMOUNT) SUM_VAL
            FROM _0TO5000
           UNION
           SELECT '5000to10000' CLASSIFICATION,
                      SUM(_5000TO10000.AMOUNT) SUM_VAL
           FROM _5000TO10000
           UNION
           SELECT '10000to100000' CLASSIFICATION,
                     SUM(_10000TO100000.AMOUNT) SUM_VAL
           FROM _10000to100000
           UNION
           SELECT '100000toup' CLASSIFICATION,
                      SUM(_100000TOUP.AMOUNT) SUM_VAL
           FROM _100000TOUP
           "));

    }

    /**
     * get sum all amount in date
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function reportSumAmounts(Carbon $date)
    {
        return static::query()
            ->selectRaw(DB::raw("sum(amount)"))
            ->where('created_at', $date)
            ->first();
    }

    /**
     * convert amount to rial
     * @return int
     */
    public function getAmountAsRialAttribute(): int
    {
        return $this->attributes['amount'] * 10;
    }
   //todo webService
    public function webService(): BelongsTo
    {
        return $this->belongsTo(WebService::class);
    }
}
