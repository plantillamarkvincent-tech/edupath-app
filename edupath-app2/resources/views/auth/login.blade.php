<x-guest-layout>
    <div class="fixed inset-0 z-0">
        <div class="absolute inset-0" style="background-image:url('{{ asset('images/dorsu-logo.png.png') }}'); background-size:contain; background-repeat:no-repeat; background-position:center;"></div>
        <div class="absolute inset-0 bg-white/85 dark:bg-black/70 backdrop-blur-sm"></div>
    </div>

    <div class="relative z-10 overflow-hidden rounded-2xl border border-gray-100 dark:border-gray-700 shadow-xl">
        <div class="bg-white dark:bg-gray-800 px-6 py-8">
            <div class="mb-8 text-center">
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-wide text-gray-900 dark:text-white uppercase" style="font-family: 'Georgia', 'Times New Roman', serif; text-align:center;">
                    Admin Login
                </h1>
                <p class="mt-2 text-base md:text-lg text-gray-600 dark:text-gray-300" style="text-align:center;">
                    Access your campus management dashboard
                </p>
                <div class="mt-4 mx-auto h-px w-24 bg-gradient-to-r from-transparent via-blue-500 to-transparent"></div>
            </div>
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6" onsubmit="const btn=this.querySelector('#loginBtn'); if(btn){btn.disabled=true; btn.classList.add('opacity-75','cursor-not-allowed'); const t=btn.querySelector('[data-text]'); if(t){t.textContent='Signing in...';}}">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Username or Email')" class="text-gray-800 dark:text-gray-200" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                                  class="mt-2 w-full rounded-full bg-gray-100 dark:bg-gray-700/70 border border-gray-200 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-gray-100 placeholder-gray-400 px-5 py-3"
                                  placeholder="you@domain.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-gray-800 dark:text-gray-200" />
                    <x-text-input id="password" type="password" name="password" required autocomplete="current-password"
                                  class="mt-2 w-full rounded-full bg-gray-100 dark:bg-gray-700/70 border border-gray-200 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-gray-100 placeholder-gray-400 px-5 py-3"
                                  placeholder="Enter your password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="pt-2">
                    <button id="loginBtn" type="submit"
                            class="relative w-full inline-flex items-center justify-center gap-2 px-4 py-4 rounded-full text-white font-semibold tracking-wide uppercase shadow-2xl shadow-blue-600/30 border border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all active:scale-[0.99]"
                            style="background-image: linear-gradient(90deg, #2563eb 0%, #2563eb 50%, #1d4ed8 100%); background-color:#2563eb; color:#ffffff;">
                        <svg class="h-5 w-5 opacity-90" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/></svg>
                        <span data-text>{{ __('Login') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

