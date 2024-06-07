<x-guest-layout>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="https://cdn-icons-png.flaticon.com/512/6330/6330400.png" class="img-fluid" alt="Phone image">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="mt-4">
                        @csrf
                        <!-- username input -->
                        <div class="form-outline mb-4">
                            <label for="username">{{ __('Usuario:') }}</label>
                            <input type="username" id="username" class="form-control" name="username"
                                :value="old('username')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <label for="password">{{ __('Contraseña:') }}</label>
                            <input type="password" id="password" class="form-control" name="password" required
                                autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="d-flex justify-content-around align-items-center mb-4">
        

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary ml-3">
                                {{ __('Iniciar Sesión') }}
                            </button>


                    </form>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
