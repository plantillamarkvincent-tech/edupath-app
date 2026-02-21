@extends('layouts.app')

@section('content')
<style>
    .career-hero {
        background: linear-gradient(135deg, #003366 0%, #004488 100%);
        color: white;
        padding: 1.25rem 0;
        margin-bottom: 1.25rem;
        position: relative;
        overflow: hidden;
    }
    .career-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        opacity: 0.3;
    }
    .career-hero > div {
        position: relative;
        z-index: 1;
    }
    .program-card {
        border: 2px solid #0b3b75;
        border-top-width: 5px;
        border-bottom-width: 5px;
        border-radius: 10px;
        padding: 1rem 1rem 1.1rem;
        background: #ffffff;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        box-shadow: 0 6px 12px rgba(11,59,117,0.08);
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
        width: 280px; /* desktop size close to mock */
        min-height: 210px;
        margin: 0 auto;
    }
    /* base strip under card like in mock */
    .program-card::after {
        content: '';
        position: absolute;
        left: 16px;
        right: 16px;
        bottom: -8px;
        height: 6px;
        background: #0b3b75;
        border-radius: 3px;
        opacity: 0.9;
    }
    .program-card:hover { transform: translateY(-2px); }
    .program-icon {
        width: 56px;
        height: 56px;
        border-radius: 8px;
        background: #0b2f66;
        border: 2px solid #0b3b75;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        margin-bottom: 1rem;
        box-shadow: 0 6px 12px rgba(11,59,117,0.25);
    }
    .program-card h2 {
        color: #0b2f66;
        font-size: 1.125rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1.3;
        letter-spacing: -0.01em;
    }
    .program-card p {
        color: #667385;
        font-size: 0.85rem;
        line-height: 1.45;
        flex-grow: 1;
        margin-bottom: 1.2rem;
    }
    .card-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid rgba(11,59,117,0.25);
        box-shadow: 0 4px 8px rgba(0,0,0,0.12);
    }
    .btn-career {
        padding: 0.7rem 0.75rem;
        font-weight: 600;
        font-size: 0.82rem;
        transition: background 0.2s ease, transform 0.2s ease;
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        text-decoration: none;
        border: none;
        cursor: pointer;
        letter-spacing: 0.01em;
    }
    .btn-career:hover {
        transform: translateY(-1px);
        filter: brightness(1.03);
    }
    .btn-primary {
        background: #082a57; /* navy like mock */
        color: white;
        border-right: 1px solid rgba(255,255,255,0.2);
    }
    .btn-success {
        background: #10a56b; /* flat green like mock */
        color: white;
    }
    .program-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.25rem;
        justify-items: center;
    }
    @media (min-width: 1024px) {
        .program-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }
    .btn-add-program {
        background: #003366 !important;
        color: white;
        border-radius: 0;
    }
    .btn-add-program:hover {
        background: #004488 !important;
        color: white;
    }
</style>

<div class="career-hero">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="flex items-center gap-2 mb-1">
            <div style="width: 3px; height: 32px; background: white; border-radius: 1px;"></div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold mb-0.5">Career Pathway Dashboard</h1>
                <p class="text-xs sm:text-sm opacity-95">Discover your future at Davao Oriental State University</p>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 sm:px-6 pb-6">
	@if (session('status'))
		<div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 px-3 py-2 rounded-r mb-3 text-xs sm:text-sm font-medium shadow-sm">
			✓ {{ session('status') }}
		</div>
	@endif

	<div class="mb-3 sm:mb-4 flex items-center justify-between gap-3 flex-wrap">
		<div>
			<p class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">Browse available programs</p>
			<p class="text-xs text-gray-500 mt-0.5">{{ $programs->count() }} program{{ $programs->count() !== 1 ? 's' : '' }} available</p>
		</div>
		@auth
			@if (Auth::user()->isAdmin())
				<a href="{{ route('admin.programs.create') }}" class="btn-add-program px-3 py-1.5 transition shadow-sm hover:shadow text-xs sm:text-sm font-semibold">
					+ Add Program
				</a>
			@endif
		@endauth
	</div>

	<div class="program-grid">
		@foreach ($programs as $program)
			<div class="program-card">
				<div class="program-icon">
					🎓
				</div>
				<h2>{{ $program->name }}</h2>
				<p>{{ Str::limit($program->description, 130) }}</p>
                <div class="card-actions mt-auto">
                    <a href="{{ route('career.show', $program) }}" class="btn-career btn-primary">View</a>
                    <a href="{{ route('enrollment.create', $program) }}" class="btn-career btn-success">Enroll</a>
				</div>
			</div>
		@endforeach
	</div>
</div>
@endsection
