<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('role')
                    ->label('الدور')
                    ->options(function () {
                        return collect([
                            UserRole::SuperVisor,
                            UserRole::Manager,
                            UserRole::Employee,
                        ])->mapWithKeys(fn($r) => [$r->value => $r->name]);
                    })
                    ->default('3')
                    ->live()
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('name')
                    ->label('الاسم')
                    ->required(),
                TextInput::make('phone')
                    ->label('رقم الهاتف')
                    ->tel(),
                TextInput::make('email')
                    ->label('البريد الإلكتروني')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->label('كلمة المرور')
                    ->password()
                    ->required(fn(string $operation) => $operation === 'create')
                    ->dehydrated(fn($state) => filled($state)),
                Toggle::make('is_active')
                    ->label('الحالة')
                    ->default(true)
                    ->inline()
                    ->columnSpanFull(),
            ]);
    }
}
