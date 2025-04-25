<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pangkat extends Model
{
    use HasFactory;
    protected $connection = 'mysql_no_prefix';
    protected $table = 'pangkat';

    public function fasilitators(): HasMany
    {
        return $this->hasMany(Fasilitator::class, 'pangkat_id');
    }
}
