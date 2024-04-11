@extends('layouts.landing')

@section('content') 
<div class="h-full flex justify-center">

    <div class="h-screen flex lg:flex flex-row w-full h-screen">
        <div class="flex bg-cover bg-center h-full lg:w-1/2 flex flex-col bg-cover bg-center h-full" style="background-image: url('images/landing/library.jpg');">
            <div class="flex items-center justify-center h-screen">
                <div class="items-center pb-96 lg:pb-2 flex flex-col items-center sm:flex flex-col items-center">
                    <img class="w-24 lg:w-80 mb-3" src="images/CvSU-logo.png" alt="cvsu logo">
                        <div class=" align-text-top pb-28 text-center lg:text-center text-white mb-2">
                            <p class="font-bold text-lg md:text-2xl  lg:text-2xl">CAVITE STATE UNIVERSITY <br> LIBRARY SYSTEM</p>
                            <p class="text-white font-semibold text-lg">Control Center</p>
                        </div>
                        <!--forms-->
                     <div class="p-8 py-0 px-px pt-2 bg-white text-center rounded-2xl shadow-inner border border-gray-2 lg:hidden">
                        <div>
                            <h1 class="text-2xl font-medium text-center mb-2 mt-3 text-gray-700">Self-Registration for Librarians<br>Accessing the CvSU Integrated Library System-Control Center<br>
                                    <span class="text-base font-normal"><i>(For librarian of CvSU only)</i></span>
                            </h1>
                            <hr class="mb-2">
                            <p class="text-center text-lg mb-6 p-2 font-semibold text-gray-700 tracking-wide">
                                    
                                    The CvSU Control Center intelligently adapts based on your login information. Whether you're a librarian or library staff member, 
                                    it dynamically presents the tools you need for managing book borrowing, returning, and other essential library tasks
                                     within the Ladislao N. Diwa Memorial Library system.</p>
                        </div>
                        <div class="flex items-center justify-center ">
                            <a href="{{ url('auth/google') }}"                 
                                class="px-4 py-2 border flex gap-2 border-slate-200 rounded-lg text-slate-700 hover:border-slate-400 hover:text-slate-900 hover:shadow transition duration-150">
                                <img class="w-6 h-6" src="images/CvSU-logo-64x64.webp"
                                    loading="lazy" alt="google logo">
                                <span class="text-gray-700">Register with Google</span>
                            </a>
                        </div>
                        <br>
                        <a class ="text-gray-700"href="{{ url('auth/google') }}"><small>Click here if you already have an account.</small></a>
                        </div>

                        <div class="absolute bottom-0 text-center p-4 ml-4 sm:ml-10 md:ml-44 lg:hidden">
                            <p class="text-base font-medium text-white ">© Copyright 2022 Cavite State University | 
                                Integrated Library System</p>
                        </div>

                </div>
            </div>
        </div>
        <!-- right side -->
        <div class="hidden lg:block w-1/2 flex flex-col">
            <div class="flex h-full justify-center items-center space-y-8 bg-[#F6FFF1]">
                <div class="text-center rounded-3xl px-16">
                    <div class="py-8 px-8 pt-2 bg-white rounded-2xl shadow-xl z-20 border border-gray-2 00">
                        <div>
                            <h1 class="text-2xl font-medium text-center mb-2 mt-3">Self-Registration for Librarians<br>Accessing the CvSU Integrated Library System-Control Center<br>
                                <span class="text-base font-normal"><i>(For librarian of CvSU only)</i></span>
                            </h1>
                            <hr class="mb-2">
                            <p class="text-center text-lg mb-6 p-2 font-semibold text-gray-700 tracking-wide">
                                
                                The CvSU Control Center intelligently adapts based on your login information. Whether you're a librarian or library staff member, 
                                it dynamically presents the tools you need for managing book borrowing, returning, and other essential library tasks
                                 within the Ladislao N. Diwa Memorial Library system.</p>
                        </div>
                        <div class="flex items-center justify-center ">
                            <a href="{{ url('auth/google') }}"                 
                                class="px-4 py-2 border flex gap-2 border-slate-200 rounded-lg text-slate-700 hover:border-slate-400 hover:text-slate-900 hover:shadow transition duration-150">
                                <img class="w-6 h-6" src="images/CvSU-logo-64x64.webp"
                                    loading="lazy" alt="google logo">
                                <span class="text-gray-700">Register with Google</span>
                            </a>
                           
                        </div>

                        <br>
                        <a href="{{ url('auth/google') }}"><small>Click here if you already have an account.</small></a>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-0 text-center p-4 ml-10 lg:absolute bottom-0 text-center p-4 ml-2">
                <p class="text-base font-medium text-gray-700">© Copyright 2022 Cavite State University | 
                    Integrated Library System</p>
            </div>
        </div>
        <div class="hidden lg:block flex-none absolute bottom-0 right-0">
            <img src="images/landing/laya at diwa - Edited.png" alt="Image" class="w-auto h-96 opacity-40" />
        </div>
    </div>
</div>
@endsection