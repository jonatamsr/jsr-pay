<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * Class Customer
 *
 * @property int $id
 * @property int $customer_type_id
 * @property string $name
 * @property string|null $cpf
 * @property string|null $cnpj
 * @property string $email
 * @property string $password
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 *
 * @method static Builder query()
 *
 * @package App\Models
 */
class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'customers';

    protected $fillable = [
        'customer_type_id',
        'name',
        'cpf',
        'cnpj',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
