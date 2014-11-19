<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImageUploadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            $schema = Schema::connection('migration');
            $schema::create('image_uploads', function(Blueprint $table)
            {
                $table->increments('id');
                $table->tinyInteger('state');
                $table->timestamps();
                $table->primary('id');
            });
            foreach(ImageUpload::$idList as $id => $name) {
                $upload = ImageUpload::find($id);
                if(!$upload) {
                    $upload = new ImageUpload();
                    $upload->id = $id;
                }
                $upload->save();
            }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            $schema = Schema::connection('migration');
            $schema::drop('image_uploads');
	}

}
