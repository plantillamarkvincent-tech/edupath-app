php artisan serve
# TODO: Add Submission Function for Announcements

## Steps to Complete
- [x] Add submitAnnouncement method in AnnouncementController.php to create announcement and send emails
- [x] Update routes in web.php to include the new submission route
- [x] Test the email sending functionality (ensure .env is configured for Gmail SMTP)
- [x] Verify that emails are sent to all students with submitted enrollment requests

## Information Gathered
- AnnouncementController.php is currently empty and needs the submission function.
- Students who have submitted requirements are identified by EnrollmentRequest records with non-null emails.
- NewAnnouncementNotification class exists for email content.
- Mail configuration defaults to 'log', but for Gmail, user must set MAIL_MAILER=smtp and Gmail credentials in .env.
- AdminAnnouncementController already has a store method, but it uses notifications which may not send due to log mailer.

## Plan
- Add a submitAnnouncement method in AnnouncementController that validates input, creates an Announcement, retrieves emails from EnrollmentRequest, and sends emails using Mail::to()->send(new NewAnnouncementNotification($announcement)).
- Add a POST route for /announcements/submit in web.php.
- Use the existing Announcement model and NewAnnouncementNotification.

## Dependent Files to Edit
- edupath-app2/app/Http/Controllers/AnnouncementController.php
- edupath-app2/routes/web.php

## Followup Steps
- After implementation, test by creating an announcement and checking if emails are sent (monitor logs or actual inbox).
- If emails don't send, verify .env configuration for Gmail SMTP.
