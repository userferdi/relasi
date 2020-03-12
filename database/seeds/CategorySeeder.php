<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class CategorySeeder extends Seeder
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
    		DB::table('category')->insert([
        	'name' => $faker->name
        	]);
    	}
    }
}
