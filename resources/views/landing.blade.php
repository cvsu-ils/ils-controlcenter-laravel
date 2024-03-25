@extends('layouts.landing')

@section('content')
    <div class="container-fluid h-screen"> 
        <div class="h-screen flex"> 
        <div class="md:w-1/2 bg-cover bg-center h-full" style="background-image: url('{{ asset('storage/images/landing/library.jpg') }}');">
            <div class="flex flex-col items-center justify-center h-full">
            <img class="w-300 mb-3" src="{{ asset('storage/images/CvSU-logo-64x64.webp') }}" alt="cvsu logo">
            <div class="text-center text-white">
                <p class="font-bold mb-2 text-50px">CAVITE STATE UNIVERSITY INTEGRATED LIBRARY SYSTEM</p>
                <p class="font-medium">Control Center</p>
            </div>
            </div>
        </div>

        <div class="md:w-1/2 flex flex-col justify-center bg-light"  style="display: flex; flex-direction: column; justify-content: center;"> 
            <div class="m-auto">
                <div class="text-center rounded-2xl p-4 bg-white shadow mb-90">
                    <form method="POST" action="#" id="loginForm">

                @csrf
                <div>
                    <div class="container mx-auto"> <div class="text-center">
                        <h1 class="text-3xl font-bold mb-2">Sign in Account</h1>
                        <p class="w-80 mx-auto text-sm mb-8 font-semibold text-gray-700 tracking-wide">
                        Lorem ipsum lorem ipsum
                        </p>
                    </div>
                    
                    <div class="text-center mt-6 "> 
                        <div class="text-center mt-6 "> 
                        <div class="mt-auto mr-auto text-center flex justify-center"> 
                        
                            <a href="{{ url('auth/google') }}" class="btn text-white flex fw-bolder p-2 rounded align-middle hoverable-button" style="background-color: #408c40;">
                            <div class="cvsu-google-icon-wrapper" style="background-color: white; border-radius: 10%;"> 
                                <img src="{{ asset('storage/images/CvSU-logo-64x64.webp') }}" style="height:30px" class="rounded mt-1 ml-1 mr-1 mb-1" alt="Sign in with Google"> 
                            </div>
                            <p class="btn-text mt-1 ml-1"><b> Sign in with CvSU Email</b></p>
                            </a> 
                            
                        </div>       
                    </div>                   
                    </div>
                    </div>
                </div>
                </form>
            </div>
            </div>

            <div class="mt-auto text-center py-2">
            <p class="text-gray-700"><b>
                © Copyright 2022 Cavite State University | 
                Integrated Library System</b>
            </p>
            </div>
            <div class="flex-none absolute bottom-0 right-0">
                <img src="{{ asset('storage/images/landing/laya at diwa - Edited.png') }}" alt="Image" class="w-auto h-96 opacity-40" />
            </div>
        </div>
        </div>
    </div>
@endsection