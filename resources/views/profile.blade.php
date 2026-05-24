@php
use Illuminate\Support\Facades\DB;

$user = session('username');

// USER DATA
$userData = DB::table('users')
    ->where('username', $user)
    ->first();

// USER POSTS ONLY
$posts = DB::table('posts')
    ->where('username', $user)
    ->orderBy('id', 'desc')
    ->get();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profile</title>
    <link rel="stylesheet" href="{{ asset('dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('profile.css') }}">
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>C0DiA</h2>
    <a href="{{ route('dashboard') }}">🏠 Home</a>
    <a href="{{ route('profile') }}">👤 Profile</a>
    <a href="{{ route('course') }}">📚 Courses</a>
    <a href="{{ route('logout') }}">🚪 Logout</a>
</div>

<div class="main">
    <div class="feed">

        <!-- PROFILE HEADER (FB STYLE CLEAN) -->
        <div class="card profile-header">

            <div class="profile-top">

                <!-- PROFILE PIC -->
                <div class="avatar-wrap">
    <img
        src="{{ $userData->profile_pic ? asset('storage/'.$userData->profile_pic) : 'https://via.placeholder.com/120' }}"
        alt="Profile Picture"
        class="profile-pic"
    >
</div>
                <!-- INFO -->
                <div class="profile-info">

                    <div class="name-row">
                        <h2>{{ $userData->username }}</h2>

                        <button class="edit-btn" onclick="openModal()">
                            Edit Profile
                        </button>
                    </div>

                    <!-- BIO (EMPTY IF NONE) -->
                    @if(!empty($userData->bio))
                        <div class="bio-text">{{ $userData->bio }}</div>
                    @endif

                </div>

            </div>

        </div>

        <!-- POSTS -->
        <h3>Your Posts</h3>

        @foreach ($posts as $row)
            <div class="post" data-post-id="{{ $row->id }}">

                <div class="post-header">
                    <img src="{{ $userData->profile_pic ? asset('storage/'.$userData->profile_pic) : 'https://via.placeholder.com/120' }}" alt="Profile Picture" class="post-avatar" />

                    <div>
                        <h4>{{ $row->username }}</h4>

                        <small>
                            {{ \Carbon\Carbon::parse($row->created_at)->format('F d, Y') }}
                        </small>
                    </div>
                </div>

                <p>{{ $row->content }}</p>

                @if ($row->media_path)
                    @if (str_contains($row->media_path, '.mp4'))
                        <video src="{{ asset('storage/'.$row->media_path) }}" controls style="max-width:100%; border-radius:10px;"></video>
                    @else
                        <img src="{{ asset('storage/'.$row->media_path) }}" style="max-width:100%; border-radius:10px;">
                    @endif
                @endif

                @php
                    $likeCount = DB::table('reactions')->where('post_id', $row->id)->whereNull('comment_id')->count();
                    $allComments = DB::table('comments')
                        ->leftJoin('users', 'comments.username', '=', 'users.username')
                        ->select('comments.*', 'users.profile_pic')
                        ->where('post_id', $row->id)
                        ->orderBy('comments.id', 'asc')
                        ->get();
                    $comments = $allComments->filter(function ($comment) {
                        return !str_starts_with($comment->comment, '@');
                    });
                    $replyMap = [];
                    $latestParentByUser = [];
                    foreach ($allComments as $comment) {
                        if (!str_starts_with($comment->comment, '@')) {
                            $latestParentByUser[$comment->username] = $comment->id;
                        } elseif (preg_match('/^@([^\s]+)/', $comment->comment, $match)) {
                            $parentUsername = $match[1];
                            if (isset($latestParentByUser[$parentUsername])) {
                                $replyMap[$latestParentByUser[$parentUsername]][] = $comment;
                            }
                        }
                    }
                @endphp

                <div class="post-actions">
                    <!-- LIKE -->
                    <form method="POST" action="{{ route('profile.action') }}" class="ajax-form" style="display:inline;">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $row->id }}">
                        <input type="hidden" name="like" value="1">
                        <button type="submit">👍 Like</button>
                    </form>

                    <!-- COMMENT -->
                    <button type="button" class="comment-toggle-btn" onclick="openCommentModal({{ $row->id }})">💬 {{ $comments->count() }} Comments</button>

                    <!-- DELETE -->
                    @if ($row->username == session('username'))
                        <form method="POST" action="{{ route('post.delete') }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="post_id" value="{{ $row->id }}">
                            <button>🗑 Delete</button>
                        </form>
                    @endif
                </div>

                <p class="post-likes">{{ $likeCount }} Likes</p>

                <div class="modal-bg comment-modal-bg" id="commentModal-{{ $row->id }}">
                    <div class="modal comment-modal">
                        <div class="modal-header">
                            <h3>Comments</h3>
                            <button type="button" class="modal-close" onclick="closeCommentModal({{ $row->id }})">&times;</button>
                        </div>
                        <div class="comment-modal-body">
                            <div class="comments-list">
                            @foreach ($comments as $c)
                                <div class="comment-item" data-comment-id="{{ $c->id }}">
                                    <img src="{{ $c->profile_pic ? asset('storage/'.$c->profile_pic) : 'https://via.placeholder.com/120' }}" alt="Comment avatar" class="comment-avatar" />
                                    <div class="comment-content">
                                        <div class="comment-bubble">
                                            <strong>{{ $c->username }}</strong>
                                            <p>{{ $c->comment }}</p>
                                        </div>
                                        <div class="comment-actions">
                                            <span class="comment-like-count" data-comment-id="{{ $c->id }}">{{ DB::table('reactions')->where('comment_id', $c->id)->count() }} likes</span>
                                            <form method="POST" action="{{ route('profile.action') }}" class="ajax-form" style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="comment_id" value="{{ $c->id }}">
                                                <input type="hidden" name="comment_like" value="1">
                                                <button type="submit">👍 Like</button>
                                            </form>
                                            <button type="button" class="reply-toggle">Reply</button>
                                            <div class="reply-form" style="display:none;">
                                                <form method="POST" action="{{ route('profile.action') }}" class="ajax-form">
                                                    @csrf
                                                    <input type="hidden" name="comment_id" value="{{ $c->id }}">
                                                    <input type="hidden" name="reply_btn" value="1">
                                                    <input class="comment-input" type="text" name="reply" placeholder="Write a reply..." required>
                                                    <button type="submit">↩ Reply</button>
                                                </form>
                                            </div>
                                            @if ($c->username == session('username'))
                                                <form method="POST" action="{{ route('comment.delete') }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="comment_id" value="{{ $c->id }}">
                                                    <button class="delete-comment">Delete</button>
                                                </form>
                                            @endif
                                        </div>
                                        @if (!empty($replyMap[$c->id]))
                                            <div class="comment-replies">
                                                @foreach ($replyMap[$c->id] as $reply)
                                                    <div class="comment-item comment-reply" data-comment-id="{{ $reply->id }}">
                                                        <img src="{{ $reply->profile_pic ? asset('storage/'.$reply->profile_pic) : 'https://via.placeholder.com/120' }}" alt="Reply avatar" class="comment-avatar" />
                                                        <div class="comment-content">
                                                            <div class="comment-bubble reply-bubble">
                                                                <strong>{{ $reply->username }}</strong>
                                                                <p>{{ $reply->comment }}</p>
                                                            </div>
                                                            <div class="comment-actions">
                                                                <span class="comment-like-count" data-comment-id="{{ $reply->id }}">{{ DB::table('reactions')->where('comment_id', $reply->id)->count() }} likes</span>
                                                                <form method="POST" action="{{ route('profile.action') }}" class="ajax-form" style="display:inline;">
                                                                    @csrf
                                                                    <input type="hidden" name="comment_id" value="{{ $reply->id }}">
                                                                    <input type="hidden" name="comment_like" value="1">
                                                                    <button type="submit" style="background:none; border:none; color:#dc3545; cursor:pointer; font-weight:bold;">👍 Like</button>
                                                                </form>
                                                                @if ($reply->username == session('username'))
                                                                    <form method="POST" action="{{ route('comment.delete') }}" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <input type="hidden" name="comment_id" value="{{ $reply->id }}">
                                                                        <button class="delete-comment" style="background:none; border:none; color:#dc3545; cursor:pointer; font-weight:bold;">Delete</button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            </div>
                            <form method="POST" action="{{ route('profile.action') }}" class="ajax-form comment-modal-form">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $row->id }}">
                                <input type="hidden" name="comment_btn" value="1">
                                <input class="comment-input" type="text" name="comment" placeholder="Write a comment..." required>
                                <button type="submit" class="confirm">Post Comment</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach

    </div>
