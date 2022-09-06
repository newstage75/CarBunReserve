<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // 外部キー制約と型の制約を一度につける
            $table->foreignId('car_id')->constrained('cars'); // 外部キー制約と型の制約を一度につける
            $table->text('memo')->comment('使用用途など');
            $table->dateTime('start_at')->comment('開始時間');
            $table->dateTime('end_at')->comment('終了時間');
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
        Schema::dropIfExists('reservations');
    }
}
