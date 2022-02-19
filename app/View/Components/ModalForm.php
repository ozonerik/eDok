<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModalForm extends Component
{
    public $modalname;
    public $linksubmit,$btntype,$btnlabel;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($modalname,$linksubmit,$btntype,$btnlabel)
    {
        $this->modalname = $modalname;
        $this->linksubmit = $linksubmit;
        $this->btntype = $btntype;
        $this->btnlabel = $btnlabel;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal-form');
    }
}
