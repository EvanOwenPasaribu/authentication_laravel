<?php

namespace Database\Seeders;

use App\Models\RegisterType;
use Illuminate\Database\Seeder;

class RegisterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name' => 'normal',
            'status' => 1,
        ];

        RegisterType::create($data);

        $data = [
            'name' => 'google',
            'status' => 1,
        ];

        RegisterType::create($data);

    }
}
