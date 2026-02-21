<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=9" />
  <title>DAVAO ORIENTAL STATE UNIVERSITY - STUDENT'S PROFILE FORM (SPF)</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      background: white;
      font-size: 12px;
      line-height: 1.4;
    }
    
    .container {
      max-width: 8.5in;
      margin: 0 auto;
      background: white;
      padding: 20px;
      border: 2px solid #000;
    }
    
    /* Header with full-width blue lines */
    .header {
      position: relative;
      padding: 15px 0 5px 0;
      background: blue;
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      margin-bottom: 20px;
    }
    
    /* Top blue line */
    .header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: #1e40af;
    }
    
    /* Bottom blue line */
    .header::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 1px;
      background: #000;
    }
    
    .university-section {
      flex: 1;
      text-align: center;
    }
    
    .university-name {
      font-size: 20px;
      font-weight: bold;
      margin: 0;
      color: #1e40af;
      text-align: left;
      font-family: Arial, sans-serif;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      line-height: 1.2;
    }
    
    .university-tagline {
      color: black;
      font-style: italic;
      font-size: 10px;
      margin: 4px 0 0 0;
    }
    
    .logo-section {
      margin: 0 10px 0 20px;
      display: flex;
      align-items: center;
    }
    
    .logo-section img {
      width: 70px;
      height: 70px;
    }
    
    .form-code-section {
      border: 1px solid #000;
      width: 200px;
      font-size: 9px;
      margin-left: auto;
      text-align: center;
      padding: 2px 5px;
    }
    
    .form-code-header {
      background: #001f3f;
      color: white;
      padding: 2px 4px;
      text-align: center;
      font-weight: bold;
      font-size: 8px;
      text-transform: uppercase;
      line-height: 1.2;
    }
    
    .form-code {
      font-size: 10px;
      font-weight: bold;
      padding: 2px 0;
      text-align: center;
      display: block;
    }
    
    .form-code-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 8px;
    }
    
    .form-code-table th {
      background: #1e40af;
      color: white;
      padding: 3px 2px;
      text-align: center;
      font-weight: bold;
      border: 1px solid #000;
    }
    
    .form-code-table td {
      padding: 3px 2px;
      text-align: center;
      border: 1px solid #000;
      background: white;
    }
    
    .form-title {
      font-size: 16px;
      font-weight: bold;
      margin: 20px 0;
      color: #000;
    }
    
    .instructions {
      margin: 20px 0;
      position: relative;
    }
    
    .instructions h4 {
      font-weight: bold;
      margin: 0 0 10px 0;
      font-size: 12px;
    }
    
    .instructions ol {
      margin: 0;
      padding-left: 20px;
    }
    
    .photo-box {
      position: absolute;
      right: 0;
      top: 0;
      width: 120px;
      height: 150px;
      border: 2px solid #000;
      text-align: center;
      padding-top: 60px;
      font-size: 11px;
    }
    
    .section {
      margin: 20px 0;
    }
    
    .section-title {
      font-weight: bold;
      font-size: 12px;
      margin-bottom: 15px;
      text-decoration: underline;
    }
    
    .form-item {
      margin: 8px 0;
      display: flex;
      align-items: baseline;
    }
    
    .form-item label {
      margin-right: 10px;
      font-size: 11px;
    }
    
    .form-line {
      border-bottom: 1px solid #000;
      min-width: 200px;
      height: 20px;
      display: inline-block;
      margin: 0 5px;
    }
    
    .form-line-long {
      border-bottom: 1px solid #000;
      min-width: 400px;
      height: 20px;
      display: inline-block;
      margin: 0 5px;
    }
    
    .checkbox-group {
      display: flex;
      gap: 20px;
      align-items: center;
      margin: 10px 0;
    }
    
    .checkbox-item {
      display: flex;
      align-items: center;
      gap: 5px;
    }
    
    .checkbox-item input[type="checkbox"] {
      width: 12px;
      height: 12px;
    }
    
    .preferred-courses {
      margin-left: 20px;
    }
    
    .preferred-courses .form-item {
      margin: 5px 0;
    }
    
    @media print {
      body { margin: 0; padding: 0; }
      .container { border: none; }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <div class="university-section">
        <h1 class="university-name">DAVAO ORIENTAL STATE UNIVERSITY</h1>
        <p class="university-tagline">A University of excellence, innovation, and inclusion</p>
      </div>
      
      <div class="logo-section">
        <img src="{{ asset('images/dorsu-logo.png') }}" alt="DORSU Logo">
      </div>
      
      <div class="form-code-section">
        <div class="form-code-header">Document Code No.</div>
        <div class="form-code">FM-DOrSU-ODI-05</div>
      </div>
      </div>
    </div>

    <h2 class="form-title">Student's Profile Form</h2>

    <div class="instructions">
      <h4>INSTRUCTIONS:</h4>
      <ol type="a">
        <li>Fill out this form completely and correctly.</li>
        <li>Write legibly. Mark all appropriate boxes/spaces with a check mark (/).</li>
      </ol>
      <div class="photo-box">
        Paste your<br>
        2x2 photo<br>
        here
      </div>
    </div>

    <div class="section">
      <div class="section-title">I. &nbsp;&nbsp;&nbsp;&nbsp;APPLICATION FOR ADMISSION</div>
      
      <div class="form-item">
        <label>1. &nbsp;&nbsp;DOrSU Student ID Number:</label>
        <span class="form-line-long"></span>
        <br><span style="margin-left: 200px; font-size: 10px;">(To be filled up by the Admissions Office)</span>
      </div>

      <div class="form-item">
        <label>2. &nbsp;&nbsp;Semester</label>
        <span class="form-line"></span>
        <label>Academic Year</label>
        <span class="form-line"></span>
      </div>

      <div class="form-item">
        <label>3. &nbsp;&nbsp;</label>
        <div class="checkbox-group">
          <div class="checkbox-item">
            <input type="checkbox" name="entry_type" value="first_year">
            <label>First Year</label>
          </div>
          <div class="checkbox-item">
            <input type="checkbox" name="entry_type" value="transferee">
            <label>Transferee</label>
          </div>
          <div class="checkbox-item">
            <input type="checkbox" name="entry_type" value="returnee">
            <label>Returnee</label>
          </div>
        </div>
      </div>

      <div class="form-item">
        <label>4. &nbsp;&nbsp;LRN:</label>
        <span class="form-line-long"></span>
      </div>

      <div class="form-item">
        <label>5. &nbsp;&nbsp;Campus:</label>
        <span class="form-line-long"></span>
      </div>

      <div class="form-item">
        <label>6. &nbsp;&nbsp;Preferred Courses:</label>
      </div>
      <div class="preferred-courses">
        <div class="form-item">
          <label>1.</label>
          <span class="form-line-long"></span>
        </div>
        <div class="form-item">
          <label>2.</label>
          <span class="form-line-long"></span>
        </div>
        <div class="form-item">
          <label>3.</label>
          <span class="form-line-long"></span>
        </div>
      </div>
    </div>

    <div class="section">
      <div class="section-title">II. &nbsp;&nbsp;&nbsp;PERSONAL INFORMATION</div>
      <!-- Personal information section would continue here -->
    </div>
  </div>
</body>
</html>
