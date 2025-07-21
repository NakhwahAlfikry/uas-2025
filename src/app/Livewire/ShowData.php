<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DataPendaftaran;

class ShowData extends Component
{
    public function render()
    {
       
        $pendaftarans = DataPendaftaran::orderBy('created_at', 'desc')->get();

        return view('livewire.show-data', [
            'pendaftarans' => $pendaftarans,
        ]);
    }
}
