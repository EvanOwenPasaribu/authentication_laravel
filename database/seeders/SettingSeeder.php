<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'key' => 'login',
            'value' => '{"max_attempt" : 5, "delay_attempt" : 60}',
        ];

        Setting::create($data);
    }
}
