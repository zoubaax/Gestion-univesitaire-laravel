<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('code')->unique()->nullable();
            $table->text('description')->nullable();
            $table->foreignId('filiere_id')->constrained('filieres')->onDelete('cascade');
            $table->timestamps();
        });

        // Link etudiants to users
        Schema::table('etudiants', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('cascade');
        });

        // Update notes table
        Schema::table('notes', function (Blueprint $table) {
            $table->foreignId('module_id')->nullable()->after('etudiant_id')->constrained('modules')->onDelete('cascade');
            $table->decimal('cc1', 4, 2)->nullable()->after('module_id');
            $table->decimal('cc2', 4, 2)->nullable()->after('cc1');
            $table->decimal('examen', 4, 2)->nullable()->after('cc2');
            $table->decimal('note_finale', 4, 2)->nullable()->after('examen');
            $table->dropColumn('note');
            $table->dropColumn('matiere');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropForeign(['module_id']);
            $table->dropColumn(['module_id', 'cc1', 'cc2', 'examen']);
            $table->renameColumn('note_finale', 'note');
        });

        Schema::table('etudiants', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::dropIfExists('modules');
    }
};
