<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCommentsTable extends Migration
{
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->unsignedBigInteger('video_id');
            $table->foreign('video_id', 'video_fk_3793070')->references('id')->on('videos');
            $table->unsignedBigInteger('answer_id')->nullable();
            $table->foreign('answer_id', 'answer_fk_3806362')->references('id')->on('comments');
        });
    }
}
