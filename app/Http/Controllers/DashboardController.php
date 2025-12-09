<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();

        $stats = [
            'contacts_count' => Contact::where('user_id', $user->id)->count(),
            'tasks_count' => Task::where('user_id', $user->id)->count(),
            'tasks_pending' => Task::where('user_id', $user->id)->where('status', 'pending')->count(),
            'tasks_completed' => Task::where('user_id', $user->id)->where('status', 'completed')->count(),
        ];

        $recentContacts = Contact::where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        $recentTasks = Task::where('user_id', $user->id)
            ->with('contact')
            ->latest()
            ->limit(5)
            ->get();

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'recentContacts' => $recentContacts,
            'recentTasks' => $recentTasks,
        ]);
    }
}
