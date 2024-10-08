<?php

namespace kwenziwa\FilamentVonageSms;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use kwenziwa\FilamentVonageSms\Resources\SmsResource;

class FilamentVonageSmsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-vonage-sms';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations()
            ->hasMigration('2024_08_11_025446_create_sms_table')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('kwenziwa/filament-vonage-sms');
            });
    }

    public function packageRegistered(): void
    {
        //
    }

    public function packageBooted(): void
    {
        // Register the SMS resource
        FilamentAsset::register([
            // Add any assets if needed
        ]);

        FilamentIcon::register([
            // Add any custom icons if needed
        ]);

        \Filament\Facades\Filament::registerResources([
            SmsResource::class,
        ]);
    }
}
