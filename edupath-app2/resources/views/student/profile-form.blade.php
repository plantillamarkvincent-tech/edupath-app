<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Davao Oriental State University - Student's Profile Form (SPF)</title>
  <style>
    /* SPF Form Styling */
    :root{--bg:#f6f8fa;--card:#fff;--accent:#1f6feb;--muted:#6b7280}
    *{box-sizing:border-box}
    body{font-family:Inter,ui-sans-serif,system-ui,Segoe UI,Roboto,Arial; background:var(--bg); margin:0;color:#111; border-top: 10px solid red;}
    .container{max-width:1200px;margin:24px auto;padding:20px;background:var(--card);border-radius:10px;box-shadow:0 6px 18px rgba(20,20,40,0.06)}
    
    /* Header Styling - Exact match to screenshot */
    .form-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 20px;
        margin-bottom: 30px;
        background: white;
        position: relative;
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
        margin: 8px 0 0 0;
        color: black;
        padding: 0;
        line-height: 1.3;
        font-family: Arial, Helvetica, sans-serif;
    }
    .logo-container {
        width: 90px;
        height: 90px;
        margin: 0 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        flex-shrink: 0;
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
    
    .subtitle{margin:0;color:var(--muted);text-align:center;font-size:18px;font-weight:bold;margin-bottom:20px;}
    form fieldset{margin:14px 0;padding:14px;border:1px solid #e6eef6;border-radius:8px}
    form legend{font-weight:bold;color:var(--accent)}
    form label{display:block;margin:8px 0;font-size:14px}
    .row{display:flex;gap:12px;flex-wrap:wrap}
    .row label{flex:1}
    input[type="text"], input[type="email"], input[type="date"], input[type="number"], select, textarea{width:100%;padding:8px;border:1px solid #dbe7f6;border-radius:6px}
    textarea{min-height:70px;resize:vertical}
    .preferred input{display:block;margin-top:6px;padding:8px}
    .checkbox-grid{display:flex;flex-wrap:wrap;gap:8px}
    .checkbox-grid label{background:#f3f7fb;padding:6px 8px;border-radius:6px;font-size:12px}
    .form-actions{display:flex;gap:10px;justify-content:flex-end;margin-top:12px}
    button{background:var(--accent);color:#fff;border:none;padding:10px 14px;border-radius:8px;cursor:pointer}
    button.secondary{background:#666}
    footer{margin-top:18px;font-size:12px;color:var(--muted)}
    @media(min-width:900px){ .row label{min-width:220px} }
  </style>
</head>
<body>
  <main class="container">
    <!-- DORSU Header - Exact match to image -->
    <div class="form-header">
      <div class="header-left">
        <div class="blue-line-top"></div>
        <div class="university-name-line1">DAVAO ORIENTAL</div>
        <div class="university-name-line2">STATE UNIVERSITY</div>
        <div class="university-tagline">A University of excellence, innovation, and inclusion</div>
        <div class="blue-line-bottom"></div>
      </div>
      <div class="logo-container">
        @php
            $logoPath = null;
            $candidates = [
                'images/dorsu-logo.png.png',
                'images/dorsu-logo.png', 
                'images/dorsu-logo.PNG', 
                'images/dorsu-logo.webp', 
                'images/dorsu-logo.jpg', 
                'images/dorsu-logo.jpeg',
                'dorsu-logo.png.png',
                'dorsu-logo.png'
            ];
            foreach ($candidates as $c) {
                if (file_exists(public_path($c))) {
                    $logoPath = asset($c);
                    break;
                }
            }
            if (!$logoPath && is_dir(public_path('images'))) {
                $any = glob(public_path('images/*.{png,PNG,webp,jpg,jpeg,JPG,JPEG,gif}'), GLOB_BRACE);
                if (!empty($any)) {
                    $logoPath = asset('images/' . basename($any[0]));
                }
            }
        @endphp
        @if($logoPath)
            <img src="{{ $logoPath }}" alt="DOrSU Logo" style="width: 100%; height: 100%; object-fit: contain;">
        @else
            <div style="font-size: 9px; text-align: center; padding: 5px; color: #003366; font-weight: bold;">DOrSU<br/>LOGO</div>
        @endif
      </div>
      <div class="doc-control">
        <div class="doc-control-header">Document Code No.</div>
        <div class="doc-control-code">FM-DOrSU-ODI-05</div>
        <table class="doc-control-table">
          <tr class="doc-control-header-row">
            <td>Issue Status</td>
            <td>Rev No.</td>
            <td>Effective Date</td>
            <td>Page No.</td>
          </tr>
          <tr class="doc-control-value-row">
            <td>01</td>
            <td>00</td>
            <td>07.22.2022</td>
            <td>1 of 2</td>
          </tr>
        </table>
      </div>
    </div>

    <h1 class="subtitle">Student's Profile Form (SPF)</h1>

    <form id="spfForm" action="{{ route('student.profile-form.submit') }}" method="post" enctype="multipart/form-data" autocomplete="off">
      @csrf

      <fieldset><legend>I. APPLICATION FOR ADMISSION</legend>
        <label>1. DOrSU Student ID Number: <input name="student_id" type="text" /></label>
        <label>2. Semester / Academic Year: <input name="semester" type="text" placeholder="e.g. 1st Sem / 2025-2026" /></label>
        <label>3. Entry Type:
          <select name="entry_type">
            <option value="First Year">First Year</option>
            <option value="Transferee">Transferee</option>
            <option value="Returnee">Returnee</option>
          </select>
        </label>
        <label>4. LRN: <input name="lrn" type="text" /></label>
        <label>5. Campus: <input name="campus" type="text" /></label>
        <div class="preferred">
          <label>6. Preferred Courses:</label>
          <input name="course1" placeholder="1." />
          <input name="course2" placeholder="2." />
          <input name="course3" placeholder="3." />
        </div>
      </fieldset>

      <fieldset><legend>II. PERSONAL INFORMATION</legend>
        <div class="row">
          <label>SURNAME: <input name="surname" required /></label>
          <label>FIRST NAME: <input name="firstname" required /></label>
          <label>MIDDLE NAME: <input name="middlename" /></label>
        </div>

        <div class="row">
          <label>Date of Birth: <input name="dob" type="date" /></label>
          <label>Sex:
            <select name="sex"><option>Male</option><option>Female</option><option>Other</option></select>
          </label>
          <label>Place of Birth: <input name="place_of_birth" /></label>
        </div>

        <div class="row">
          <label>Civil Status:
            <select name="civil_status"><option>Single</option><option>Married</option><option>Widowed</option><option>Separated/Annulled</option></select>
          </label>
          <label>Citizenship: <input name="citizenship" /></label>
          <label>Religion: <input name="religion" /></label>
        </div>

        <div class="row">
          <label>Height (ft): <input name="height" /></label>
          <label>Weight (kg): <input name="weight" /></label>
          <label>Tribe/Ethnic Group: <input name="tribe" /></label>
        </div>

        <label>Email Address: <input name="email" type="email" /></label>
        <label>Contact Number: <input name="contact_number" /></label>
        <label>Permanent Address: <textarea name="permanent_address"></textarea></label>

        <label>Paste your 2x2 photo here: <input type="file" name="photo" accept="image/*" /></label>
      </fieldset>

      <fieldset><legend>III. FAMILY BACKGROUND</legend>
        <label>Father's Name: <input name="father_name" /></label>
        <label>Father's Occupation: <input name="father_occupation" /></label>
        <label>Father's Contact No.: <input name="father_contact" /></label>

        <label>Mother's Name: <input name="mother_name" /></label>
        <label>Mother's Occupation: <input name="mother_occupation" /></label>
        <label>Mother's Contact No.: <input name="mother_contact" /></label>

        <label>Parents are:
          <select name="parents_status">
            <option>Living Together</option>
            <option>Permanently Separated</option>
            <option>Marriage Annulled/Legally Separated</option>
            <option>Temporarily Separated</option>
            <option>Father w/another partner</option>
            <option>Mother w/another partner</option>
          </select>
        </label>

        <label>Monthly Family Income (estimated): <input name="monthly_income" /></label>

        <label>Person to Contact in Case of Emergency: <input name="emergency_contact_name" /></label>
        <label>Emergency Contact Number: <input name="emergency_contact_number" /></label>
        <label>Emergency Contact Address: <textarea name="emergency_contact_address"></textarea></label>
      </fieldset>

      <fieldset><legend>IV. SCAST Result</legend>
        <label>General Ability: <input name="s_cast_general" /></label>
        <label>Spatial Aptitude: <input name="s_cast_spatial" /></label>
        <label>Verbal Aptitude: <input name="s_cast_verbal" /></label>
        <label>Perceptual Aptitude: <input name="s_cast_perceptual" /></label>
        <label>Numerical Aptitude: <input name="s_cast_numerical" /></label>
        <label>Manual Dexterity: <input name="s_cast_manual" /></label>
      </fieldset>

      <fieldset><legend>V. UNIQUE FEATURES</legend>
        <label>Hobbies/Recreational Activities: <textarea name="hobbies"></textarea></label>
        <label>Motto: <input name="motto" /></label>
        <label>Special Skills/Talents: <textarea name="skills"></textarea></label>
        <label>Special Interests: <textarea name="interests"></textarea></label>
      </fieldset>

      <fieldset><legend>VI. EDUCATIONAL BACKGROUND</legend>
        <label>Elementary: <input name="elementary_school" /> Year Graduated: <input name="elementary_year" /></label>
        <label>Senior High School: <input name="senior_high" /> Strand: <input name="senior_high_strand" /> Year Graduated: <input name="senior_high_year" /></label>
        <label>Vocational: <input name="vocational" /> Course: <input name="vocational_course" /> Year Graduated: <input name="vocational_year" /></label>
        <label>College: <input name="college" /> Degree: <input name="college_degree" /> Year Graduated: <input name="college_year" /></label>
        <label>Last School Attended (for transferee): <input name="last_school" /> Course: <input name="last_school_course" /> Last School Year Attended: <input name="last_school_year" /></label>

        <label>Are you enrolling as a scholar?
          <select name="is_scholar"><option value="NO">NO</option><option value="YES">YES</option></select>
          If Yes, Scholarship Grant: <input name="scholar_grant" />
        </label>

        <label>Why did you decide to take the course you are enrolling? <textarea name="why_course"></textarea></label>
        <label>Is it your own choice to enroll in DORSU? <select name="own_choice"><option>YES</option><option>NO</option></select> If NO, who influenced you? <input name="influenced_by" /></label>
        <label>What is your plan or ambition in life? <textarea name="ambition"></textarea></label>
      </fieldset>

      <fieldset><legend>VII. SELF ASSESSMENT</legend>
        <p>37. What traits/characteristics do you think you possess? (Check all that apply)</p>
        <div class="checkbox-grid">
          <label><input type="checkbox" name="trait[]" value="tense"> tense/jittery</label>
          <label><input type="checkbox" name="trait[]" value="easily_troubled"> easily troubled</label>
          <label><input type="checkbox" name="trait[]" value="happy_go_lucky"> happy-go-lucky</label>
          <label><input type="checkbox" name="trait[]" value="friendly"> friendly</label>
          <label><input type="checkbox" name="trait[]" value="confident"> confident</label>
          <label><input type="checkbox" name="trait[]" value="responsible"> responsible</label>
          <label><input type="checkbox" name="trait[]" value="loner"> loner</label>
          <label><input type="checkbox" name="trait[]" value="imaginative"> imaginative</label>
          <label><input type="checkbox" name="trait[]" value="submissive"> submissive</label>
          <label><input type="checkbox" name="trait[]" value="relaxed"> relaxed/calm</label>
          <label>Others: <input name="trait_other" /></label>
        </div>

        <label>38. What bothers you most at the moment?
          <select name="bothers_most">
            <option>Financial difficulty</option>
            <option>Health problems</option>
            <option>Difficulties in adjusting a new school</option>
            <option>Interpersonal relationship</option>
            <option>Study habits</option>
            <option>Student-Instructor relationship</option>
            <option>Developing self-confidence</option>
            <option>Others</option>
          </select>
          If health/others please specify: <input name="bothers_specify" />
        </label>

        <label>39. Most embarrassing experience in life:<textarea name="embarrassing_experience"></textarea></label>
        <label>40. Things you would like to talk and discuss with: Friends <input name="talk_friends" /> Parents <input name="talk_parents" /> Teachers <input name="talk_teachers" /> Counselor <input name="talk_counselor" /></label>
      </fieldset>

      <fieldset><legend>VIII. OTHER INFORMATION</legend>
        <label>41. Are you a person with disability (PWD)? <select name="is_pwd"><option>NO</option><option>YES</option></select> If yes, details: <input name="pwd_details" /></label>
        <label>42. Are you a single parent? <select name="is_single_parent"><option>NO</option><option>YES</option></select> If yes, details: <input name="single_parent_details" /></label>
        <label>43. Are you a working-student? <select name="is_working_student"><option>NO</option><option>YES</option></select> If yes, employer details: <input name="employer_details" /></label>
      </fieldset>

      <fieldset class="consent"><legend>PLEDGE & DATA PRIVACY CONSENT</legend>
        <p>Please read the pledge and Student's Data Privacy Consent. By checking the box you agree to the terms.</p>
        <label><input type="checkbox" name="agree_pledge" required> I hereby agree to the pledge and data privacy consent.</label>
      </fieldset>

      <div class="form-actions">
        <button type="submit">Submit SPF</button>
        <button type="reset" class="secondary">Reset</button>
      </div>
    </form>

    <footer class="footer">
      <p>Student Profile Form - Davao Oriental State University</p>
    </footer>
  </main>

  <script>
    // basic validation
    document.getElementById('spfForm').addEventListener('submit', function(e){
      var email = document.querySelector('[name="email"]').value;
      if(email && !/^\S+@\S+\.\S+$/.test(email)){ e.preventDefault(); alert('Please enter a valid email.'); }
    });
  </script>
</body>
</html>