<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComparisonScientific extends Model
{
    protected $table = 'comparisonscientific';
    protected $fillable = [
        'name','city','avg','maxStudentsNumber'
    ];
    use HasFactory;
}
