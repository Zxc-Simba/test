<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Site;

class SiteSeeder extends Seeder
{
    /**
     * @var $sites array
     */
    private $sites = [
        ['name' => 'Site 1'],
        ['name' => 'Site 2'],
        ['name' => 'Site 3'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->sites as $site) {
            if (!Site::firstWhere('name', $site['name'])) {
                Site::create($site);
            }
        }
    }
}
