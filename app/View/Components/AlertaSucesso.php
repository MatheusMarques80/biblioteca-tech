<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AlertaSucesso extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $icone = 'bi bi-check-circle',
        public string $mensagem = ''
    )
    {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alerta-sucesso');
    }
}