</div>

<!-- EDIT PROFILE MODAL -->
<div class="modal-bg" id="profileModal">

    <div class="modal">

        <h3>Edit Profile</h3>

        <form method="POST" action="{{ route('profile.upload') }}" enctype="multipart/form-data">
            @csrf

            <input type="text" name="username" value="{{ $userData->username }}" placeholder="Username">

            <textarea name="bio" placeholder="Write your bio...">{{ $userData->bio }}</textarea>

            <input type="file" name="profile_pic">

            <button type="submit" class="confirm">Save Changes</button>
            <button type="button" class="cancel" onclick="closeModal()">Cancel</button>

        </form>

    </div>

</div>

<!-- MODAL JS -->
<script>
function openModal(){
    document.getElementById('profileModal').style.display = 'flex';
}

function closeModal(){
    document.getElementById('profileModal').style.display = 'none';
}
</script>

<script>
const currentUser = "{{ session('username') }}";
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

document.addEventListener('DOMContentLoaded', function() {
    document.body.addEventListener('submit', function(event) {
        const form = event.target.closest('.ajax-form');
        if (!form) return;
        event.preventDefault();

        const formData = new FormData(form);
        if (csrfToken) {
            formData.append('_token', csrfToken);
        }
        const submitButton = event.submitter;
        if (submitButton && submitButton.name) {
            formData.append(submitButton.name, submitButton.value || '1');
        }

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (!result.success) return;

            const postBlock = form.closest('.post');

            if (result.action === 'like' && postBlock) {
                const likeText = postBlock.querySelector('.post-likes');
                if (likeText) likeText.textContent = `${result.like_count} Likes`;
            }

            if ((result.action === 'comment' || result.action === 'reply') && postBlock) {
                if (result.action === 'reply' && result.comment.parent_id) {
                    const parentItem = postBlock.querySelector(`.comment-item[data-comment-id="${result.comment.parent_id}"]`);
                    if (parentItem) {
                        const parentContent = parentItem.querySelector('.comment-content') || parentItem;
                        let repliesList = parentContent.querySelector('.comment-replies');
                        if (!repliesList) {
                            repliesList = document.createElement('div');
                            repliesList.className = 'comment-replies';
                            parentContent.appendChild(repliesList);
                        }
                        repliesList.insertAdjacentHTML('beforeend', buildCommentHtml(result.comment, true));
                    }
                } else {
                    const commentsList = postBlock.querySelector('.comments-list');
                    if (commentsList) {
                        commentsList.insertAdjacentHTML('beforeend', buildCommentHtml(result.comment));
                    }
                }
                if (result.action === 'comment') {
                    const commentBtn = postBlock.querySelector('.comment-toggle-btn');
                    if (commentBtn) {
                        const currentCount = parseInt(commentBtn.textContent.replace(/\D/g, '')) || 0;
                        commentBtn.textContent = `💬 ${currentCount + 1} Comments`;
                    }
                }
            }

            if (result.action === 'comment_like') {
                const commentId = formData.get('comment_id');
                const likeCountEl = document.querySelector(`.comment-like-count[data-comment-id="${commentId}"]`);
                if (likeCountEl) likeCountEl.textContent = `${result.like_count} likes`;
            }

            form.reset();
        })
        .catch(error => {
            console.error('Action failed', error);
        });
    });
});

