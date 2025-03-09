<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('grades', function (Blueprint $table) {
            // Change column types to handle both numeric and 'INC' values
            $table->string('midterm_grade', 10)->change();
            $table->string('final_grade', 10)->change();
        });
    }

    public function down()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->decimal('midterm_grade', 3, 2)->change();
            $table->decimal('final_grade', 3, 2)->change();
        });
    }
}; 