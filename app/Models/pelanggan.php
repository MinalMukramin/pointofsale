<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pelanggan extends Model
{
    use HasFactory;
    protected $table = 'pelangans';
    public $timestamps = false;

    // has many to detailpembelian
    public function detailpembelian()
    {
        return $this->hasMany(detailpembelian::class , 'pelanggan_id', 'id');
    }
}
