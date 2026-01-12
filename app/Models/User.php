<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'firstname',
        'name',
        'email',
        'password',
        'avatar_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];



    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Autorisation d'accès au panel Filament.
     * Ajuste selon ton besoin (rôle, domaine email, etc.)
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Exemple simple: tout utilisateur authentifié
        // Tu peux faire: return $this->hasRole('admin');
        return true;
    }

    /**
     * Avatar Filament: doit retourner une URL.
     * Ton fichier est sur le disk "public".
     */
    public function getFilamentAvatarUrl(): ?string
    {
        if (! $this->avatar_url) {
            return null;
        }

        return Storage::disk('public')->url($this->avatar_url);
    }

}
