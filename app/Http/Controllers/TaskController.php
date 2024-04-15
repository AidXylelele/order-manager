<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\File;
use Illuminate\Http\Request;

// use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $totalHours = 0;
        $totalMinutes = 0;
        $tasksQuery = Task::where('user_id', auth()->id());

        if ($request->filled('search')) {
            $tasksQuery->where('title', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->filled('created_at')) {
            $tasksQuery->whereDate('created_at', $request->input('created_at'));
        }

        $tasks = $tasksQuery->get();

        foreach ($tasks as $task) {
            list($hours, $minutes) = explode(':', $task->required_time);
            $totalHours += (int) $hours;
            $totalMinutes += (int) $minutes;
            $totalHours += floor($totalMinutes / 60);
            $totalMinutes = $totalMinutes % 60;
        }

        $totalRequiredTime = sprintf('%02d:%02d', $totalHours, $totalMinutes);
        return view('tasks.table', compact('tasks', 'totalRequiredTime'));
    }

    public function create()
    {
        return view('tasks.createForm');
    }

    public function edit(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);

        return view('tasks.editForm', compact('task'));
    }

    public function store(StoreTaskRequest $request)
    {
        $task = new Task();
        $file_record = new File();

        $user = auth()->user();

        $task->title = $request->title;
        $task->description = $request->description;
        $task->required_time = $request->required_time;
        $task->deadline_date = $request->deadline_date;
        $task->user_id = $user->id;
        $task->save();

        $file = $request->file('file');

        if ($file) {
            $filePath = $file->store('uploads', 'public');
            $file_record->path = '/storage/' . $filePath;
            $file_record->name = $file->hashName();
            $file_record->task_id = $task->id;
            $file_record->save();
        }

        return redirect()->route('tasks.index');
    }

    public function check(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $file = File::where('task_id', $task->id)->first();
        return view('tasks.checkForm', compact('task', 'file'));
    }

    public function update(UpdateTaskRequest $request, $taskId)
    {
        $task = Task::findOrFail($taskId);

        $file = File::where('task_id', $task->id)->first();

        $newFile = $request->file('file');

        if ($newFile) {
            $newFilePath = $newFile->store('uploads', 'public');
            $newFullFilePath = '/storage/' . $newFilePath;
            $newFileName = $newFile->hashName();

            if ($file) {
                Storage::delete($file->name);
                $file->update([
                    'name' => $newFileName,
                    'path' => $newFullFilePath,
                ]);
            } else {
                $newFileRecord = new File();
                $newFileRecord->task_id = $task->id;
                $newFileRecord->name = $newFileName;
                $newFileRecord->path = $newFullFilePath;
                $newFileRecord->save();
            }
        } elseif ($file) {
            Storage::delete($file->name);
            unlink(storage_path('app/public/uploads/' . $file->name));
            $file->delete();
        }

        $task->update($request->except('file'));

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }
}