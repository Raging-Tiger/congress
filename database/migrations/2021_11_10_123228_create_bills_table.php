<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->decimal('total_cost_per_articles', $precision = 8, $scale = 2)->nullable(); 
            $table->decimal('total_cost_per_participation', $precision = 8, $scale = 2)->nullable();
            $table->decimal('total_cost_per_materials', $precision = 8, $scale = 2)->nullable();
            $table->boolean('is_confirmation_uploaded')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('event_id')->constrained();
            $table->foreignId('bill_status_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
