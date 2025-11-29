<?php
// database/migrations/2024_01_01_000002_create_scholarship_applications_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('scholarship_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('program_id')->constrained('scholarship_programs')->onDelete('cascade');
            $table->json('application_data'); // Contains academic_records, financial_info, essay, etc.
            $table->string('cor_file_path')->nullable(); // Certificate of Registration file path
            $table->string('gwa_file_path')->nullable(); // GWA proof file path
            $table->string('recommendation_file_path')->nullable(); // Recommendation letter file path
            $table->enum('status', ['draft', 'pending', 'under_review', 'approved', 'rejected'])->default('draft');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->text('admin_notes')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
            
            // Ensure one application per user per program
            $table->unique(['user_id', 'program_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('scholarship_applications');
    }
};