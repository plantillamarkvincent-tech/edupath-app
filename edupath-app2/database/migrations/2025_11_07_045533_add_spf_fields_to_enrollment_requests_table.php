<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('enrollment_requests', function (Blueprint $table) {
            // I. APPLICATION FOR ADMISSION
            if (!Schema::hasColumn('enrollment_requests', 'student_id')) {
                $table->string('student_id')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'semester')) {
                $table->string('semester')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'academic_year')) {
                $table->string('academic_year')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'student_type')) {
                $table->json('student_type')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'lrn')) {
                $table->string('lrn')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'campus')) {
                $table->string('campus')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'preferred_course_1')) {
                $table->string('preferred_course_1')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'preferred_course_2')) {
                $table->string('preferred_course_2')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'preferred_course_3')) {
                $table->string('preferred_course_3')->nullable();
            }

            // II. PERSONAL INFORMATION
            if (!Schema::hasColumn('enrollment_requests', 'surname')) {
                $table->string('surname')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'first_name')) {
                $table->string('first_name')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'middle_name')) {
                $table->string('middle_name')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'sex')) {
                $table->enum('sex', ['male', 'female'])->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'place_of_birth')) {
                $table->string('place_of_birth')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'birth_municipality')) {
                $table->string('birth_municipality')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'birth_province')) {
                $table->string('birth_province')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'birth_country')) {
                $table->string('birth_country')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'civil_status')) {
                $table->enum('civil_status', ['single', 'married', 'widowed', 'separated'])->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'citizenship')) {
                $table->string('citizenship')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'height')) {
                $table->string('height')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'weight')) {
                $table->string('weight')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'religion')) {
                $table->string('religion')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'tribe_ethnic')) {
                $table->string('tribe_ethnic')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'permanent_address')) {
                $table->text('permanent_address')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'zip_code')) {
                $table->string('zip_code')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'student_photo')) {
                $table->text('student_photo')->nullable();
            }

            // III. FAMILY BACKGROUND
            if (!Schema::hasColumn('enrollment_requests', 'spouse_name')) {
                $table->string('spouse_name')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'spouse_occupation')) {
                $table->string('spouse_occupation')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'spouse_children')) {
                $table->integer('spouse_children')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'father_name')) {
                $table->string('father_name')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'father_occupation')) {
                $table->string('father_occupation')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'father_contact')) {
                $table->string('father_contact')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'mother_name')) {
                $table->string('mother_name')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'mother_occupation')) {
                $table->string('mother_occupation')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'mother_contact')) {
                $table->string('mother_contact')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'parents_status')) {
                $table->enum('parents_status', ['living_together', 'temp_separated', 'perm_separated', 'father_partner', 'annulled', 'mother_partner'])->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'family_income')) {
                $table->string('family_income')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'emergency_contact_name')) {
                $table->string('emergency_contact_name')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'emergency_contact_number')) {
                $table->string('emergency_contact_number')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'emergency_contact_address')) {
                $table->text('emergency_contact_address')->nullable();
            }

            // IV. SCAST Result
            if (!Schema::hasColumn('enrollment_requests', 'scast_general')) {
                $table->string('scast_general')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'scast_spatial')) {
                $table->string('scast_spatial')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'scast_verbal')) {
                $table->string('scast_verbal')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'scast_perceptual')) {
                $table->string('scast_perceptual')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'scast_numerical')) {
                $table->string('scast_numerical')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'scast_manual')) {
                $table->string('scast_manual')->nullable();
            }

            // V. UNIQUE FEATURES
            if (!Schema::hasColumn('enrollment_requests', 'hobbies')) {
                $table->text('hobbies')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'motto')) {
                $table->text('motto')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'special_skills')) {
                $table->text('special_skills')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'special_interests')) {
                $table->text('special_interests')->nullable();
            }

            // VI. EDUCATIONAL BACKGROUND
            if (!Schema::hasColumn('enrollment_requests', 'elementary_school')) {
                $table->string('elementary_school')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'elementary_year')) {
                $table->string('elementary_year')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'shs_school')) {
                $table->string('shs_school')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'shs_strand')) {
                $table->string('shs_strand')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'shs_year')) {
                $table->string('shs_year')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'vocational_school')) {
                $table->string('vocational_school')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'vocational_course')) {
                $table->string('vocational_course')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'vocational_year')) {
                $table->string('vocational_year')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'college_school')) {
                $table->string('college_school')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'college_degree')) {
                $table->string('college_degree')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'college_year')) {
                $table->string('college_year')->nullable();
            }

            // For Transferee
            if (!Schema::hasColumn('enrollment_requests', 'last_school_course')) {
                $table->string('last_school_course')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'last_school_year')) {
                $table->string('last_school_year')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'is_scholar')) {
                $table->enum('is_scholar', ['yes', 'no'])->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'scholarship_grant')) {
                $table->string('scholarship_grant')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'course_decision_reason')) {
                $table->text('course_decision_reason')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'own_choice')) {
                $table->enum('own_choice', ['yes', 'no'])->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'influencer')) {
                $table->string('influencer')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'enroll_reason')) {
                $table->text('enroll_reason')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'life_plan')) {
                $table->text('life_plan')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'expectation_school')) {
                $table->text('expectation_school')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'expectation_course')) {
                $table->text('expectation_course')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'expectation_instructors')) {
                $table->text('expectation_instructors')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'expectation_students')) {
                $table->text('expectation_students')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'subject_least')) {
                $table->text('subject_least')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'subject_most')) {
                $table->text('subject_most')->nullable();
            }

            // VII. SELF ASSESSMENT
            if (!Schema::hasColumn('enrollment_requests', 'traits')) {
                $table->json('traits')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'traits_other')) {
                $table->string('traits_other')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'bothers_most')) {
                $table->enum('bothers_most', ['financial', 'adjusting', 'study_habits', 'confidence', 'health', 'interpersonal', 'student_instructor', 'others'])->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'bothers_specify')) {
                $table->string('bothers_specify')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'embarrassing_experience')) {
                $table->text('embarrassing_experience')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'discuss_friends')) {
                $table->text('discuss_friends')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'discuss_parents')) {
                $table->text('discuss_parents')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'discuss_teachers')) {
                $table->text('discuss_teachers')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'discuss_counselor')) {
                $table->text('discuss_counselor')->nullable();
            }

            // VIII. OTHER INFORMATION
            if (!Schema::hasColumn('enrollment_requests', 'is_pwd')) {
                $table->enum('is_pwd', ['yes', 'no'])->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'pwd_details')) {
                $table->text('pwd_details')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'is_single_parent')) {
                $table->enum('is_single_parent', ['yes', 'no'])->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'single_parent_details')) {
                $table->text('single_parent_details')->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'is_working_student')) {
                $table->enum('is_working_student', ['yes', 'no'])->nullable();
            }
            if (!Schema::hasColumn('enrollment_requests', 'working_student_details')) {
                $table->text('working_student_details')->nullable();
            }

            // Privacy
            if (!Schema::hasColumn('enrollment_requests', 'privacy_ay_start')) {
                $table->string('privacy_ay_start')->nullable();
            }

            // Keep old fields for backward compatibility but make them nullable
            if (Schema::hasColumn('enrollment_requests', 'full_name')) {
                try {
                    $table->string('full_name')->nullable()->change();
                } catch (\Exception $e) {
                    // Column might already be nullable
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollment_requests', function (Blueprint $table) {
            $columns = [
                'student_id', 'semester', 'academic_year', 'student_type', 'lrn', 'campus',
                'preferred_course_1', 'preferred_course_2', 'preferred_course_3',
                'surname', 'first_name', 'middle_name', 'date_of_birth', 'sex',
                'place_of_birth', 'birth_municipality', 'birth_province', 'birth_country',
                'civil_status', 'citizenship', 'height', 'weight', 'religion', 'tribe_ethnic',
                'permanent_address', 'zip_code',
                'spouse_name', 'spouse_occupation', 'spouse_children',
                'father_name', 'father_occupation', 'father_contact',
                'mother_name', 'mother_occupation', 'mother_contact', 'parents_status',
                'family_income', 'emergency_contact_name', 'emergency_contact_number', 'emergency_contact_address',
                'scast_general', 'scast_spatial', 'scast_verbal', 'scast_perceptual', 'scast_numerical', 'scast_manual',
                'hobbies', 'motto', 'special_skills', 'special_interests',
                'elementary_school', 'elementary_year', 'shs_school', 'shs_strand', 'shs_year',
                'vocational_school', 'vocational_course', 'vocational_year',
                'college_school', 'college_degree', 'college_year',
                'last_school_course', 'last_school_year', 'is_scholar', 'scholarship_grant',
                'course_decision_reason', 'own_choice', 'influencer', 'enroll_reason', 'life_plan',
                'expectation_school', 'expectation_course', 'expectation_instructors', 'expectation_students',
                'subject_least', 'subject_most',
                'traits', 'traits_other', 'bothers_most', 'bothers_specify', 'embarrassing_experience',
                'discuss_friends', 'discuss_parents', 'discuss_teachers', 'discuss_counselor',
                'is_pwd', 'pwd_details', 'is_single_parent', 'single_parent_details',
                'is_working_student', 'working_student_details', 'privacy_ay_start'
            ];
            
            $existingColumns = array_filter($columns, function($column) {
                return Schema::hasColumn('enrollment_requests', $column);
            });
            
            if (!empty($existingColumns)) {
                $table->dropColumn(array_values($existingColumns));
            }
        });
    }
};
