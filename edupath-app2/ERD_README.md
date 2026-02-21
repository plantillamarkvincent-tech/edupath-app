# Entity Relationship Diagram (ERD) Documentation

This directory contains Entity Relationship Diagram documentation for the EduPath Application.

## Files Overview

### 1. `ERD.md`
**Primary ERD file with Mermaid diagram**
- Visual Mermaid ERD diagram (renders in GitHub, GitLab, and many markdown viewers)
- Quick reference for entity relationships
- Key constraints and relationships summary

**How to view:**
- Open in any markdown viewer that supports Mermaid (GitHub, GitLab, VS Code with Mermaid extension)
- Or use online tools like [Mermaid Live Editor](https://mermaid.live)

### 2. `ERD_DETAILED.md`
**Comprehensive documentation**
- Complete entity descriptions with all columns
- Detailed relationship explanations
- Business rules and constraints
- Data integrity notes
- Perfect for developers and database administrators

### 3. `ERD.puml`
**PlantUML format ERD**
- Compatible with PlantUML tools
- Can be rendered as images
- Works with various UML tools and IDEs

**How to view:**
- Use [PlantUML Online Server](http://www.plantuml.com/plantuml/uml/)
- Or install PlantUML extension in your IDE
- Can generate PNG, SVG, or PDF output

## Quick Start

### Viewing the ERD

**Option 1: Mermaid (Recommended)**
```bash
# Open ERD.md in VS Code with Mermaid extension
# Or view on GitHub/GitLab
```

**Option 2: PlantUML**
```bash
# Install PlantUML
# Then render ERD.puml
java -jar plantuml.jar ERD.puml
```

**Option 3: Online Tools**
- Mermaid: https://mermaid.live (paste content from ERD.md)
- PlantUML: http://www.plantuml.com/plantuml/uml/ (paste content from ERD.puml)

## Database Schema Summary

### Core Entities (9 tables)

1. **users** - Authentication and user management
2. **students** - Student academic profiles
3. **programs** - Academic programs/degrees
4. **courses** - Individual courses/subjects
5. **enrollments** - Student course enrollments (junction table)
6. **enrollment_requests** - Enrollment application forms
7. **announcements** - System announcements
8. **contact_messages** - Contact form submissions
9. **about_pages** - About page content

### Key Relationships

- **User ↔ Student**: One-to-one (optional)
- **Program → Students**: One-to-many
- **Program → Courses**: One-to-many
- **Student ↔ Course**: Many-to-many (via enrollments)
- **User → EnrollmentRequest**: One-to-many
- **User → Announcement**: One-to-many

## Entity Count

- **Total Entities**: 9
- **Relationships**: 8
- **Foreign Keys**: 8
- **Unique Constraints**: 5
- **Junction Tables**: 1 (enrollments)

## Maintenance

When updating the database schema:
1. Update the migration files
2. Update the model relationships
3. Update this ERD documentation
4. Regenerate diagrams if needed

## Tools Used

- **Mermaid**: For markdown-compatible diagrams
- **PlantUML**: For UML-standard diagrams
- **Laravel Eloquent**: ORM relationships

## Notes

- All timestamps use Laravel's `created_at` and `updated_at` convention
- Soft deletes are used in `enrollment_requests` table
- Foreign key cascades are carefully designed to maintain data integrity
- Some relationships are optional (nullable foreign keys) for flexibility

---

**Last Updated**: 2025
**Database**: SQLite (dev) / MySQL/PostgreSQL (prod)
**Framework**: Laravel

