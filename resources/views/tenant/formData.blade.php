<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="crsf-token">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Infinite Breeze</title>

        <!-- Fonts -->

        <link rel="icon" href="{{ asset('img/logo.jpg') }}" type="image/icon type">
        <link rel="stylesheet"  href="{{ asset('css/styleadmin.css') }}" />
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    </head>
    <body>
        <div class="wrapper">
                    
            <div class="form-box dataform">
                <h2 class="">Sign Up.</h2>
                <form method="POST" action="{{ route('tenant.store') }}" enctype="multipart/form-data">
                @csrf
                <!-- Email -->
                <div class="form-columns">
                    <div class="input-box">
                        <h3>Brand Name</h3>
                        <input id="tenant_name" type="text" name="tenant_name" required autofocus placeholder="Bebas Makan">
                        <span class="material-symbols-outlined">id_card</span>
                        <x-input-error :messages="$errors->get('tenant_name')"/>
                    </div>
                        
                    <!-- Alamat -->
                    <div class="input-box">
                        <h3>Brand Category</h3>
                        <input id="category_name" type="text" name="category_name" required placeholder="Thailand Food">
                        <span class="material-symbols-outlined">category</span>
                        <x-input-error :messages="$errors->get('category_name')" />
                    </div>
                        
                    <!-- Bank -->
                    <div class="input-box">
                        <h3>Bank</h3>
                        <input id="nama_bank" type="text" name="nama_bank" required placeholder="BCA">
                        <span class="material-symbols-outlined">account_balance</span>
                        <x-input-error :messages="$errors->get('nama_bank')" />
                    </div>

                    <!-- Rekening -->
                    <div class="input-box" >
                        <h3>Rekening</h3>
                        <input id="rekening" type="text" name="rekening" required placeholder="12 digit">
                        <span class="material-symbols-outlined">credit_card</span>
                        <x-input-error :messages="$errors->get('rekening')" />
                    </div>

                    <!-- Alamat -->
                    <div class="input-box">
                        <h3>Alamat</h3>
                        <textarea id="alamat" name="alamat" required placeholder="Jl. Sudirman"></textarea>
                        <span class="material-symbols-outlined">location_on</span>
                        <x-input-error :messages="$errors->get('alamat')" />
                    </div>

                    <!-- Logo -->
                    <div class="input-box-no">
                        <h3>Logo</h3>
                        <input id="logo" type="file" name="logo" required>
                        <x-input-error :messages="$errors->get('logo')" />
                    </div>
                </div>
                <!-- Role -->
                <input type="hidden" name="role" value="Tenant">

                <!-- Submit Button -->
                    <button type="submit" class="btn animation">Save</button>
                </form>
            </div>
        </div>
        <script src="js/script.js"></script>
    </body>
</html>
