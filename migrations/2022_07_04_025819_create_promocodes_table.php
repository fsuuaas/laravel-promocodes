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
        Schema::create(config('promocodes.table', 'promocodes'), function (Blueprint $table) {
            $table->id();
            $table->string('code', 32)->unique();
            $table->double('reward', 10, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->text('data')->nullable();
            $table->boolean('is_disposable')->default(false);
            $table->timestamp('expires_at')->nullable();
        });
        Schema::create(config('promocodes.relation_table', 'promocode_user'), function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('promocode_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('used_at');
            $table->primary(['user_id', 'promocode_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(config('promocodes.relation_table', 'promocode_user'));
        Schema::drop(config('promocodes.table', 'promocodes'));
    }
};
