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
    public $timestamps = false;

    protected $table = 'transaction_statuses';

    protected $fillable = [
        'status',
    ];
}
