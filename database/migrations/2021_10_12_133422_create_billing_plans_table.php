<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);   
            $table->decimal('cost_per_article', $precision = 8, $scale = 2); 
            $table->decimal('cost_per_participation', $precision = 8, $scale = 2);
            $table->decimal('cost_per_material', $precision = 8, $scale = 2);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billing_plans');
    }
}
