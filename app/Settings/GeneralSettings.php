<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{

    public string $site_name = 'My Awesome Site';
    public ?string $site_logo = null;
    public string $footer_copyright = '© 2025 My Company';

    public static function group(): string
    {
        return 'general';
    }
}
