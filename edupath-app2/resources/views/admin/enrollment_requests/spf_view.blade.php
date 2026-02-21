<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPF - {{ $enrollmentRequest->full_name }}</title>
<style>
    @page {
        size: A4;
        margin: 0.5in;
    }
    
    @media print {
        .no-print {
            display: none !important;
        }
        .spf-form {
            padding: 0;
            margin: 0;
            max-width: 100%;
            width: 100%;
            box-shadow: none;
        }
        body {
            background: white;
            margin: 0;
            padding: 0;
        }
        .submit-buttons {
            display: none;
        }
        .page-break {
            page-break-before: always;
        }
    }
    
    .header-top-line {
        height: 6px;
        background: #0b3b75;
        width: 100%;
        margin-bottom: 15px;
    }

    .spf-form {
        font-family: Arial, Helvetica, sans-serif;
        max-width: 8.27in;
        width: 8.27in;
        min-height: 11.69in;
        margin: 0 auto;
        padding: 0.5in;
        background: white;
        color: #000;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        position: relative;
        padding: 15px 20px;
        background: white;
        width: 100%;
    }
    .header-left {
        flex: 1;
        max-width: 45%;
        padding-right: 20px;
        text-align: left;
    }
    .blue-line-top,
    .blue-line-bottom {
        height: 4px;
        background: #1e40af;
        width: 100%;
        margin: 8px 0;
        display: block;
    }
    .university-name-line1 {
        font-size: 20px;
        font-weight: bold;
        color: #1e40af;
        letter-spacing: 0.5px;
        line-height: 1.3;
        margin: 0;
        margin-bottom: 2px;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif;
        text-transform: none;
    }
    .university-name-line2 {
        font-size: 18px;
        font-weight: bold;
        color: #1e40af;
        letter-spacing: 0.5px;
        line-height: 1.3;
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif;
        text-transform: none;
    }
    .university-tagline {
        font-size: 10px;
        font-style: italic;
        color: black;
        margin: 8px 0 0 0;
        padding: 0;
        line-height: 1.3;
        font-family: Arial, Helvetica, sans-serif;
    }
    .logo-container {
        width: 90px;
        height: 90px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        flex-shrink: 0;
        margin: 0 25px;
        padding: 0;
        position: relative;
    }
    .logo-container img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .doc-control {
        border: 1px solid #000;
        width: 205px;
        font-family: Arial, Helvetica, sans-serif;
        background: white;
        flex-shrink: 0;
    }
    .doc-control-header {
        background: #001f3f;
        color: white;
        padding: 3px 0;
        font-size: 10px;
        text-align: center;
        font-weight: bold;
        border-bottom: 1px solid #000;
    }
    .doc-control-code {
        background: white;
        color: #000;
        padding: 4px 0;
        text-align: center;
        font-weight: bold;
        font-size: 12px;
        border-bottom: 1px solid #000;
    }
    .doc-control-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 8px;
    }
    .doc-control-table td {
        border: 1px solid #000;
        padding: 3px 4px;
        text-align: center;
    }
    .doc-control-header-row td {
        background: #001f3f;
        color: white;
        font-weight: bold;
        font-size: 8px;
    }
    .doc-control-value-row td {
        background: white;
        color: #000;
        font-size: 8px;
    }
    .form-title {
        text-align: left;
        font-size: 20px;
        font-weight: 700;
        margin: 20px 0 18px 0;
        padding-left: 20px;
        color: #000;
        letter-spacing: 0.4px;
    }
    .instructions {
        font-size: 11px;
        margin-bottom: 15px;
        clear: both;
        line-height: 1.6;
    }
    .instructions strong {
        font-weight: bold;
        color: #000;
        font-size: 11px;
    }
    .photo-box {
        width: 120px;
        height: 150px;
        border: 1px solid #000;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-size: 9px;
        text-align: center;
        position: relative;
        background: white;
        cursor: pointer;
        line-height: 1.4;
    }
    .photo-box:hover {
        border-color: #003366;
    }
    .photo-box input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    .photo-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
    }
    .photo-upload-text {
        padding: 5px;
        color: #000;
    }
    .photo-upload-text strong {
        font-size: 10px;
        font-weight: bold;
    }
    .photo-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: none;
    }
    .section {
        margin-bottom: 20px;
        clear: both;
    }
    .section-title {
        font-weight: bold;
        font-size: 12px;
        margin-bottom: 12px;
        margin-top: 15px;
        color: #000;
        letter-spacing: 0.2px;
    }
    .form-field {
        margin-bottom: 10px;
        font-size: 11px;
        line-height: 1.5;
    }
    .form-field label {
        display: inline-block;
        min-width: 120px;
        font-weight: normal;
    }
    .form-field input[type="text"],
    .form-field input[type="email"],
    .form-field input[type="date"],
    .form-field input[type="number"],
    .form-field select,
    .form-field textarea {
        border: none;
        border-bottom: 1px solid #000;
        padding: 2px 5px;
        font-size: 11px;
        font-family: Arial, sans-serif;
        background: transparent;
        min-width: 200px;
    }
    .form-field textarea {
        width: 100%;
        min-height: 40px;
        resize: vertical;
    }
    .inline-fields {
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }
    .checkbox-group {
        display: inline-flex;
        gap: 15px;
        align-items: center;
        margin-left: 10px;
    }
    .checkbox-group input[type="checkbox"],
    .checkbox-group input[type="radio"] {
        width: 12px;
        height: 12px;
        border: 1px solid #000;
    }
    .checkbox-group label {
        min-width: auto;
        margin-left: 3px;
    }
    .two-column {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }
    .underline-input {
        border: none;
        border-bottom: 1px solid #000;
        padding: 2px 5px;
        min-width: 150px;
        background: transparent;
    }
    .field-note {
        font-size: 9px;
        font-style: italic;
        margin-top: 2px;
    }
    .pledge-section {
        margin: 30px 0;
        font-size: 11px;
        line-height: 1.6;
        text-align: justify;
    }
    .signature-section {
        margin-top: 40px;
        display: flex;
        justify-content: space-between;
    }
    .signature-box {
        width: 45%;
    }
    .signature-line {
        border-bottom: 1px solid #000;
        margin-top: 40px;
        padding-bottom: 3px;
    }
    .footer-note {
        text-align: center;
        font-style: italic;
        font-weight: bold;
        margin-top: 20px;
        font-size: 11px;
    }
    .submit-buttons {
        text-align: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #ccc;
    }
    .submit-buttons button,
    .submit-buttons .btn {
        padding: 12px 30px;
        font-size: 14px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        margin: 0 8px;
        border-radius: 4px;
        transition: all 0.3s;
    }
    .submit-buttons button[type="submit"] {
        background: #003366;
        color: white;
    }
    .submit-buttons button[type="submit"]:hover {
        background: #004488;
    }
    .submit-buttons .btn-print {
        background: #28a745;
        color: white;
    }
    .submit-buttons .btn-print:hover {
        background: #218838;
    }
    .submit-buttons a {
        padding: 12px 30px;
        font-size: 14px;
        background: #666;
        color: white;
        text-decoration: none;
        display: inline-block;
        border-radius: 4px;
        transition: all 0.3s;
    }
    .submit-buttons a:hover {
        background: #555;
    }
