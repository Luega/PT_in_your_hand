<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Program extends Model
{
    use HasFactory;

    protected $table = 'programs';

     protected $fillable = [
        'title',
        'period_of_time',
        'goal',
    ];
    use HasFactory;

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class);
    }

    public function exercises() 
    {
        return $this->belongsToMany(Exercise::class);
    }
}
