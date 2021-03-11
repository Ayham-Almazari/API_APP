<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('buyer_id');
            $table->unsignedBigInteger('owner_id');
            $table->foreign('admin_id')->references('id')->on('buyers');
            $table->foreign('buyer_id')->references('id')->on('owners');
            $table->foreign('owner_id')->references('id')->on('admins');
            $table->string('picture');
            $table->string('instagram');
            $table->string('address');
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
        Schema::dropIfExists('users_profiles');
    }
}
