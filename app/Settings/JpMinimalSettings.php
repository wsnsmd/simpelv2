<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class JpMinimalSettings extends Settings
{
    public int $perbulan;
    public string $jabatan;
    public string $nama;
    public string $nip;

    public static function group(): string
    {
        return 'jpminimal';
    }
}
