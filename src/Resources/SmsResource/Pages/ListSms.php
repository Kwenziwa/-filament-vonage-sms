<?php

namespace YourUsername\FilamentVonageSms\Resources\SmsResource\Pages;

use Filament\Resources\Pages\ListRecords;
use YourUsername\FilamentVonageSms\Resources\SmsResource;
use YourUsername\FilamentVonageSms\Actions\SendSmsAction;

class ListSms extends ListRecords
{
    protected static string $resource = SmsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            SendSmsAction::make(),
        ];
    }
}
