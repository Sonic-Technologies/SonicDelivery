<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('artcode', 50)->nullable();
            $table->string('artdesc', 100)->nullable();
            $table->float('primcs')->nullable();
            $table->float('secondcs')->nullable();
            $table->float('price')->nullable();
            $table->string('artshrtdesc', 100)->nullable();
            $table->string('unitconv2', 20)->nullable();
            $table->string('stat', 20)->nullable();
            $table->string('site', 20)->nullable();
            $table->string('uom2', 20)->nullable();
            $table->string('uom3', 20)->nullable();
            $table->float('volumecs')->nullable();
            $table->float('volumecsl')->nullable();
            $table->float('volumepc')->nullable();
            $table->float('volumepcl')->nullable();
            $table->float('widthcs')->nullable();
            $table->float('widthpc')->nullable();
            $table->string('bum', 20)->nullable();
            $table->string('uom1', 20)->nullable();
            $table->string('unitconv1', 20)->nullable();
            $table->string('unitconv3', 20)->nullable();
            $table->string('merchcat', 20)->nullable();
            $table->string('brand', 40)->nullable();
            $table->string('category', 75)->nullable();
            $table->string('subcat', 40)->nullable();
            $table->string('division', 40)->nullable();
            $table->string('assortnum', 20)->nullable();
            $table->string('listmod', 20)->nullable();
            $table->string('assortstat', 20)->nullable();
            $table->float('grosswghtpc')->nullable();
            $table->float('netwghtpc')->nullable();
            $table->float('grosswghtcs')->nullable();
            $table->float('netwghtcs')->nullable();
            $table->float('lengthpc')->nullable();
            $table->float('heightpc')->nullable();
            $table->float('lengthcs')->nullable();
            $table->float('heightcs')->nullable();
            $table->string('photo', 500)->nullable();
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
