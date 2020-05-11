<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('organisation_id');
            $table->string('title');
            $table->string('logo_text')->nullable();
            $table->string('tld');
            $table->text('description')->nullable();
            $table->boolean('uses_www')->default(1);
            $table->boolean('uses_https')->default(1);
            $table->string('theme')->default('default');
            $table->string('status')->default('maintenance');
            $table->boolean('passed_health_check')->nullable();
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
        Schema::dropIfExists('sites');
    }
}
