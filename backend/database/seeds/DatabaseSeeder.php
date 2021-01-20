<?php

use App\Models\CastMembers;
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
         $this->call(CastMembersSeeder::class);
         $this->call(CategorySeeder::class);
         $this->call(GeneroSeeder::class);
    }
}
