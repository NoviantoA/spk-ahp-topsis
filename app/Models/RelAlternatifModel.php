<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelAlternatifModel extends Model
{
    use HasFactory;
    protected $table = 'rel_alternatif';
    protected $primaryKey = 'rel_alternatif_id';
    protected $guarded = [];

    public function alternatif()
    {
        return $this->belongsTo(AlternatifModel::class, 'relatif_id');
    }
    public function kriteria()
    {
        return $this->belongsTo(KriteriaModel::class, 'kriteria_id');
    }
}