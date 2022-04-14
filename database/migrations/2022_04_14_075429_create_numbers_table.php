<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumbersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('numbers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('token_id')->index();
            $table->integer('number');
            $table->timestamps();

            $table->foreign('token_id')
                ->references('id')
                ->on('tokens')
                ->restrictOnUpdate()
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('numbers');
    }
}
