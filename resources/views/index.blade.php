<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>AWC</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<style>

    body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, Helvetica, sans-serif;
        }
    #headingLogo {
            font-family: 'cursive';
            text-transform: uppercase;
            text-align: center;
            font-size: 8rem;
            color: #2c3e50; /* Darker text color for contrast */
            text-shadow: 4px 4px 8px rgba(0, 0, 0, 0.4), 0 0 25px rgba(0, 0, 0, 0.2); /* Soft shadow effect */
            letter-spacing: 0.1em; /* Spacing between letters */
            font-weight: bold;
            background: linear-gradient(145deg, #ffffff, #f1f1f1); /* Gradient background */
            -webkit-background-clip: text; /* Clips the gradient to the text */
            border-radius: 8px; /* Optional: Rounded corners */
            padding: 10px 20px; /* Padding around the text */

        }
        #headingLogo:hover{
            font-family: 'vardana';
            color: #000000; /* Darker text color for contrast */
            text-shadow: 4px 4px 8px rgba(63, 102, 180, 0.4), 0 0 25px rgba(23, 23, 158, 0.2); /* Soft shadow effect */
            background: linear-gradient(145deg, #ffffff, #f1f1f1); /* Gradient background */
        }
</style>
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="container mt-2">
            <div class="row">
                <div class="col-10"></div>
                <div class="col-2">
                    @if (Route::has('login'))
                    <nav class="-mx-3 flex flex-1 justify-end">
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Dashboard
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Log in
                            </a>

                            @if (Route::has('register'))
                                {{-- <a
                                    href="{{ route('register') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Register
                                </a> --}}
                            @endif
                        @endauth
                    </nav>
                @endif
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h1 id="headingLogo">american wellness center</h1>
                </div>
            </div>
        </div>



    </body>
</html>
