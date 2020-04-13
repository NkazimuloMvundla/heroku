<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyingRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buying_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('br_u_id');
            $table->integer('br_pc_id');
            $table->string('br_pc_name');
            $table->string('br_pd_spec');
            $table->string('br_attachment')->nullable();
            $table->integer('br_order_qty');
            $table->string('br_order_qnty_unit');
            $table->dateTime('br_expired_date')->nullable();
            $table->integer('br_approval_status')->nullable();
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
        Schema::dropIfExists('buying_requests');
    }
}
