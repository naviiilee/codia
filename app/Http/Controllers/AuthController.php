<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function signupForm()
    {
        return view('signup');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'first' => 'required|string|max:50',
            'last' => 'required|string|max:50',
            'username' => 'required|string|max:30|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => [
                'required',
                'string',
                'size:8',
                'regex:/^(?=.*[\d\W]).{8}$/',
            ],
            'confirm_password' => 'required|same:password',
        ]);

        DB::table('users')->insert([
            'first' => $request->first,
            'last' => $request->last,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('home')->with('success', 'Account created! Please login.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = DB::table('users')
            ->where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->route('home')->with('error', 'Invalid credentials.');
        }

        Session::put('user_id', $user->id);
        Session::put('username', $user->username);
        Session::put('first', $user->first);
        Session::put('role', $user->role);

        DB::table('login_logs')->insert([
            'username' => $user->username,
            'login_time' => now(),
        ]);

        return $user->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('dashboard');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('home');
    }

    public function dashboard()
    {
        $username = $this->currentUsername();
        if (!$username) {
            return redirect()->route('home');
        }

        $posts = DB::table('posts')
            ->leftJoin('users', 'posts.username', '=', 'users.username')
            ->select('posts.*', 'users.profile_pic')
            ->inRandomOrder()
            ->get();

        $notif_count = DB::table('notifications')
            ->where('username', $username)
            ->where('is_read', 0)
            ->count();

        $notes = DB::table('notifications')
            ->where('username', $username)
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        $courses = DB::table('user_courses')
            ->leftJoin('user_progress', function ($join) {
                $join->on('user_courses.username', '=', 'user_progress.username')
                     ->on('user_courses.course_name', '=', 'user_progress.course_name');
            })
            ->where('user_courses.username', $username)
            ->select('user_courses.*', 'user_progress.current_lesson')
            ->get();

        foreach ($courses as $course) {
            $course->progress = $course->current_lesson
                ? min(($course->current_lesson / 6) * 100, 100)
                : 0;
            $course->completed = $course->current_lesson >= 7;
        }

        return view('dashboard', compact('posts', 'notif_count', 'notes', 'courses'));
    }

    public function handlePost(Request $request)
    {
        $username = $this->currentUsername();
        if (!$username) {
            return redirect()->route('home');
        }

        $response = ['success' => true];

        if ($request->has('post')) {
            $this->createPost($request, $username);
        } elseif ($request->has('like')) {
            $response = $this->togglePostLike($request, $username);
        } elseif ($request->has('comment_btn')) {
            $response = $this->addComment($request, $username);
        } elseif ($request->has('comment_like')) {
            $response = $this->toggleCommentLike($request, $username);
        } elseif ($request->has('reply_btn')) {
            $response = $this->addReply($request, $username);
        } elseif ($request->has('read_single_notification')) {
            $response = $this->markNotificationRead($request, $username);
        } elseif ($request->has('read_notifications')) {
            $response = $this->markNotificationsRead($username);
        }

        if ($request->ajax()) {
            return response()->json($response);
        }

        return redirect()->route('dashboard');
    }

    public function profileAction(Request $request)
    {
        $username = $this->currentUsername();
        if (!$username) {
            return redirect()->route('home');
        }

        $response = ['success' => true];

        if ($request->has('like')) {
            $response = $this->togglePostLike($request, $username);
        } elseif ($request->has('comment_btn')) {
            $response = $this->addComment($request, $username, route('profile.action'));
        } elseif ($request->has('comment_like')) {
            $response = $this->toggleCommentLike($request, $username);
        } elseif ($request->has('reply_btn')) {
            $response = $this->addReply($request, $username, route('profile.action'));
        }

        if ($request->ajax()) {
            return response()->json($response);
        }

        return redirect()->route('profile');
    }

    public function course()
    {
        $username = $this->currentUsername();
        if (!$username) {
            return redirect()->route('home');
        }

        $courses = DB::table('user_courses')
            ->where('username', $username)
            ->get();

        return view('course', compact('courses'));
    }

    public function deletePost(Request $request)
    {
        $request->validate(['post_id' => 'required|integer']);

        DB::table('posts')
            ->where('id', $request->post_id)
            ->where('username', $this->currentUsername())
            ->delete();

        return redirect()->back();
    }

    public function deleteComment(Request $request)
    {
        $request->validate(['comment_id' => 'required|integer']);

        DB::table('comments')
            ->where('id', $request->comment_id)
            ->where('username', $this->currentUsername())
            ->delete();

        return redirect()->back();
    }

    public function profile()
    {
        $username = $this->currentUsername();
        if (!$username) {
            return redirect()->route('home');
        }

        $userData = DB::table('users')
            ->where('username', $username)
            ->first();

        $posts = DB::table('posts')
            ->where('username', $username)
            ->orderByDesc('id')
            ->get();

        $courses = DB::table('user_courses')
            ->where('username', $username)
            ->get();

        return view('profile', compact('userData', 'posts', 'courses'));
    }

    public function updateProfile(Request $request)
    {
        $currentUsername = $this->currentUsername();
        if (!$currentUsername) {
            return redirect()->route('home');
        }

        $request->validate([
            'bio' => 'nullable|string|max:500',
            'username' => 'nullable|string|max:30',
            'profile_pic' => 'nullable|image|max:2048',
        ]);

        $data = ['bio' => $request->bio];
        $newUsername = $request->username;

        if ($newUsername && $newUsername !== $currentUsername) {
            $request->validate([
                'username' => 'unique:users,username',
            ]);
            $data['username'] = $newUsername;
        }

        if ($request->hasFile('profile_pic')) {
            $data['profile_pic'] = $request->file('profile_pic')->store('profiles', 'public');
        }

        DB::table('users')
            ->where('username', $currentUsername)
            ->update($data);

        if (!empty($newUsername) && $newUsername !== $currentUsername) {
            $this->updateRelatedUsername($currentUsername, $newUsername);
            session(['username' => $newUsername]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    public function cCourse()
    {
        return view('c_course');
    }

    public function cppCourse()
    {
        return view('cpp_course');
    }

    public function javaCourse()
    {
        return view('java_course');
    }

    protected function currentUsername()
    {
        return session('username');
    }

    private function createPost(Request $request, string $username): void
    {
        $mediaPath = null;
        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('uploads', 'public');
        }

        DB::table('posts')->insert([
            'username' => $username,
            'content' => $request->content,
            'media_path' => $mediaPath,
            'created_at' => now(),
        ]);
    }

    private function togglePostLike(Request $request, string $username): array
    {
        $postId = $request->post_id;
        $exists = DB::table('reactions')
            ->where('post_id', $postId)
            ->where('username', $username)
            ->whereNull('comment_id')
            ->exists();

        if ($exists) {
            DB::table('reactions')
                ->where('post_id', $postId)
                ->where('username', $username)
                ->whereNull('comment_id')
                ->delete();
        } else {
            DB::table('reactions')->insert([
                'post_id' => $postId,
                'username' => $username,
            ]);

            $owner = DB::table('posts')->where('id', $postId)->value('username');
            if ($owner && $owner !== $username) {
                $this->insertNotification($owner, 'like', $postId, $username);
            }
        }

        $likeCount = DB::table('reactions')
            ->where('post_id', $postId)
            ->whereNull('comment_id')
            ->count();

        return ['success' => true, 'action' => 'like', 'like_count' => $likeCount];
    }

    private function addComment(Request $request, string $username, string $formAction = null): array
    {
        $postId = $request->post_id;
        $commentId = DB::table('comments')->insertGetId([
            'post_id' => $postId,
            'username' => $username,
            'comment' => $request->comment,
            'created_at' => now(),
        ]);

        $owner = DB::table('posts')->where('id', $postId)->value('username');
        if ($owner && $owner !== $username) {
            $this->insertNotification($owner, 'comment', $postId, $username);
        }

        $profilePic = DB::table('users')->where('username', $username)->value('profile_pic');

        return [
            'success' => true,
            'action' => 'comment',
            'comment' => [
                'id' => $commentId,
                'username' => $username,
                'profile_pic' => $this->formatProfilePic($profilePic),
                'comment' => $request->comment,
                'formAction' => $formAction ?? route('handle.post'),
                'deleteAction' => route('comment.delete'),
            ],
        ];
    }

    private function toggleCommentLike(Request $request, string $username): array
    {
        $commentId = $request->comment_id;
        $postId = DB::table('comments')->where('id', $commentId)->value('post_id');

        $exists = DB::table('reactions')
            ->where('comment_id', $commentId)
            ->where('username', $username)
            ->exists();

        if ($exists) {
            DB::table('reactions')
                ->where('comment_id', $commentId)
                ->where('username', $username)
                ->delete();
        } else {
            DB::table('reactions')->insert([
                'post_id' => $postId,
                'comment_id' => $commentId,
                'username' => $username,
            ]);
        }

        $likeCount = DB::table('reactions')
            ->where('comment_id', $commentId)
            ->count();

        return ['success' => true, 'action' => 'comment_like', 'comment_id' => $commentId, 'like_count' => $likeCount];
    }

    private function addReply(Request $request, string $username, string $formAction = null): array
    {
        $commentId = $request->comment_id;
        $replyText = trim($request->reply);
        $parentComment = DB::table('comments')->where('id', $commentId)->first();

        if (!$parentComment || $replyText === '') {
            return ['success' => false];
        }

        $newCommentId = DB::table('comments')->insertGetId([
            'post_id' => $parentComment->post_id,
            'username' => $username,
            'comment' => '@' . $parentComment->username . ' ' . $replyText,
            'created_at' => now(),
        ]);

        $profilePic = DB::table('users')->where('username', $username)->value('profile_pic');

        return [
            'success' => true,
            'action' => 'reply',
            'comment' => [
                'id' => $newCommentId,
                'parent_id' => $commentId,
                'username' => $username,
                'profile_pic' => $this->formatProfilePic($profilePic),
                'comment' => '@' . $parentComment->username . ' ' . $replyText,
                'formAction' => $formAction ?? route('handle.post'),
                'deleteAction' => route('comment.delete'),
            ],
        ];
    }

    private function markNotificationRead(Request $request, string $username): array
    {
        DB::table('notifications')
            ->where('id', $request->notif_id)
            ->where('username', $username)
            ->update(['is_read' => 1]);

        $newCount = DB::table('notifications')
            ->where('username', $username)
            ->where('is_read', 0)
            ->count();

        return ['success' => true, 'action' => 'read_single_notification', 'new_count' => $newCount];
    }

    private function markNotificationsRead(string $username): array
    {
        DB::table('notifications')
            ->where('username', $username)
            ->update(['is_read' => 1]);

        return ['success' => true, 'action' => 'read_notifications'];
    }

    private function insertNotification(string $username, string $type, int $postId, string $sender): void
    {
        DB::table('notifications')->insert([
            'username' => $username,
            'type' => $type,
            'post_id' => $postId,
            'sender' => $sender,
            'created_at' => now(),
        ]);
    }

    private function updateRelatedUsername(string $oldUsername, string $newUsername): void
    {
        $tables = ['posts', 'comments', 'reactions', 'notifications', 'user_courses', 'user_progress', 'login_logs'];

        foreach ($tables as $table) {
            DB::table($table)
                ->where('username', $oldUsername)
                ->update(['username' => $newUsername]);
        }

        DB::table('notifications')
            ->where('sender', $oldUsername)
            ->update(['sender' => $newUsername]);
    }

    private function formatProfilePic(?string $path): string
    {
        return $path ? asset('storage/' . $path) : 'https://via.placeholder.com/120';
    }
}
