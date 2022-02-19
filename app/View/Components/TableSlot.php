<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableSlot extends Component
{
    public $table,$ncol;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($table,$ncol)
    {
        $this->table = $table;
        $this->ncol = $ncol;
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
