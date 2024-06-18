<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function questions(): HasMany
    {
        return $this->hasMany(QuestionBank::class);
    }
}
