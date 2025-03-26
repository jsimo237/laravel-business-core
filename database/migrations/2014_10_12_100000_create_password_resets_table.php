<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if(!Schema::hasTable('password_resets')){
            Schema::create('password_resets', function (BluePrint $table) {
                $table->string('email')->index(uniqid("INDX_"));
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
};
