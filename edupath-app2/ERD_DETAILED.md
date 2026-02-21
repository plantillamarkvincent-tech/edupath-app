# Detailed Entity Relationship Documentation
## EduPath Application - Complete Database Schema

## Table of Contents
1. [Entities Overview](#entities-overview)
2. [Detailed Entity Descriptions](#detailed-entity-descriptions)
3. [Relationship Details](#relationship-details)
4. [Business Rules](#business-rules)
5. [Indexes and Constraints](#indexes-and-constraints)

---

## Entities Overview

| Entity | Description | Primary Key | Records Type |
|--------|-------------|-------------|--------------|
| **users** | System users (admins, students) | `id` | Authentication & Authorization |
| **students** | Student academic profiles | `id` | Academic Records |
| **programs** | Academic programs/degrees | `id` | Academic Structure |
| **courses** | Individual courses/subjects | `id` | Academic Structure |
| **enrollments** | Student course enrollments | `id` | Academic Records |
| **enrollment_requests** | Enrollment applications | `id` | Application Forms |
| **announcements** | System announcements | `id` | Content Management |
| **contact_messages** | Contact form submissions | `id` | Communication |
| **about_pages** | About page content | `id` | Content Management |

---

## Detailed Entity Descriptions

### 1. USERS
**Purpose**: Authentication and user management for the system.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique user identifier |
| `name` | VARCHAR(255) | NOT NULL | User's full name |
| `email` | VARCHAR(255) | UNIQUE, NOT NULL | User's email (login) |
| `password` | VARCHAR(255) | NOT NULL | Hashed password |
| `role` | VARCHAR(255) | DEFAULT 'student' | User role (admin/student) |
| `email_verified_at` | TIMESTAMP | NULLABLE | Email verification timestamp |
| `remember_token` | VARCHAR(100) | NULLABLE | Remember me token |
| `created_at` | TIMESTAMP | NULLABLE | Record creation time |
| `updated_at` | TIMESTAMP | NULLABLE | Record update time |

**Relationships**:
- Has one `Student` (optional)
- Has many `EnrollmentRequest` (optional)
- Has many `Announcement` (via `created_by`)

**Business Rules**:
- Email must be unique across all users
- Role defaults to 'student' if not specified
- Password is automatically hashed

---

### 2. STUDENTS
**Purpose**: Student academic and personal information.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique student identifier |
| `user_id` | BIGINT UNSIGNED | FOREIGN KEY → users.id, CASCADE DELETE | Associated user account |
| `student_number` | VARCHAR(255) | UNIQUE, NOT NULL | Unique student ID number |
| `first_name` | VARCHAR(255) | NOT NULL | Student's first name |
| `middle_name` | VARCHAR(255) | NULLABLE | Student's middle name |
| `last_name` | VARCHAR(255) | NOT NULL | Student's last name |
| `birthdate` | DATE | NULLABLE | Date of birth |
| `sex` | VARCHAR(10) | NULLABLE | Gender |
| `contact_number` | VARCHAR(255) | NULLABLE | Contact phone number |
| `address` | VARCHAR(255) | NULLABLE | Physical address |
| `program_id` | BIGINT UNSIGNED | FOREIGN KEY → programs.id, NULL ON DELETE | Enrolled program |
| `year_level` | VARCHAR(255) | NULLABLE | Current year level |
| `status` | VARCHAR(255) | DEFAULT 'active' | Student status |
| `created_at` | TIMESTAMP | NULLABLE | Record creation time |
| `updated_at` | TIMESTAMP | NULLABLE | Record update time |

**Relationships**:
- Belongs to `User` (required)
- Belongs to `Program` (optional)
- Has many `Enrollment`

**Business Rules**:
- Student number must be unique
- Student number format: `S{YYYY}{user_id}` (e.g., S2025123)
- When user is deleted, student record is also deleted
- When program is deleted, student's program_id is set to NULL

---

### 3. PROGRAMS
**Purpose**: Academic programs/degree programs offered by the institution.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique program identifier |
| `code` | VARCHAR(255) | UNIQUE, NOT NULL | Program code (e.g., BSIT) |
| `name` | VARCHAR(255) | NOT NULL | Program name |
| `description` | TEXT | NULLABLE | Program description |
| `years` | INTEGER | DEFAULT 4 | Duration in years |
| `subjects_by_year` | LONGTEXT | NULLABLE | JSON structure of subjects |
| `possible_projects` | LONGTEXT | NULLABLE | Possible projects description |
| `possible_careers` | LONGTEXT | NULLABLE | Career opportunities |
| `created_at` | TIMESTAMP | NULLABLE | Record creation time |
| `updated_at` | TIMESTAMP | NULLABLE | Record update time |

**Relationships**:
- Has many `Student`
- Has many `Course`
- Has many `EnrollmentRequest`

**Business Rules**:
- Program code must be unique
- Default duration is 4 years

---

### 4. COURSES
**Purpose**: Individual courses/subjects within programs.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique course identifier |
| `code` | VARCHAR(255) | UNIQUE, NOT NULL | Course code (e.g., CS101) |
| `title` | VARCHAR(255) | NOT NULL | Course title |
| `units` | TINYINT UNSIGNED | NOT NULL | Credit units |
| `program_id` | BIGINT UNSIGNED | FOREIGN KEY → programs.id, NULL ON DELETE | Associated program |
| `year_level` | TINYINT UNSIGNED | NULLABLE | Year level (1-4) |
| `semester` | TINYINT UNSIGNED | NULLABLE | Semester (1-2) |
| `created_at` | TIMESTAMP | NULLABLE | Record creation time |
| `updated_at` | TIMESTAMP | NULLABLE | Record update time |

**Relationships**:
- Belongs to `Program` (optional)
- Has many `Enrollment`

**Business Rules**:
- Course code must be unique
- When program is deleted, course's program_id is set to NULL

---

### 5. ENROLLMENTS
**Purpose**: Tracks student enrollments in specific courses.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique enrollment identifier |
| `student_id` | BIGINT UNSIGNED | FOREIGN KEY → students.id, CASCADE DELETE | Enrolled student |
| `course_id` | BIGINT UNSIGNED | FOREIGN KEY → courses.id, CASCADE DELETE | Enrolled course |
| `term` | VARCHAR(255) | NULLABLE | Term (e.g., 1st, 2nd) |
| `school_year` | VARCHAR(255) | NULLABLE | School year |
| `status` | ENUM | DEFAULT 'pending' | Enrollment status |
| `grade` | DECIMAL(5,2) | NULLABLE | Final grade |
| `created_at` | TIMESTAMP | NULLABLE | Record creation time |
| `updated_at` | TIMESTAMP | NULLABLE | Record update time |

**Relationships**:
- Belongs to `Student` (required)
- Belongs to `Course` (required)

**Business Rules**:
- Unique constraint on `(student_id, course_id, term, school_year)`
- Status values: 'pending', 'approved', 'rejected', 'completed'
- When student is deleted, enrollments are deleted
- When course is deleted, enrollments are deleted

---

### 6. ENROLLMENT_REQUESTS
**Purpose**: Student enrollment application forms (SPF - Student Profile Form).

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique request identifier |
| `user_id` | BIGINT UNSIGNED | FOREIGN KEY → users.id, NULL ON DELETE | Associated user (nullable) |
| `program_id` | BIGINT UNSIGNED | FOREIGN KEY → programs.id, CASCADE DELETE | Requested program |
| `full_name` | VARCHAR(255) | NOT NULL | Applicant's full name |
| `email` | VARCHAR(255) | NOT NULL | Applicant's email |
| `contact_number` | VARCHAR(255) | NULLABLE | Contact number |
| `address` | VARCHAR(255) | NULLABLE | Address |
| `last_school_attended` | VARCHAR(255) | NULLABLE | Previous school |
| `school_year` | VARCHAR(255) | NULLABLE | School year |
| `status` | ENUM | DEFAULT 'pending', INDEXED | Request status |
| `admin_note` | TEXT | NULLABLE | Admin notes |
| `student_photo` | VARCHAR(255) | NULLABLE | Photo path |
| `deleted_at` | TIMESTAMP | NULLABLE | Soft delete timestamp |
| `created_at` | TIMESTAMP | NULLABLE | Record creation time |
| `updated_at` | TIMESTAMP | NULLABLE | Record update time |
| *[Many SPF fields]* | Various | NULLABLE | Extended form fields |

**Relationships**:
- Belongs to `User` (optional)
- Belongs to `Program` (required)

**Business Rules**:
- Status values: 'pending', 'review', 'approved', 'rejected'
- Uses soft deletes (can be restored)
- When approved, creates User and Student records
- When program is deleted, requests are deleted
- When user is deleted, request's user_id is set to NULL

**SPF Sections** (Extended Fields):
- I. Application for Admission
- II. Personal Information
- III. Family Background
- IV. SCAST Results
- V. Unique Features
- VI. Educational Background
- VII. Self Assessment
- VIII. Other Information

---

### 7. ANNOUNCEMENTS
**Purpose**: System-wide announcements and notifications.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique announcement identifier |
| `title` | VARCHAR(255) | NOT NULL | Announcement title |
| `content` | TEXT | NOT NULL | Announcement content |
| `type` | VARCHAR(255) | DEFAULT 'general' | Announcement type |
| `is_active` | BOOLEAN | DEFAULT true | Active status |
| `publish_at` | TIMESTAMP | NULLABLE | Publication date |
| `expires_at` | TIMESTAMP | NULLABLE | Expiration date |
| `created_by` | BIGINT UNSIGNED | FOREIGN KEY → users.id | Creator user |
| `created_at` | TIMESTAMP | NULLABLE | Record creation time |
| `updated_at` | TIMESTAMP | NULLABLE | Record update time |

**Relationships**:
- Belongs to `User` (via `created_by`)

**Business Rules**:
- Type defaults to 'general'
- Can be scheduled (publish_at) and expired (expires_at)
- Active announcements are visible based on publish/expire dates

---

### 8. CONTACT_MESSAGES
**Purpose**: Contact form submissions from website visitors.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique message identifier |
| `name` | VARCHAR(255) | NOT NULL | Sender's name |
| `email` | VARCHAR(255) | NOT NULL | Sender's email |
| `subject` | VARCHAR(255) | NOT NULL | Message subject |
| `message` | TEXT | NOT NULL | Message content |
| `is_read` | BOOLEAN | DEFAULT false | Read status |
| `created_at` | TIMESTAMP | NULLABLE | Record creation time |
| `updated_at` | TIMESTAMP | NULLABLE | Record update time |

**Relationships**: None (standalone entity)

**Business Rules**:
- No foreign key relationships
- Used for tracking contact form submissions

---

### 9. ABOUT_PAGES
**Purpose**: About page content management.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique page identifier |
| `title` | VARCHAR(255) | DEFAULT 'About Us' | Page title |
| `content` | TEXT | NULLABLE | Page content |
| `map_embed_url` | TEXT | NULLABLE | Google Maps embed URL |
| `created_at` | TIMESTAMP | NULLABLE | Record creation time |
| `updated_at` | TIMESTAMP | NULLABLE | Record update time |

**Relationships**: None (standalone entity)

**Business Rules**:
- No foreign key relationships
- Used for managing about page content

---

## Relationship Details

### One-to-One Relationships

1. **User ↔ Student**
   - **Cardinality**: 1:1 (optional on both sides)
   - **Foreign Key**: `students.user_id` → `users.id`
   - **Cascade**: DELETE CASCADE (deleting user deletes student)
   - **Business Logic**: A user can have at most one student profile

### One-to-Many Relationships

1. **User → EnrollmentRequest**
   - **Cardinality**: 1:N (optional)
   - **Foreign Key**: `enrollment_requests.user_id` → `users.id`
   - **Cascade**: SET NULL (deleting user sets user_id to NULL)
   - **Business Logic**: A user can submit multiple enrollment requests

2. **User → Announcement**
   - **Cardinality**: 1:N
   - **Foreign Key**: `announcements.created_by` → `users.id`
   - **Cascade**: RESTRICT (cannot delete user with announcements)
   - **Business Logic**: A user can create multiple announcements

3. **Program → Student**
   - **Cardinality**: 1:N
   - **Foreign Key**: `students.program_id` → `programs.id`
   - **Cascade**: SET NULL (deleting program sets program_id to NULL)
   - **Business Logic**: A program can have many students

4. **Program → Course**
   - **Cardinality**: 1:N
   - **Foreign Key**: `courses.program_id` → `programs.id`
   - **Cascade**: SET NULL (deleting program sets program_id to NULL)
   - **Business Logic**: A program contains many courses

5. **Program → EnrollmentRequest**
   - **Cardinality**: 1:N
   - **Foreign Key**: `enrollment_requests.program_id` → `programs.id`
   - **Cascade**: DELETE CASCADE (deleting program deletes requests)
   - **Business Logic**: A program receives many enrollment requests

6. **Student → Enrollment**
   - **Cardinality**: 1:N
   - **Foreign Key**: `enrollments.student_id` → `students.id`
   - **Cascade**: DELETE CASCADE (deleting student deletes enrollments)
   - **Business Logic**: A student can enroll in many courses

7. **Course → Enrollment**
   - **Cardinality**: 1:N
   - **Foreign Key**: `enrollments.course_id` → `courses.id`
   - **Cascade**: DELETE CASCADE (deleting course deletes enrollments)
   - **Business Logic**: A course can have many student enrollments

### Many-to-Many Relationships (via Junction Table)

1. **Student ↔ Course** (via `enrollments`)
   - **Cardinality**: M:N
   - **Junction Table**: `enrollments`
   - **Business Logic**: Students enroll in multiple courses, courses have multiple students
   - **Additional Attributes**: term, school_year, status, grade

---

## Business Rules

### Enrollment Process
1. Student submits `EnrollmentRequest` with program selection
2. Admin reviews and approves/rejects request
3. Upon approval:
   - User account is created (if not exists)
   - Student record is created with auto-generated student number
   - Initial enrollments are auto-created for first semester courses
4. Student can then enroll in additional courses through `Enrollment` records

### Student Number Generation
- Format: `S{YYYY}{user_id}`
- Example: `S2025123` (Student in 2025, user ID 123)
- Generated automatically when student record is created

### Enrollment Constraints
- Unique constraint prevents duplicate enrollments: `(student_id, course_id, term, school_year)`
- A student cannot enroll in the same course for the same term and school year twice

### Soft Deletes
- `EnrollmentRequest` uses soft deletes
- Deleted requests can be restored
- Use `withTrashed()` to query deleted records

---

## Indexes and Constraints

### Primary Keys
- All tables have `id` as PRIMARY KEY (BIGINT UNSIGNED, AUTO_INCREMENT)

### Unique Constraints
- `users.email` - UNIQUE
- `students.student_number` - UNIQUE
- `programs.code` - UNIQUE
- `courses.code` - UNIQUE
- `enrollments(student_id, course_id, term, school_year)` - UNIQUE (composite)

### Foreign Key Indexes
- All foreign key columns are automatically indexed
- `enrollment_requests.status` - INDEXED (for filtering)

### Foreign Key Cascades
- **CASCADE DELETE**: 
  - `students.user_id` → `users.id`
  - `enrollments.student_id` → `students.id`
  - `enrollments.course_id` → `courses.id`
  - `enrollment_requests.program_id` → `programs.id`

- **SET NULL ON DELETE**:
  - `students.program_id` → `programs.id`
  - `courses.program_id` → `programs.id`
  - `enrollment_requests.user_id` → `users.id`

- **RESTRICT**:
  - `announcements.created_by` → `users.id`

---

## Data Integrity Notes

1. **Referential Integrity**: All foreign keys are enforced at the database level
2. **Cascade Behavior**: Carefully designed to prevent orphaned records while allowing flexible deletions
3. **Soft Deletes**: Enrollment requests can be restored, maintaining audit trail
4. **Unique Constraints**: Prevent duplicate data at database level
5. **Nullable Foreign Keys**: Allow for flexible data entry (e.g., students without programs initially)

---

## Version Information
- **Database System**: SQLite (development) / MySQL/PostgreSQL (production)
- **ORM**: Laravel Eloquent
- **Framework**: Laravel
- **Last Updated**: 2025

