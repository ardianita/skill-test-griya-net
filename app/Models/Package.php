<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';
    protected $fillable = ['package', 'price'];

    public function customers()
    {
        return $this->hasMany(Customer::class, 'package_id', 'id');
    }
}
