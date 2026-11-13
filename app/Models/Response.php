<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Response extends Model
{
    //
    protected $fillable = [
        'survey_id',
        'respondent_ip',
        'submitted_at',
    ];

    /**
     * Mengubah string tanggal dari database menjadi objek Carbon (DateTime Laravel)
     * sehingga mudah diformat di tampilan (contoh: $response->submitted_at->diffForHumans()).
     */
    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    /**
     * Satu sesi Response ditujukan untuk satu Survei tertentu.
     */
    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    /**
     * Satu sesi pengisian dari responden berisi banyak detail Jawaban per pertanyaan.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
