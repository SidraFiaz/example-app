<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Optional explicit browser page title (without app name).
     * Usage: <x-app-layout title="Students"> or <x-slot name="title">Students</x-slot>
     */
    public function __construct(
        public ?string $title = null,
    ) {}

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
