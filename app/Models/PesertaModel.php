<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaModel extends Model
{
    use HasFactory;

    protected $table = 'peserta';
    protected $primaryKey = 'id';

    protected $fillable = [
        'no_reg',
        'name',
        'origin',
        'event_title',
        'user_id'
    ];

    public function userUpload()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
