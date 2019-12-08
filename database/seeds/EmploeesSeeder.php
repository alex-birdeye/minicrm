<?php

use App\Models\Emploee;
use Illuminate\Database\Seeder;

class EmploeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Emploee::class, 10000)->create();
    }
}
