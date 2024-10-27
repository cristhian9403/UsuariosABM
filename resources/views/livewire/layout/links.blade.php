<x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
    <i class="fa-solid fa-house mr-2 text-sm"></i> {{ __('Dashboard') }}
</x-nav-link>

<x-nav-link :href="route('users')" :active="request()->routeIs('users')">
    <i class="fa-solid fa-users mr-2 text-sm"></i> {{ __('Usuarios') }}
</x-nav-link>

<x-nav-link :href="route('profile')" :active="request()->routeIs('profile')" wire:navigate>
    <i class="fa-solid fa-address-card mr-2 text-sm"></i> {{ __('Perfil') }}
</x-nav-link>



