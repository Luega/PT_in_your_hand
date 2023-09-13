<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $table = 'exercises';

     protected $fillable = [
        'name',
        'type',
        'muscles_involved',
        'repetitions',
        'series',
        'time_under_work',
        'time_of_rest',
    ];
    use HasFactory;

    public function programs()
    {
        return $this->belongsToMany(Program::class);
    }
}
