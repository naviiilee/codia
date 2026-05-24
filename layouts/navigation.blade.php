{{-- resources/views/components/navigation-bar.blade.php --}}

<nav class="bg-white shadow-lg border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo/Brand -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                    <img class="h-8 w-8" src="{{ asset('images/logo.png') }}" alt="Logo">
                    <span class="ml-2 text-xl font-bold text-gray-900">{{ config('app.name', 'Laravel') }}</span>
                </a>
            </div>

            <!-- Desktop Navigation Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <!-- Navigation Links -->
                <div class="flex items-center space-x-8">
                    @auth
                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                            Dashboard
                        </x-nav-link>
                        
                        @if(auth()->user()->can('viewAny', App\Models\Post::class))
                            <x-nav-link href="{{ route('posts.index') }}" :active="request()->routeIs('posts.*')">
                                Posts
                            </x-nav-link>
                        @endif
                        
                        @can('viewAny', App\Models\User::class)
                            <x-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.*')">
                                Users
                            </x-nav-link>
                        @endcan
                    @else
                        <x-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                            Login
                        </x-nav-link>
                        <x-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
                            Register
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <!-- Desktop Right Section -->
            <div class="hidden md:flex items-center space-x-4">
                <!-- Search (Optional) -->
                <div class="relative">
                    <input type="text" placeholder="Search..." 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- User Menu -->
                @auth
                    <div class="relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-full">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}">
                                    <span class="ml-2 hidden sm:inline">{{ auth()->user()->name }}</span>
                                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link href="{{ route('profile.edit') }}">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                @if(auth()->user()->can('viewAny', App\Models\Post::class))
                                    <x-dropdown-link href="{{ route('posts.index') }}">
                                        {{ __('Manage Posts') }}
                                    </x-dropdown-link>
                                @endif

                                <x-dropdown-link href="{{ route('profile.settings') }}">
                                    {{ __('Settings') }}
                                </x-dropdown-link>

                                <hr class="my-2 border-gray-200">

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button @click="open = ! open" 
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" x-show="!open" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg class="hidden h-6 w-6" x-show="open" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div x-data="{ open: false }" @close.window="open = false" class="md:hidden" x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-gray-200">
            @auth
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    Dashboard
                </x-responsive-nav-link>

                @if(auth()->user()->can('viewAny', App\Models\Post::class))
                    <x-responsive-nav-link href="{{ route('posts.index') }}" :active="request()->routeIs('posts.*')">
                        Posts
                    </x-responsive-nav-link>
                @endif

                @can('viewAny', App\Models\User::class)
                    <x-responsive-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.*')">
                        Users
                    </x-responsive-nav-link>
                @endcan
            @else
                <x-responsive-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                    Login
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
                    Register
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Mobile User Menu -->
        @auth
            <div class="pt-4 pb-3 border-t border-gray-200 bg-gray-50">
                <div class="px-4 flex items-center">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}">
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-900">{{ auth()->user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 px-2 space-y-1">
                    <x-responsive-nav-link href="{{ route('profile.edit') }}">
                        Profile
                    </x-responsive-nav-link>

                    @if(auth()->user()->can('viewAny', App\Models\Post::class))
                        <x-responsive-nav-link href="{{ route('posts.index') }}">
                            Manage Posts
                        </x-responsive-nav-link>
                    @endif

                    <x-responsive-nav-link href="{{ route('profile.settings') }}">
                        Settings
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            Log Out
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
        @endauth
    </div>
</nav>