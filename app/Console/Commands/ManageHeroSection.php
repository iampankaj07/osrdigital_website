<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HeroSection;

class ManageHeroSection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hero:manage 
                            {action : Action to perform (list|create|update|delete|activate|deactivate)}
                            {--page= : Page name for the hero section}
                            {--title= : Hero section title}
                            {--subtitle= : Hero section subtitle}
                            {--content= : Hero section content}
                            {--button-text= : Primary button text}
                            {--button-link= : Primary button link}
                            {--button-text-secondary= : Secondary button text}
                            {--button-link-secondary= : Secondary button link}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage hero sections for different pages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'list':
                $this->listHeroSections();
                break;
            case 'create':
                $this->createHeroSection();
                break;
            case 'update':
                $this->updateHeroSection();
                break;
            case 'delete':
                $this->deleteHeroSection();
                break;
            case 'activate':
                $this->toggleHeroSection(true);
                break;
            case 'deactivate':
                $this->toggleHeroSection(false);
                break;
            default:
                $this->error("Invalid action: {$action}");
                $this->info('Available actions: list, create, update, delete, activate, deactivate');
                return 1;
        }

        return 0;
    }

    private function listHeroSections()
    {
        $this->info('🎬 Hero Sections:');
        $this->newLine();

        $heroSections = HeroSection::orderBy('page')->get();

        if ($heroSections->isEmpty()) {
            $this->warn('No hero sections found.');
            return;
        }

        $headers = ['Page', 'Title', 'Subtitle', 'Status', 'Sort Order'];
        $rows = [];

        foreach ($heroSections as $hero) {
            $rows[] = [
                $hero->page,
                $hero->title,
                $hero->subtitle,
                $hero->is_active ? '✅ Active' : '❌ Inactive',
                $hero->sort_order
            ];
        }

        $this->table($headers, $rows);
    }

    private function createHeroSection()
    {
        $this->info('🎬 Creating New Hero Section...');
        $this->newLine();

        $page = $this->option('page') ?: $this->ask('Page name');
        $title = $this->option('title') ?: $this->ask('Title');
        $subtitle = $this->option('subtitle') ?: $this->ask('Subtitle');
        $content = $this->option('content') ?: $this->ask('Content');
        $buttonText = $this->option('button-text') ?: $this->ask('Primary button text (optional)');
        $buttonLink = $this->option('button-link') ?: $this->ask('Primary button link (optional)');
        $buttonTextSecondary = $this->option('button-text-secondary') ?: $this->ask('Secondary button text (optional)');
        $buttonLinkSecondary = $this->option('button-link-secondary') ?: $this->ask('Secondary button link (optional)');

        $heroSection = HeroSection::create([
            'page' => $page,
            'title' => $title,
            'subtitle' => $subtitle,
            'content' => $content,
            'button_text' => $buttonText,
            'button_link' => $buttonLink,
            'button_text_secondary' => $buttonTextSecondary,
            'button_link_secondary' => $buttonLinkSecondary,
            'is_active' => true,
            'sort_order' => 1
        ]);

        $this->info("✅ Hero section created successfully for page: {$page}");
    }

    private function updateHeroSection()
    {
        $page = $this->option('page') ?: $this->ask('Page name to update');

        $heroSection = HeroSection::where('page', $page)->first();

        if (!$heroSection) {
            $this->error("Hero section for page '{$page}' not found.");
            return;
        }

        $this->info("🎬 Updating Hero Section for page: {$page}");
        $this->newLine();

        $data = [];
        if ($title = $this->option('title') ?: $this->ask('Title (current: ' . $heroSection->title . ')', $heroSection->title)) {
            $data['title'] = $title;
        }
        if ($subtitle = $this->option('subtitle') ?: $this->ask('Subtitle (current: ' . $heroSection->subtitle . ')', $heroSection->subtitle)) {
            $data['subtitle'] = $subtitle;
        }
        if ($content = $this->option('content') ?: $this->ask('Content (current: ' . substr($heroSection->content, 0, 50) . '...)', $heroSection->content)) {
            $data['content'] = $content;
        }

        $heroSection->update($data);

        $this->info("✅ Hero section updated successfully for page: {$page}");
    }

    private function deleteHeroSection()
    {
        $page = $this->option('page') ?: $this->ask('Page name to delete');

        $heroSection = HeroSection::where('page', $page)->first();

        if (!$heroSection) {
            $this->error("Hero section for page '{$page}' not found.");
            return;
        }

        if ($this->confirm("Are you sure you want to delete the hero section for page '{$page}'?")) {
            $heroSection->delete();
            $this->info("✅ Hero section deleted successfully for page: {$page}");
        } else {
            $this->info('Operation cancelled.');
        }
    }

    private function toggleHeroSection($activate)
    {
        $page = $this->option('page') ?: $this->ask('Page name');

        $heroSection = HeroSection::where('page', $page)->first();

        if (!$heroSection) {
            $this->error("Hero section for page '{$page}' not found.");
            return;
        }

        $heroSection->update(['is_active' => $activate]);

        $status = $activate ? 'activated' : 'deactivated';
        $this->info("✅ Hero section {$status} successfully for page: {$page}");
    }
}
