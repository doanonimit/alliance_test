<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourceContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('source_contact', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->constrained('source')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->string('email');
            $table->unsignedBigInteger('phone');
            $table->timestamps();
            $table->index(['phone']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('source_contact');
    }
}
