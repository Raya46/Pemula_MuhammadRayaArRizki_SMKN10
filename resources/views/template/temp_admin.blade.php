<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>EFintech</title>
</head>

<body>
    @if (Auth::user()->roles_id == 1)
        <div class="flex flex-col lg:flex-row navbar bg-base-100 fixed top-0">
            <div class="flex-1">
                <a href="/" class="btn btn-ghost text-xl">EFintech</a>
            </div>
            <div class="flex-none">
                <ul class="menu menu-horizontal px-1">
                    @if (Auth::user()->roles_id == 1)
                        <li><a href="/history">History</a></li>
                        <li><a href="/transaksi-harian">Transaksi Harian</a></li>
                        <li><a href="/cart">Cart</a></li>
                        <li><a href="/logout">Logout</a></li>
                    @elseif (Auth::user()->roles_id == 2)
                        <li><a href="/history">History</a></li>
                        <li><a href="/transaksi-harian">Transaksi Harian</a></li>
                        <li><a href="/logout">Logout</a></li>
                    @else
                        <li><a href="/transaksi-harian">Transaksi Harian</a></li>
                        <li><a href="/logout">Logout</a></li>
                    @endif

                </ul>
            </div>
        </div>
        <div class="mb-24 lg:mb-14"></div>
        @yield('content')
    @else
        <div class="grid min-h-screen w-full lg:grid-cols-[280px_1fr]">
            <div class="border-r shadow-lg lg:block">
                <div class="flex h-full max-h-screen flex-col gap-2">
                    <div class="flex h-[60px] items-center border-b px-6">
                        <a class="hidden lg:flex items-center gap-2 font-semibold" href="#"><a href="/"
                                class="font-bold">EFintech</a></a>
                    </div>
                    <div class="flex-1 overflow-auto py-2">
                        <nav class="grid items-start px-4 text-sm font-medium">
                            @if (Auth::user()->roles_id == 2)
                                <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-900"
                                    href="/"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                    Home
                                </a>
                                <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-900"
                                    href="/transaksi-harian"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                        <path d="M3 3v18h18"></path>
                                        <path d="m19 9-5 5-4-4-3 3"></path>
                                    </svg>
                                    Reports
                                </a>
                                <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-900"
                                    href="/history"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                        height="16" fill="currentColor" class="bi bi-clock-history"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z" />
                                        <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z" />
                                        <path
                                            d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5" />
                                    </svg>
                                    History
                                </a>
                                <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-900"
                                    href="/confirm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                                      </svg>
                                    Confirm
                                </a>
                                <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-900"
                                    href="/logout"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                    Logout
                                </a>
                            @elseif(Auth::user()->roles_id == 4)
                                <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-900"
                                    href="/"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                    Home
                                </a>
                                <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-900"
                                    href="/transaksi-harian"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="h-4 w-4">
                                        <path d="M3 3v18h18"></path>
                                        <path d="m19 9-5 5-4-4-3 3"></path>
                                    </svg>
                                    Reports
                                </a>
                                <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-900"
                                    href="/category"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                        height="16" fill="currentColor" class="bi bi-dropbox"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M8.01 4.555 4.005 7.11 8.01 9.665 4.005 12.22 0 9.651l4.005-2.555L0 4.555 4.005 2zm-4.026 8.487 4.006-2.555 4.005 2.555-4.005 2.555zm4.026-3.39 4.005-2.556L8.01 4.555 11.995 2 16 4.555 11.995 7.11 16 9.665l-4.005 2.555z" />
                                    </svg>
                                    Category
                                </a>
                                <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-900"
                                    href="/role"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                        height="16" fill="currentColor" class="bi bi-person-fill-gear"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4m9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0" />
                                    </svg>
                                    Role
                                </a>
                                <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-900"
                                    href="/logout"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="h-4 w-4">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                    Logout
                                </a>
                            @else
                                <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-900"
                                    href="/"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="h-4 w-4">
                                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                    Home
                                </a>
                                <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-900"
                                    href="/transaksi-harian"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="h-4 w-4">
                                        <path d="M3 3v18h18"></path>
                                        <path d="m19 9-5 5-4-4-3 3"></path>
                                    </svg>
                                    Reports
                                </a>
                                <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-900"
                                    href="/logout"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="h-4 w-4">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                    Logout
                                </a>
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
            <div class="flex flex-col">
                <header class="flex shadow-sm h-14 lg:h-[60px] items-center gap-4 border-b px-6"><a class="lg:hidden"
                        href="#"><span class="sr-only">Home</span></a>
                </header>
                @yield('content')

            </div>
        </div>
    @endif

</body>

</html>
