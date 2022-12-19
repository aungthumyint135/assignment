<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();$table->uuid('uuid');
            $table->string('name');
            $table->longText('desc')->nullable();
            $table->unsignedBigInteger('sub_category_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('sub_category_id')->on('sub_categories')->references('id')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
