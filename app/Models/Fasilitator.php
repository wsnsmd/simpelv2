<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fasilitator extends Model
{
    use HasFactory;
    protected $connection = 'mysql_no_prefix';
    protected $table = 'fasilitator';
    protected $fillable = [
        'nip',
        'nama',
        'pangkat_id',
        'tmt_pangat',
        'jabatan',
        'tmt_jabatan',
        'instansi',
        'satker_nama',
        'internal',
    ];

    protected $casts = [
        'internal' => 'boolean',
    ];

    public function pangkat(): BelongsTo
    {
        return $this->belongsTo(Pangkat::class, 'pangkat_id');
    }
}
