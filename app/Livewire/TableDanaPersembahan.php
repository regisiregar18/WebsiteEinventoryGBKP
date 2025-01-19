<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DanaPersembahan;
use Illuminate\Support\Facades\DB;

class TableDanaPersembahan extends Component
{
    public $cariDana = 0;

    public function render()
    {
        if ($this->cariDana != 0) {
            $data = DanaPersembahan::where('bulan', 'LIKE', '%' . $this->cariDana . '%')
                ->latest()->get();
            $total = DB::table('dana_persembahans')->where('bulan', 'LIKE', '%' . $this->cariDana . '%')
                ->sum('jumlah_persembahan');
        } else {
            $data = DanaPersembahan::latest()->get();
            $total = DB::table('dana_persembahans')->sum('jumlah_persembahan');
        }

        return view('livewire.table-dana-persembahan', compact('data', 'total'));
    }
}
