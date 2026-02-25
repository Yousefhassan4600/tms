<?php

use App\Models\Task;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/tasks/{task}/print', function (Task $task) {
    $task->load(['taskCategory', 'user']);
    return view('tasks.print', compact('task'));
})->middleware(['auth'])->name('tasks.print');
