<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('jpminimal.perbulan', '32');
        $this->migrator->add('jpminimal.jabatan', 'Kepala Bidang X');
        $this->migrator->add('jpminimal.nama', 'Nama Pejabat');
        $this->migrator->add('jpminimal.nip', 'XXX');
    }
};
