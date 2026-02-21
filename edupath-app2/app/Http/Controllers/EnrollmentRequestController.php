<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\EnrollmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class EnrollmentRequestController extends Controller
{
	public function create(Program $program)
	{
		return view('enrollment.create', compact('program'));
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'program_id' => ['required','exists:programs,id'],
			'email' => ['required','email','max:255'],
			'surname' => ['required','string','max:255'],
			'first_name' => ['required','string','max:255'],
			// Make photo truly optional and accept any uploadable file up to 2MB
			'student_photo' => ['nullable', 'file', 'max:2048'],
			// All other fields are optional
		]);

		$validated['user_id'] = Auth::id();
		
		// Handle photo upload
		if ($request->hasFile('student_photo')) {
			$photo = $request->file('student_photo');
			$photoName = time() . '_' . $photo->getClientOriginalName();
			$photoPath = $photo->storeAs('student_photos', $photoName, 'public');
			$validated['student_photo'] = $photoPath;
			\Log::info('Photo uploaded successfully: ' . $photoPath);
		} else {
			\Log::warning('No photo file in request');
		}
		
		// Build full_name from surname, first_name, middle_name
		$fullName = trim($request->surname . ', ' . $request->first_name);
		if ($request->middle_name) {
			$fullName .= ' ' . $request->middle_name;
		}
		$validated['full_name'] = $fullName;

		// Ensure a default status so the request is clearly visible to admins
		if (!isset($validated['status']) || empty($validated['status'])) {
			$validated['status'] = 'pending';
		}

		// Map permanent_address to address for backward compatibility
		if ($request->has('permanent_address') && $request->permanent_address) {
			$validated['address'] = $request->permanent_address;
		} else {
			$validated['address'] = 'N/A'; // Provide default value
		}

		// Map contact_number if not provided
		if (!$request->has('contact_number') || !$request->contact_number) {
			$validated['contact_number'] = 'N/A';
		}

		// Provide default for last_school_attended (map from shs_school or elementary_school)
		if (!$request->has('last_school_attended') || !$request->last_school_attended) {
			$validated['last_school_attended'] = $request->shs_school ?? $request->elementary_school ?? 'N/A';
		}

		// Provide default for school_year
		if (!$request->has('school_year') || !$request->school_year) {
			$validated['school_year'] = $request->academic_year ?? date('Y');
		}

		// Handle array fields
		if ($request->has('student_type')) {
			$validated['student_type'] = $request->student_type;
		}
		if ($request->has('traits')) {
			$validated['traits'] = $request->traits;
		}

		// Get all other fields from request, but only include those that exist in fillable
		$allFields = [
			'student_id', 'semester', 'academic_year', 'lrn', 'campus',
			'preferred_course_1', 'preferred_course_2', 'preferred_course_3',
			'middle_name', 'date_of_birth', 'sex',
			'place_of_birth', 'birth_municipality', 'birth_province', 'birth_country',
			'civil_status', 'citizenship', 'height', 'weight', 'religion', 'tribe_ethnic',
			'permanent_address', 'zip_code', 'contact_number', 'student_photo',
			'spouse_name', 'spouse_occupation', 'spouse_children',
			'father_name', 'father_occupation', 'father_contact',
			'mother_name', 'mother_occupation', 'mother_contact', 'parents_status',
			'family_income', 'emergency_contact_name', 'emergency_contact_number', 'emergency_contact_address',
			'scast_general', 'scast_spatial', 'scast_verbal', 'scast_perceptual', 'scast_numerical', 'scast_manual',
			'hobbies', 'motto', 'special_skills', 'special_interests',
			'elementary_school', 'elementary_year', 'shs_school', 'shs_strand', 'shs_year',
			'vocational_school', 'vocational_course', 'vocational_year',
			'college_school', 'college_degree', 'college_year',
			'last_school_attended', 'last_school_course', 'last_school_year', 'is_scholar', 'scholarship_grant',
			'course_decision_reason', 'own_choice', 'influencer', 'enroll_reason', 'life_plan',
			'expectation_school', 'expectation_course', 'expectation_instructors', 'expectation_students',
			'subject_least', 'subject_most',
			'traits_other', 'bothers_most', 'bothers_specify', 'embarrassing_experience',
			'discuss_friends', 'discuss_parents', 'discuss_teachers', 'discuss_counselor',
			'is_pwd', 'pwd_details', 'is_single_parent', 'single_parent_details',
			'is_working_student', 'working_student_details', 'privacy_ay_start',
		];

		// Get fillable fields from model
		$fillableFields = (new EnrollmentRequest())->getFillable();
		
		// Get columns that actually exist in the database
		$existingColumns = Schema::getColumnListing('enrollment_requests');
		
		// Only include fields that are in fillable AND exist in database schema AND are in request
		foreach ($allFields as $field) {
			if (in_array($field, $fillableFields) && 
				in_array($field, $existingColumns) && 
				$request->has($field) && 
				$request->input($field) !== null && 
				$request->input($field) !== '') {
				$validated[$field] = $request->input($field);
			}
		}

		// Filter validated data to only include fields that exist in both fillable and database
		$validated = array_filter($validated, function($key) use ($fillableFields, $existingColumns) {
			return in_array($key, $fillableFields) && in_array($key, $existingColumns);
		}, ARRAY_FILTER_USE_KEY);

		\Log::info('About to save enrollment with data:', ['has_photo' => isset($validated['student_photo']), 'photo_path' => $validated['student_photo'] ?? 'NULL']);
		
		$enrollment = EnrollmentRequest::create($validated);
		
		\Log::info('Enrollment saved with ID: ' . $enrollment->id . ', Photo in DB: ' . ($enrollment->student_photo ?? 'NULL'));

		return redirect()->route('career.index')->with('status', 'Enrollment request submitted.');
	}
}
