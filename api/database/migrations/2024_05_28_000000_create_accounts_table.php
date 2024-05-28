<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('accounts', function(Blueprint $table) {
            $table->id();
            $table->string('step')->nullable();
            $table->string('phone');

            $table->string('place')->nullable();
            $table->string('operator')->nullable();
            $table->string('subscriber')->nullable();
            $table->string('account')->nullable();
            $table->string('address')->nullable();
            $table->string('profile')->nullable();

            $table->string('code')->nullable();
            $table->string('token')->nullable();
            $table->string('refresh')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
