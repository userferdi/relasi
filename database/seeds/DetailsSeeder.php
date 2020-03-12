<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class DetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker::create('id_ID');
    	for($i=1;$i<=25;$i++){
    		DB::table('details')->insert([
        	'name' => $faker->name,
        	'details_1' => $faker-> ,
        	'details_2' => $faker-> 
        	]);
    	}
    }
}
