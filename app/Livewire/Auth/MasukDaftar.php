<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Masuk / Daftar Akun Warga — SAPA SOSIAL')]
class MasukDaftar extends Component
{
    public string $activeTab = 'masuk'; // masuk, daftar

    // Form Masuk
    public string $loginIdentifier = '';

    public string $password = '';

    public bool $remember = false;

    // Form Daftar
    public string $name = '';

    public string $nik = '';

    public string $phone = '';

    public string $email = '';

    public string $reg_password = '';

    public string $reg_password_confirmation = '';

    public bool $terms = false;

    public ?string $loginError = null;

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->loginError = null;
    }

    public function login(): void
    {
        $this->loginError = null;

        $this->validate([
            'loginIdentifier' => 'required|string',
            'password' => 'required|string',
        ], [
            'loginIdentifier.required' => 'Nomor WhatsApp atau Email wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $identifier = trim($this->loginIdentifier);

        // Check if identifier is email or phone
        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $user = User::where($field, $identifier)->first();

        if (! $user || ! Hash::check($this->password, $user->password)) {
            $this->loginError = 'Identitas atau kata sandi yang Anda masukkan tidak sesuai.';

            return;
        }

        if (! $user->is_active) {
            $this->loginError = 'Akun Anda sedang dinonaktifkan oleh administrator.';

            return;
        }

        Auth::login($user, $this->remember);

        $this->redirect(route('riwayat.pengajuan'), navigate: true);
    }

    public function register(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:users,nik',
            'phone' => 'required|string|min:9|max:16|unique:users,phone',
            'email' => 'required|email|max:255|unique:users,email',
            'reg_password' => 'required|string|min:8|same:reg_password_confirmation',
            'terms' => 'accepted',
        ], [
            'name.required' => 'Nama lengkap wajib diisi sesuai KTP.',
            'nik.required' => 'NIK wajib diisi 16 digit.',
            'nik.size' => 'NIK harus tepat 16 digit.',
            'nik.unique' => 'NIK ini sudah terdaftar sebelumnya.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.unique' => 'Nomor WhatsApp ini sudah terdaftar.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'reg_password.min' => 'Kata sandi minimal 8 karakter.',
            'reg_password.same' => 'Konfirmasi kata sandi tidak cocok.',
            'terms.accepted' => 'Anda harus menyetujui ketentuan privasi data.',
        ]);

        $user = User::create([
            'name' => $this->name,
            'nik' => $this->nik,
            'phone' => $this->phone,
            'email' => $this->email,
            'password' => Hash::make($this->reg_password),
            'is_active' => true,
        ]);

        $user->assignRole('masyarakat');

        Auth::login($user);

        $this->redirect(route('riwayat.pengajuan'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.masuk-daftar');
    }
}
