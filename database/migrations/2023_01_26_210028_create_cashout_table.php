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
        Schema::create('cashout', function (Blueprint $table) {
            $table->id();
            $table->string('material')->nullable();
            $table->string('type');
            $table->integer('amount')->default(0);
            $table->string('currency')->default('idr');
            $table->integer('user');
            $table->integer('qty');
            $table->string('status');
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
        Schema::dropIfExists('cashout');
    }
};
