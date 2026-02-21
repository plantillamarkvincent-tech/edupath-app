@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Contact Admin</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Have questions or need help? Send us a message and we'll get back to you via email.</p>

        @if (session('status'))
            <div class="mt-4 mb-6 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="mt-4 mb-6 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('contact.send') }}" class="mt-6 space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Your Name</label>
                <input id="name" name="name" type="text" value="{{ old('name', auth()->user()->name ?? '') }}" required
                       class="mt-1 w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                       placeholder="John Doe">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Your Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', auth()->user()->email ?? '') }}" required
                       class="mt-1 w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                       placeholder="your.email@example.com">
                @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="subject" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Subject</label>
                <input id="subject" name="subject" type="text" value="{{ old('subject') }}" required
                       class="mt-1 w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                       placeholder="Select a subject">
                @error('subject')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="message" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Message</label>
                <textarea id="message" name="message" rows="6" required
                          class="mt-1 w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                          placeholder="Please describe your question or concern in detail...">{{ old('message') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Maximum 2000 characters</p>
                @error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-5 py-3 rounded-lg font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 border border-blue-700"
                        style="background-color:#2563eb; color:#ffffff;">
                    Send Message
                </button>
                <a href="{{ url()->previous() }}" class="px-5 py-3 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg font-semibold hover:bg-gray-300 dark:hover:bg-gray-600">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection