<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('pd_id');
            $table->integer('pd_u_id');
            $table->integer('pd_subCategory_id');
            $table->integer('pd_category_id');
            $table->string('pd_name');
            $table->string('pd_keyword');
            $table->string('pd_listing_description');
            $table->integer('pd_min_order_qty');
            $table->string('minOrderUnit');
            $table->integer('min_price');
            $table->integer('max_price');
            $table->string('fob_mu_id');
            $table->string('port');
            $table->string('pd_payment_term');
            $table->integer('capacity');
            $table->integer('pd_supply_ability');
            $table->string('supplyPeriod');
            $table->string('pd_delivery_time');
            $table->string('pd_photo');
            $table->integer('pd_approval_status');
            $table->integer('pd_featured_status');
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
        Schema::dropIfExists('products');
    }
}
