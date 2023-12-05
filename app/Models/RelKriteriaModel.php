<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelKriteriaModel extends Model
{
    use HasFactory;
    protected $table = 'rel_kriteria';
    protected $primaryKey = 'rel_kriteria_id';
    protected $guarded = [];
}