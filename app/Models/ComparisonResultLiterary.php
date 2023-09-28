<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComparisonResultLiterary extends Model
{
    protected $table = 'comparisonresult_l';
    protected $fillable = [
        'subscriptionNumber','comparisonId'
    ];
    use HasFactory;
}
