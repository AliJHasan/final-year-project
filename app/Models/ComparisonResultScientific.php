<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComparisonResultScientific extends Model
{
    protected $table = 'comparisonresult_s';
    protected $fillable = [
        'subscriptionNumber','comparisonId','desireId','status'
    ];
    use HasFactory;
}
