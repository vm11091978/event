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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->datetime('date');
            $table->string('description', 1000)->nullable();
            $table->boolean('active')->nullable();
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('active')->nullable();
            $table->timestamps();
        });

        Schema::create('category_event', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('event_id');
            $table->index(['category_id', 'event_id']);
         // $table->unique(['category_id', 'event_id'], 'UniqueKey');

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('event_id')->references('id')->on('events');
        });

        Schema::create('event_user', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('user_id');
            $table->index(['event_id', 'user_id']);
            $table->unique(['event_id', 'user_id'], 'UniqueKey');

            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('category_event');
        Schema::dropIfExists('user_event');
    }
};
