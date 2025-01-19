<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Barang extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    

    /**
     * The peminjaman that belong to the Barang
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function peminjaman(): BelongsToMany
    {
        return $this->belongsToMany(Peminjam::class, 'peminjamen', 'id_barang', 'id_peminjam', 'bukti_peminjam')->withPivot('tgl_peminjaman', 'tgl_kembali');
    }
}
