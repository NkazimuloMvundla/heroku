<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('msg_from_id');
            $table->integer('msg_to_id');
            $table->string('msg_subject');
            $table->string('msg_body');
            $table->float('price');
            $table->string('reply_attachment')->nullable();
            $table->string('quantity_unit');
            $table->integer('quantity');
            $table->integer('msg_read');
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
        Schema::dropIfExists('messages');
    }
}
