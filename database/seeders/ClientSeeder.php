<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * @var $clients array
     */
    private $clients = [
        ['name' => 'Client 1'],
        ['name' => 'Client 2'],
        ['name' => 'Client 3'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->clients as $client) {
            if (!Client::firstWhere('name', $client['name'])) {
                Client::create($client);
            }
        }
    }
}
