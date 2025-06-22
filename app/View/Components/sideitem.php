<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class sideitem extends Component
{
    public $href;
    public $title;
    public $active;
    public $icon;

    /**
     * Create a new component instance.
     */
    public function __construct($href, $title,  $icon)
    {
        $this->href = $href;
        $this->title = $title;
        $this->icon = $icon;
        $this->active = request()->getPathInfo() == $href;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sideitem');
    }
}
