<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use App\Livewire\Roles;
use App\Models\Sale;
use Spatie\Permission\Models\Role;

class Users extends Component
{
    use WithPagination, LivewireAlert, WithFileUploads;

    public $tempImage;
    public $name, $phone, $email, $username, $status, $image, $password, $selected_id, $fileLoaded, $role, $profile;
    public $componentName, $pageTitle, $roleName, $searchengine, $guard_name, $rolesList, $currentImage;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Usuarios';
        $this->status = 'Elegir';
    }

    public function render()
    {
        if (strlen($this->searchengine) > 0) {
            $users = User::where('name', 'like', '%' . $this->searchengine . '%')
                ->select('*')->orderBy('name', 'asc')->paginate($this->pagination);
        } else {
            $users = User::select('*')->orderBy('name', 'asc')->paginate($this->pagination);
        }

        $valores = $this->valoresFiltro();

        return view('livewire.users.users', [
            'roles' => Role::orderBy('name', 'asc')->get(),
            'users' => $users,
            'valores' => $valores
        ]);
    }

    public function valoresFiltro()
    {
        $valores = User::pluck('profile')->unique()->toArray();
        return $valores;
    }

    public function create()
    {
        $this->reset('name', 'image', 'phone', 'email', 'username', 'profile', 'status', 'password');
        $this->resetUI();
    }

    public function Store()
    {
        $this->validate([
            'name' => 'required|min:3',
            'username' => 'required|unique:users,username|min:3',
            'email' => 'required|unique:users|email',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3',
            'phone' => 'required|min:3',
        ]);

        $imagePath = $this->image ? $this->image->store('users') : null;

        $user = User::create([
            'name' => $this->name,
            'username' => $this->username,
            'image' => $imagePath,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'profile' => $this->profile,
            'password' => bcrypt($this->password),
        ]);

        $user->syncRoles($this->profile);

        $this->resetUI();
        $this->alert('success', 'Created Successfully');
        $this->dispatch('user-added', 'Usuario Registrado');
    }

    public function edit(User $user)
    {
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->password = $user->password;
        $this->phone = $user->phone;
        $this->image = $user->image;
        $this->tempImage = null;
        $this->status = $user->status;
        $this->profile = $user->profile;
        $this->dispatch('show-modal', 'Show modal');
    }

    public function Update()
    {
        $this->validate([
            'name' => 'required|min:3',
            'username' => 'required|unique:users,username,' . $this->selected_id,
            'email' => 'required|email|unique:users,email,' . $this->selected_id,
            'phone' => 'required|min:3',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3'
        ]);

        if ($this->selected_id) {
            $user = User::find($this->selected_id);

            $data = [
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'phone' => $this->phone,
                'status' => $this->status,
                'profile' => $this->profile,
                'password' => bcrypt($this->password),
            ];

            if ($this->tempImage) {
                $data['image'] = $this->tempImage->store('users');
            }

            $user->update($data);
            $user->syncRoles($this->profile);

            $this->alert('success', 'Updated Successfully');
            $this->resetUI();
            $this->dispatch('user-updated', 'User Actualizado');
        }
    }

    public function delete($id)
    {
        $this->selected_id = $id;
        $this->alert('warning', '¿Estás seguro de que quieres eliminar?', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'confirmedDeletion',
            'showCancelButton' => true,
            'onDismissed' => '',
            'showDenyButton' => false,
            'onDenied' => '',
            'timerProgressBar' => false,
            'width' => '400',
        ]);
    }

    public function confirmedDeletion()
    {
        logger('confirmedDeletion called, ID: ' . $this->selected_id);

        $user = User::find($this->selected_id);
        if ($user) {
            $sales = Sale::where('user_id', $user->id)->count();
            if ($sales > 0) {
                $this->alert('warning', 'El usuario no puede ser eliminado porque tiene ventas registradas.');
            } else {
                $user->delete();
                $this->resetUI();
                $this->alert('success', 'El usuario ha sido eliminado.');
            }
        }
    }

    protected $listeners = [
        'confirmedDeletion',
        'resetUI'
    ];

    public function resetUI()
    {
        $this->profile = '';
        $this->name = '';
        $this->username = '';
        $this->email = '';
        $this->password = '';
        $this->phone = '';
        $this->image = '';
        $this->searchengine = '';
        $this->status = 'Elegir';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}