<?php

namespace App\View\Components;

use Closure;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class SideItem extends Component
{
    public $href;
    public $title;
    public $active;
    public $icon;

    /**
     * Create a new component instance.
     */
    public function __construct($href, $title,  $icon,)
    {
        $this->href = $href;
        $this->title = $title;
        $this->icon = $icon;
        // test
        $this->active = Str::startsWith(request()->getPathInfo() . '/', rtrim($href, '/') . '/');
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.side-item');
    }
}
