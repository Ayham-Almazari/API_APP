<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('property_image');
            $table->enum('account_verification',['canceled','confirmed','under verification'])->default('under verification');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password');
            $table->timestamp("password_reset_at")->nullable();
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
        Schema::dropIfExists('owners');
    }
}
