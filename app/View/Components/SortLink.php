<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SortLink extends Component
{
    public $col;
    public $label;

    /**
     * Create a new component instance.
     */
    public function __construct($col, $label)
    {
        $this->col = $col;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sort-link');
    }
}
