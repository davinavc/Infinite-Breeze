<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="crsf-token">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Infinite Breeze</title>

        <!-- Fonts -->

        <link rel="icon" href="img/logo.jpg" type="image/icon type">
        <link rel="stylesheet"  href="css/styleadmin.css" />
        <link href="'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap'" rel="stylesheet" />

        
    </head>
    <body>
        <x-auth-session-status class="mb-4" :status="session('status')"/>
            <div class="wrapper">
                
                <span class="bg-animate"></span>
                <span class="bg-animate2"></span>

                <!-- Login Section -->
                <div class="form-box login">
                    <h2 class="animation" style="--i:0; --j:0;">Login.</h2>
                    <form method="POST" action="{{ route('login') }}" >
                    @csrf  
                    <!-- Email -->
                    <div class="input-box animation" style="--i:1; --j:1;">
                        <h3>Email</h3>
                        <x-input-label for="email" />
                        <x-text-input id="email" type="email" name="email" required autofocus autocomplete="email" placeholder="sam07@gmail.com" />
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2zm-2 0l-8 5l-8-5zm0 12H4V8l8 5l8-5z"/></svg>
                        <x-input-error :messages="$errors->get('email')" class="input-error" />
                    </div>
                    <!-- Password -->
                    <div class="input-box animation" style="--i:2; --j:3;">
                        <h3>Password</h3>
                        <x-input-label for="password" />
                        <x-text-input id="password" type="password" name="password" required autocomplete="off" placeholder="........" />
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M6 22q-.825 0-1.412-.587T4 20V10q0-.825.588-1.412T6 8h1V6q0-2.075 1.463-3.537T12 1t3.538 1.463T17 6v2h1q.825 0 1.413.588T20 10v10q0 .825-.587 1.413T18 22zm0-2h12V10H6zm6-3q.825 0 1.413-.587T14 15t-.587-1.412T12 13t-1.412.588T10 15t.588 1.413T12 17M9 8h6V6q0-1.25-.875-2.125T12 3t-2.125.875T9 6zM6 20V10z"/></svg>
                        <x-input-error :messages="$errors->get('password')" class="input-error mt-2" />
                    </div>

                        <!-- Submit Button -->
                        <x-primary-button type="submit" class="btn animation" style="--i:3; --j:14;"> {{ __('Log in') }}</x-primary-button>

                    <!-- Forgot Password -->
                    <div class="logpass-link animation" style="--i:5; --j:6;">
                        @if (Route::has('password.request'))
                            <p>
                                <a href="{{ route('password.request') }}" class="forgetpass-link" >Forgot Password?</a>
                            </p>
                        @endif
                    </div>
                        <div class="logreg-link animation" style="--i:5; --j:6;">
                            <p>Don't have an account? <a href="{{ route('register') }}" class="register-link">Sign Up</a></p>
                        </div>
                        </form>
                    </div>
                    <div class="info-text login">
                        <div class="midlogo" >
                            <img class="animation" style="--i:0; --j:4;" src="img/logo_white.png" alt="logo">
                        </div> 
                        <h2 class="animation" style="--i:2; --j:6;">Enter Your Event Dashboard</h2>
                        <p class="animation" style="--i:3; --j:8;">Manage all your events seamlessly with our platform. Log in to start organizing, tracking, and enhancing your event experience.</p>
                    </div>
            </div>
            <script src="js/script.js"></script>
    </body>
</html>
