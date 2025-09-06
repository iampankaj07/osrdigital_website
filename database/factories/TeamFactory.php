<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $positions = [
            'CEO', 'CTO', 'Lead Developer', 'Senior Developer', 'Frontend Developer',
            'Backend Developer', 'UI/UX Designer', 'Graphic Designer', 'Project Manager',
            'Business Analyst', 'Quality Assurance', 'DevOps Engineer', 'Marketing Manager',
            'Sales Representative', 'Customer Success Manager'
        ];

        $socialPlatforms = ['linkedin', 'twitter', 'facebook', 'github', 'website', 'instagram'];

        return [
            'name' => $this->faker->name(),
            'position' => $this->faker->randomElement($positions),
            'description' => $this->faker->paragraph(3),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'social_links' => $this->generateSocialLinks(),
            'is_active' => $this->faker->boolean(85), // 85% chance of being active
            'sort_order' => $this->faker->numberBetween(1, 100),
        ];
    }

    private function generateSocialLinks(): array
    {
        $platforms = ['linkedin', 'twitter', 'facebook', 'github', 'website', 'instagram'];
        $links = [];
        $numberOfLinks = $this->faker->numberBetween(0, 3);

        $selectedPlatforms = $this->faker->randomElements($platforms, $numberOfLinks);

        foreach ($selectedPlatforms as $platform) {
            $links[] = [
                'platform' => $platform,
                'url' => $this->generateUrlForPlatform($platform),
            ];
        }

        return $links;
    }

    private function generateUrlForPlatform(string $platform): string
    {
        $username = $this->faker->userName();

        return match ($platform) {
            'linkedin' => "https://linkedin.com/in/{$username}",
            'twitter' => "https://twitter.com/{$username}",
            'facebook' => "https://facebook.com/{$username}",
            'github' => "https://github.com/{$username}",
            'instagram' => "https://instagram.com/{$username}",
            'website' => "https://{$username}.dev",
            default => $this->faker->url(),
        };
    }
}
