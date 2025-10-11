<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Associate;
use App\Models\TrustedPartner;
use App\Models\TeamMember;
use App\Models\FilmPortfolio;
use App\Models\Testimonial;
use App\Models\Portfolio;

class ClearMissingImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:clear-missing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all missing images and replace with proper placeholders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to clear missing images...');

        // Clear Associates missing images
        $this->clearAssociatesImages();

        // Clear Trusted Partners external URLs
        $this->clearTrustedPartnersImages();

        // Clear Team Members external URLs
        $this->clearTeamMembersImages();

        // Clear Film Portfolios external URLs
        $this->clearFilmPortfoliosImages();

        // Clear Testimonials missing data
        $this->clearTestimonialsData();

        // Clear Portfolio missing images
        $this->clearPortfolioImages();

        $this->info('All missing images have been cleared and replaced with placeholders.');
    }

    private function clearAssociatesImages()
    {
        $this->info('Clearing Associates missing images...');
        
        $associates = Associate::whereNull('logo')->orWhere('logo', '')->get();
        
        foreach ($associates as $associate) {
            $initials = $this->getInitials($associate->name);
            $placeholderUrl = "https://via.placeholder.com/400x300/EC681D/FFFFFF?text={$initials}";
            
            $associate->update(['logo' => $placeholderUrl]);
            $this->line("Updated Associate: {$associate->name} with placeholder image");
        }
    }

    private function clearTrustedPartnersImages()
    {
        $this->info('Clearing Trusted Partners external URLs...');
        
        $partners = TrustedPartner::where('logo', 'like', '%via.placeholder.com%')->get();
        
        foreach ($partners as $partner) {
            $initials = $this->getInitials($partner->name);
            $placeholderUrl = "https://via.placeholder.com/200x100/EC681D/FFFFFF?text={$initials}";
            
            $partner->update(['logo' => $placeholderUrl]);
            $this->line("Updated Partner: {$partner->name} with placeholder logo");
        }
    }

    private function clearTeamMembersImages()
    {
        $this->info('Clearing Team Members external URLs...');
        
        $members = TeamMember::where('avatar', 'like', '%via.placeholder.com%')->get();
        
        foreach ($members as $member) {
            $initials = $this->getInitials($member->name);
            $placeholderUrl = "https://via.placeholder.com/300x300/EC681D/FFFFFF?text={$initials}";
            
            $member->update(['avatar' => $placeholderUrl]);
            $this->line("Updated Team Member: {$member->name} with placeholder avatar");
        }
    }

    private function clearFilmPortfoliosImages()
    {
        $this->info('Clearing Film Portfolios external URLs...');
        
        $films = FilmPortfolio::where('image_url', 'like', '%unsplash.com%')->get();
        
        foreach ($films as $film) {
            $initials = $this->getInitials($film->title);
            $placeholderUrl = "https://via.placeholder.com/800x450/EC681D/FFFFFF?text={$initials}";
            
            $film->update(['image_url' => $placeholderUrl]);
            $this->line("Updated Film: {$film->title} with placeholder image");
        }
    }

    private function clearTestimonialsData()
    {
        $this->info('Clearing Testimonials missing data...');
        
        $testimonials = Testimonial::whereNull('name')->orWhere('name', '')->get();
        
        foreach ($testimonials as $index => $testimonial) {
            $authorName = "Client " . ($index + 1);
            $initials = $this->getInitials($authorName);
            $placeholderAvatar = "https://via.placeholder.com/300x300/EC681D/FFFFFF?text={$initials}";
            
            $testimonial->update([
                'name' => $authorName,
                'avatar_url' => $placeholderAvatar
            ]);
            $this->line("Updated Testimonial: {$authorName} with placeholder data");
        }
    }

    private function clearPortfolioImages()
    {
        $this->info('Clearing Portfolio missing images...');
        
        $portfolios = Portfolio::whereNull('image_url')->orWhere('image_url', '')->get();
        
        foreach ($portfolios as $portfolio) {
            $initials = $this->getInitials($portfolio->title);
            $placeholderUrl = "https://via.placeholder.com/800x450/EC681D/FFFFFF?text={$initials}";
            
            $portfolio->update(['image_url' => $placeholderUrl]);
            $this->line("Updated Portfolio: {$portfolio->title} with placeholder image");
        }
    }

    private function getInitials($name)
    {
        $words = explode(' ', trim($name));
        $initials = '';
        
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }
        
        // Limit to 2 characters for better display
        return substr($initials, 0, 2);
    }
}