function openCommentModal(postId) {
    const modal = document.getElementById(`commentModal-${postId}`);
    if (modal) {
        modal.style.display = 'flex';
    }
}

function closeCommentModal(postId) {
    const modal = document.getElementById(`commentModal-${postId}`);
    if (modal) {
        modal.style.display = 'none';
    }
}

document.addEventListener('click', function(event) {
    const toggle = event.target.closest('.reply-toggle');
    if (toggle) {
        const item = toggle.closest('.comment-item');
        if (!item) return;
        const replyBlock = item.querySelector('.reply-form');
        if (replyBlock) {
            replyBlock.style.display = replyBlock.style.display === 'flex' ? 'none' : 'flex';
        }
    }
});

function buildCommentHtml(comment, isReply = false) {
    return `
        <div class="comment-item${isReply ? ' comment-reply' : ''}" data-comment-id="${comment.id}">
            <img src="${comment.profile_pic}" alt="Comment avatar" class="comment-avatar" />
            <div class="comment-content">
                <div class="comment-bubble${isReply ? ' reply-bubble' : ''}">
                    <strong>${comment.username}</strong>
                    <p>${comment.comment}</p>
                </div>
                <div class="comment-actions">
                    <span class="comment-like-count" data-comment-id="${comment.id}">0 likes</span>
                    <form method="POST" action="${comment.formAction}" class="ajax-form" style="display:inline;">
                        <input type="hidden" name="comment_id" value="${comment.id}">
                        <input type="hidden" name="comment_like" value="1">
                        <button type="submit">👍 Like</button>
                    </form>
                    ${!isReply ? `
                    <button type="button" class="reply-toggle">Reply</button>
                    <div class="reply-form">
                        <form method="POST" action="${comment.formAction}" class="ajax-form">
                            <input type="hidden" name="comment_id" value="${comment.id}">
                            <input type="hidden" name="reply_btn" value="1">
                            <input class="comment-input" type="text" name="reply" placeholder="Write a reply..." required>
                            <button type="submit">↩ Reply</button>
                        </form>
                    </div>
                    ` : ''}
                    ${comment.username === currentUser ? `
                        <form method="POST" action="${comment.deleteAction}" style="display:inline;">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="comment_id" value="${comment.id}">
                            <button class="delete-comment" type="submit">Delete</button>
                        </form>
                    ` : ''}
                </div>
            </div>
        </div>
    `;
}
</script>

</body>
</html>
