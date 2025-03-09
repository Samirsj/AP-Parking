<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('historique_attributions', function (Blueprint $table) {
            $table->timestamp('expiration_at')->nullable()->after('date_attribution');
        });
    }
    
    public function down()
    {
        Schema::table('historique_attributions', function (Blueprint $table) {
            $table->dropColumn('expiration_at');
        });
    }
    
};
