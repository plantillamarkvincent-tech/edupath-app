<!DOCTYPE html>
<html>
<head>
    <title>TEST - SPF Form</title>
    <style>
        body { 
            background: yellow; 
            font-family: Arial; 
            padding: 20px;
        }
        .header {
            background: white;
            padding: 20px;
            position: relative;
            border: 2px solid black;
        }
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: blue;
        }
        .header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: blue;
        }
        h1 {
            color: blue;
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <h1>TEST PAGE - If you see this, the file is loading!</h1>
    
    <div class="header">
        <h2 style="color: blue; margin: 0;">DAVAO ORIENTAL STATE UNIVERSITY</h2>
        <p style="font-style: italic; margin: 5px 0;">"A University of excellence, innovation, and inclusion"</p>
    </div>
    
    <p><strong>This is a test page. You should see:</strong></p>
    <ul>
        <li>Yellow background</li>
        <li>Blue lines above and below the header</li>
        <li>Blue university name</li>
    </ul>
    
    <p>If you can see this page, then we know Laravel is working and we can fix the main form.</p>
</body>
</html>
