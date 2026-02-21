@extends('layouts.app')

@section('content')
<style>
    .program-header {
        background: linear-gradient(135deg, #003366 0%, #004488 100%);
        color: white;
        padding: 1.25rem 0;
        margin-bottom: 1.25rem;
        position: relative;
        overflow: hidden;
    }
    .program-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        opacity: 0.3;
    }
    .program-header > div {
        position: relative;
        z-index: 1;
    }
    .info-card {
        background: white;
        border: 2px solid #003366;
        border-radius: 0;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .info-card:hover {
        box-shadow: 0 4px 8px rgba(0,51,102,0.2);
        transform: translateY(-1px);
        border-color: #004488;
    }
    .info-card h3 {
        color: #003366;
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #003366;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .year-card {
        background: #f8fafc;
        border: 2px solid #003366;
        border-left: 4px solid #003366;
        border-radius: 0;
        padding: 0.875rem;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
    }
    .year-card:hover {
        background: #f1f5f9;
        transform: translateX(2px);
        border-color: #004488;
    }
    .year-card h4 {
        color: #003366;
        font-weight: 700;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .semester-section {
        background: white;
        border-radius: 0;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        border: 2px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    .semester-section:hover {
        border-color: #003366;
        box-shadow: 0 2px 6px rgba(0,51,102,0.15);
    }
    .semester-title {
        color: #004488;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .course-item {
        padding: 0.5rem;
        border: 1px solid #e2e8f0;
        border-bottom: 2px solid #e2e8f0;
        font-size: 0.8rem;
        transition: all 0.2s ease;
        display: flex;
        align-items: flex-start;
        gap: 0.375rem;
        margin-bottom: 0.25rem;
    }
    .course-item:hover {
        background: #f8fafc;
        border: 2px solid #003366;
        border-left: 4px solid #003366;
    }
    .course-item:last-child {
        border-bottom: none;
    }
    .course-bullet {
        color: #003366;
        font-weight: bold;
        margin-top: 0.125rem;
    }
    .course-code {
        font-weight: 700;
        color: #003366;
        min-width: 60px;
        font-size: 0.75rem;
    }
    @media (min-width: 640px) {
        .course-code {
            min-width: 80px;
            font-size: 0.8rem;
        }
    }
    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 0;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }
    .btn-enroll {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 12px rgba(16,185,129,0.3);
    }
    .btn-enroll:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16,185,129,0.4);
        color: white;
    }
    .btn-back {
        background: #64748b;
        color: white;
        box-shadow: 0 2px 8px rgba(100,116,139,0.2);
    }
    .btn-back:hover {
        background: #475569;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(100,116,139,0.3);
        color: white;
    }
    .content-text {
        color: #475569;
        line-height: 1.6;
        font-size: 0.85rem;
    }
</style>

<div class="program-header">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="flex items-start gap-2 sm:gap-3">
            <div style="width: 3px; height: 40px; background: white; border-radius: 1px; flex-shrink: 0;"></div>
            <div>
                <h1 class="text-lg sm:text-xl font-bold mb-1">{{ $program->name }}</h1>
                <p class="text-xs sm:text-sm opacity-95 leading-relaxed">{{ $program->description }}</p>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 sm:px-6 pb-6">
	<div class="flex gap-2 mb-3 sm:mb-4 flex-wrap">
		<a href="{{ route('enrollment.create', $program) }}" class="btn-action btn-enroll">
			<span class="hidden sm:inline">✏️</span>
			<span>Enroll</span>
		</a>
		<a href="{{ route('career.index') }}" class="btn-action btn-back">
			<span class="hidden sm:inline">←</span>
			<span>Back</span>
		</a>
	</div>

	<!-- Subjects by Year/Semester -->
	<div class="info-card">
		<h3>
			<span>📚</span>
			<span>Subjects by Year and Semester</span>
		</h3>
		<div class="content-text">
			{!! nl2br(e($program->subjects_by_year ?? '')) ?: '<p class="text-gray-500 italic text-center py-4">Course details coming soon.</p>' !!}
		</div>
	</div>

	<!-- Possible Projects -->
	<div class="info-card">
		<h3>
			<span>🎓</span>
			<span>Possible Projects (Capstone/Thesis)</span>
		</h3>
		<div class="content-text">
			{!! nl2br(e($program->possible_projects ?? '')) ?: '<p class="text-gray-500 italic text-center py-4">Details coming soon.</p>' !!}
		</div>
	</div>

	<!-- Possible Careers -->
	<div class="info-card">
		<h3>
			<span>💼</span>
			<span>Possible Careers</span>
		</h3>
		<div class="content-text">
			{!! nl2br(e($program->possible_careers ?? '')) ?: '<p class="text-gray-500 italic text-center py-4">Details coming soon.</p>' !!}
		</div>
	</div>

	<div class="text-center mt-6">
		<a href="{{ route('enrollment.create', $program) }}" class="btn-action btn-enroll">
			<span class="hidden sm:inline">🚀</span>
			<span>Start Enrollment</span>
		</a>
	</div>
</div>
@endsection
