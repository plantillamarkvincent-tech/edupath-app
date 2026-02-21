<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Empower your learning journey with personalized educational paths and resources.">

    <title>{{ config('app.name', 'EduPath') }} - Personalized Learning Platform</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Custom styles for animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
        .animate-delay-100 {
            animation-delay: 0.1s;
        }
        .animate-delay-200 {
            animation-delay: 0.2s;
        }
        .animate-delay-300 {
            animation-delay: 0.3s;
        }
        .gradient-text {
            background: linear-gradient(90deg, #4F46E5 0%, #10B981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }
        .btn-primary {
            @apply bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200;
        }
        .btn-secondary {
            @apply bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 font-medium py-3 px-6 rounded-lg transition-colors duration-200;
        }
        .hero-section {
            min-height: calc(100vh - 4rem);
            padding-top: 6rem;
        }
    </style>
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">EduPath</span>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Features</a>
                    <a href="#how-it-works" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">How It Works</a>
                    <a href="#pricing" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Pricing</a>
                    <a href="#contact" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Contact</a>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-secondary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-secondary">Sign In</a>
                            <a href="{{ route('register') }}" class="btn-primary">Get Started</a>
                        @endauth
                    @endif
                </div>
                <div class="md:hidden flex items-center">
                    <!-- Mobile menu button -->
                    <button type="button" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400" id="mobile-menu-button">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#features" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Features</a>
                <a href="#how-it-works" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">How It Works</a>
                <a href="#pricing" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Pricing</a>
                <a href="#contact" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Contact</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Sign In</a>
                        <a href="{{ route('register') }}" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-gray-800">Get Started</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="hero-section pt-16 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6 animate-fade-in">
                    <span class="inline-block px-3 py-1 text-sm font-medium bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-300 rounded-full animate-fade-in">Empowering Education</span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight animate-fade-in animate-delay-100">
                        Personalized Learning 
                        <span class="gradient-text">For Everyone</span>
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300 animate-fade-in animate-delay-200">
                        Discover your ideal learning path with AI-powered recommendations and track your progress with our intuitive platform.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 pt-4 animate-fade-in animate-delay-300">
                        <a href="{{ route('register') }}" class="btn-primary text-center">
                            Start Learning Free
                        </a>
                        <a href="#features" class="btn-secondary text-center">
                            Learn More
                        </a>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                        <div class="flex -space-x-2">
                            <img class="h-8 w-8 rounded-full border-2 border-white dark:border-gray-800" src="https://randomuser.me/api/portraits/women/12.jpg" alt="User">
                            <img class="h-8 w-8 rounded-full border-2 border-white dark:border-gray-800" src="https://randomuser.me/api/portraits/men/42.jpg" alt="User">
                            <img class="h-8 w-8 rounded-full border-2 border-white dark:border-gray-800" src="https://randomuser.me/api/portraits/women/34.jpg" alt="User">
                        </div>
                        <span>Join 10,000+ learners today</span>
                    </div>
                </div>
                <div class="relative">
                    <div class="relative z-10 rounded-2xl overflow-hidden shadow-xl transform rotate-1 animate-fade-in">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80" alt="Students learning" class="w-full h-auto rounded-2xl">
                    </div>
                    <div class="absolute -bottom-6 -right-6 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-lg w-2/3 animate-fade-in animate-delay-200">
                        <div class="flex items-center space-x-2">
                            <div class="p-2 bg-indigo-100 dark:bg-indigo-900 rounded-lg">
                                <i class="fas fa-trophy text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                            <div>
                                <p class="font-medium">Success Stories</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">95% of students achieve their goals</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl">Amazing Features</h2>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-300">Everything you need to succeed in your learning journey</p>
            </div>
            <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Feature 1 -->
                <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl hover:shadow-lg transition-shadow duration-300">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-route text-indigo-600 dark:text-indigo-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Personalized Learning Paths</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Get customized learning recommendations based on your goals, skills, and progress.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl hover:shadow-lg transition-shadow duration-300">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-chart-line text-indigo-600 dark:text-indigo-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Progress Tracking</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Monitor your learning journey with detailed analytics and achievement tracking.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl hover:shadow-lg transition-shadow duration-300">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-users text-indigo-600 dark:text-indigo-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Community Support</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Connect with fellow learners and experts to enhance your learning experience.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl">How It Works</h2>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-300">Get started in just a few simple steps</p>
            </div>
            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">1</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Sign Up</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Create your free account in less than a minute.</p>
                </div>
                
                <!-- Step 2 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">2</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Set Your Goals</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Tell us what you want to learn and achieve.</p>
                </div>
                
                <!-- Step 3 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">3</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Start Learning</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Begin your personalized learning journey today.</p>
                </div>
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('register') }}" class="btn-primary inline-block">
                    Get Started Now
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl">What Our Students Say</h2>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-300">Join thousands of satisfied learners</p>
            </div>
            <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Testimonial 1 -->
                <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full" src="https://randomuser.me/api/portraits/women/45.jpg" alt="Sarah Johnson">
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Sarah Johnson</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Web Developer</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">"EduPath completely transformed how I learn. The personalized learning paths helped me master web development in just 6 months!"</p>
                    <div class="mt-4 flex text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full" src="https://randomuser.me/api/portraits/men/32.jpg" alt="Michael Chen">
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Michael Chen</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Data Scientist</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">"The community support and expert guidance helped me transition into data science. The progress tracking kept me motivated throughout my journey."</p>
                    <div class="mt-4 flex text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full" src="https://randomuser.me/api/portraits/women/68.jpg" alt="Emily Rodriguez">
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Emily Rodriguez</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">UX Designer</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">"As a visual learner, I appreciated the variety of content formats. The platform is intuitive and made learning UX design principles a breeze!"</p>
                    <div class="mt-4 flex text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-indigo-600">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                Ready to start your learning journey?
            </h2>
            <p class="mt-4 text-xl text-indigo-100">
                Join thousands of students who are already achieving their learning goals with EduPath.
            </p>
            <div class="mt-8">
                <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 md:py-4 md:text-lg md:px-10">
                    Get Started for Free
                </a>
                <a href="#features" class="ml-4 inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-700 bg-opacity-60 hover:bg-opacity-50 md:py-4 md:text-lg md:px-10">
                    Learn More
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">EduPath</h3>
                    <p class="text-gray-400">Empowering your learning journey with personalized educational paths and resources.</p>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Navigation</h4>
                    <ul class="space-y-2">
                        <li><a href="#features" class="text-gray-300 hover:text-white">Features</a></li>
                        <li><a href="#how-it-works" class="text-gray-300 hover:text-white">How It Works</a></li>
                        <li><a href="#pricing" class="text-gray-300 hover:text-white">Pricing</a></li>
                        <li><a href="#contact" class="text-gray-300 hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Cookie Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Connect</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white">
                            <span class="sr-only">Facebook</span>
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white">
                            <span class="sr-only">Twitter</span>
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white">
                            <span class="sr-only">Instagram</span>
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white">
                            <span class="sr-only">LinkedIn</span>
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} EduPath. All rights reserved.</p>
                <div class="mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white text-sm mr-4">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile menu toggle script -->
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('block');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            
            if (!mobileMenu.contains(event.target) && event.target !== mobileMenuButton) {
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.remove('block');
            }
        });
    </script>
