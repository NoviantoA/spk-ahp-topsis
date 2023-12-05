<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaModel extends Model
{
    use HasFactory;
    protected $table = 'kriteria';
    protected $primaryKey = 'kriteria_id';
    protected $guarded = [];

    public function relAlternatif()
    {
        return $this->hasMany(RelAlternatifModel::class, 'kriteria_id');
    }
}
