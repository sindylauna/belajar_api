<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemain extends Model
{
    use HasFactory;
    public $fillable=['nama_pemain', 'foto', 'tgl_lahir', 'posisi', 'harga_pasar','negara','id_klub'];
    public function klub()
    {
        return $this->belongsTo(Klub::class ,'id_klub');
    }
}
