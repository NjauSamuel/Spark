<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Contact;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $user = $request->user();
        $query = Task::where('user_id', $user->id)->with('contact');

        // Filter by contact
        if ($request->has('contact_id') && $request->get('contact_id') !== '') {
            $query->where('contact_id', $request->get('contact_id'));
        }

        // Filter by status
        if ($request->has('status') && $request->get('status') !== '') {
            $query->where('status', $request->get('status'));
        }

        // Search functionality
        if ($request->has('search') && $request->filled('search')) {
            $search = $request->get('search');
            $query->where('title', 'like', "%{$search}%");
        }

        $tasks = $query->latest()->paginate(15)->withQueryString();

        // Get contacts for filter dropdown
        $contacts = Contact::where('user_id', $user->id)
            ->orderBy('name')
            ->get();

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
            'contacts' => $contacts,
            'filters' => $request->only(['contact_id', 'status', 'search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Response
    {
        $contacts = Contact::where('user_id', $request->user()->id)
            ->orderBy('name')
            ->get();

        return Inertia::render('Tasks/Create', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        // Verify contact belongs to user
        $contact = Contact::findOrFail($request->contact_id);
        if ($contact->user_id !== $request->user()->id) {
            abort(403);
        }

        $task = Task::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Task $task): Response
    {
        // Ensure the task belongs to the authenticated user
        if ($task->user_id !== $request->user()->id) {
            abort(403);
        }

        $contacts = Contact::where('user_id', $request->user()->id)
            ->orderBy('name')
            ->get();

        return Inertia::render('Tasks/Edit', [
            'task' => $task->load('contact'),
            'contacts' => $contacts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        // Ensure the task belongs to the authenticated user
        if ($task->user_id !== $request->user()->id) {
            abort(403);
        }

        // Verify contact belongs to user
        $contact = Contact::findOrFail($request->contact_id);
        if ($contact->user_id !== $request->user()->id) {
            abort(403);
        }

        $task->update($request->validated());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Task $task): RedirectResponse
    {
        // Ensure the task belongs to the authenticated user
        if ($task->user_id !== $request->user()->id) {
            abort(403);
        }

        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }
}
