<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gcodes', function (Blueprint $table)
        {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('photo')->default('');
            $table->string('password');
            $table->string('gcode');
            $table->string('permit')->default('0');
            $table->string('settings_value')->default('0');
            $table->string('realTimeInfo')->default('0');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('gcodes');
    }
};
