<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableSlot extends Component
{
    public $table,$ncol,$ncolAdmin;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($table,$ncol,$ncolAdmin)
    {
        $this->table = $table;
        $this->ncol = $ncol;
        $this->ncolAdmin = $ncolAdmin;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table-slot');
    }
}
