<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * Class Transaction
 *
 * @property int $id
 * @property int $payer_id
 * @property int $payee_id
 * @property int $transaction_status_id
 * @property double $amount
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static Builder query()
 *
 * @package App\Models
 */
class Transaction extends Model
{
    use HasUuids;

    protected $table = 'transactions';

    protected $fillable = [
        'payer_id',
        'payee_id',
        'transaction_status_id',
        'amount',
    ];
}
