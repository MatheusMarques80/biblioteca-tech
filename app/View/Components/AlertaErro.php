<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AlertaErro extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $icone = 'bi bi-exclamation-octagon',
        public string $mensagem = ''
    )
    {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alerta-erro');
    }
}
