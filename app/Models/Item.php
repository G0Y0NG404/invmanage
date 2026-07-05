<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'serial_number', 'nsn',
        'date_acquired', 'warranty_status', 'status',
        'location_battalion', 'location_storage', 'assigned_personnel',
        'quantity',
    ];

    protected function casts(): array
    {
        return [
            'date_acquired' => 'date',
            'deleted_at' => 'datetime',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
