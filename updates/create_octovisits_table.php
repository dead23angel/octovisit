<?php

namespace CWTeam\OctoVisit\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cwteam_octovisit_visits', static function (Blueprint $table) {
            $table->id();
            $table->morphs('visitable');
            $table->json('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cwteam_octovisit_visits');
    }
};
