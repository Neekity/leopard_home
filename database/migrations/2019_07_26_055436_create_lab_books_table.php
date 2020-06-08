<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bookName')->comment('书名');
            $table->string('borrowerName')->comment('借阅人姓名');
            $table->string('borrowerEmail')->comment('借阅人邮箱');
            $table->integer('is_deleted')->default(0)->comment('0为存在1为消失');
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
        Schema::dropIfExists('lab_books');
    }
}
