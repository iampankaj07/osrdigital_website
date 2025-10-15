<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Associate;
use App\Models\FilmPortfolio;
use App\Models\Testimonial;
use App\Models\News;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\FilmCategory;
use App\Models\DistributionService;
use App\Models\TrustedPartner;
use App\Models\PartnershipBenefit;
use App\Models\TeamValue;
use App\Models\CoreValue;
use App\Models\HeroSlider;
use App\Models\NewsCategory;

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
            'film_categories' => FilmCategory::count(),
            'distribution_services' => DistributionService::count(),
            'trusted_partners' => TrustedPartner::count(),
            'partnership_benefits' => PartnershipBenefit::count(),
            'team_values' => TeamValue::count(),
            'core_values' => CoreValue::count(),
            'hero_sliders' => HeroSlider::count(),
            'news_categories' => NewsCategory::count(),
        ];
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
