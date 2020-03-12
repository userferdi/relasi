<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class ProductSeeder extends Seeder
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
    		DB::table('product')->insert([
        	'name' => $faker->name,
        	'price' => $faker->numberBetween(1000,100000),
        	'image' => $faker->name,
        	'brand_id' => numberBetween(1,15),
        	'category_id' => numberBetween(1,15)
        	]);
    	}
    }
}
