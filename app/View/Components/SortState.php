<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SortState extends Component
{
    public $sortBy,$colName,$sortDir;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($sortBy,$colName,$sortDir)
    {
        $this->sortBy = $sortBy;
        $this->sortDir = $sortDir;
        $this->colName = $colName;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sort-state');
    }
}
