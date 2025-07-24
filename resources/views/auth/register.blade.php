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
        <div class="wrapper active">
                    
            <span class="bg-animate"></span>
            <span class="bg-animate2"></span>

            <div class="form-box register">
                <h2 class="animation" style="--i:7; --j:0;">Sign Up.</h2>
                <form method="POST" action="{{ route('register') }}" autocomplete="off">
                @csrf
                <!-- Email -->
                <div class="input-box animation" style="--i:8; --j:1;">
                        <h3>Email</h3>
                        <x-input-label for="email" />
                        <x-text-input id="email" type="email" name="email" required autofocus autocomplete="off" placeholder="sam07@gmail.com" />
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2zm-2 0l-8 5l-8-5zm0 12H4V8l8 5l8-5z"/></svg>
                        <x-input-error :messages="$errors->get('email')" class="input-error" />
                    </div>
                    
                <!-- No Telp -->
                <div class="input-box animation" style="--:20; --j:3;">
                        <h3>Phone Number</h3>
                        <x-input-label for="no_telp" />
                        <x-text-input id="no_telp" class="block mt-1 w-full" type="text" name="no_telp" :value="old('no_telp')" required autofocus autocomplete="off" placeholder="62xxxxxxxxx" />
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M6 22q-.825 0-1.412-.587T4 20V10q0-.825.588-1.412T6 8h1V6q0-2.075 1.463-3.537T12 1t3.538 1.463T17 6v2h1q.825 0 1.413.588T20 10v10q0 .825-.587 1.413T18 22zm0-2h12V10H6zm6-3q.825 0 1.413-.587T14 15t-.587-1.412T12 13t-1.412.588T10 15t.588 1.413T12 17M9 8h6V6q0-1.25-.875-2.125T12 3t-2.125.875T9 6zM6 20V10z"/></svg>
                        <x-input-error :messages="$errors->get('no_telp')" class="input-error" />
                    </div>
                    
                <!-- Password -->
                    <div class="input-box animation" style="--i:9; --j:2;">
                        <h3>Password</h3>
                        <x-input-label for="password" />
                        <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="........" />
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M6 22q-.825 0-1.412-.587T4 20V10q0-.825.588-1.412T6 8h1V6q0-2.075 1.463-3.537T12 1t3.538 1.463T17 6v2h1q.825 0 1.413.588T20 10v10q0 .825-.587 1.413T18 22zm0-2h12V10H6zm6-3q.825 0 1.413-.587T14 15t-.587-1.412T12 13t-1.412.588T10 15t.588 1.413T12 17M9 8h6V6q0-1.25-.875-2.125T12 3t-2.125.875T9 6zM6 20V10z"/></svg>
                        <x-input-error :messages="$errors->get('password')" class="input-error" />
                    </div>

                <!-- Confirm Password -->
                    <div class="input-box animation" style="--i:10; --j:3;">
                        <h3>Confirm Password</h3>
                        <x-input-label for="password_confirmation" />
                        <x-text-input id="password_confirmation"
                            type="password"
                            name="password_confirmation" required autocomplete="off" placeholder="........" />
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M6 22q-.825 0-1.412-.587T4 20V10q0-.825.588-1.412T6 8h1V6q0-2.075 1.463-3.537T12 1t3.538 1.463T17 6v2h1q.825 0 1.413.588T20 10v10q0 .825-.587 1.413T18 22zm0-2h12V10H6zm6-3q.825 0 1.413-.587T14 15t-.587-1.412T12 13t-1.412.588T10 15t.588 1.413T12 17M9 8h6V6q0-1.25-.875-2.125T12 3t-2.125.875T9 6zM6 20V10z"/></svg>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="input-error" />
                    </div>

                
                <!-- Role -->
                <input type="hidden" name="role" value="Tenant">

                <!-- Submit Button -->
                    <button type="submit" class="btn animation" style="--i:11; --j:4;">Sign Up</button>
                    <div class="logreg-link animation" style="--i:22; --j:5;">
                        <p>Already have an account? <a href="{{ route('login') }}" class="login-link">Login</a></p>
                    </div>
                </form>
            </div>
            <div class="info-text register">
                <div class="midlogo" style="--i:0; --j:0;">
                    <img class="animation" src="img/logo_white.png" alt="logo">
                </div>
                <h2 class="animation" style="--i:1; --j:1;">Enter Your Event Dashboard</h2>
                <p class="animation" style="--i:2; --j:2;">Manage all your events seamlessly with our platform. Log in to start organizing, tracking, and enhancing your event experience.</p>
            </div>
        </div>
        <script src="js/script.js"></script>
    </body>
</html>
