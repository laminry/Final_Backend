<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateBookingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Model::unguard();
        Schema::create('bookings',function(Blueprint $table){
            $table->increments("id");
            $table->string("name");
            $table->string("email");
            $table->string("passid");
            $table->integer("rooms_id")->references("id")->on("rooms");
            $table->date("checkin");
            $table->date("checkout");
            $table->integer("noadults");
            $table->integer("nochildren");
            $table->string("additional")->nullable();
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
        Schema::drop('bookings');
    }

}
