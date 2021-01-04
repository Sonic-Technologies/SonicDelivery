<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertCategories1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('categories')->insert([
            ['category_name' => 'savoury', 'description' => 'Savoury'],
            ['category_name' => 'dressings', 'description' => 'Dressings'],
            ['category_name' => 'otherfoods', 'description' => 'Other Foods'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->whereIn('category_name',['savoury','dressings','otherfoods'])->delete();
    }
}
