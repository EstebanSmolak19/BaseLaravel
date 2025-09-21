<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class input extends Component
{

    public string $type;
    public string $label;
    public string $name;
    public ?string $placeholder;


    /**
     * Create a new component instance.
     */
    public function __construct(string $type = 'text', string $label = '', string $name = '', string $placeholder = '')
    {
        $this->type = $type;
        $this->label = $label;
        $this->name = $name;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
