<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Tally') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Figtree:wght@400;500;600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .font-fraunces { font-family: 'Fraunces', serif; }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex items-center justify-center bg-[#F6F3EA] p-4 sm:p-6">
            <div class="w-full max-w-4xl grid grid-cols-1 md:grid-cols-2 bg-white border border-[#E4E0D3] rounded-2xl shadow-sm overflow-hidden">

                <!-- Left: branding panel -->
                <div class="hidden md:flex flex-col justify-between bg-[#17231F] text-[#F6F3EA] p-10">
                    <div class="flex items-center gap-2">
                        <span style="display:flex; align-items:center; justify-content:center; width:30px; height:30px; border-radius:7px; background-color:#C99A3A; color:#17231F; font-weight:700; font-size:16px;">T</span>
                        <span class="font-fraunces font-bold text-xl">Tally</span>
                    </div>

                    <div class="my-10">
                        <p class="font-fraunces text-3xl leading-snug font-medium">
                            Know where every dollar went, without opening a spreadsheet.
                        </p>
                    </div>

                    <div class="space-y-0">
                        <div class="flex justify-between py-2 text-sm border-b border-dashed border-white/20" style="font-family: monospace;">
                            <span>Salary — Aug</span><span class="text-[#B7D8C6]">+3,200.00</span>
                        </div>
                        <div class="flex justify-between py-2 text-sm border-b border-dashed border-white/20" style="font-family: monospace;">
                            <span>Rent</span><span class="text-[#E3B39F]">-1,450.00</span>
                        </div>
                        <div class="flex justify-between py-2 text-sm border-b border-dashed border-white/20" style="font-family: monospace;">
                            <span>Groceries</span><span class="text-[#E3B39F]">-186.40</span>
                        </div>
                        <div class="flex justify-between py-2 text-sm" style="font-family: monospace;">
                            <span>Freelance</span><span class="text-[#B7D8C6]">+540.00</span>
                        </div>
                    </div>

                    <div class="text-xs text-white/40 mt-10">
                        CST8257 · Web Applications Development
                    </div>
                </div>

                <!-- Right: form panel -->
                <div class="flex flex-col justify-center p-8 sm:p-10">
                    <div class="flex md:hidden items-center gap-2 mb-8 justify-center">
                        <span style="display:flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:7px; background-color:#C99A3A; color:#17231F; font-weight:700; font-size:16px;">T</span>
                        <span class="font-fraunces font-bold text-xl text-[#17231F]">Tally</span>
                    </div>

                    {{ $slot }}
                </div>

            </div>
        </div>
    </body>
</html>