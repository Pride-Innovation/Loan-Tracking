<?php

namespace Database\Seeders;

use App\Models\Branches;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Group branches by region
        $branchesByRegion = [
            'Central' => [
                'Head Office',
                'City Centre',
                'Mukono',
                'Nateete',
                'Nakawa',
                'Kawempe',
                'Kabwohe',
                'Kyaliwajjala',
                'Nansana',
                'Abayita Ababiri',
                'Gayaza',
                'Kikuubo',
                'Kabalagala',
                'Nakulabye',
                'Bukoto',
                'Wandegeya',
                'Katwe',
                'Lugazi',
                'Kayunga',
                'Entebbe Road',
                'Bweyogerere',
            ],
            'Western' => [
                'Mbarara',
                'Masaka',
                'Kasese',
                'Ishaka',
                'Kabale',
                'Hoima',
                'Fortportal',
                'Bushenyi',
                'Buwenge',
                'Kisoro',
                'Bweyale',
                'Isingiro',
                'Ibanda',
                'Kagadi',
                'Masindi',
                'Rukungiri',
            ],
            'Eastern' => [
                'Jinja',
                'Mbale',
                'Iganga',
                'Soroti',
                'Bugiri',
                'Kamuli',
                'Namayingo',
            ],
            'Northern' => [
                'Lira',
                'Arua',
                'Gulu Branch',
                'Pader',
            ],
        ];

        // For each region, create branches
        foreach ($branchesByRegion as $regionName => $branches) {
            // Get region ID (assuming regions are seeded in order 1-4)
            $regionId = match($regionName) {
                'Central' => 1,
                'Western' => 2,
                'Eastern' => 3,
                'Northern' => 4,
            };

            // Create branches for this region
            foreach ($branches as $branchName) {
                Branches::create([
                    'name' => $branchName,
                    'region_id' => $regionId,
                    // Other fields will use defaults from the migration
                ]);
            }
        }
    }
}
