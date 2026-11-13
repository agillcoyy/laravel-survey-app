<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Survey extends Model
{
    /**
     * Mass Assignment Protection:
     * Daftar kolom yang diizinkan untuk diisi secara massal lewat Survey::create([...]).
     * Mencegah user jahat menyisipkan kolom sensitif (misal 'id') lewat form request.
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'slug',
        'is_active',
    ];

    /**
     * Attribute Casting:
     * MySQL menyimpan tipe boolean sebagai angka 1 atau 0 (TINYINT).
     * Baris ini memaksa Laravel mengubahnya menjadi true/false murni saat dibaca di PHP.
     */

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relasi Inverse (Balikan): Satu Survei dimiliki oleh satu User pembuatnya.
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi One-to-Many: Satu Survei memiliki banyak Pertanyaan.
     * ->orderBy('order') memastikan setiap kali pertanyaan dipanggil, urutannya selalu rapi.
     */

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    /**
     * Relasi One-to-Many: Satu Survei memiliki banyak sesi jawaban (Responses) dari responden.
     */
    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }
}
