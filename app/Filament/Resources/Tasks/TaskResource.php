<?php

namespace App\Filament\Resources\Tasks;

use App\Enums\UserRole;
use App\Filament\Resources\Tasks\Pages\CreateTask;
use App\Filament\Resources\Tasks\Pages\EditTask;
use App\Filament\Resources\Tasks\Pages\ListTasks;
use App\Filament\Resources\Tasks\Schemas\TaskForm;
use App\Filament\Resources\Tasks\Tables\TasksTable;
use App\Models\Task;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TaskResource extends Resource
{

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'مهمات';

    protected static ?string $navigationLabel = 'مهمات';

    protected static ?string $modelLabel =  'مهمة';

    protected static ?string $pluralModelLabel = 'مهمات';
    protected static ?string $model = Task::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    public static function form(Schema $schema): Schema
    {
        return TaskForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TasksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        // dd(auth()->user()->role->value);
        if (auth()->user()->role->value === UserRole::SuperVisor->value) {
            return parent::getEloquentQuery();
        } else if (auth()->user()->role->value === UserRole::Manager->value) {
            return parent::getEloquentQuery()->where('status', 3);
        } else {
            return parent::getEloquentQuery()->where('user_id', auth()->id());
        }
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTasks::route('/'),
            'create' => CreateTask::route('/create'),
            'edit' => EditTask::route('/{record}/edit'),
        ];
    }
}
