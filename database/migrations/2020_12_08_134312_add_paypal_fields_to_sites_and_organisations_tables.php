<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaypalFieldsToSitesAndOrganisationsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->string('paypal_client_id')->after('passed_health_check')->nullable();
            $table->string('paypal_client_secret')->after('paypal_client_id')->nullable();
        });

        Schema::table('organisations', function (Blueprint $table) {
            $table->string('paypal_client_id')->after('postcode')->nullable();
            $table->string('paypal_client_secret')->after('paypal_client_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn('paypal_client_id');
            $table->dropColumn('paypal_client_secret');
        });

        Schema::table('organisations', function (Blueprint $table) {
            $table->dropColumn('paypal_client_id');
            $table->dropColumn('paypal_client_secret');
        });
    }
}
