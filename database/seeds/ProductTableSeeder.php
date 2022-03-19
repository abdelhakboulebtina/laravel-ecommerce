<?php

use Illuminate\Database\Seeder;
use App\Product;
class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=Faker\factory::create();
        //
        for($i=1;$i<30;$i++)
        {
            Product::create([
                'title'=> $faker->sentence(4),
                'slug'=> $faker->slug,
                'subtitle'=> $faker->sentence(3),
                'description'=> $faker->text,
                'price'=> $faker->numberBetween(100,150)*100,
                'image'=> 'https://via.placeholder.com/200x250',

            ])->categories()->attach([
                rand(1,4),
                rand(1,4)
            ]);
        }
    
    }
}
