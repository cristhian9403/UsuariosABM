<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Users') }}
    </h2>
    <x-breadcrumbs :breadcrumbs="[['title' => 'Inicio', 'url' => route('dashboard')], ['title' => 'Usuarios', 'url' => null]]" />
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-user')">
                {{ __('Add new') }} </x-primary-button>

            <div class="max-w-full overflow-x-auto mt-6" style="overflow-x: auto; overflow-y: hidden">
                <x-datatable />
                <table class="w-full bg-white border border-gray-200 mt-6" id="DataTable">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-sm leading-normal">
                            <th class="py-2 px-6 text-left">{{ __('Name') }}</th>
                            <th class="py-2 px-6 text-left">{{ __('Email') }}</th>
                            <th class="py-2 px-6 text-left">{{ __('Télefono') }}</th>
                            <th class="py-2 px-6 text-left">{{ __('Rol') }}</th>
                            <th class="py-2 px-6 text-left">{{ __('Status') }}</th>
                            <th class="py-2 px-6 text-center">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($users as $user)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-2 px-6 text-left text-gray-900 flex items-center">
                                    {{ strtoupper($user->name) }}
                                </td>
                                <td class="py-2 px-6 text-left">{{ $user->email }}</td>
                                <td class="py-2 px-6 text-left">{{ $user->telefono }}</td>
                                <td class="py-2 px-6 text-left">{{ strtoupper(__($user->getRoleNames()->first())) }}
                                </td>
                                <td class="py-2 px-6 text-left">
                                    @if ($user->is_active)
                                        <span
                                            style="display: inline-block; width: 10px; height: 10px; background-color: green; border-radius: 50%; margin-right: 5px;"></span>
                                        {{ __('Active') }}
                                    @else
                                        <span
                                            style="display: inline-block; width: 10px; height: 10px; background-color: #C00000; border-radius: 50%; margin-right: 5px;"></span>
                                        {{ __('Inactive') }}
                                    @endif
                                </td>
                                <td class="py-2 px-6 flex space-x-4 text-center justify-center">

                                    <a wire:click.prevent="viewUser('{{ $user->id }}')"
                                        x-on:click="$dispatch('open-modal', 'update-user')" class="cursor-pointer"
                                        title="{{ __('Update') . ' ' . strtolower(__('User')) }}">
                                        <i class="fa-solid fa-user-pen text-xl"></i>
                                    </a>


                                    <a class="cursor-pointer" wire:click.prevent="changeStatus({{ $user }})"
                                        title="{{ __('Switch') . ' ' . strtolower(__('Status')) }}">
                                        <i class="fa-solid fa-rotate text-xl"></i>
                                    </a>

                                    <a class="cursor-pointer" onclick="confirmDeleteUser({{ $user }})"
                                        title="{{ __('Delete') . ' ' . strtolower(__('User')) }}">
                                        <i class="fa-solid fa-trash text-xl"></i>
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <x-modal name="create-user" focusable>
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 text-center mb-4 ">
                        {{ __('Add new') . ' ' . strtolower(__('User')) }}
                    </h2>
                    <form wire:submit.prevent="storeUser">
                        @include('livewire.user.form')
                        <div class="mt-6 flex justify-end">
                            <x-danger-button x-on:click="$dispatch('close')" wire:click="reload" type="button">
                                {{ __('Cancel') }}
                            </x-danger-button>

                            <x-primary-button class="ms-3" type="submit">
                                {{ __('Create') . ' ' . __('User') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </x-modal>



            <x-modal name="update-user" :show="$errors->isNotEmpty()">

                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-6 text-center">
                        {{ __('Update') . ' ' . strtolower(__('User')) }}
                    </h2>
                    @if ($selectUser)
                        <form wire:submit.prevent="updateUser">

                            @include('livewire.user.form')

                            <div class="mt-6 flex justify-end">
                                <x-danger-button x-on:click="$dispatch('close')" wire:click="reload" type="button">
                                    {{ __('Cancel') }}
                                </x-danger-button>

                                <x-primary-button class="ms-3" type="submit">
                                    {{ __('Update') . ' ' . __('User') }}
                                </x-primary-button>
                            </div>
                        </form>
                    @endif

                </div>
            </x-modal>
        </div>
    </div>

    @include('components.alert-component')




</div>

@push('js')
    <script>
        function confirmDeleteUser(user) {
            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡No podrás revertir esto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "¡Si, elimínalo!",
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/delete-user/${user['id']}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Content-Type': 'application/json'
                            },
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            Swal.fire({
                                title: "Deleted!",
                                text: "¡El usuario ha sido eliminado!",
                                icon: "success"
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        })
                        .catch(error => {
                            Swal.fire({
                                title: "Error!",
                                text: "Ups! Ocurrio un error al eliminar el usuario",
                                icon: "error"
                            });
                        });
                }
            });
        }
    </script>
@endpush
