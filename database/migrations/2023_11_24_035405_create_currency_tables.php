<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currency', function (Blueprint $table) {
            $table->id();
            $table->string('currency_code');
            $table->string('cbr_code');
            $table->timestamp('date');
            $table->integer('nominal');
            $table->decimal('rate', 10, 4);
            $table->float('unit_rate', 10, 4);

            $table->unique('currency_code');
            $table->unique('cbr_code');

            $table->timestamps();
        });

        Schema::create('currency_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('currency_id');
            $table->timestamp('date');
            $table->integer('nominal');
            $table->float('rate', 10, 4);
            $table->float('unit_rate', 10, 4);

            $table->foreign('currency_id')
                ->references('id')
                ->on('currency')
                ->onDelete('cascade');

            $table->unique(['currency_id', 'date']);
            $table->index('nominal');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_history');
    }
};
