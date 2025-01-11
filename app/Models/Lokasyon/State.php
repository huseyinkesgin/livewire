<?php

namespace App\Models\Lokasyon;

use App\Traits\AutoCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use AutoCode;

    protected $table = 'states';
    protected $fillable = [
        'Code',
        'Name',
        'Status',
        'Description'
    ];

    protected $casts = [
        'Status' => 'boolean'
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
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

    public function scopeSearch(Builder $query, ?string $search)
    {
        if ($search) {
            return $query->where(function ($query) use ($search) {
                $query->where('Code', 'like', '%' . $search . '%')
                    ->orWhere('Name', 'like', '%' . $search . '%')
                    ->orWhere('Description', 'like', '%' . $search . '%');
            });
        }

        return $query;
    }
}
