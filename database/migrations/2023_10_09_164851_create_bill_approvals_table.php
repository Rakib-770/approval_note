<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('approval_note_id');
            $table->longText('bill_approval_description')->nullable();
            $table->longText('bill_approval_narration')->nullable();
            $table->string('file');
            $table->double('amount');
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
        Schema::dropIfExists('bill_approvals');
    }
};
