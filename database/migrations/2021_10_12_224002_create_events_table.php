<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
        
            $table->id();                                           
            $table->string('name');   
            $table->timestamps();
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->timestamp('registration_until');
            $table->foreignId('event_type_id')->constrained();
            $table->foreignId('billing_plan_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {        
        Schema::dropIfExists('events');
    }
}
