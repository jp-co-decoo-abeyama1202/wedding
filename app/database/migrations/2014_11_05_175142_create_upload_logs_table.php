<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            $schema = Schema::connection('migration');
            $schema::create('upload_logs', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('type')->unsigned();
                $table->tinyInteger('state')->unsigned()->default(0);
                $table->binary('data');
                $table->timestamps();
                $table->primary('id');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            $schema = Schema::connection('migration');
            $schema::drop('upload_logs');
	}

}
