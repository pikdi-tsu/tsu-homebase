<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'My Awesome Site');
        $this->migrator->add('general.site_logo', null);
        $this->migrator->add('general.footer_copyright', '© 2025 My Company');
    }
};
