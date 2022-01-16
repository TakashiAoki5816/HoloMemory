<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHololiveMemberMstTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('HOLOLIVE_MEMBER_MST', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30)->comment('ホロメン名');
            $table->string('channel_id', 255)->unique()->comment('チャンネルID、各チャンネルページのchannel/以降の文字列');
            $table->integer('graduate_id')->comment('期生ID、ゲーマーズ:99、IRys:98');
            $table->string('channel_icon_url', 255);
            $table->string('country', 10);
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
        Schema::dropIfExists('HOLOLIVE_MEMBER_MST');
    }
}
