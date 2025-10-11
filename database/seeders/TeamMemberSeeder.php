<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TeamMember;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teamMembers = [
            [
                'name' => 'Sarah Chen',
                'position' => 'CEO & Founder',
                'department' => 'Leadership',
                'avatar' => 'https://via.placeholder.com/300x300/EC681D/FFFFFF?text=SC',
                'linkedin' => 'https://linkedin.com/in/sarahchen',
                'twitter' => 'https://twitter.com/sarahchen',
                'email' => 'sarah@osrdigital.com',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Michael Rodriguez',
                'position' => 'Chief Technology Officer',
                'department' => 'Technology',
                'avatar' => 'https://via.placeholder.com/300x300/EC681D/FFFFFF?text=MR',
                'linkedin' => 'https://linkedin.com/in/michaelrodriguez',
                'twitter' => 'https://twitter.com/michaelrod',
                'email' => 'michael@osrdigital.com',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Emma Thompson',
                'position' => 'Head of Content Strategy',
                'department' => 'Content',
                'avatar' => 'https://via.placeholder.com/300x300/EC681D/FFFFFF?text=ET',
                'linkedin' => 'https://linkedin.com/in/emmathompson',
                'twitter' => 'https://twitter.com/emmathompson',
                'email' => 'emma@osrdigital.com',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'David Park',
                'position' => 'Head of Partnerships',
                'department' => 'Business Development',
                'avatar' => 'https://via.placeholder.com/300x300/EC681D/FFFFFF?text=DP',
                'linkedin' => 'https://linkedin.com/in/davidpark',
                'twitter' => 'https://twitter.com/davidpark',
                'email' => 'david@osrdigital.com',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Lisa Wang',
                'position' => 'Head of Marketing',
                'department' => 'Marketing',
                'avatar' => 'https://via.placeholder.com/300x300/EC681D/FFFFFF?text=LW',
                'linkedin' => 'https://linkedin.com/in/lisawang',
                'twitter' => 'https://twitter.com/lisawang',
                'email' => 'lisa@osrdigital.com',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'James Wilson',
                'position' => 'Head of Operations',
                'department' => 'Operations',
                'avatar' => 'https://via.placeholder.com/300x300/EC681D/FFFFFF?text=JW',
                'linkedin' => 'https://linkedin.com/in/jameswilson',
                'twitter' => 'https://twitter.com/jameswilson',
                'email' => 'james@osrdigital.com',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Maria Garcia',
                'position' => 'Lead Developer',
                'department' => 'Technology',
                'avatar' => 'https://via.placeholder.com/300x300/EC681D/FFFFFF?text=MG',
                'linkedin' => 'https://linkedin.com/in/mariagarcia',
                'twitter' => 'https://twitter.com/mariagarcia',
                'email' => 'maria@osrdigital.com',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Alex Johnson',
                'position' => 'Content Manager',
                'department' => 'Content',
                'avatar' => 'https://via.placeholder.com/300x300/EC681D/FFFFFF?text=AJ',
                'linkedin' => 'https://linkedin.com/in/alexjohnson',
                'twitter' => 'https://twitter.com/alexjohnson',
                'email' => 'alex@osrdigital.com',
                'sort_order' => 8,
                'is_active' => true,
            ]
        ];

        foreach ($teamMembers as $member) {
            TeamMember::create($member);
        }
    }
}