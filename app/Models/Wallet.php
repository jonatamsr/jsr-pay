<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class Wallet
 * 
 * @property int $id
 * @property int $customer_id
 * @property double $amount
 * 
 * @method static Builder query()
 * 
 * @package App\Models
 */
class Wallet extends Model
{
    public $timestamps = false;

    protected $table = 'wallets';

    protected $fillable = [
        'customer_id',
        'balance',
    ];
}
