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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title',256);
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->text('image')->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->integer('active')->default(0);
            $table->integer('menu_id');
            $table->integer('category_id');
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
        Schema::dropIfExists('news');
    }
};
