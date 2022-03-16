<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Grafik extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    
     public $namechart,$type,$target,$labelchart,$datachart,$chartcolor,$labelcolor;

    public function __construct($namechart,$type,$target,$labelchart,$datachart,$chartcolor,$labelcolor)
    {
        $this->namechart = $namechart;
        $this->type = $type;
        $this->target = $target;
        $this->labelchart = $labelchart;
        $this->datachart = $datachart;
        $this->chartcolor = $chartcolor;
        $this->labelcolor = $labelcolor;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function isColor($opsi)
    {
        if(count($opsi)==1){
            return implode("",$opsi);
        }
         return $opsi;
    }
     public function render()
    {
        return view('components.grafik');
    }
}
