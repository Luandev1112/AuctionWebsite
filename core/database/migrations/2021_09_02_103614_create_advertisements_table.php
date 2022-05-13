<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('name',60)->nullable();
            $table->integer('click')->default(0);
            $table->integer('impression')->default(0);
            $table->tinyInteger('type')->default(0)->comment('Banner : 1, Script : 2');
            $table->string('size', 40)->nullable();
            $table->string('redirect_url')->nullable();
            $table->string('image')->nullable();
            $table->text('script')->nullable();
            $table->tinyInteger('status')->default(0)->comment('Enable : 1, Disable : 2');
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
        Schema::dropIfExists('advertisements');
    }
}