</body>
</html>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Custom styles for animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
        .animate-delay-100 {
            animation-delay: 0.1s;
        }
        .animate-delay-200 {
            animation-delay: 0.2s;
        }
        .animate-delay-300 {
            animation-delay: 0.3s;
        }
        .gradient-text {
            background: linear-gradient(90deg, #4F46E5 0%, #10B981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }
        .btn-primary {
            @apply bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200;
        }
        .btn-secondary {
            @apply bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 font-medium py-3 px-6 rounded-lg transition-colors duration-200;
        }
        .hero-section {
            min-height: calc(100vh - 4rem);
            padding-top: 6rem;
        }
    </style>
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">EduPath</span>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Features</a>
                    <a href="#how-it-works" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">How It Works</a>
                    <a href="#pricing" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Pricing</a>
                    <a href="#contact" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Contact</a>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-secondary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-secondary">Sign In</a>
                            <a href="{{ route('register') }}" class="btn-primary">Get Started</a>
                        @endauth
                    @endif
                </div>
                <div class="md:hidden flex items-center">
                    <!-- Mobile menu button -->
                    <button type="button" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400" id="mobile-menu-button">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#features" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Features</a>
                <a href="#how-it-works" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">How It Works</a>
                <a href="#pricing" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Pricing</a>
                <a href="#contact" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Contact</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Sign In</a>
                        <a href="{{ route('register') }}" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-gray-800">Get Started</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="hero-section pt-16 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6 animate-fade-in">
                    <span class="inline-block px-3 py-1 text-sm font-medium bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-300 rounded-full animate-fade-in">Empowering Education</span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight animate-fade-in animate-delay-100">
                        Personalized Learning 
                        <span class="gradient-text">For Everyone</span>
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300 animate-fade-in animate-delay-200">
                        Discover your ideal learning path with AI-powered recommendations and track your progress with our intuitive platform.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 pt-4 animate-fade-in animate-delay-300">
                        <a href="{{ route('register') }}" class="btn-primary text-center">
                            Start Learning Free
                        </a>
                        <a href="#features" class="btn-secondary text-center">
                            Learn More
                        </a>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                        <div class="flex -space-x-2">
                            <img class="h-8 w-8 rounded-full border-2 border-white dark:border-gray-800" src="https://randomuser.me/api/portraits/women/12.jpg" alt="User">
                            <img class="h-8 w-8 rounded-full border-2 border-white dark:border-gray-800" src="https://randomuser.me/api/portraits/men/42.jpg" alt="User">
                            <img class="h-8 w-8 rounded-full border-2 border-white dark:border-gray-800" src="https://randomuser.me/api/portraits/women/34.jpg" alt="User">
                        </div>
                        <span>Join 10,000+ learners today</span>
                    </div>
                </div>
                <div class="relative">
                    <div class="relative z-10 rounded-2xl overflow-hidden shadow-xl transform rotate-1 animate-fade-in">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80" alt="Students learning" class="w-full h-auto rounded-2xl">
                    </div>
                    <div class="absolute -bottom-6 -right-6 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-lg w-2/3 animate-fade-in animate-delay-200">
                        <div class="flex items-center space-x-2">
                            <div class="p-2 bg-indigo-100 dark:bg-indigo-900 rounded-lg">
                                <i class="fas fa-trophy text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                            <div>
                                <p class="font-medium">Success Stories</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">95% of students achieve their goals</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl">Amazing Features</h2>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-300">Everything you need to succeed in your learning journey</p>
            </div>
            <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Feature 1 -->
                <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl hover:shadow-lg transition-shadow duration-300">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-route text-indigo-600 dark:text-indigo-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Personalized Learning Paths</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Get customized learning recommendations based on your goals, skills, and progress.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl hover:shadow-lg transition-shadow duration-300">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-chart-line text-indigo-600 dark:text-indigo-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Progress Tracking</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Monitor your learning journey with detailed analytics and achievement tracking.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl hover:shadow-lg transition-shadow duration-300">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-users text-indigo-600 dark:text-indigo-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Community Support</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Connect with fellow learners and experts to enhance your learning experience.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl">How It Works</h2>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-300">Get started in just a few simple steps</p>
            </div>
            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">1</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Sign Up</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Create your free account in less than a minute.</p>
                </div>
                
                <!-- Step 2 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">2</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Set Your Goals</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Tell us what you want to learn and achieve.</p>
                </div>
                
                <!-- Step 3 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">3</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Start Learning</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Begin your personalized learning journey today.</p>
                </div>
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('register') }}" class="btn-primary inline-block">
                    Get Started Now
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl">What Our Students Say</h2>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-300">Join thousands of satisfied learners</p>
            </div>
            <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Testimonial 1 -->
                <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full" src="https://randomuser.me/api/portraits/women/45.jpg" alt="Sarah Johnson">
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Sarah Johnson</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Web Developer</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">"EduPath completely transformed how I learn. The personalized learning paths helped me master web development in just 6 months!"</p>
                    <div class="mt-4 flex text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full" src="https://randomuser.me/api/portraits/men/32.jpg" alt="Michael Chen">
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Michael Chen</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Data Scientist</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">"The community support and expert guidance helped me transition into data science. The progress tracking kept me motivated throughout my journey."</p>
                    <div class="mt-4 flex text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full" src="https://randomuser.me/api/portraits/women/68.jpg" alt="Emily Rodriguez">
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Emily Rodriguez</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">UX Designer</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">"As a visual learner, I appreciated the variety of content formats. The platform is intuitive and made learning UX design principles a breeze!"</p>
                    <div class="mt-4 flex text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-indigo-600">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                Ready to start your learning journey?
            </h2>
            <p class="mt-4 text-xl text-indigo-100">
                Join thousands of students who are already achieving their learning goals with EduPath.
            </p>
            <div class="mt-8">
                <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 md:py-4 md:text-lg md:px-10">
                    Get Started for Free
                </a>
                <a href="#features" class="ml-4 inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-700 bg-opacity-60 hover:bg-opacity-50 md:py-4 md:text-lg md:px-10">
                    Learn More
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">EduPath</h3>
                    <p class="text-gray-400">Empowering your learning journey with personalized educational paths and resources.</p>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Navigation</h4>
                    <ul class="space-y-2">
                        <li><a href="#features" class="text-gray-300 hover:text-white">Features</a></li>
                        <li><a href="#how-it-works" class="text-gray-300 hover:text-white">How It Works</a></li>
                        <li><a href="#pricing" class="text-gray-300 hover:text-white">Pricing</a></li>
                        <li><a href="#contact" class="text-gray-300 hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Cookie Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Connect</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white">
                            <span class="sr-only">Facebook</span>
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white">
                            <span class="sr-only">Twitter</span>
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white">
                            <span class="sr-only">Instagram</span>
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white">
                            <span class="sr-only">LinkedIn</span>
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} EduPath. All rights reserved.</p>
                <div class="mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white text-sm mr-4">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile menu toggle script -->
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('block');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            
            if (!mobileMenu.contains(event.target) && event.target !== mobileMenuButton) {
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.remove('block');
            }
        });
    </script>
</body>
</html>
