<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = [
            [
                'name' => 'Open',
                'button' => 'Open',
                'color' => '#5cb85c',
                'sort' => 1,
                'is_default' => true,
            ],
            [
                'name' => 'Awaiting Review',
                'button' => 'Mark as Done',
                'color' => '#ff8522',
                'sort' => 2
            ],
            [
                'name' => 'Postponed',
                'button' => 'Postpone',
                'color' => '#ffc926',
                'sort' => 3
            ],
            [
                'name' => 'Closed',
                'button' => 'Close',
                'color' => '#8e9eb3',
                'sort' => 4,
                'is_final' => true
            ]
        ];

        foreach ($priorities as $priority) {
            Status::firstOrCreate(['name' => $priority['name']], $priority);
        }
    }
}
