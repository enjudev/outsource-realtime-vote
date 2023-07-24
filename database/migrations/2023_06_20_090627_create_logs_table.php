<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->index();
            $table->string('email')->nullable()->index();
            $table->string('ip')->nullable()->index()->index();
            $table->string('browser')->nullable();
            $table->string('method')->nullable()->index();
            $table->longText('data')->nullable();
            $table->string('time')->nullable()->index();
            $table->string('url')->nullable();
            $table->string('action')->nullable();
            $table->string('module')->nullable()->index();
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
        Schema::dropIfExists('logs');
    }
};
