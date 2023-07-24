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
        Schema::create('configures', function (Blueprint $table) {
            $table->id();
            $table->string('configure_title')->nullable();
            $table->string('configure_name')->nullable();
            $table->text('configure_value')->nullable();
            $table->string('configure_type')->nullable();
            $table->boolean('configure_publish')->default(true);
            $table->integer('configure_ordering')->nullable();
            $table->string('group_name')->nullable();
            $table->integer('group_ordering')->nullable();
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
        Schema::dropIfExists('configures');
    }
};

