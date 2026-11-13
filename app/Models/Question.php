<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    //
    protected $fillable = [
        'survey_id',
        'question_text',
        'question_type',
        'order',
    ];

    /**
     * Satu Pertanyaan adalah bagian dari satu Survei.
     */
    public function survey():BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    /**
     * Satu Pertanyaan (tipe radio/checkbox) memiliki banyak Opsi pilihan jawaban.
     */
    public function options():HasMany
    {
        return $this->hasMany(Option::class);
    }

    /**
     * Satu Pertanyaan memiliki banyak jawaban (Answers) dari responden.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }


}
