<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class TransactionStatus
 * 
 * @property int $id
 * @property string $status
 * 
 * @method static Builder query()
 * 
 * @package App\Models
 */
class TransactionStatus extends Model
{
    public const STATUS_ID_PROCESSING = 1;
    public const STATUS_ID_SUCCESS = 2;
    public const STATUS_ID_ERROR = 3;

    public $timestamps = false;

    protected $table = 'transaction_statuses';

    protected $fillable = [
        'status',
    ];
}
