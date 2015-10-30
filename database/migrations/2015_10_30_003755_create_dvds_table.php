<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDvdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'dvds',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->text('description')->nullable();
                $table->integer('series_id')->unsigned()->nullable();
                $table->integer('rating_id')->unsigned()->nullable();
                $table->integer('account_id')->unsigned();

                $table->timestamps();
                $table->softDeletes();

                $table->foreign('series_id')->references('id')->on('series');
                $table->foreign('rating_id')->references('id')->on('ratings');
                $table->foreign('account_id')->references('id')->on('accounts');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'dvds',
            function (Blueprint $table) {
                $table->dropForeign('dvds_series_id_foreign');
                $table->dropForeign('dvds_rating_id_foreign');
                $table->dropForeign('dvds_account_id_foreign');
            }
        );

        Schema::drop('dvds');
    }

}
