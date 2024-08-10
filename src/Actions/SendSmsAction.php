<?php

namespace YourUsername\FilamentVonageSms\Actions;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

class SendSmsAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'send_sms';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Send SMS')
            ->form([
                Select::make('user_id')
                    ->label('Recipient')
                    ->options(function () {
                        return config('filament-vonage-sms.user_model')::pluck('name', 'id');
                    })
                    ->searchable()
                    ->required(),
                Textarea::make('message')
                    ->label('Message')
                    ->required()
                    ->maxLength(160),
            ])
            ->action(function (array $data): void {
                $userModel = config('filament-vonage-sms.user_model');
                $user = $userModel::findOrFail($data['user_id']);
                $message = $data['message'];

                $basic = new Basic(config('filament-vonage-sms.key'), config('filament-vonage-sms.secret'));
                $client = new Client($basic);

                $response = $client->sms()->send(
                    new SMS($user->phone, config('filament-vonage-sms.from'), $message)
                );

                $message = $response->current();

                if ($message->getStatus() == 0) {
                    Notification::make()
                        ->title('SMS sent successfully')
                        ->success()
                        ->send();
                } else {
                    Notification::make()
                        ->title('SMS sending failed')
                        ->danger()
                        ->body('Error: ' . $message->getStatus())
                        ->send();
                }
            });
    }
}
