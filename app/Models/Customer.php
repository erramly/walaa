<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Customer extends Authenticatable
{
    use HasFactory;
    // TABLE 

    protected $fillable = [
        'name',
        'phone_number',
        'password',
        'email', // Assuming you want to store email as well
        'customer_code', // Ensure this is fillable if you are setting it
    ];
    // hidde
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function restaurants()
    {
        return $this->belongsToMany(Customer::class, 'restaurant_customer');
    }
    // visits relationship
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
