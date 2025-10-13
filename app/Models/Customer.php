<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
     protected $fillable = ['shopkeeper_id', 'name', 'phone', 'address'];

    public function shopkeeper() {
        return $this->belongsTo(User::class, 'shopkeeper_id');
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
