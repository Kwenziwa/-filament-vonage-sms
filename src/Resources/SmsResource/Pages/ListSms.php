<?php

namespace kwenziwa\FilamentVonageSms\Resources\SmsResource\Pages;

use Vonage\Client;
use Vonage\SMS\Message\SMS;
use Filament\Actions\Action;
use Vonage\Client\Credentials\Basic;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use kwenziwa\FilamentVonageSms\Models\Sms as mySMS;
use kwenziwa\FilamentVonageSms\Resources\SmsResource;

class ListSms extends ListRecords
{
    protected static string $resource = SmsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('sendSms')
                ->label('Send SMS')
                ->form([
                    Select::make('recipient')
                        ->label('Recipient')
                        ->options(function () {
                            return config('filament-vonage-sms.user_model')::pluck('name', 'phone');
                        })
                        ->searchable()
                        ->required(),
                    Textarea::make('message')
                        ->label('Message')
                        ->required()
                        ->maxLength(160),
                ])
                ->action(function (array $data): void {
                    $recipient = $data['recipient'];
                    $message = $data['message'];

                    $basic = new Basic(config('filament-vonage-sms.key'), config('filament-vonage-sms.secret'));
                    $client = new Client($basic);

                    $response = $client->sms()->send(
                        new SMS($recipient, config('filament-vonage-sms.from'), $message)
                    );

                    $vonageMessage = $response->current();

                    $status = $vonageMessage->getStatus() == 0 ? 'sent' : 'failed';

                    // Save the SMS record
                    mySMS::create([
                        'recipient' => $recipient,
                        'message' => $message,
                        'status' => $status,
                    ]);

                    if ($status === 'sent') {
                        Notification::make()
                            ->title('SMS sent successfully')
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('SMS sending failed')
                            ->danger()
                            ->body('Error: ' . $vonageMessage->getStatus())
                            ->send();
                    }
                }),
        ];
    }
}
