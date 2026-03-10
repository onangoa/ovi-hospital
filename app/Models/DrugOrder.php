<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'ordered_by_id',
        'items',
        'total_quantity',
        'total_amount',
    ];

    protected $casts = [
        'items' => 'array',
        'date' => 'date',
    ];

    public function orderedBy()
    {
        return $this->belongsTo(User::class, 'ordered_by_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'ordered_by_id');
    }
}
