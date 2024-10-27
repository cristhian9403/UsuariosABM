<div class="space-y-6">
    <!-- Form -->
    <div class="bg-white p-4 ">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input wire:model="name" id="name" class="block mt-1 w-full uppercase" type="text" name="name" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <!-- Telefono -->
            <div>
                <x-input-label for="telefono" :value="__('Télefono')" />
                <x-text-input wire:model="telefono" id="telefono" class="block mt-1 w-full" type="text" name="telefono" required autocomplete="telefono" min="1" step="1" />
                <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
            </div>
             <!-- Role -->
             <div>
                <x-select-rol :roles="$roles" />
            </div>
            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-password-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-password-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
           
            <!-- Status -->
            <div>
                <x-input-label for="is_active" :value="__('Select') . ' ' . strtolower(__('Status')) . ':'" />
                <x-select-option wire:model="is_active" id="is_active" :disabled="false" :options="['1' => __('Active'), '0' => __('Inactive')]" class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
            </div>
        </div>
    </div>
</div>
