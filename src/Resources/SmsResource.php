<?php

namespace kwenziwa\FilamentVonageSms\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use kwenziwa\FilamentVonageSms\Models\Sms;
use kwenziwa\FilamentVonageSms\Resources\SmsResource\Pages;

class SmsResource extends Resource
{
    protected static ?string $model = Sms::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'Send SMS';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('recipient')
                    ->label('Recipient')
                    ->options(function () {
                        return config('filament-vonage-sms.user_model')::pluck('name', 'phone');
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
                Tables\Columns\TextColumn::make('recipient')->searchable(),
                Tables\Columns\TextColumn::make('message')->limit(50),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // You can add view or delete actions here if needed
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
