<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        \Illuminate\Support\Facades\DB::table('organizers')->where('id',1)->update(['password_hash'=>bcrypt('demopass1')]);
        \Illuminate\Support\Facades\DB::table('organizers')->where('id',2)->update(['password_hash'=>bcrypt('demopass2')]);
    }
}
