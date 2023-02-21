<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TemplateLayout extends Component
{
    
    public function __construct()
    {
        //
    }

    public function render()
    {
        return view('layouts.template.app');
    }
}
