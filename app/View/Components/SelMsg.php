<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelMsg extends Component
{
    public $table,$selectPage,$selectAll,$checked;
    public $linkDeselect,$linkSelect;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($table,$selectPage,$selectAll,$checked,$linkDeselect,$linkSelect)
    {
        $this->table = $table;
        $this->selectPage = $selectPage;
        $this->selectAll = $selectAll;
        $this->checked = $checked;
        $this->linkDeselect = $linkDeselect;
        $this->linkSelect = $linkSelect;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sel-msg');
    }
}
