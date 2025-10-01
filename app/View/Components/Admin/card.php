<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class card extends Component
{
    public $label;
    public $number;
    public $progress;
    public $color;
    public $icon;
    /**
     * Create a new component instance.
     */
    public function __construct($label, $number, $progress = null, $color = 'info', $icon = 'fa-clipboard-list')
    {
        $this->label = $label;
        $this->number = $number;
        $this->progress = $progress;
        $this->color = $color;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.card');
    }
}
