<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialIntegration extends Model
{
    use HasFactory;

    protected $table = 'social_integrations';

    protected $fillable = [
        'platform',
        'name',
        'username',
        'profile_url',
        'embed_code',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Memeriksa apakah integrasi memiliki script/kode embed widget yang valid.
     */
    public function hasEmbedCode(): bool
    {
        return ! empty($this->embed_code) && trim($this->embed_code) !== '';
    }

    /**
     * Mengembalikan username berformat @username.
     */
    public function getFormattedUsernameAttribute(): string
    {
        if (empty($this->username)) {
            return '@bpmpsultra';
        }

        return str_starts_with($this->username, '@') ? $this->username : '@'.$this->username;
    }
}
