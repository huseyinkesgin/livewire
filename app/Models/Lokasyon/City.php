<?php

namespace App\Models\Lokasyon;

use App\Traits\AutoCode;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use AutoCode;

    protected $table = 'cities';
    protected $fillable = ['Code', 'Name', 'Description', 'Status', 'state_id'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function scopeSearch($query, $term)
    {
        if ($term) {
            $query->where(function ($query) use ($term) {
                $query->where('Code', 'like', "%{$term}%")
                    ->orWhere('Name', 'like', "%{$term}%")
                    ->orWhere('Description', 'like', "%{$term}%");
            });
        }
        return $query;
    }
}