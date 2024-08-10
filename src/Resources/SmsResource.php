<?php

namespace YourUsername\FilamentVonageSms\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use YourUsername\FilamentVonageSms\Resources\SmsResource\Pages;
use YourUsername\FilamentVonageSms\Actions\SendSmsAction;

class SmsResource extends Resource
{
    protected static ?string $model = null;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'Send SMS';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Recipient')
                    ->options(function () {
                        return config('filament-vonage-sms.user_model')::pluck('name', 'id');
                    })
                    ->searchable()
                    ->required(),
                Forms\Components\Textarea::make('message')
                    ->label('Message')
                    ->required()
                    ->maxLength(160),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('phone')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                SendSmsAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSms::route('/'),
        ];
    }
}
