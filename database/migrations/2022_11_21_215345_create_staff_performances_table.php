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
        Schema::create('staff_performances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('type')->nullable();
            $table->integer('rating')->nullable()->default(5);

            // $table->integer('performance')->nullable()->default(5);
            // $table->integer('punctuality')->nullable()->default(5);
            // $table->integer('discipline')->nullable()->default(5);
            
            $table->text('description')->nullable();
            $table->string('date_time')->nullable();

            $table->timestamp('created_at')->nullable()->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(\DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_performances');
    }
};
