<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
    ];

    // relationship with reward settings
    public function rewardSettings()
    {
        return $this->hasOne(RewardSetting::class, 'restaurant_id');
    }
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'restaurant_customer');
    }
    public function restaurantCustomers()
    {
        return $this->hasMany(RestaurantCustomer::class);
    }

}
