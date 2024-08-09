<x-guest-layout>


    <x-authentication-card>
        

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession
        <div class="login-register-wrapper">
            <div class="container">
                <div class="member-area-from-wrap">
                    <div class="row">
                        <!-- Login Content Start -->
                        <div class="col-lg-6 col-10 mx-auto">
                
                            <div class="login-reg-form-wrap  pr-lg-50">
            
             <h2 class="text-center my-2">Sign In</h2>
                <a href="/" class="d-flex mx-auto">
                    <img src=" {{asset('assets/img/laracom.png')}} " alt="" class="mx-auto">
                </a>
                <a href="{{ route('auth.google') }}" class="d-flex my-3 mx-auto login-with-google-btn">
    Sign in with Google
</a>        
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="single-input-item">
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>
            <div class="single-input-item">
            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>
        
            <div class="single-input-item">
                                        <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                                            <div class="remember-meta">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"   name="remember" class="custom-control-input" id="rememberMe">
                                                    <label class="custom-control-label" for="rememberMe">{{ __('Remember me') }}</label>
                                                </div>
                                            </div>
                                            @if (Route::has('password.request'))
                                            <a href="#" class="forget-pwd">Forget Password?</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="single-input-item">
                                        <button class="sqr-btn">Login</button>
                                    </div>
           
            </div>
        </form>
                            </div>
                            </div>
                            </div>
                </div>
            </div>
        </div>
       
    </x-authentication-card>
</x-guest-layout>
