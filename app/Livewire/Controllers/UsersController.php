<?php

namespace App\Livewire\Controllers;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;





class UsersController extends Component
{
    public $users;
    public $selectUser;
    public $name = "";
    public $email = "";
    public $telefono = "";
    public $is_active = 1;
    public $roles;
    public $rol = "";
    public $password = '';
    public $password_confirmation = '';





    public function mount()
    {
        $this->users = User::all();
        $this->roles = Role::orderBy('name', 'asc')->pluck('name', 'id')->toArray();

    }
    public function reload()
    {
        $this->redirect(route('users', absolute: false), navigate: true);
    }

    public function storeUser()
    {
        $validator = Validator::make($this->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'is_active' => ['required', 'boolean'],
            'rol' => ['required', 'exists:roles,id'],
            'telefono' => ['required', 'string'],
        ]);


        $validated = $validator->validated();

        $validated['name'] = strtoupper($this->name);



        $validated['password'] = Hash::make($validated['password']);


        $user = User::create($validated);
        $role = Role::findOrFail($this->rol);
        $user->assignRole($role);
        $user->save();


        event(new Registered($user));


        $this->dispatch('alert', ['title' => __('¡Usuario creado exitosamente!'), 'type' => 'success', 'message' => '']);
        $this->dispatch('reload');

    }

    public function updateUser()
    {
        $user = $this->selectUser;
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'password' => ['nullable', 'string', 'confirmed', Rules\Password::defaults()],
            'is_active' => ['required', 'boolean'],
            'rol' => ['nullable', 'exists:roles,id'],
            'telefono' => ['required', 'string'],
        ]);
    
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
    
        $validated['name'] = strtoupper($this->name);

        $user->fill($validated);
        $user->save();
    
        
        $this->dispatch('alert', ['title' => __('¡Usuario actualizado con éxito!'), 'type' => 'success', 'message' => '']);
        $this->dispatch('reload');
    }
    
    public function viewUser($userId)
    {
        $this->selectUser = User::findOrFail($userId);
        $this->name = $this->selectUser->name;
        $this->email = $this->selectUser->email;
        $this->is_active = $this->selectUser->is_active;
        $this->rol = $this->selectUser->roles->first()->id ?? '';
        $this->telefono = $this->selectUser->telefono;

    }
    public function changeStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();


        $this->dispatch('toast', ['title' => __('Cambio de estado exitoso'), 'type' => 'info', 'message' => '']);
        $this->dispatch('reload');

    }

    public function deleteUser($userid)
    {
        $user = User::findOrFail($userid);
        $user->delete();



        return response()->json([
            'status' => 'success',
        ]);



    }


    public function render()
    {

        return view('livewire.user.index')->layout('layouts.app');
    }
}


