<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('address',255);
            $table->string('photo',255)->nullable();
            $table->string('slug',255)->unique();
            $table->string('phone_number',30)->nullable();
            $table->text('service')->nullable();
            $table->text('curriculum')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('photo');
            $table->dropColumn('slug');
            $table->dropColumn('phone_number');
            $table->dropColumn('service');
            $table->dropColumn('curriculum');
        });
    }
}
