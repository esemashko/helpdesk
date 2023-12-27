<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $priorities = [
            [
                'name' => 'Low',
                'color' => '#8e9eb3',
                'sort' => 1,
                'is_default' => true,
            ],
            [
                'name' => 'Normal',
                'color' => '#5cb85c',
                'sort' => 2
            ],
            [
                'name' => 'High',
                'color' => '#ea2e49',
                'sort' => 3
            ]
        ];

        foreach ($priorities as $priority) {
            Priority::firstOrCreate(['name' => $priority['name']], $priority);
        }
    }
}
