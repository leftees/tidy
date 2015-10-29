<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('for_dvd')->default(false);
            $table->boolean('for_bluray')->default(false);
            $table->boolean('for_book')->default(false);
            $table->integer('account_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('series')) {
            Schema::table('series', function(Blueprint $table) {
                $table->dropForeign('series_account_id_foreign');
            });
        }
            
        
        Schema::dropIfExists('series');
    }
}
