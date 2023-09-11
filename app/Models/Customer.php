<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $table = 'customers';

     protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'age',
        'gender',
        'height',
        'weight',
    ];
    use HasFactory;

     public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class);
    }
}
