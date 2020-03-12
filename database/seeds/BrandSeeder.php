<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker::create('id_ID');
    	for($i=1;$i<=15;$i++){
    		DB::table('brand')->insert([
        	'name' => $faker->name
        	]);
    	}
    }
}
