<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Site;
use Illuminate\Database\Seeder;
use Database\Seeders\LabelSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // seed dictionaries
            LabelSeeder::class,
            SiteSeeder::class,
            ClientSeeder::class,
            CompanySeeder::class,
        ]);
    }
}
