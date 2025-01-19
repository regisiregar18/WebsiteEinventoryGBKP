<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Peminjam extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * The peminjaman that belong to the Barang
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function barang(): BelongsToMany
    {
        return $this->belongsToMany(Barang::class, 'peminjamen', 'id_peminjam', 'id_barang', 'peminjams');
    }
}
