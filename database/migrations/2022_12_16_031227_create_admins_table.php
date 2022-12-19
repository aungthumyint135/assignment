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
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid()->index();
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('password', 255);
            $table->unsignedBigInteger('role_id');
            $table->tinyInteger('is_super')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('role_id')->on('roles')->references('id')
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
        Schema::dropIfExists('admins');
    }
};
