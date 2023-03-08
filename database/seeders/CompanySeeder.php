<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * @var $companies array
     */
    private $companies = [
        ['name' => 'Company 1'],
        ['name' => 'Company 2'],
        ['name' => 'Company 3'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->companies as $company) {
            if (!Company::firstWhere('name', $company['name'])) {
                Company::create($company);
            }
        }
    }
}
