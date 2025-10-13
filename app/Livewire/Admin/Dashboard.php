<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Associate;
use App\Models\FilmPortfolio;
use App\Models\Testimonial;
use App\Models\News;
use App\Models\Service;
use App\Models\TeamMember;

class Dashboard extends Component
{
    public $stats = [];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->stats = [
            'associates' => Associate::count(),
            'film_portfolios' => FilmPortfolio::count(),
            'testimonials' => Testimonial::count(),
            'news' => News::count(),
            'services' => Service::count(),
            'team_members' => TeamMember::count(),
        ];
    }

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('admin.layout', ['title' => 'Dashboard']);
    }
}
