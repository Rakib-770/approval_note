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
        Schema::create('approvals', function (Blueprint $table) {
            $table->id('approval_note_id');
            $table->foreignId('addressed_to_id')->nullable();
            $table->foreignId('approval_for_company_id');
            $table->foreignId('prepared_by_id');
            $table->string('approval_request_from');
            $table->date('approval_note_date');
            $table->longText('approval_note_subject');
            $table->string('approval_note_reference_no');
            $table->string('is_bill');
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
        Schema::dropIfExists('approvals');
    }
};
