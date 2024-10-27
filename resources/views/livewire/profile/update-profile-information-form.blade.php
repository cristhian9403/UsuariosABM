<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public $telefono= '';
    public $new_password;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->telefono = Auth::user()->telefono;
    }


    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'telefono' => ['required', 'string'],
            'new_password' => 'nullable|string|min:8',
        ]);

        if ($this->new_password) {
            $validated['password'] = Hash::make($this->new_password);
        }


        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>
    <div style="display: flex; justify-content: space-between">
        <div style="width: 36rem">
            <form wire:submit.prevent="updateProfileInformation" class="mt-6 space-y-6" enctype="multipart/form-data">
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full"
                        required  autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input wire:model="email" id="email" name="email" type="email"
                        class="mt-1 block w-full" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                        <div>
                            <p class="text-sm mt-2 text-gray-800">
                                {{ __('Your email address is unverified.') }}
                                <button wire:click.prevent="sendVerification"
                                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
               
                <div>
                    <x-input-label for="telefono" :value="__('Télefono')" />
                    <x-text-input wire:model="telefono" id="telefono" name="telefono" type="text"
                        class="mt-1 block w-full" required autocomplete="telefono"/>
                    <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
                </div>
                <div>
                    <x-input-label for="new_password" :value="__('Nueva Contraseña')" />
                    <x-text-input wire:model.defer="new_password" id="new_password" name="new_password" type="password" 
                        class="mt-1 block w-full" />
                    <x-input-error class="mt-2" :messages="$errors->get('new_password')" />
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                    <x-action-message class="me-3" on="profile-updated">
                        {{ __('Saved.') }}
                    </x-action-message>
                </div>
            </form>
        </div>        
    </div>
</section>
