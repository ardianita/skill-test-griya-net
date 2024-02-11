<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $fillable = ['package_id', 'sales_id', 'name', 'alamat', 'telp', 'ktp'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function sales()
    {
        return $this->belongsTo(Sales::class);
    }
}
