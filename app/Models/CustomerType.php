<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class CustomerType
 *
 * @property int $id
 * @property string $type
 *
 * @method static Builder query()
 *
 * @package App\Models
 */
class CustomerType extends Model
{
    public const TYPE_ID_COMMON = 1;
    public const TYPE_ID_RETAILER = 2;

    public $timestamps = false;

    protected $table = 'customer_types';

    protected $fillable = [
        'type',
    ];
}
