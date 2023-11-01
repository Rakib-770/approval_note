<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id('company_id');
            $table->string('company_name');
            $table->timestamps();
        });

        DB::table('companies')->insert([
            ['company_name' => 'Mir Telecom Ltd.'],
            ['company_name' => 'Coloasia'],
            ['company_name' => 'Mir Cloud'],
            ['company_name' => 'Bangla Telecom'],
            ['company_name' => 'Orange Pie']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
