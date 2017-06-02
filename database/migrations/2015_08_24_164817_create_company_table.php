<?php

/**
 * Antvel - Data Base
 * Main Company Table.
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 100)->unique();
            $table->string('contact_email', 100);
            $table->string('sales_email', 100);
            $table->string('support_email', 100);
            $table->enum('status', array_keys(trans('globals.company_status')))->default('active');
            $table->string('name');
            $table->string('website_name', 150);
            $table->string('slogan', 100)->nullable();
            $table->string('logo', 100)->nullable();
            $table->string('theme', 50)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('cell_phone', 20)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('zip_code', 20)->nullable();
            $table->string('website', 100)->nullable();
            $table->string('twitter', 100)->nullable();
            $table->string('facebook', 100)->nullable();
            $table->string('google_plus', 100)->nullable();
            $table->string('facebook_app_id', 50)->nullable();
            $table->longText('description');
            $table->longText('keywords');
            $table->longText('about_us');
            $table->longText('refund_policy');
            $table->longText('privacy_policy');
            $table->longText('terms_of_service');
            $table->string('google_maps_key_api')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('company');
    }
}
