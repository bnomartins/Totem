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
        Schema::create('triagems', function (Blueprint $table) {
            $table->id();
            $table->string('classificacao');
            $table->text('observacao');

            $table->timestamp('dthrsenha')->nullable();
            $table->timestamp('dthrinicio')->nullable();
            $table->timestamp('dthrfim')->nullable();

            $table->foreignId('atendimento_id')->constrained('atendimentos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('triagems');
    }
};
