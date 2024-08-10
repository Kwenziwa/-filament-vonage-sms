<?php

namespace kwenziwa\FilamentVonageSms\Resources\SmsResource\Pages;

use Filament\Resources\Pages\ListRecords;
use kwenziwa\FilamentVonageSms\Resources\SmsResource;
use kwenziwa\FilamentVonageSms\Actions\SendSmsAction;

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
