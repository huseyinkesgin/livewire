<?php

namespace App\Models\Lokasyon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class District extends Model
{
    protected $table = 'districts';
    protected $fillable = ['city_id', 'Code', 'Name', 'Description', 'Status'];

    public function city() : BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    ########################### SCOPES ###########################
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('Status', true);
    }

    public function scopePassive(Builder $query): Builder
    {
        return $query->where('Status', false);
    }
}
