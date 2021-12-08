<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversation', function (Blueprint $table) {
            $table->id();
            $table->integer('sender_id');
            $table->integer('from_id');
            $table->integer('conversation_id');
            $table->string('from_username');
            $table->string('sender_username');
            $table->string('message');
            $table->boolean('new')->default(1)->nullable();
            $table->boolean('markRead')->default(0)->nullable();
            $table->string('status');
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
        Schema::dropIfExists('conversation');
    }
}