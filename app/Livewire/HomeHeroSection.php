<?php

namespace App\Livewire;

use App\Models\HeroSection;
use Livewire\Component;

class HomeHeroSection extends Component
{
    public function render()
    {
        $heroSections = HeroSection::getActiveForHome();

        return view('livewire.home-hero-section', compact('heroSections'));
    }
}
