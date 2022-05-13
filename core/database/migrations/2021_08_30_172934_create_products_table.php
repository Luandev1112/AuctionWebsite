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
            $table->integer('user_id');
            $table->integer('category_id');
            $table->string('title', 255)->nullable();
            $table->string('sub_title', 255)->nullable();
            $table->string('image')->nullable();
            $table->decimal('amount', 28,8)->default(0);
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(0)->comment('Pending : 0, Approved : 1, Cancel : 2, Expired : 3');
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
