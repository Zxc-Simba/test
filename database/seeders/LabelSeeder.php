<?php

namespace Database\Seeders;

use App\Models\Label;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    /**
     * @var $labels array
     */
    private $labels = [
        ['name' => 'Lable 1'],
        ['name' => 'Lable 2'],
        ['name' => 'Lable 3'],
        ['name' => 'Lable 4'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->labels as $label) {
            if (!Label::firstWhere('name', $label['name'])) {
                Label::create($label);
            }
        }
    }
}
