<?php

use App\Models\CastMembers;
use Illuminate\Database\Seeder;

class CastMembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CastMembers::class, 50)->create();
    }
}
