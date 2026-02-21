<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnrollmentRequest extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'user_id',
		'program_id',
		'full_name',
		'email',
		'contact_number',
		'address',
		'last_school_attended',
		'school_year',
		'status',
		'admin_note',
		// I. APPLICATION FOR ADMISSION
		'student_id', 'semester', 'academic_year', 'student_type', 'lrn', 'campus',
		'preferred_course_1', 'preferred_course_2', 'preferred_course_3',
		// II. PERSONAL INFORMATION
		'surname', 'first_name', 'middle_name', 'date_of_birth', 'sex',
		'place_of_birth', 'birth_municipality', 'birth_province', 'birth_country',
		'civil_status', 'citizenship', 'height', 'weight', 'religion', 'tribe_ethnic',
		'permanent_address', 'zip_code', 'student_photo',
		// III. FAMILY BACKGROUND
		'spouse_name', 'spouse_occupation', 'spouse_children',
		'father_name', 'father_occupation', 'father_contact',
		'mother_name', 'mother_occupation', 'mother_contact', 'parents_status',
		'family_income', 'emergency_contact_name', 'emergency_contact_number', 'emergency_contact_address',
		// IV. SCAST Result
		'scast_general', 'scast_spatial', 'scast_verbal', 'scast_perceptual', 'scast_numerical', 'scast_manual',
		// V. UNIQUE FEATURES
		'hobbies', 'motto', 'special_skills', 'special_interests',
		// VI. EDUCATIONAL BACKGROUND
		'elementary_school', 'elementary_year', 'shs_school', 'shs_strand', 'shs_year',
		'vocational_school', 'vocational_course', 'vocational_year',
		'college_school', 'college_degree', 'college_year',
		// For Transferee
		'last_school_course', 'last_school_year', 'is_scholar', 'scholarship_grant',
		'course_decision_reason', 'own_choice', 'influencer', 'enroll_reason', 'life_plan',
		'expectation_school', 'expectation_course', 'expectation_instructors', 'expectation_students',
		'subject_least', 'subject_most',
		// VII. SELF ASSESSMENT
		'traits', 'traits_other', 'bothers_most', 'bothers_specify', 'embarrassing_experience',
		'discuss_friends', 'discuss_parents', 'discuss_teachers', 'discuss_counselor',
		// VIII. OTHER INFORMATION
		'is_pwd', 'pwd_details', 'is_single_parent', 'single_parent_details',
		'is_working_student', 'working_student_details', 'privacy_ay_start',
	];

	protected $casts = [
		'student_type' => 'array',
		'traits' => 'array',
		'date_of_birth' => 'date',
	];

	public function program()
	{
		return $this->belongsTo(Program::class);
	}
}
