<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('buyers');
            $table->foreignId('factory_id')->constrained('factories');
            $table->enum("status",["Shipped", "Cancelled", "In Process"])->default('In Process');
            $table->text("comment")->nullable();
            $table->decimal('total_amount',8,2)->nullable();
            $table->dateTime('orderDate')->nullable();
            $table->date('requiredDate')->nullable();
            $table->dateTime('shippedDate')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
