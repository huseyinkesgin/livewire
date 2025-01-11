<?php

namespace App\Models\Lokasyon;

use App\Traits\AutoCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use AutoCode;

    protected $table = 'cities';
    protected $fillable = ['state_id', 'Code', 'Name', 'Description', 'Status'];

    protected $casts = [
        'Status' => 'boolean'
    ];

    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
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
                    ->orWhere('Description', 'like', '%' . $search . '%')
                    ->orWhereHas('state', function ($query) use ($search) {
                        $query->where('Name', 'like', '%' . $search . '%');
                    });
            });
        }

        return $query;
    }
}
