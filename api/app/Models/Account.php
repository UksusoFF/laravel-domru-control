<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 *
 *
 * @property int $id
 * @property \App\Models\AccountStep|null $step
 * @property string $phone
 * @property string|null $place
 * @property string|null $operator
 * @property string|null $subscriber
 * @property string|null $account
 * @property string|null $address
 * @property string|null $profile
 * @property string|null $code
 * @property string|null $token
 * @property string|null $refresh
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Account defaultSort(string $column, string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Account filters(?mixed $kit = null, ?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Account filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Account filtersApplySelection($class)
 * @method static \Illuminate\Database\Eloquent\Builder|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereOperator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereRefresh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereStep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereSubscriber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Account extends Model
{
    use AsSource;
    use Filterable;

    protected $casts = [
        'step' => AccountStep::class,
    ];

    protected $fillable = [
        'phone',
        'code',
    ];
}
