<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('lastName');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('account_type');
            $table->string('role');
            $table->string('about_us')->nullable();
            $table->string('industry');
            $table->string('company_name');
            $table->string('company_logo')->nullable();
            $table->string('company_slogan')->nullable();
            $table->string('company_background_img')->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('country');
            $table->string('province');
            $table->string('company_address')->nullable();
            $table->integer('phone_number');
            $table->integer('status');
            $table->string('membership');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
