@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold">{{ isset($announcement) ? 'Edit Announcement' : 'Create Announcement' }}</h1>
        <a href="{{ route('admin.announcements.index') }}" class="text-indigo-600 hover:text-indigo-900">← Back to Announcements</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <form action="{{ isset($announcement) ? route('admin.announcements.update', $announcement) : route('admin.announcements.store') }}" method="POST">
            @csrf
            @if(isset($announcement))
                @method('PUT')
            @endif

            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                        value="{{ old('title', $announcement->title ?? '') }}" required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                    <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @foreach(['general' => 'General', 'course' => 'Course Update', 'class' => 'Class Update'] as $value => $label)
                            <option value="{{ $value }}" {{ old('type', $announcement->type ?? '') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea name="content" id="content" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('content', $announcement->content ?? '') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="publish_at" class="block text-sm font-medium text-gray-700">Publish Date (optional)</label>
                        <input type="datetime-local" name="publish_at" id="publish_at" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            value="{{ old('publish_at', isset($announcement) && $announcement->publish_at ? $announcement->publish_at->format('Y-m-d\TH:i') : '') }}">
                        @error('publish_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="expires_at" class="block text-sm font-medium text-gray-700">Expiry Date (optional)</label>
                        <input type="datetime-local" name="expires_at" id="expires_at" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            value="{{ old('expires_at', isset($announcement) && $announcement->expires_at ? $announcement->expires_at->format('Y-m-d\TH:i') : '') }}">
                        @error('expires_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                @if(isset($announcement))
                    <div>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                {{ old('is_active', $announcement->is_active) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-600">Active</span>
                        </label>
                    </div>
                @endif

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-red rounded hover:bg-indigo-700">
                        {{ isset($announcement) ? 'Update Announcement' : 'Publish Announcement' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection