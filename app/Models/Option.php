<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends Model
{
    //
    protected $fillable = [
        'question_id',
        'option_text',
    ];

    /**
     * Satu Opsi pilihan jawaban dimiliki oleh satu Pertanyaan.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

   /**
     * Satu Opsi bisa dipilih berkali-kali oleh responden yang berbeda.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
