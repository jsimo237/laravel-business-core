<?php


namespace Kirago\BusinessCore\Support\Bootables;

use Illuminate\Database\Eloquent\Builder;

trait InteractWithCommonsScopeFilter{


    /**
     * Scope the query for created_at between dates
     *
     * @param Builder $query
     * @param array $dateRange
     * @return Builder
     */
    public function scopeCreatedAtBetween(Builder $query,array $dateRange): Builder
    {
        return $query->whereBetween('created_at', $dateRange);
    }

    /**
     * Scope the query for updated_at between dates
     *
     * @param Builder $query
     * @param array $dateRange
     * @return Builder
     */
    public function scopeUpdatedAtBetween(Builder $query,array $dateRange): Builder
    {
        return $query->whereBetween('updated_at', $dateRange);
    }

    /**
     * Scope the query for created_at between dates
     *
     * @param Builder $query
     * @param array $values
     * @return Builder
     */
    public function scopeInIds(Builder $query,array $values): Builder
    {
        return $query->whereIn('id', $values);
    }

    /**
     * Scope the query for created_at between dates
     *
     * @param Builder $query
     * @param string|int|array $data
     * @param string $field
     * @return Builder
     */
    public function scopeWithIds(Builder $query, string|int|array $data, string $field = 'id') : Builder
    {
        $data = is_string($data) ? explode($data,",") : $data;

        return $query->orderByRaw('FIELD('.$field.', '.implode(',', $data).') DESC');
    }
}
