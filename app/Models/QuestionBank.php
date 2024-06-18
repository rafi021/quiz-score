<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionBank extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'options' => 'array',
    ];
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
