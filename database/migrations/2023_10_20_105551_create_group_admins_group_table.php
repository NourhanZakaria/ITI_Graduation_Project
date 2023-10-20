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
        Schema::create('group_admins_group', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('group_admins_id');
            $table->unsignedBigInteger('group_id');


            $table->foreign('group_admins_id')->references('id')->on('group_admins')->onUpdate("cascade")->onDelete("cascade");
            $table->foreign('group_id')->references('id')->on('groups')->onUpdate("cascade")->onDelete("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_admins_group');
    }
};
