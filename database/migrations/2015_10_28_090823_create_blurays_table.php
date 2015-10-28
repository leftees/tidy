<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBluraysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blurays', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('series_id')->unsigned()->nullable();
            $table->integer('rating_id')->unsigned()->nullable();
            $table->integer('account_id')->unsigned();
            
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
        if(Schema::hasTable('blurays')) {
            Schema::table('blurays', function(Blueprint $table) {
                $table->dropForeign('series_series_id_foreign');
                $table->dropForeign('ratings_rating_id_foreign');
                $table->dropForeign('accounts_account_id_foreign');
            });
        }
        
        Schema::dropIfExists('bluerays');
    }
}
