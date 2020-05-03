<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellingRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selling_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sr_u_id');
            $table->integer('sr_pc_id');
            $table->string('sr_pc_name');
            $table->string('sr_pd_spec');
            $table->string('sr_attachment')->nullable();
            $table->integer('sr_order_qty');
            $table->string('sr_order_qnty_unit');
            $table->string('message');
            $table->dateTime('sr_expired_date')->nullable();
            $table->integer('sr_approval_status')->nullable();
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
        Schema::dropIfExists('selling_requests');
    }
}
