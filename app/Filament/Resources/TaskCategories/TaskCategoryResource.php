<?php

namespace App\Filament\Resources\TaskCategories;

use App\Filament\Resources\TaskCategories\Pages\CreateTaskCategory;
use App\Filament\Resources\TaskCategories\Pages\EditTaskCategory;
use App\Filament\Resources\TaskCategories\Pages\ListTaskCategories;
use App\Filament\Resources\TaskCategories\Schemas\TaskCategoryForm;
use App\Filament\Resources\TaskCategories\Tables\TaskCategoriesTable;
use App\Models\TaskCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TaskCategoryResource extends Resource
{
    protected static ?string $model = TaskCategory::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'تصنيفات المهمات';

    protected static ?string $navigationLabel = 'تصنيفات المهمات';

    protected static ?string $modelLabel = 'تصنيف المهمات';

    protected static ?string $pluralModelLabel = 'تصنيفات المهمات';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolder;

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()->role->value ===1;
    }
    public static function form(Schema $schema): Schema
    {
        return TaskCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TaskCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTaskCategories::route('/'),
            'create' => CreateTaskCategory::route('/create'),
            'edit' => EditTaskCategory::route('/{record}/edit'),
        ];
    }
}
