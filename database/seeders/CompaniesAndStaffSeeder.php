<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompaniesAndStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            [
                'name' => 'Support',
                'website' => 'https://esemashko.com',
                'users' => [
                    [
                        'name' => 'Eduard',
                        'email' => 'info@esemashko.com',
                        'password' => bcrypt('password')
                    ]
                ]
            ],
            [
                'name' => 'Apple',
                'website' => 'https://www.apple.com',
                'users' => [
                    [
                        'name' => 'Steve Jobs',
                        'email' => 'steve.jobs@apple.com',
                        'password' => bcrypt('password'),
                    ],
                    [
                        'name' => 'Manager Apple',
                        'email' => 'manager@apple.com',
                        'password' => bcrypt('password'),
                    ]
                ]
            ],
            [
                'name' => 'Microsoft',
                'website' => 'https://www.microsoft.com',
                'users' => [
                    [
                        'name' => 'Bill Gates',
                        'email' => 'bill.gates@microsoft.com',
                        'password' => bcrypt('password'),
                    ]
                ]
            ],
            [
                'name' => 'Google',
                'website' => 'https://www.google.com',
                'users' => [
                    [
                        'name' => 'Larry Page',
                        'email' => 'larry.page@google.com',
                        'password' => bcrypt('password'),
                    ]
                ],
            ]
        ];

        foreach ($companies as $company) {
            $users = $company['users'];
            unset($company['users']);

            $result = Company::firstOrCreate(['name' => $company['name']], $company);
            if ($result->id) {
                foreach ($users as $user) {
                    $createdUser = User::firstOrCreate(['email' => $user['email']], $user);
                    $createdUser->companies()->attach($result->id);
                }
            }
        }
    }
}
