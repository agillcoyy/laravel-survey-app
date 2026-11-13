<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    //
    protected $fillable = [
        'response_id',
        'question_id',
        'option_id',
        'answer_text',
    ];

    /**
     * Jawaban ini termasuk dalam satu sesi pengiriman (Response) tertentu.
     */
    public function response(): BelongsTo
    {
        return $this->belongsTo(Response::class);
    }

    /**
     * Jawaban ini merujuk pada satu Pertanyaan tertentu.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Jika tipe pertanyaannya pilihan ganda, jawaban ini merujuk pada Opsi yang dipilih.
     * Akan bernilai null jika tipe pertanyaannya adalah esai ('text').
     */
    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }
}
