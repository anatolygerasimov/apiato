<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrchidAttachmentstableTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('original_name');
            $table->string('mime');
            $table->string('extension')->nullable();
            $table->bigInteger('size')->default(0);
            $table->integer('sort')->default(0);
            $table->text('path');
            $table->text('description')->nullable();
            $table->text('alt')->nullable();
            $table->text('hash')->nullable();
            $table->string('disk')->default('public');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('group')->nullable();
            $table->timestamps();
        });

        Schema::create('attachmentable', function (Blueprint $table) {

            $table->id();
            $table->numericMorphs('attachmentable');

            $table->foreignId('attachment_id')
                ->index()
                ->comment('FK Attachments')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('attachmentable');
        Schema::drop('attachments');
    }
}
