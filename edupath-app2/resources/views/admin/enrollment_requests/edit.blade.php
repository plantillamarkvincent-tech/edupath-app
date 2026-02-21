@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="mb-6">
        <a href="{{ route('admin.enrollment_requests.show', $enrollmentRequest) }}" class="text-sm text-blue-600 hover:text-blue-800">← Back to View</a>
        <h1 class="text-3xl font-bold mt-2">Edit Enrollment Request</h1>
        <p class="text-gray-600 mt-1">Student: {{ $enrollmentRequest->full_name }}</p>
    </div>

    @if (session('status'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.enrollment_requests.update', $enrollmentRequest) }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        @csrf
        @method('PUT')

        <!-- I. APPLICATION FOR ADMISSION -->
        <div class="mb-8">
            <h2 class="text-xl font-bold mb-4 text-blue-700 border-b-2 border-blue-700 pb-2">I. APPLICATION FOR ADMISSION</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">DOrSU Student ID Number</label>
                    <input type="text" name="student_id" value="{{ old('student_id', $enrollmentRequest->student_id) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">LRN</label>
                    <input type="text" name="lrn" value="{{ old('lrn', $enrollmentRequest->lrn) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Semester</label>
                    <input type="text" name="semester" value="{{ old('semester', $enrollmentRequest->semester) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Academic Year</label>
                    <input type="text" name="academic_year" value="{{ old('academic_year', $enrollmentRequest->academic_year) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Campus</label>
                    <input type="text" name="campus" value="{{ old('campus', $enrollmentRequest->campus) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Student Type</label>
                    <div class="flex gap-4 mt-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="student_type[]" value="first_year" {{ is_array($enrollmentRequest->student_type) && in_array('first_year', $enrollmentRequest->student_type) ? 'checked' : '' }} class="rounded" />
                            <span class="ml-2">First Year</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="student_type[]" value="transferee" {{ is_array($enrollmentRequest->student_type) && in_array('transferee', $enrollmentRequest->student_type) ? 'checked' : '' }} class="rounded" />
                            <span class="ml-2">Transferee</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="student_type[]" value="returnee" {{ is_array($enrollmentRequest->student_type) && in_array('returnee', $enrollmentRequest->student_type) ? 'checked' : '' }} class="rounded" />
                            <span class="ml-2">Returnee</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-semibold mb-2">Preferred Courses</label>
                <div class="space-y-2">
                    <input type="text" name="preferred_course_1" value="{{ old('preferred_course_1', $enrollmentRequest->preferred_course_1) }}" placeholder="1st Choice" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                    <input type="text" name="preferred_course_2" value="{{ old('preferred_course_2', $enrollmentRequest->preferred_course_2) }}" placeholder="2nd Choice" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                    <input type="text" name="preferred_course_3" value="{{ old('preferred_course_3', $enrollmentRequest->preferred_course_3) }}" placeholder="3rd Choice" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>
        </div>

        <!-- II. PERSONAL INFORMATION -->
        <div class="mb-8">
            <h2 class="text-xl font-bold mb-4 text-blue-700 border-b-2 border-blue-700 pb-2">II. PERSONAL INFORMATION</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">Surname <span class="text-red-500">*</span></label>
                    <input type="text" name="surname" value="{{ old('surname', $enrollmentRequest->surname) }}" required class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">First Name <span class="text-red-500">*</span></label>
                    <input type="text" name="first_name" value="{{ old('first_name', $enrollmentRequest->first_name) }}" required class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Middle Name</label>
                    <input type="text" name="middle_name" value="{{ old('middle_name', $enrollmentRequest->middle_name) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $enrollmentRequest->date_of_birth?->format('Y-m-d')) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Sex</label>
                    <select name="sex" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        <option value="">Select</option>
                        <option value="male" {{ $enrollmentRequest->sex === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ $enrollmentRequest->sex === 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Civil Status</label>
                    <select name="civil_status" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        <option value="">Select</option>
                        <option value="single" {{ $enrollmentRequest->civil_status === 'single' ? 'selected' : '' }}>Single</option>
                        <option value="married" {{ $enrollmentRequest->civil_status === 'married' ? 'selected' : '' }}>Married</option>
                        <option value="widowed" {{ $enrollmentRequest->civil_status === 'widowed' ? 'selected' : '' }}>Widowed</option>
                        <option value="separated" {{ $enrollmentRequest->civil_status === 'separated' ? 'selected' : '' }}>Separated/Annulled</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $enrollmentRequest->email) }}" required class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Contact Number</label>
                    <input type="text" name="contact_number" value="{{ old('contact_number', $enrollmentRequest->contact_number) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Citizenship</label>
                    <input type="text" name="citizenship" value="{{ old('citizenship', $enrollmentRequest->citizenship) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Religion</label>
                    <input type="text" name="religion" value="{{ old('religion', $enrollmentRequest->religion) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Height (ft)</label>
                    <input type="text" name="height" value="{{ old('height', $enrollmentRequest->height) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Weight (kg)</label>
                    <input type="text" name="weight" value="{{ old('weight', $enrollmentRequest->weight) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-semibold mb-1">Permanent Address</label>
                <textarea name="permanent_address" rows="2" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">{{ old('permanent_address', $enrollmentRequest->permanent_address) }}</textarea>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-semibold mb-1">Student Photo</label>
                @if($enrollmentRequest->student_photo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $enrollmentRequest->student_photo) }}" alt="Current Photo" class="w-32 h-32 object-cover border rounded" />
                        <p class="text-xs text-gray-500 mt-1">Current photo</p>
                    </div>
                @endif
                <input type="file" name="student_photo" accept="image/*" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                <p class="text-xs text-gray-500 mt-1">Upload new photo to replace current one (optional)</p>
            </div>
        </div>

        <!-- III. FAMILY BACKGROUND -->
        <div class="mb-8">
            <h2 class="text-xl font-bold mb-4 text-blue-700 border-b-2 border-blue-700 pb-2">III. FAMILY BACKGROUND</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">Father's Name</label>
                    <input type="text" name="father_name" value="{{ old('father_name', $enrollmentRequest->father_name) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Father's Occupation</label>
                    <input type="text" name="father_occupation" value="{{ old('father_occupation', $enrollmentRequest->father_occupation) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Mother's Name</label>
                    <input type="text" name="mother_name" value="{{ old('mother_name', $enrollmentRequest->mother_name) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Mother's Occupation</label>
                    <input type="text" name="mother_occupation" value="{{ old('mother_occupation', $enrollmentRequest->mother_occupation) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Emergency Contact Name</label>
                    <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $enrollmentRequest->emergency_contact_name) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Emergency Contact Number</label>
                    <input type="text" name="emergency_contact_number" value="{{ old('emergency_contact_number', $enrollmentRequest->emergency_contact_number) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>
        </div>

        <!-- IV. EDUCATIONAL BACKGROUND -->
        <div class="mb-8">
            <h2 class="text-xl font-bold mb-4 text-blue-700 border-b-2 border-blue-700 pb-2">IV. EDUCATIONAL BACKGROUND</h2>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Elementary School</label>
                        <input type="text" name="elementary_school" value="{{ old('elementary_school', $enrollmentRequest->elementary_school) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Year Graduated</label>
                        <input type="text" name="elementary_year" value="{{ old('elementary_year', $enrollmentRequest->elementary_year) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Senior High School</label>
                        <input type="text" name="shs_school" value="{{ old('shs_school', $enrollmentRequest->shs_school) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Strand</label>
                        <input type="text" name="shs_strand" value="{{ old('shs_strand', $enrollmentRequest->shs_strand) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Year Graduated</label>
                        <input type="text" name="shs_year" value="{{ old('shs_year', $enrollmentRequest->shs_year) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Status and Admin Note -->
        <div class="mb-8">
            <h2 class="text-xl font-bold mb-4 text-blue-700 border-b-2 border-blue-700 pb-2">ADMIN SECTION</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">Status</label>
                    <select name="status" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        <option value="pending" {{ $enrollmentRequest->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="review" {{ $enrollmentRequest->status === 'review' ? 'selected' : '' }}>Under Review</option>
                        <option value="approved" {{ $enrollmentRequest->status === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $enrollmentRequest->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Admin Note</label>
                    <textarea name="admin_note" rows="3" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" placeholder="Internal notes or rejection reason">{{ old('admin_note', $enrollmentRequest->admin_note) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex gap-4 justify-end pt-6 border-t">
            <a href="{{ route('admin.enrollment_requests.show', $enrollmentRequest) }}" class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