</style>

<div class="spf-form">
    <!-- Header -->
    @include('admin.enrollment_requests._spf_header', ['enrollmentRequest' => $enrollmentRequest ?? null, 'pageNo' => '1 of 2'])

    <!-- Form Title -->
    <div class="form-title">Student's Profile Form</div>

    <!-- Instructions and Photo Box Container -->
    <div style="position: relative; margin-bottom: 15px; min-height: 150px;">
        <!-- Instructions -->
        <div class="instructions" style="width: calc(100% - 160px); float: left;">
            <strong>INSTRUCTIONS:</strong><br>
            a) Fill out this form completely and correctly.<br>
            b) Write legibly. Mark all appropriate boxes/spaces with a check mark (/).
        </div>

        <!-- Photo Box -->
        <div class="photo-box" id="photoBox" style="float: right; margin: 0; position: relative;">
            @if(!empty($enrollmentRequest->student_photo))
                <img src="{{ asset('storage/' . $enrollmentRequest->student_photo) }}" 
                     alt="Student Photo" 
                     style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;" 
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" />
                <div class="photo-upload-text" style="color: #000; display: none;">
                    Photo not found
                </div>
            @else
                <div class="photo-upload-text" style="color: #000;">
                    No photo<br>uploaded
                </div>
            @endif
        </div>
        <div style="clear: both;"></div>
    </div>

    <div id="spfForm">

        <!-- I. APPLICATION FOR ADMISSION -->
        <div class="section">
            <div class="section-title">I. APPLICATION FOR ADMISSION</div>
            
            <div class="form-field">
                <label>1. DOrSU Student ID Number:</label>
                <input type="text" name="student_id" class="underline-input" />
                <div class="field-note">(To be filled up by the Admissions Office)</div>
            </div>

            <div class="form-field">
                <label>2. Semester:</label>
                <input type="text" name="semester" class="underline-input" style="width: 100px;" />
                <label style="margin-left: 20px;">Academic Year:</label>
                <input type="text" name="academic_year" class="underline-input" style="width: 150px;" />
            </div>

            <div class="form-field">
                <label>3.</label>
                <div class="checkbox-group">
                    <input type="checkbox" name="student_type[]" value="first_year" id="first_year" />
                    <label for="first_year">First Year</label>
                    <input type="checkbox" name="student_type[]" value="transferee" id="transferee" />
                    <label for="transferee">Transferee</label>
                    <input type="checkbox" name="student_type[]" value="returnee" id="returnee" />
                    <label for="returnee">Returnee</label>
                </div>
            </div>

            <div class="form-field">
                <label>4. LRN:</label>
                <input type="text" name="lrn" class="underline-input" />
            </div>

            <div class="form-field">
                <label>5. Campus:</label>
                <input type="text" name="campus" class="underline-input" />
            </div>

            <div class="form-field">
                <label>6. Preferred Courses:</label><br>
                <div style="margin-left: 20px; margin-top: 5px;">
                    <div style="margin-bottom: 5px;">
                        1. <input type="text" name="preferred_course_1" class="underline-input" style="width: 300px;" />
                    </div>
                    <div style="margin-bottom: 5px;">
                        2. <input type="text" name="preferred_course_2" class="underline-input" style="width: 300px;" />
                    </div>
                    <div>
                        3. <input type="text" name="preferred_course_3" class="underline-input" style="width: 300px;" />
                    </div>
                </div>
            </div>
        </div>

        <!-- II. PERSONAL INFORMATION -->
        <div class="section">
            <div class="section-title">II. PERSONAL INFORMATION</div>
            
            <div class="form-field">
                <div class="inline-fields">
                    <div>
                        <label>7. SURNAME:</label>
                        <input type="text" name="surname" class="underline-input" required />
                    </div>
                    <div>
                        <label>FIRST NAME:</label>
                        <input type="text" name="first_name" class="underline-input" required />
                    </div>
                    <div>
                        <label>MIDDLE NAME:</label>
                        <input type="text" name="middle_name" class="underline-input" />
                    </div>
                </div>
            </div>

            <div class="form-field">
                <label>8. Date of Birth (mm/dd/yyyy):</label>
                <input type="date" name="date_of_birth" class="underline-input" required />
            </div>

            <div class="form-field">
                <label>9. Sex:</label>
                <div class="checkbox-group">
                    <input type="radio" name="sex" value="male" id="sex_male" />
                    <label for="sex_male">Male</label>
                    <input type="radio" name="sex" value="female" id="sex_female" />
                    <label for="sex_female">Female</label>
                </div>
            </div>

            <div class="form-field">
                <label>10. Place of Birth:</label>
                <input type="text" name="place_of_birth" class="underline-input" />
                <div style="margin-top: 5px;">
                    <div class="inline-fields">
                        <div>
                            <label>(Municipality/City):</label>
                            <input type="text" name="birth_municipality" class="underline-input" />
                        </div>
		<div>
                            <label>(Province):</label>
                            <input type="text" name="birth_province" class="underline-input" />
		</div>
		<div>
                            <label>(Country):</label>
                            <input type="text" name="birth_country" class="underline-input" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-field">
                <label>11. Civil Status:</label>
                <div class="checkbox-group">
                    <input type="radio" name="civil_status" value="single" id="civil_single" />
                    <label for="civil_single">Single</label>
                    <input type="radio" name="civil_status" value="married" id="civil_married" />
                    <label for="civil_married">Married</label>
                    <input type="radio" name="civil_status" value="widowed" id="civil_widowed" />
                    <label for="civil_widowed">Widowed</label>
                    <input type="radio" name="civil_status" value="separated" id="civil_separated" />
                    <label for="civil_separated">Separated/Annulled</label>
                </div>
            </div>

            <div class="form-field">
                <label>12. Citizenship:</label>
                <input type="text" name="citizenship" class="underline-input" />
            </div>

            <div class="form-field">
                <label>13. Height (ft):</label>
                <input type="text" name="height" class="underline-input" style="width: 100px;" />
                <label style="margin-left: 20px;">14. Weight (kg):</label>
                <input type="text" name="weight" class="underline-input" style="width: 100px;" />
            </div>

            <div class="form-field">
                <label>15. Religion:</label>
                <input type="text" name="religion" class="underline-input" />
            </div>

            <div class="form-field">
                <label>16. Tribe/Ethnic Group:</label>
                <input type="text" name="tribe_ethnic" class="underline-input" />
            </div>

            <div class="form-field">
                <label>17. E-mail Address:</label>
                <input type="email" name="email" class="underline-input" required />
            </div>

            <div class="form-field">
                <label>18. Contact Number:</label>
                <input type="text" name="contact_number" class="underline-input" />
            </div>

            <div class="form-field">
                <label>19. Permanent Address:</label>
                <input type="text" name="permanent_address" class="underline-input" style="width: 400px;" />
                <label style="margin-left: 20px;">Zip Code:</label>
                <input type="text" name="zip_code" class="underline-input" style="width: 100px;" />
            </div>
        </div>

        <!-- III. FAMILY BACKGROUND -->
        <div class="section">
            <div class="section-title">III. FAMILY BACKGROUND</div>
            
            <div class="form-field">
                <label>20. Name of Spouse (if married):</label>
                <input type="text" name="spouse_name" class="underline-input" />
                <label style="margin-left: 20px;">Occupation:</label>
                <input type="text" name="spouse_occupation" class="underline-input" />
                <label style="margin-left: 20px;">No. of Children:</label>
                <input type="number" name="spouse_children" class="underline-input" style="width: 80px;" />
            </div>

            <div class="form-field">
                <label>21. Father's Name:</label>
                <input type="text" name="father_name" class="underline-input" />
                <label style="margin-left: 20px;">Occupation:</label>
                <input type="text" name="father_occupation" class="underline-input" />
                <label style="margin-left: 20px;">Contact No.:</label>
                <input type="text" name="father_contact" class="underline-input" />
            </div>

            <div class="form-field">
                <label>22. Mother's Name:</label>
                <input type="text" name="mother_name" class="underline-input" />
                <label style="margin-left: 20px;">Occupation:</label>
                <input type="text" name="mother_occupation" class="underline-input" />
                <label style="margin-left: 20px;">Contact No.:</label>
                <input type="text" name="mother_contact" class="underline-input" />
            </div>

            <div class="form-field">
                <label>23. Parents are:</label>
                <div class="two-column" style="margin-left: 20px; margin-top: 5px;">
                    <div class="checkbox-group">
                        <input type="radio" name="parents_status" value="living_together" id="parents_living" />
                        <label for="parents_living">Living Together</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="radio" name="parents_status" value="temp_separated" id="parents_temp" />
                        <label for="parents_temp">Temporarily Separated</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="radio" name="parents_status" value="perm_separated" id="parents_perm" />
                        <label for="parents_perm">Permanently Separated</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="radio" name="parents_status" value="father_partner" id="parents_father" />
                        <label for="parents_father">Father w/another partner</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="radio" name="parents_status" value="annulled" id="parents_annulled" />
                        <label for="parents_annulled">Marriage Annulled/Legally Separated</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="radio" name="parents_status" value="mother_partner" id="parents_mother" />
                        <label for="parents_mother">Mother w/another partner</label>
                    </div>
                </div>
            </div>

            <div class="form-field">
                <label>24. Monthly Family Income (estimated):</label>
                <input type="text" name="family_income" class="underline-input" />
            </div>

            <div class="form-field">
                <label>25. Person to Contact in Case of Emergency:</label>
                <input type="text" name="emergency_contact_name" class="underline-input" />
                <label style="margin-left: 20px;">Contact Number:</label>
                <input type="text" name="emergency_contact_number" class="underline-input" />
                <div style="margin-top: 5px;">
                    <label>Address:</label>
                    <input type="text" name="emergency_contact_address" class="underline-input" style="width: 500px;" />
                </div>
            </div>
        </div>

        <!-- IV. SCAST Result -->
        <div class="section">
            <div class="section-title">IV. SCAST Result (Please indicate the INDEX)</div>
            <div class="two-column">
                <div class="form-field">
                    <label>General Ability:</label>
                    <input type="text" name="scast_general" class="underline-input" />
                </div>
                <div class="form-field">
                    <label>Spatial Aptitude:</label>
                    <input type="text" name="scast_spatial" class="underline-input" />
                </div>
                <div class="form-field">
                    <label>Verbal Aptitude:</label>
                    <input type="text" name="scast_verbal" class="underline-input" />
                </div>
                <div class="form-field">
                    <label>Perceptual Aptitude:</label>
                    <input type="text" name="scast_perceptual" class="underline-input" />
                </div>
                <div class="form-field">
                    <label>Numerical Aptitude:</label>
                    <input type="text" name="scast_numerical" class="underline-input" />
                </div>
                <div class="form-field">
                    <label>Manual Dexterity:</label>
                    <input type="text" name="scast_manual" class="underline-input" />
                </div>
            </div>
        </div>

        <!-- V. UNIQUE FEATURES -->
        <div class="section">
            <div class="section-title">V. UNIQUE FEATURES</div>
            <div class="two-column">
                <div class="form-field">
                    <label>Hobbies/Recreational Activities:</label>
                    <textarea name="hobbies" class="underline-input"></textarea>
                </div>
                <div class="form-field">
                    <label>Motto:</label>
                    <textarea name="motto" class="underline-input"></textarea>
                </div>
                <div class="form-field">
                    <label>Special Skills/Talents:</label>
                    <textarea name="special_skills" class="underline-input"></textarea>
                </div>
                <div class="form-field">
                    <label>Special Interests:</label>
                    <textarea name="special_interests" class="underline-input"></textarea>
                </div>
            </div>
        </div>

        <!-- VI. EDUCATIONAL BACKGROUND -->
        <div class="section">
            <div class="section-title">VI. EDUCATIONAL BACKGROUND</div>
            
            <div class="form-field">
                <label>26. Elementary:</label>
                <input type="text" name="elementary_school" class="underline-input" />
                <label style="margin-left: 20px;">Year Graduated:</label>
                <input type="text" name="elementary_year" class="underline-input" style="width: 100px;" />
            </div>

            <div class="form-field">
                <label>27. Senior High School:</label>
                <input type="text" name="shs_school" class="underline-input" />
                <label style="margin-left: 20px;">Strand:</label>
                <input type="text" name="shs_strand" class="underline-input" />
                <label style="margin-left: 20px;">Year Graduated:</label>
                <input type="text" name="shs_year" class="underline-input" style="width: 100px;" />
            </div>

            <div class="form-field">
                <label>28. Vocational:</label>
                <input type="text" name="vocational_school" class="underline-input" />
                <label style="margin-left: 20px;">Course:</label>
                <input type="text" name="vocational_course" class="underline-input" />
                <label style="margin-left: 20px;">Year Graduated:</label>
                <input type="text" name="vocational_year" class="underline-input" style="width: 100px;" />
            </div>

            <div class="form-field">
                <label>29. College:</label>
                <input type="text" name="college_school" class="underline-input" />
                <label style="margin-left: 20px;">Degree:</label>
                <input type="text" name="college_degree" class="underline-input" />
                <label style="margin-left: 20px;">Year graduated:</label>
                <input type="text" name="college_year" class="underline-input" style="width: 100px;" />
            </div>
        </div>

        <div class="footer-note">Please continue at the back...</div>

        <!-- Page 2 Content (For Transferee Section) -->
        <div class="section page-break" style="margin-top: 40px;">
            <!-- Header for Page 2 -->
            <div style="margin-bottom: 20px;">
                @include('admin.enrollment_requests._spf_header', ['enrollmentRequest' => $enrollmentRequest ?? null, 'pageNo' => '2 of 2'])
            </div>

            <div class="section-title">For Transferee</div>
            
            <div class="form-field">
                <label>30. Last School Attended:</label>
                <input type="text" name="last_school_attended" class="underline-input" />
                <label style="margin-left: 20px;">Course:</label>
                <input type="text" name="last_school_course" class="underline-input" />
                <label style="margin-left: 20px;">Last School Year Attended:</label>
                <input type="text" name="last_school_year" class="underline-input" />
            </div>

            <div class="form-field">
                <label>31. Are you enrolling as a scholar?</label>
                <div class="checkbox-group">
                    <input type="radio" name="is_scholar" value="yes" id="scholar_yes" />
                    <label for="scholar_yes">YES</label>
                    <input type="radio" name="is_scholar" value="no" id="scholar_no" />
                    <label for="scholar_no">NO</label>
                </div>
                <label style="margin-left: 20px;">If Yes, what Scholarship Grant?</label>
                <input type="text" name="scholarship_grant" class="underline-input" />
            </div>

            <div class="form-field">
                <label>32. Why did you decide to take the course you are enrolling?</label>
                <textarea name="course_decision_reason" class="underline-input" style="width: 100%; min-height: 50px;"></textarea>
            </div>

            <div class="form-field">
                <label>33. Is it your own choice to enroll in DOSCST?</label>
                <div class="checkbox-group">
                    <input type="radio" name="own_choice" value="yes" id="choice_yes" />
                    <label for="choice_yes">YES</label>
                    <input type="radio" name="own_choice" value="no" id="choice_no" />
                    <label for="choice_no">NO</label>
                </div>
                <label style="margin-left: 20px;">If NO, who influenced you?</label>
                <input type="text" name="influencer" class="underline-input" />
            </div>

            <div class="form-field">
                <label>34. Why did you decide to enroll in DOSCST?</label>
                <textarea name="enroll_reason" class="underline-input" style="width: 100%; min-height: 50px;"></textarea>
            </div>

            <div class="form-field">
                <label>35. What is your plan or ambition in life?</label>
                <textarea name="life_plan" class="underline-input" style="width: 100%; min-height: 50px;"></textarea>
            </div>

            <div class="form-field">
                <label>36. What are your Expectations on?</label>
                <div style="margin-left: 20px; margin-top: 5px;">
                    <div style="margin-bottom: 5px;">
                        <label>School:</label>
                        <textarea name="expectation_school" class="underline-input" style="width: 400px; min-height: 30px;"></textarea>
                    </div>
                    <div style="margin-bottom: 5px;">
                        <label>Course:</label>
                        <textarea name="expectation_course" class="underline-input" style="width: 400px; min-height: 30px;"></textarea>
                    </div>
                    <div style="margin-bottom: 5px;">
                        <label>Instructors:</label>
                        <textarea name="expectation_instructors" class="underline-input" style="width: 400px; min-height: 30px;"></textarea>
                    </div>
                    <div style="margin-bottom: 5px;">
                        <label>Students:</label>
                        <textarea name="expectation_students" class="underline-input" style="width: 400px; min-height: 30px;"></textarea>
                    </div>
                    <div style="margin-bottom: 5px;">
                        <label>Subject you like least:</label>
                        <textarea name="subject_least" class="underline-input" style="width: 400px; min-height: 30px;"></textarea>
		</div>
		<div>
                        <label>Subject you like most:</label>
                        <textarea name="subject_most" class="underline-input" style="width: 400px; min-height: 30px;"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- VII. SELF ASSESSMENT -->
        <div class="section">
            <div class="section-title">VII. SELF ASSESSMENT</div>
            
            <div class="form-field">
                <label>37. What traits/characteristics do you think you possess? (You may check as many)</label>
                <div class="two-column" style="margin-left: 20px; margin-top: 5px;">
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="tense_jittery" id="trait1" />
                        <label for="trait1">tense/jittery</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="confident" id="trait2" />
                        <label for="trait2">confident</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="submissive" id="trait3" />
                        <label for="trait3">submissive</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="independent" id="trait4" />
                        <label for="trait4">independent</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="sensitive" id="trait5" />
                        <label for="trait5">sensitive</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="trusting" id="trait6" />
                        <label for="trait6">trusting</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="easily_troubled" id="trait7" />
                        <label for="trait7">easily troubled</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="responsible" id="trait8" />
                        <label for="trait8">responsible</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="relaxed_calm" id="trait9" />
                        <label for="trait9">relaxed/calm</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="dependent" id="trait10" />
                        <label for="trait10">dependent</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="perceptive" id="trait11" />
                        <label for="trait11">perceptive</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="insecure" id="trait12" />
                        <label for="trait12">insecure</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="happy_go_lucky" id="trait13" />
                        <label for="trait13">happy-go-lucky</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="loner" id="trait14" />
                        <label for="trait14">loner</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="suspicious" id="trait15" />
                        <label for="trait15">suspicious</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="stubborn" id="trait16" />
                        <label for="trait16">stubborn</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="idealistic" id="trait17" />
                        <label for="trait17">idealistic</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="worrier" id="trait18" />
                        <label for="trait18">worrier</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="friendly" id="trait19" />
                        <label for="trait19">friendly</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="imaginative" id="trait20" />
                        <label for="trait20">imaginative</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="dominant" id="trait21" />
                        <label for="trait21">dominant</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="sentimental" id="trait22" />
                        <label for="trait22">sentimental</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="traits[]" value="practical" id="trait23" />
                        <label for="trait23">practical</label>
                    </div>
                    <div class="checkbox-group">
                        <label>Others:</label>
                        <input type="text" name="traits_other" class="underline-input" />
                    </div>
                </div>
            </div>

            <div class="form-field">
                <label>38. What bothers you most at the moment?</label>
                <div class="two-column" style="margin-left: 20px; margin-top: 5px;">
                    <div class="checkbox-group">
                        <input type="radio" name="bothers_most" value="financial" id="bother1" />
                        <label for="bother1">Financial difficulty</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="radio" name="bothers_most" value="adjusting" id="bother2" />
                        <label for="bother2">Difficulties in adjusting a new school</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="radio" name="bothers_most" value="study_habits" id="bother3" />
                        <label for="bother3">Study habits</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="radio" name="bothers_most" value="confidence" id="bother4" />
                        <label for="bother4">Developing self-confidence</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="radio" name="bothers_most" value="health" id="bother5" />
                        <label for="bother5">Health problems</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="radio" name="bothers_most" value="interpersonal" id="bother6" />
                        <label for="bother6">Interpersonal relationship (parents; friends; siblings)</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="radio" name="bothers_most" value="student_instructor" id="bother7" />
                        <label for="bother7">Student-Instructor relationship</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="radio" name="bothers_most" value="others" id="bother8" />
                        <label for="bother8">Others</label>
                    </div>
                </div>
                <div style="margin-top: 5px; margin-left: 20px;">
                    <label>Please specify:</label>
                    <input type="text" name="bothers_specify" class="underline-input" style="width: 300px;" />
                </div>
            </div>

            <div class="form-field">
                <label>39. What was your most embarrassing experience in life?</label>
                <textarea name="embarrassing_experience" class="underline-input" style="width: 100%; min-height: 50px;"></textarea>
            </div>

            <div class="form-field">
                <label>40. Things you would like to talk and discuss with:</label>
                <div class="two-column" style="margin-left: 20px; margin-top: 5px;">
                    <div>
                        <label>Friends:</label>
                        <textarea name="discuss_friends" class="underline-input" style="width: 100%; min-height: 40px;"></textarea>
		</div>
		<div>
                        <label>Parents:</label>
                        <textarea name="discuss_parents" class="underline-input" style="width: 100%; min-height: 40px;"></textarea>
		</div>
		<div>
                        <label>Teachers:</label>
                        <textarea name="discuss_teachers" class="underline-input" style="width: 100%; min-height: 40px;"></textarea>
		</div>
		<div>
                        <label>Counselor:</label>
                        <textarea name="discuss_counselor" class="underline-input" style="width: 100%; min-height: 40px;"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- VIII. OTHER INFORMATION -->
        <div class="section">
            <div class="section-title">VIII. OTHER INFORMATION</div>
            
            <div class="form-field">
                <label>41. Are you a person with disability (PWD)?</label>
                <div class="checkbox-group">
                    <input type="radio" name="is_pwd" value="yes" id="pwd_yes" />
                    <label for="pwd_yes">Yes</label>
                    <input type="radio" name="is_pwd" value="no" id="pwd_no" />
                    <label for="pwd_no">No</label>
                </div>
                <label style="margin-left: 20px;">If yes, give details (type of disability):</label>
                <input type="text" name="pwd_details" class="underline-input" />
            </div>

            <div class="form-field">
                <label>42. Are you a single parent?</label>
                <div class="checkbox-group">
                    <input type="radio" name="is_single_parent" value="yes" id="sp_yes" />
                    <label for="sp_yes">Yes</label>
                    <input type="radio" name="is_single_parent" value="no" id="sp_no" />
                    <label for="sp_no">No</label>
                </div>
                <label style="margin-left: 20px;">If yes, give details (number of children):</label>
                <input type="text" name="single_parent_details" class="underline-input" />
            </div>

            <div class="form-field">
                <label>43. Are you a working-student?</label>
                <div class="checkbox-group">
                    <input type="radio" name="is_working_student" value="yes" id="ws_yes" />
                    <label for="ws_yes">Yes</label>
                    <input type="radio" name="is_working_student" value="no" id="ws_no" />
                    <label for="ws_no">No</label>
                </div>
                <label style="margin-left: 20px;">If yes, give details (employer):</label>
                <input type="text" name="working_student_details" class="underline-input" />
            </div>
        </div>

        <!-- PLEDGE -->
        <div class="pledge-section">
            <div class="section-title">PLEDGE</div>
            <p>
                I hereby certify that the information given in this form is true and correct to the best of my knowledge. 
                I understand that any false information may render me ineligible for admission to Davao Oriental State University. 
                I also agree to abide by all the rules and regulations of the University.
            </p>
        </div>

        <!-- STUDENT'S DATA PRIVACY CONSENT -->
        <div class="pledge-section">
            <div class="section-title">STUDENT'S DATA PRIVACY CONSENT</div>
            <p>
                I hereby give my consent to Davao Oriental State University to collect, store, access, and process my personal data 
                in accordance with the Data Privacy Act of 2012 (Republic Act No. 10173) and its implementing rules and regulations. 
                I understand that my personal information will be used for academic, administrative, and research purposes. 
                This consent is valid from AY <input type="text" name="privacy_ay_start" class="underline-input" style="width: 80px;" /> 
                until the Academic Year of my graduation or withdrawal/transfer.
            </p>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <div>Student's Signature over Printed Name</div>
                <div class="signature-line"></div>
            </div>
            <div class="signature-box" style="text-align: right;">
                <div>Date Signed</div>
                <div class="signature-line"></div>
            </div>
        </div>

        <div class="signature-section" style="margin-top: 30px;">
            <div class="signature-box">
                <div>Admitted by:</div>
                <div class="signature-line"></div>
            </div>
            <div class="signature-box" style="text-align: right;">
                <div>Date:</div>
                <div class="signature-line"></div>
            </div>
		</div>

        <!-- Submit Buttons -->
        <div class="submit-buttons no-print">
            <button type="submit">Submit Enrollment Form</button>
            <button type="button" class="btn btn-print" onclick="window.print()">🖨️ Print SPF</button>
            <a href="{{ route('career.index') }}">Cancel</a>
		</div>
	</form>
</div>

<script>
    // Print functionality
    function printSPF() {
        window.print();
    }
    
    // Populate form with enrollment request data
    const enrollmentData = @json($enrollmentRequest);
    
    // Fill all input fields
    for (const [key, value] of Object.entries(enrollmentData)) {
        const input = document.querySelector(`[name="${key}"]`);
        if (input && value) {
            if (input.type === 'checkbox') {
                if (Array.isArray(value)) {
                    value.forEach(v => {
                        const checkbox = document.querySelector(`[name="${key}[]"][value="${v}"]`);
                        if (checkbox) checkbox.checked = true;
                    });
                } else {
                    input.checked = true;
                }
            } else if (input.type === 'radio') {
                const radio = document.querySelector(`[name="${key}"][value="${value}"]`);
                if (radio) radio.checked = true;
            } else {
                input.value = value;
            }
            input.readOnly = true;
            input.disabled = true;
        }
    }
    
    // All form fields are already populated and made read-only above
</script>

</body>
</html>
