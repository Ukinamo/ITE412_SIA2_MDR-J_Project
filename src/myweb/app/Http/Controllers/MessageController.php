<?php
// app/Http/Controllers/MessageController.php
namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get unread count for badge
        $unreadCount = $user->receivedMessages()
            ->where('is_read', false)
            ->count();
            
        $messages = $user->receivedMessages()
            ->with(['sender', 'recipient', 'application'])
            ->latest()
            ->paginate(15);

        // Return role-specific view based on current route
        if ($user->role === 'admin') {
            return view('admin.messages.index', compact('messages', 'unreadCount'));
        } elseif ($user->role === 'viewer') {
            return view('viewer.messages.index', compact('messages', 'unreadCount'));
        } else {
            return view('user.messages.index', compact('messages', 'unreadCount'));
        }
    }

    public function create()
    {
        $user = Auth::user();
        
        // Get users based on role permissions
        if ($user->role === 'admin') {
            // Admins can message anyone
            $users = User::where('id', '!=', Auth::id())->get();
        } elseif ($user->role === 'viewer') {
            // Reviewers can message admins and other reviewers
            $users = User::where('id', '!=', Auth::id())
                        ->whereIn('role', ['admin', 'viewer'])
                        ->get();
        } else {
            // Users can message admins only
            $users = User::where('role', 'admin')->get();
        }
        
        // Return role-specific view
        if ($user->role === 'admin') {
            return view('admin.messages.create', compact('users'));
        } elseif ($user->role === 'viewer') {
            return view('viewer.messages.create', compact('users'));
        } else {
            return view('user.messages.create', compact('users'));
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Validate based on user role
        $validationRules = [
            'to_user_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:general,application_update,notification'
        ];

        // Additional validation for user role permissions
        $toUser = User::find($request->to_user_id);
        if ($user->role === 'user' && $toUser->role !== 'admin') {
            return back()->withErrors(['to_user_id' => 'You can only send messages to administrators.']);
        }
        
        if ($user->role === 'viewer' && $toUser->role === 'user') {
            return back()->withErrors(['to_user_id' => 'Reviewers cannot send messages to regular users.']);
        }

        $request->validate($validationRules);

        Message::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $request->to_user_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'type' => $request->type,
            'application_id' => $request->application_id,
        ]);

        // Redirect based on user role
        if ($user->role === 'admin') {
            return redirect()->route('admin.messages.index')
                ->with('success', 'Message sent successfully!');
        } elseif ($user->role === 'viewer') {
            return redirect()->route('viewer.messages.index')
                ->with('success', 'Message sent successfully!');
        } else {
            return redirect()->route('user.messages.index')
                ->with('success', 'Message sent successfully!');
        }
    }

    public function show(Message $message)
    {
        if ($message->to_user_id !== Auth::id() && $message->from_user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($message->to_user_id === Auth::id() && !$message->is_read) {
            $message->update(['is_read' => true]);
        }

        $user = Auth::user();
        
        // Return role-specific view
        if ($user->role === 'admin') {
            return view('admin.messages.show', compact('message'));
        } elseif ($user->role === 'viewer') {
            return view('viewer.messages.show', compact('message'));
        } else {
            return view('user.messages.show', compact('message'));
        }
    }

    public function markAsRead(Message $message)
    {
        if ($message->to_user_id === Auth::id()) {
            $message->update(['is_read' => true]);
            
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.messages.index')->with('success', 'Message marked as read.');
            } elseif ($user->role === 'viewer') {
                return redirect()->route('viewer.messages.index')->with('success', 'Message marked as read.');
            } else {
                return redirect()->route('user.messages.index')->with('success', 'Message marked as read.');
            }
        }

        abort(403, 'Unauthorized action.');
    }

    public function getUnreadCount()
    {
        $unreadCount = Auth::user()->receivedMessages()
            ->where('is_read', false)
            ->count();
            
        return response()->json(['unreadCount' => $unreadCount]);
    }
}