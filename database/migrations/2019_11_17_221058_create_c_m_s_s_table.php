<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCMSSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_m_s_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cms_title');
            $table->string('cms_page');
            $table->string('cms_content');
            $table->string('cms_banner');
            $table->integer('cms_status');
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
        Schema::dropIfExists('c_m_s_s');
    }
}
