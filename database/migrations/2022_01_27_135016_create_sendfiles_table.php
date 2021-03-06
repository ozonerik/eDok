<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sendfiles', function (Blueprint $table) {
            $table->id();
            $table->string('sendkey')->unique();
            $table->foreignId('myfile_id')->unsigned()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('receiveuser_id');
            $table->foreignId('user_id')->unsigned()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('is_read')->default(false);
            $table->foreign('receiveuser_id')->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('sendfiles');
    }
}
