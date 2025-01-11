<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'Code',
        'Name',
        'Status',
        'Description'
    ];

    protected $casts = [
        'Status' => 'boolean',
    ];

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
