@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold">Career Pathway Dashboard</h1>
            <p class="text-sm text-gray-600 mt-1">Discover programs and plan your academic pathway.</p>
        </div>
        <a href="{{ route('contact.index') }}" class="inline-flex items-center text-gray-600 dark:text-gray-300 text-sm font-medium hover:underline">
            Contact Admin
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
        <p class="text-gray-700 dark:text-gray-300 mb-4">
            Browse available programs and explore your career pathway options.
        </p>
        <a href="{{ route('career.index') }}" 
           class="inline-flex items-center px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-gray text-sm font-medium rounded-lg transition">
            Click to View Career Pathway Dashboard
        </a>
    </div>
</div>
@endsection
