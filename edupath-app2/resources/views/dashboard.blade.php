<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-indigo-800 dark:text-indigo-300 leading-tight tracking-wide">
            {{ $about->title ?? __('About Us') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-xl sm:rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="p-8 text-gray-900 dark:text-gray-100 space-y-8">
                    <div class="text-center">
                        <h3 class="text-3xl font-bold mb-4 text-indigo-900 dark:text-indigo-200 tracking-tight">{{ $about->title ?? 'Davao Oriental State University – Baganga Extension Campus' }}</h3>
                        <div class="w-24 h-1 bg-gradient-to-r from-indigo-500 to-purple-600 mx-auto mb-6 rounded-full"></div>
                        <p class="text-lg leading-relaxed text-gray-700 dark:text-gray-300 max-w-4xl mx-auto whitespace-pre-line font-medium">
                            {{ $about->content ?? 'The Baganga Extension Campus of Davao Oriental State University (DOrSU) serves the communities of Baganga and nearby municipalities by providing accessible higher education and career pathways. This system helps students explore academic programs and make informed decisions about their future.' }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                        <div class="space-y-4 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full"></div>
                                <h4 class="text-2xl font-bold text-indigo-900 dark:text-indigo-200">Campus Location</h4>
                            </div>
                            <p class="text-base text-gray-800 dark:text-gray-200 font-semibold leading-relaxed">
                                🏫 Davao Oriental State University – Baganga Extension Campus<br>
                                📍 Baganga, Davao Oriental, Philippines
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 italic">
                                📍 Use the map to locate the campus and get directions from your current location.
                            </p>
                        </div>

                        <div class="w-full h-72 lg:h-80 rounded-lg overflow-hidden shadow-lg border border-gray-200 dark:border-gray-700">
                            @php
                                // Updated map: Dorsu Baganga Extension Campus (latest embed)
                                $mapSrc = $about->map_embed_url ?? 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d192797.4333579458!2d126.53957922761322!3d7.594653362284579!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32fc630056041f07%3A0x90d6c228dd4665a5!2sDorsu%20Baganga!5e1!3m2!1sen!2sph!4v1763817773965!5m2!1sen!2sph';
                            @endphp
                            <iframe
                                src="{{ $mapSrc }}"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
