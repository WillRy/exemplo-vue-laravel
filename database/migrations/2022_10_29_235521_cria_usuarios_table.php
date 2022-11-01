<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string("nome", 255);
            $table->string("email", 255)->unique();
            $table->string("senha", 255);
            $table->string("hash_rec_senha", 255)->nullable();
            $table->unsignedBigInteger("empresa_id");

            $table->timestamps();

            $table->foreign("empresa_id")
                ->references("id")
                ->on("empresas")
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};
