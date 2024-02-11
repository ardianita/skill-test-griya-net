<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $table = 'sales';
    protected $fillable = ['user_id', 'name', 'nip', 'gender'];

    public function customers()
    {
        return $this->hasMany(Customer::class, 'sales_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
