<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    public function phone_numbers (){
        return $this->hasMany( ContactPhone::class );
    }

    public function emails(){
        return $this->hasMany( ContactEmail::class );
    }

    public function groups(){
        return $this->belongsToMany( Group::class, 'contact_groups' );
    }
}
