<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_manage_group', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('user_id');


            $table->foreign('group_id')->references('id')->on('groups')->onUpdate("cascade")->onDelete("cascade");
            $table->foreign('user_id')->references('id')->on('users')->onUpdate("cascade")->onDelete("cascade");


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_manage_group');
    }
};
