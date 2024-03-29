<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();

            $table->string('provider');

            $table->string('method')
                ->nullable();

            $table->json('payload')
                ->nullable();

            $table->timestamps();
        });
    }
};
