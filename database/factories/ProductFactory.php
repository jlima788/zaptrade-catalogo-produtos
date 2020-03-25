<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Product::class, function (Faker $faker) {

    $title = $faker->sentence(5);

    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'user' => 1,
        'sale_price' => $faker->randomFloat(2, 0, 10000),
        'description' => $faker->paragraph(5),
        'status' => 1,

//        'name' => $faker->word,
//        'short_description' => $faker->sentence,
//        'description' => $faker->paragraph,
//        'category_id' => function () {
//            return factory(App\Category::class)->create()->id;
//        },
//        'amount' => $faker->randomFloat(2, 0, 10000),
//        'image' => $faker->image('public/storage/images',640,480, null, false),
    ];
});
