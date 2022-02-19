<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableMenu extends Component
{
    public $mdperhal,$table,$checked,$mdsearch;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($mdperhal,$table,$checked,$mdsearch)
    {
        $this->mdperhal = $mdperhal;
        $this->table = $table;
        $this->checked = $checked;
        $this->mdsearch = $mdsearch;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table-menu');
    }
}
