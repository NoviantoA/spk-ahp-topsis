<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlternatifModel extends Model
{
    use HasFactory;
    protected $table = 'alternatif';
    protected $primaryKey = 'alternatif_id';
    protected $guarded = [];

    public function relAlternatif()
    {
        return $this->hasMany(RelAlternatifModel::class, 'alternatif_id');
    }
}
