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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name',256);
            $table->smallInteger('parent')->default(0);
            $table->integer('status')->nullable()->default(0);
            $table->integer('active')->default(0);
            $table->integer('created_by');
            $table->timestamps();
            $table->integer('updated_by');
            $table->smallInteger('del_flg')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->integer('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
