<?php

namespace Database\Seeders;

use App\Models\Link;
use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Link::query()->delete();

        Link::factory(10)->create();

    }//end run()


}//end class
