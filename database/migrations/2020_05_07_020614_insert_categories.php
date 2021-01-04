<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('categories')->insert([
            ['category_name' => 'promo', 'description' => 'Promo Packs'],
            ['category_name' => 'powder', 'description' => 'Powder Detergent'],
            ['category_name' => 'fabric', 'description' => 'Fabric Conditioner'],
            ['category_name' => 'liquid', 'description' => 'Liquid Detergent'],
            ['category_name' => 'multi', 'description' => 'Multipurpose Cleaner'],
            ['category_name' => 'toilet', 'description' => 'Toilet / Bathroom Cleaner'],
            ['category_name' => 'dish', 'description' => 'Dish Washing'],
            ['category_name' => 'shampoo', 'description' => 'Shampoo'],
            ['category_name' => 'conditioner', 'description' => 'Conditioner'],
            ['category_name' => 'body', 'description' => 'Body Wash'],
            ['category_name' => 'deo', 'description' => 'Deodorant'],
            ['category_name' => 'oral', 'description' => 'Oral Care'],
            ['category_name' => 'foods', 'description' => 'Foods'],
            ['category_name' => 'cooking', 'description' => 'Cooking Essentials'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->delete();
    }
}
