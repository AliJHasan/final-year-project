<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        DB::table('collages')->insert([
            'name' => 'كلية الهندسة المعلوماتية',
            'city' => 'جامعة تشرين',
            'maxStudentsNumber' => 500,
        ]);
    }
}
