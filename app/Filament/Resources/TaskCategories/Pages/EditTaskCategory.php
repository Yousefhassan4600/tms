<?php

namespace App\Filament\Resources\TaskCategories\Pages;

use App\Filament\Resources\TaskCategories\TaskCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTaskCategory extends EditRecord
{
    protected static string $resource = TaskCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
            ->label('حذف التصنيف'),
        ];
    }
}
