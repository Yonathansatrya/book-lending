<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'kode_buku',
        'judul',
        'penulis',
        'penerbit',
        'tahun',
        'stok',
        'cover',
    ];

    public function loanDetails()
    {
        return $this->hasMany(LoanDetail::class);
    }
}
