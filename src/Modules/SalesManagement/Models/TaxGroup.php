<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kirago\BusinessCore\Modules\BaseModel;

/**
 * @property string $name
 * @property string $excerpt
 * @property array $other_phones
 */
class TaxGroup  extends BaseModel
{



    protected array $fillable = [
        'name',
        'country_code',
        'excerpt',
    ];



    public function getObjectName(): string
    {
        return $this->name;
    }

    public function taxes()
    {
        return $this->belongsToMany(
                        Tax::class,
                        'taxes_tax_groups'
                    )
                    ->withPivot('seq_number')
                    ->orderBy('seq_number');
    }

    /**
     * @return mixed
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('tax_groups.name', 'LIKE', "%$search%");
    }

    public function scopeIds(Builder $query, ?array $ids): Builder
    {
        return $query->whereIn('id', Arr::wrap($ids));
    }

    public function scopeIdsNotIn(Builder $query, ?array $ids): Builder
    {
        return $query->whereNotIn('id', $ids);
    }
}
