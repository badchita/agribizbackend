<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsVendor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications_vendor', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('product_id');
            $table->integer('order_id');
            $table->integer('address_id');
            $table->string('title');
            $table->text('content');
            $table->string('description');
            $table->string('subject');
            $table->integer('from_id');
            $table->integer('to_id');
            $table->string('status');
            $table->boolean('markRead');
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
        Schema::dropIfExists('notifications_vendor');
    }
}