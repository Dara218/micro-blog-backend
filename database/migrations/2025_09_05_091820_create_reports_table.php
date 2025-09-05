<?php

use App\Enums\ReportStatus;
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
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users');
            $table->bigInteger('reportable_id');
            $table->string('reason', 255);
            $table->text('notes')->nullable();
            $table->enum('status', ReportStatus::list());
            $table->timestamps();
        });
    }

    /**
     * Todo:
     * 1. Run migrations.
     * 2. Create seeders.
     */

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
