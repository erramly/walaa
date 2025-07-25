<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;
    protected $fillable = [
        'restaurant_id',
        'customer_id',
        'visit_date',
        'customer_name',
        'customer_phone',
    ];
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
