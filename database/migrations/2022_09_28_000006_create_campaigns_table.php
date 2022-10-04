<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id');

            $table->decimal('total', $precision = 10, $scale = 2);
            $table->decimal('daily_budget', $precision = 10, $scale = 2);
            
            $table->string('name', 150);

            $table->timestamp('from')->useCurrent();
            $table->timestamp('to')->nullable();
            $table->timestamps();

            $table->text('images')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
}
