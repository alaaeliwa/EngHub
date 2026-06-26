<!doctype html>
<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('style/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/course-details.css') }}" />

    <title>Course Details | EngHub</title>
</head>

<body>
    <div class="dashboard-layout">
        @include('components.sidbar')

        <main class="main-content">
            @include('components.topNav')

            <div class="dashboard-inner-content">
                <div class="breadcrumb" style="margin-bottom: var(--space-xl);">
                    <a href="{{ route('courses') }}">{{ __('messages.crs_title') }}</a> <i class="fa-solid fa-chevron-{{ App::getLocale() == 'ar' ? 'left' : 'right' }}"></i> <span>{{ $course->title }}</span>
                </div>

                <!-- Course Banner Section -->
                <div class="course-header-section">
                    <div class="header-main">
                        <div class="header-text">
                            <span class="course-badge">{{ __('messages.crs_year') }} {{ $course->year }} • {{ __('messages.crs_semester') }} {{ $course->semester }}</span>
                            <h1>{{ $course->title }}</h1>
                            <span class="course-code-pill">{{ $course->code ?? 'N/A' }}</span>
                            <p class="course-desc">
                                {{ $course->description ?? __('messages.cd_no_desc') }}
                            </p>
                        </div>
                        <div class="header-actions">
                            <a href="{{ route('upload', ['course_id' => $course->id]) }}" class="btn btn-primary">
                                <i class="fa-solid fa-plus" style="margin-right: 8px;"></i> {{ __('messages.cd_upload_mat') }}
                            </a>
                            <button class="btn btn-outline" onclick="shareCourse()"
                                style="border-color: var(--primary); color: var(--primary); background: transparent;"><i
                                    class="fa-solid fa-share-nodes" style="margin-right: 8px;"></i> {{ __('messages.cd_share') }}</button>
                        </div>
                    </div>

                    <div class="course-stats-row">
                        <div class="stat-box">
                            <i class="fa-regular fa-file-pdf"></i>
                            <div class="stat-info">
                                <span class="val">{{ $materials->where('type', 'pdf')->count() }}</span>
                                <span class="lbl">{{ __('messages.cd_pdfs') }}</span>
                            </div>
                        </div>
                        <div class="stat-box">
                            <i class="fa-solid fa-video"></i>
                            <div class="stat-info">
                                <span class="val">{{ $materials->where('type', 'video')->count() }}</span>
                                <span class="lbl">{{ __('messages.cd_videos') }}</span>
                            </div>
                        </div>
                        <div class="stat-box">
                            <i class="fa-solid fa-star"></i>
                            <div class="stat-info">
                                @php
                                    $avgCourseRating = $materials->avg('ratings_avg_rating') ?? 0;
                                @endphp
                                <span class="val">{{ number_format($avgCourseRating, 1) }}</span>
                                <span class="lbl">{{ __('messages.cd_avg_rating') }}</span>
                            </div>
                        </div>
                        <div class="stat-box">
                            <i class="fa-solid fa-layer-group"></i>
                            <div class="stat-info">
                                <span class="val">{{ $materials->count() }}</span>
                                <span class="lbl">{{ __('messages.cd_total_mat') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Contributors for this Course -->
                @if($topContributors && $topContributors->isNotEmpty())
                <div style="background: white; border-radius: var(--radius-lg); padding: var(--space-md) var(--space-xl); margin-bottom: var(--space-xl); box-shadow: var(--shadow-sm); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h3 style="margin: 0; color: var(--primary-dark); font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-medal" style="color: #fbbf24; font-size: 1.3rem;"></i> {{ __('messages.cd_top_contributors') }}
                        </h3>
                        <p style="margin: 4px 0 0; font-size: 0.85rem; color: var(--text-muted);">{{ __('messages.cd_heroes') }}</p>
                    </div>
                    <div style="display: flex; gap: 1.5rem; overflow-x: auto; padding-bottom: 5px;">
                        @foreach($topContributors as $topUser)
                            <div style="display: flex; align-items: center; gap: 10px; min-width: max-content;">
                                <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.9rem; position: relative;">
                                    {{ strtoupper(substr($topUser->first_name, 0, 1) . substr($topUser->last_name, 0, 1)) }}
                                    @if($loop->first)
                                        <div style="position: absolute; top: -6px; right: -6px; color: #fbbf24; font-size: 1.1rem;"><i class="fa-solid fa-crown"></i></div>
                                    @endif
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-size: 0.85rem; font-weight: 600; color: var(--primary-dark);">{{ $topUser->first_name }} {{ $topUser->last_name }}</span>
                                    <span style="font-size: 0.75rem; color: var(--primary); font-weight: 600;">{{ $topUser->materials_count }} {{ __('messages.cd_uploads') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Tabs & Content Section -->
                <div class="content-tabs-section">
                    <div class="tabs-nav" id="materialTabs">
                        <button class="tab-btn active" data-tab="summary">{{ __('messages.cd_summaries') }}</button>
                        <button class="tab-btn" data-tab="pdf">{{ __('messages.cd_pdfs') }}</button>
                        <button class="tab-btn" data-tab="video">{{ __('messages.cd_videos') }}</button>
                        <button class="tab-btn" data-tab="exam_bank">{{ __('messages.cd_exam_banks') }}</button>
                        <button class="tab-btn" data-tab="resource">{{ __('messages.cd_resources') }}</button>
                        <button class="tab-btn" data-tab="discussion">{{ __('messages.cd_discussion') }}</button>
                    </div>

                    <div class="tab-content">
                        <div class="tab-header">
                            <h3 style="color: var(--primary-dark); font-size: 1.1rem; margin: 0;">{{ __('messages.cd_course_mat') }}</h3>
                            <input type="text" class="tab-search" placeholder="{{ __('messages.cd_search_mat') }}" />
                        </div>

                        <div class="materials-table">
                            <div class="table-row header">
                                <div>{{ __('messages.cd_file_name') }}</div>
                                <div>{{ __('messages.cd_uploaded_by') }}</div>
                                <div>{{ __('messages.cd_date') }}</div>
                                <div>{{ __('messages.cd_rating') }}</div>
                                <div>{{ __('messages.cd_actions') }}</div>
                            </div>
                            @foreach ($materials as $material)
                                @php
                                    $isFavorited = auth()
                                        ->user()
                                        ->favorites()
                                        ->where('material_id', $material->id)
                                        ->exists();
                                @endphp
                                <div class="table-row material-item" data-type="{{ strtolower($material->type) }}">
                                    <div class="col-info">
                                        <div class="file-icon {{ strtolower($material->type) }}">
                                            @if (strtolower($material->type) == 'pdf')
                                                <i class="fa-regular fa-file-pdf"></i>
                                            @elseif(strtolower($material->type) == 'video')
                                                <i class="fa-solid fa-video"></i>
                                            @else
                                                <i class="fa-regular fa-file-lines"></i>
                                            @endif
                                        </div>
                                        <div class="file-details">
                                            <span class="file-name">{{ $material->title }}</span>
                                            <span class="file-size">{{ strtoupper($material->type) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-meta">
                                        <div class="uploader">
                                            <div
                                                style="width: 28px; height: 28px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; color: #64748b; font-weight: bold;">
                                                {{ strtoupper(substr($material->user->first_name, 0, 1) . substr($material->user->last_name, 0, 1)) }}
                                            </div>
                                            {{ $material->user->first_name }} {{ $material->user->last_name }}
                                        </div>
                                    </div>
                                    <div class="col-date">{{ $material->created_at->format('M d, Y') }}</div>
                                    <!-- Rating Column -->
                                    <div class="col-rating" id="rating-col-{{ $material->id }}">
                                        @php
                                            $avgRating = $material->ratings_avg_rating ?? 0;
                                            $ratingCount = $material->ratings_count ?? 0;
                                            $myRating = auth()->check()
                                                ? optional($material->userRating(auth()->id()))->rating
                                                : null;
                                        @endphp
                                        <div style="display:flex; flex-direction:column; align-items:center; gap:2px;">
                                            <div class="star-rating" data-material-id="{{ $material->id }}"
                                                data-my-rating="{{ $myRating ?? 0 }}">
                                                @for ($s = 1; $s <= 5; $s++)
                                                    <i class="fa-{{ $myRating && $s <= $myRating ? 'solid' : 'regular' }} fa-star star-btn"
                                                        data-val="{{ $s }}"
                                                        style="cursor:pointer; color: {{ $myRating && $s <= $myRating ? '#f59e0b' : '#d1d5db' }}; font-size:0.85rem;"
                                                        onclick="rateMaterial({{ $material->id }}, {{ $s }})"></i>
                                                @endfor
                                            </div>
                                            <span id="avg-label-{{ $material->id }}"
                                                style="font-size:0.7rem; color:var(--text-muted);">
                                                {{ $ratingCount > 0 ? round($avgRating, 1) . ' (' . $ratingCount . ')' : __('messages.cd_no_ratings') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-actions">
                                        <a href="{{ $material->file_path ? asset('storage/' . $material->file_path) : '#' }}" class="btn btn-outline" target="_blank"
                                            style="padding: 6px 10px; border-radius: 50%; border-color: #cbd5e1; color: #64748b; text-decoration: none;"><i
                                                class="fa-regular fa-eye"></i></a>
                                        <a href="{{ $material->file_path ? asset('storage/' . $material->file_path) : '#' }}" download class="btn btn-outline"
                                            style="padding: 6px 10px; border-radius: 50%; border-color: #cbd5e1; color: #64748b; text-decoration: none;"><i
                                                class="fa-solid fa-download"></i></a>
                                        <button class="btn btn-outline btn-like"
                                            style="padding: 6px 10px; border-radius: 50%; border-color: {{ $isFavorited ? 'var(--primary)' : '#cbd5e1' }}; color: {{ $isFavorited ? 'var(--primary)' : '#64748b' }};"
                                            onclick="toggleFavorite({{ $material->id }}, this)"><i
                                                class="fa-{{ $isFavorited ? 'solid' : 'regular' }} fa-heart"></i></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Discussion & Rating -->
                <div class="section-grid">
                    <!-- Contributors Card -->
                    <div class="rating-card">
                        <h3 style="color: var(--primary-dark); font-size: 1.1rem; margin-top: 0; margin-bottom: 1rem;">
                            <i class="fa-solid fa-users"
                                style="color:var(--primary); margin-right:6px;"></i>{{ __('messages.cd_contributors') }}
                        </h3>
                        @if ($contributors->isEmpty())
                            <p style="color:var(--text-muted); font-size:0.9rem;">{{ __('messages.cd_no_contrib') }}</p>
                        @else
                            <div style="display:flex; flex-direction:column; gap:0.75rem;">
                                @foreach ($contributors as $contrib)
                                    <div style="display:flex; align-items:center; gap:0.6rem;">
                                        <div
                                            style="width:36px; height:36px; border-radius:50%; background:var(--primary-light); color:var(--primary); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.85rem; flex-shrink:0;">
                                            {{ strtoupper(substr($contrib->first_name, 0, 1) . substr($contrib->last_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight:600; font-size:0.9rem; color:var(--primary-dark);">
                                                {{ $contrib->first_name }} {{ $contrib->last_name }}</div>
                                            <div style="font-size:0.75rem; color:var(--text-muted);">
                                                {{ $materials->where('user_id', $contrib->id)->count() }} {{ __('messages.cd_upload_s') }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Discussion Card -->
                    <div class="comments-container" id="discussionSection" style="display: none;">
                        <!-- Header -->
                        <div class="comments-header">
                            <div>
                                <h3><i class="fa-solid fa-comments"></i> {{ __('messages.cd_discussion') }}</h3>
                                <span class="comment-count-badge"
                                    id="commentCountBadge">{{ $comments->count() + $comments->sum(fn($c) => $c->replies->count()) }}
                                    {{ $comments->count() + $comments->sum(fn($c) => $c->replies->count()) != 1 ? __('messages.cd_comments') : __('messages.cd_comment') }}</span>
                            </div>
                            <div class="comment-sort">
                                <button class="sort-btn active" data-sort="newest"
                                    onclick="sortComments('newest', this)">
                                    <i class="fa-solid fa-arrow-down-wide-short"></i> {{ __('messages.cd_newest') }}
                                </button>
                                <button class="sort-btn" data-sort="popular" onclick="sortComments('popular', this)">
                                    <i class="fa-solid fa-fire"></i> {{ __('messages.cd_popular') }}
                                </button>
                            </div>
                        </div>

                        <!-- Comment Input -->
                        <div class="comment-input-box">
                            <div class="user-avatar-comment" style="background: var(--primary);">
                                {{ strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)) }}
                            </div>
                            <div class="comment-input-wrapper">
                                <textarea id="mainCommentBox" placeholder="{{ __('messages.cd_share_thought') }}" rows="1"
                                    oninput="autoResize(this)" onfocus="showCommentActions(this)"></textarea>
                                <div class="comment-input-actions" id="mainCommentActions" style="display:none;">
                                    <span class="char-count" id="mainCharCount">0 / 2000</span>
                                    <div>
                                        <button class="btn-cancel-comment"
                                            onclick="cancelComment('mainCommentBox', 'mainCommentActions')">{{ __('messages.cd_cancel') }}</button>
                                        <button class="btn-post-comment"
                                            onclick="postComment({{ $course->id ?? 0 }}, null, 'mainCommentBox')">
                                            <i class="fa-solid fa-paper-plane"></i> {{ __('messages.cd_post') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Comments List -->
                        <div class="comments-list" id="commentsList">
                            @forelse($comments as $comment)
                                @php
                                    $userLiked = $comment->likedByUsers->contains('id', auth()->id());
                                    $initials = strtoupper(
                                        substr($comment->user->first_name, 0, 1) .
                                            substr($comment->user->last_name, 0, 1),
                                    );
                                    $colors = ['#7c3aed', '#0891b2', '#059669', '#d97706', '#db2777', '#2563eb'];
                                    $colorIndex = crc32($comment->user->first_name) % count($colors);
                                    $avatarColor = $colors[abs($colorIndex)];
                                @endphp
                                <div class="comment-item" id="comment-{{ $comment->id }}"
                                    data-likes="{{ $comment->likes }}"
                                    data-time="{{ $comment->created_at->timestamp }}">
                                    <div class="comment-avatar" style="background: {{ $avatarColor }};">
                                        {{ $initials }}</div>
                                    <div class="comment-body-wrap">
                                        <div class="comment-bubble">
                                            <div class="comment-meta-top">
                                                <span class="comment-author">{{ $comment->user->first_name }}
                                                    {{ $comment->user->last_name }}</span>
                                                <span class="comment-dot">·</span>
                                                <span
                                                    class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                                                @if ($comment->user_id === auth()->id())
                                                    <button class="comment-delete-btn"
                                                        onclick="deleteComment({{ $comment->id }})" title="{{ __('messages.cd_delete') }}">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                @endif
                                            </div>
                                            <p class="comment-text">{{ $comment->body }}</p>
                                        </div>
                                        <div class="comment-actions-row">
                                            <button class="action-like-btn {{ $userLiked ? 'liked' : '' }}"
                                                onclick="toggleLike({{ $comment->id }}, this)"
                                                id="like-btn-{{ $comment->id }}">
                                                <i class="fa-{{ $userLiked ? 'solid' : 'regular' }} fa-heart"></i>
                                                <span
                                                    id="like-count-{{ $comment->id }}">{{ $comment->likes }}</span>
                                            </button>
                                            <button class="action-reply-btn"
                                                onclick="toggleReplyBox({{ $comment->id }})">
                                                <i class="fa-solid fa-reply"></i> {{ __('messages.cd_reply') }}
                                            </button>
                                            @if ($comment->replies->count() > 0)
                                                <button class="action-toggle-replies"
                                                    onclick="toggleReplies({{ $comment->id }}, this)">
                                                    <i class="fa-solid fa-chevron-down"></i>
                                                    <span>{{ $comment->replies->count() }}
                                                        {{ $comment->replies->count() == 1 ? __('messages.cd_reply') : __('messages.cd_replies') }}</span>
                                                </button>
                                            @endif
                                            @if ($comment->user_id !== auth()->id())
                                                <button class="action-report-btn"
                                                    onclick="reportComment({{ $comment->id }}, this)"
                                                    title="Report comment"
                                                    style="background:none;border:none;cursor:pointer;color:#94a3b8;font-size:.8rem;display:inline-flex;align-items:center;gap:4px;padding:4px 8px;border-radius:6px;transition:color .2s,background .2s;"
                                                    onmouseover="this.style.color='#ef4444';this.style.background='rgba(239,68,68,.08)'"
                                                    onmouseout="this.style.color='#94a3b8';this.style.background='none'">
                                                    <i class="fa-solid fa-flag"></i> {{ __('messages.cd_report') }}
                                                </button>
                                            @endif
                                        </div>

                                        <!-- Reply Input -->
                                        <div class="reply-input-box" id="reply-box-{{ $comment->id }}"
                                            style="display:none;">
                                            <div class="user-avatar-comment sm" style="background: var(--primary);">
                                                {{ strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)) }}
                                            </div>
                                            <div class="comment-input-wrapper">
                                                <textarea id="reply-input-{{ $comment->id }}" placeholder="{{ __('messages.cd_write_reply') }}" rows="1"
                                                    oninput="autoResize(this)"></textarea>
                                                <div class="comment-input-actions" style="display:flex;">
                                                    <span class="char-count"></span>
                                                    <div>
                                                        <button class="btn-cancel-comment"
                                                            onclick="toggleReplyBox({{ $comment->id }})">{{ __('messages.cd_cancel') }}</button>
                                                        <button class="btn-post-comment"
                                                            onclick="postComment({{ $course->id ?? 0 }}, {{ $comment->id }}, 'reply-input-{{ $comment->id }}')">
                                                            <i class="fa-solid fa-paper-plane"></i> {{ __('messages.cd_reply') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Replies -->
                                        @if ($comment->replies->count() > 0)
                                            <div class="replies-list" id="replies-{{ $comment->id }}"
                                                style="display:none;">
                                                @foreach ($comment->replies as $reply)
                                                    @php
                                                        $replyLiked = $reply->likedByUsers->contains(
                                                            'id',
                                                            auth()->id(),
                                                        );
                                                        $replyInitials = strtoupper(
                                                            substr($reply->user->first_name, 0, 1) .
                                                                substr($reply->user->last_name, 0, 1),
                                                        );
                                                        $replyColorIndex =
                                                            crc32($reply->user->first_name) % count($colors);
                                                        $replyAvatarColor = $colors[abs($replyColorIndex)];
                                                    @endphp
                                                    <div class="comment-item reply-item"
                                                        id="comment-{{ $reply->id }}">
                                                        <div class="comment-avatar sm"
                                                            style="background: {{ $replyAvatarColor }};">
                                                            {{ $replyInitials }}</div>
                                                        <div class="comment-body-wrap">
                                                            <div class="comment-bubble">
                                                                <div class="comment-meta-top">
                                                                    <span
                                                                        class="comment-author">{{ $reply->user->first_name }}
                                                                        {{ $reply->user->last_name }}</span>
                                                                    <span class="comment-dot">·</span>
                                                                    <span
                                                                        class="comment-time">{{ $reply->created_at->diffForHumans() }}</span>
                                                                    @if ($reply->user_id === auth()->id())
                                                                        <button class="comment-delete-btn"
                                                                            onclick="deleteComment({{ $reply->id }})"
                                                                            title="Delete">
                                                                            <i class="fa-solid fa-trash-can"></i>
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                                <p class="comment-text">{{ $reply->body }}</p>
                                                            </div>
                                                            <div class="comment-actions-row">
                                                                <button
                                                                    class="action-like-btn {{ $replyLiked ? 'liked' : '' }}"
                                                                    onclick="toggleLike({{ $reply->id }}, this)"
                                                                    id="like-btn-{{ $reply->id }}">
                                                                    <i
                                                                        class="fa-{{ $replyLiked ? 'solid' : 'regular' }} fa-heart"></i>
                                                                    <span
                                                                        id="like-count-{{ $reply->id }}">{{ $reply->likes }}</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="empty-comments" id="emptyComments">
                                    <div class="empty-comments-icon">
                                        <i class="fa-regular fa-comments"></i>
                                    </div>
                                    <h4>{{ __('messages.cd_no_discuss') }}</h4>
                                    <p>{{ __('messages.cd_be_first') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            @include('components.footer')
        </main>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;

        // Auto-resize textarea
        function autoResize(el) {
            el.style.height = 'auto';
            el.style.height = Math.min(el.scrollHeight, 200) + 'px';
            // update char count if main box
            const charEl = document.getElementById('mainCharCount');
            if (charEl && el.id === 'mainCommentBox') {
                charEl.textContent = `${el.value.length} / 2000`;
                charEl.style.color = el.value.length > 1800 ? '#ef4444' : '#94a3b8';
            }
        }

        function showCommentActions(el) {
            const actions = document.getElementById('mainCommentActions');
            if (actions) actions.style.display = 'flex';
        }

        function cancelComment(textareaId, actionsId) {
            const ta = document.getElementById(textareaId);
            const ac = document.getElementById(actionsId);
            if (ta) {
                ta.value = '';
                ta.style.height = 'auto';
            }
            if (ac) ac.style.display = 'none';
            if (document.getElementById('mainCharCount')) document.getElementById('mainCharCount').textContent = '0 / 2000';
        }

        function toggleReplyBox(commentId) {
            const box = document.getElementById(`reply-box-${commentId}`);
            if (!box) return;
            const isHidden = box.style.display === 'none';
            box.style.display = isHidden ? 'flex' : 'none';
            if (isHidden) {
                box.style.animation = 'slideDown 0.2s ease';
                document.getElementById(`reply-input-${commentId}`)?.focus();
            }
        }

        function toggleReplies(commentId, btn) {
            const list = document.getElementById(`replies-${commentId}`);
            if (!list) return;
            const isHidden = list.style.display === 'none';
            list.style.display = isHidden ? 'block' : 'none';
            if (isHidden) list.style.animation = 'slideDown 0.25s ease';
            const icon = btn.querySelector('i');
            icon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0)';
            icon.style.transition = 'transform 0.2s ease';
        }

        async function postComment(courseId, parentId, textareaId) {
            const ta = document.getElementById(textareaId);
            if (!ta || !ta.value.trim()) {
                ta?.classList.add('shake');
                setTimeout(() => ta?.classList.remove('shake'), 500);
                return;
            }

            const btn = ta.closest('.comment-input-wrapper').querySelector('.btn-post-comment');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';

            const body = {
                body: ta.value.trim()
            };
            if (parentId) body.parent_id = parentId;

            try {
                const res = await fetch(`/courses/${courseId}/comments`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF
                    },
                    body: JSON.stringify(body),
                });
                const data = await res.json();

                if (data.success) {
                    ta.value = '';
                    ta.style.height = 'auto';
                    btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i>' + (parentId ? ' Reply' : ' Post');
                    btn.disabled = false;

                    // hide actions for main box
                    if (!parentId) {
                        document.getElementById('mainCommentActions').style.display = 'none';
                        document.getElementById('mainCharCount').textContent = '0 / 2000';
                    } else {
                        document.getElementById(`reply-box-${parentId}`).style.display = 'none';
                    }

                    const c = data.comment;
                    const colors = ['#7c3aed', '#0891b2', '#059669', '#d97706', '#db2777', '#2563eb'];
                    const idx = Math.abs(c.user.name.charCodeAt(0) % colors.length);
                    const color = colors[idx];

                    if (!parentId) {
                        // top-level comment
                        const emptyEl = document.getElementById('emptyComments');
                        if (emptyEl) emptyEl.remove();

                        const html = buildCommentHTML(c, color, courseId, false);
                        const list = document.getElementById('commentsList');
                        list.insertAdjacentHTML('afterbegin', html);
                        document.getElementById(`comment-${c.id}`).style.animation = 'fadeInUp 0.35s ease';
                        updateCommentCount(1);
                    } else {
                        // reply
                        let repliesList = document.getElementById(`replies-${parentId}`);
                        if (!repliesList) {
                            // create replies container
                            const wrap = document.querySelector(`#comment-${parentId} .comment-body-wrap`);
                            const replyHTML =
                                `<div class="replies-list" id="replies-${parentId}" style="display:block;"></div>`;
                            wrap.insertAdjacentHTML('beforeend', replyHTML);
                            repliesList = document.getElementById(`replies-${parentId}`);
                            // add toggle button
                            const actionsRow = document.querySelector(`#comment-${parentId} .comment-actions-row`);
                            actionsRow.insertAdjacentHTML('beforeend', `
                            <button class="action-toggle-replies" onclick="toggleReplies(${parentId}, this)">
                                <i class="fa-solid fa-chevron-down" style="transform:rotate(180deg);transition:transform 0.2s;"></i>
                                <span>1 reply</span>
                            </button>`);
                        }
                        const replyHtml = buildCommentHTML(c, color, courseId, true);
                        repliesList.insertAdjacentHTML('beforeend', replyHtml);
                        repliesList.style.display = 'block';
                        document.getElementById(`comment-${c.id}`).style.animation = 'fadeInUp 0.3s ease';
                        updateCommentCount(1);
                    }
                    // scroll new comment into view softly
                    setTimeout(() => document.getElementById(`comment-${c.id}`)?.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    }), 100);
                }
            } catch (e) {
                btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i>' + (parentId ? ' Reply' : ' Post');
                btn.disabled = false;
            }
        }

        function buildCommentHTML(c, color, courseId, isReply) {
            const sizeClass = isReply ? 'sm' : '';
            return `
        <div class="comment-item ${isReply ? 'reply-item' : ''}" id="comment-${c.id}" data-likes="0" data-time="${Date.now()}">
            <div class="comment-avatar ${sizeClass}" style="background:${color};">${c.user.initials}</div>
            <div class="comment-body-wrap">
                <div class="comment-bubble">
                    <div class="comment-meta-top">
                        <span class="comment-author">${c.user.name}</span>
                        <span class="comment-dot">·</span>
                        <span class="comment-time">just now</span>
                        <button class="comment-delete-btn" onclick="deleteComment(${c.id})" title="Delete">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                    <p class="comment-text">${escapeHTML(c.body)}</p>
                </div>
                <div class="comment-actions-row">
                    <button class="action-like-btn" onclick="toggleLike(${c.id}, this)" id="like-btn-${c.id}">
                        <i class="fa-regular fa-heart"></i>
                        <span id="like-count-${c.id}">0</span>
                    </button>
                    ${!isReply ? `<button class="action-reply-btn" onclick="toggleReplyBox(${c.id})">
                            <i class="fa-solid fa-reply"></i> Reply
                        </button>
                        <button class="action-report-btn" onclick="reportComment(${c.id}, this)" title="Report comment" style="background:none;border:none;cursor:pointer;color:#94a3b8;font-size:.8rem;display:inline-flex;align-items:center;gap:4px;padding:4px 8px;border-radius:6px;transition:color .2s,background .2s;" onmouseover="this.style.color='#ef4444';this.style.background='rgba(239,68,68,.08)'" onmouseout="this.style.color='#94a3b8';this.style.background='none'">
                            <i class="fa-solid fa-flag"></i> Report
                        </button>
                        <div class="reply-input-box" id="reply-box-${c.id}" style="display:none;">
                            <div class="user-avatar-comment sm" style="background:var(--primary);">${document.querySelector('.user-avatar-comment').textContent.trim()}</div>
                            <div class="comment-input-wrapper">
                                <textarea id="reply-input-${c.id}" placeholder="Write a reply..." rows="1" oninput="autoResize(this)"></textarea>
                                <div class="comment-input-actions" style="display:flex;">
                                    <span class="char-count"></span>
                                    <div>
                                        <button class="btn-cancel-comment" onclick="toggleReplyBox(${c.id})">Cancel</button>
                                        <button class="btn-post-comment" onclick="postComment(${courseId}, ${c.id}, 'reply-input-${c.id}')">
                                            <i class="fa-solid fa-paper-plane"></i> Reply
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>` : ''}
                </div>
            </div>
        </div>`;
        }

        function escapeHTML(str) {
            return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        async function toggleLike(commentId, btn) {
            btn.disabled = true;
            const res = await fetch(`/comments/${commentId}/like`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF
                }
            });
            const data = await res.json();
            if (data.success) {
                const icon = btn.querySelector('i');
                const count = btn.querySelector('span');
                icon.className = data.liked ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
                count.textContent = data.likes;
                btn.classList.toggle('liked', data.liked);
                // pop animation
                btn.style.transform = 'scale(1.3)';
                setTimeout(() => btn.style.transform = 'scale(1)', 200);
            }
            btn.disabled = false;
        }

        async function deleteComment(commentId) {
            if (!confirm('Delete this comment?')) return;
            const res = await fetch(`/comments/${commentId}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF
                }
            });
            const data = await res.json();
            if (data.success) {
                const el = document.getElementById(`comment-${commentId}`);
                if (el) {
                    el.style.animation = 'fadeOut 0.3s ease forwards';
                    setTimeout(() => {
                        el.remove();
                        updateCommentCount(-1);
                        if (document.getElementById('commentsList').querySelectorAll(
                                '.comment-item:not(.reply-item)').length === 0) {
                            document.getElementById('commentsList').innerHTML = `
                            <div class="empty-comments" id="emptyComments">
                                <div class="empty-comments-icon"><i class="fa-regular fa-comments"></i></div>
                                <h4>No discussions yet</h4>
                                <p>Be the first to start a discussion in this course!</p>
                            </div>`;
                        }
                    }, 300);
                }
            }
        }

        async function reportComment(commentId, btn) {
            if (btn.dataset.reported) return;
            btn.disabled = true;
            btn.style.opacity = '0.5';
            try {
                const res = await fetch(`/comments/${commentId}/report`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF
                    }
                });
                const data = await res.json();
                if (data.success) {
                    btn.dataset.reported = '1';
                    btn.innerHTML =
                        '<i class="fa-solid fa-flag" style="color:#ef4444;"></i> <span style="color:#ef4444;">Reported</span>';
                    btn.style.opacity = '1';
                    if (typeof showToast === 'function') {
                        showToast('تم الإبلاغ عن التعليق للمراجعة', 'success');
                    }
                }
            } catch (e) {
                btn.disabled = false;
                btn.style.opacity = '1';
            }
        }

        function updateCommentCount(delta) {
            const badge = document.getElementById('commentCountBadge');
            if (!badge) return;
            const current = parseInt(badge.textContent) || 0;
            const newCount = Math.max(0, current + delta);
            badge.textContent = `${newCount} comment${newCount !== 1 ? 's' : ''}`;
        }

        function sortComments(type, btn) {
            document.querySelectorAll('.sort-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const list = document.getElementById('commentsList');
            const items = Array.from(list.querySelectorAll('.comment-item:not(.reply-item)'));
            items.sort((a, b) => {
                if (type === 'popular') {
                    return (parseInt(b.dataset.likes) || 0) - (parseInt(a.dataset.likes) || 0);
                } else {
                    return (parseInt(b.dataset.time) || 0) - (parseInt(a.dataset.time) || 0);
                }
            });
            items.forEach(item => list.appendChild(item));
        }

        // Toggle favorite
        async function toggleFavorite(materialId, btn) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const res = await fetch(`/favorite/${materialId}`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            const data = await res.json();
            if (data.success) {
                const icon = btn.querySelector('i');
                icon.className = data.favorited ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
                btn.style.borderColor = data.favorited ? 'var(--primary)' : '#cbd5e1';
                btn.style.color = data.favorited ? 'var(--primary)' : '#64748b';
            }
        }

        // Rate material (1-5 stars)
        async function rateMaterial(materialId, val) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const res = await fetch(`/materials/${materialId}/rate`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    rating: val
                })
            });
            const data = await res.json();
            if (data.success) {
                // Update stars UI
                const container = document.querySelector(`.star-rating[data-material-id="${materialId}"]`);
                if (container) {
                    container.dataset.myRating = val;
                    container.querySelectorAll('.star-btn').forEach((star, i) => {
                        const filled = i < val;
                        star.className = `fa-${filled ? 'solid' : 'regular'} fa-star star-btn`;
                        star.style.color = filled ? '#f59e0b' : '#d1d5db';
                    });
                }
                // Update avg label
                const label = document.getElementById(`avg-label-${materialId}`);
                if (label) label.textContent = `${data.avg} (${data.count})`;
            }
        }

        // Star hover effect
        document.querySelectorAll('.star-rating').forEach(container => {
            const stars = container.querySelectorAll('.star-btn');
            stars.forEach((star, idx) => {
                star.addEventListener('mouseenter', () => {
                    stars.forEach((s, i) => {
                        s.style.color = i <= idx ? '#f59e0b' : '#d1d5db';
                    });
                });
                star.addEventListener('mouseleave', () => {
                    const myRating = parseInt(container.dataset.myRating) || 0;
                    stars.forEach((s, i) => {
                        s.style.color = i < myRating ? '#f59e0b' : '#d1d5db';
                    });
                });
            });
        });

        // Material Tabs Filtering
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('#materialTabs .tab-btn');
            const items = document.querySelectorAll('.material-item');
            const discussionSection = document.getElementById('discussionSection');
            const materialsTable = document.querySelector('.materials-table');

            // Initial filter to 'summary'
            filterMaterials('summary');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');

                    const targetTab = tab.dataset.tab;
                    const tabHeader = document.querySelector('.tab-header');

                    if (targetTab === 'discussion') {
                        materialsTable.style.display = 'none';
                        if (tabHeader) tabHeader.style.display = 'none';
                        discussionSection.style.display = 'block';
                    } else {
                        materialsTable.style.display = 'block';
                        if (tabHeader) tabHeader.style.display = 'flex';
                        discussionSection.style.display =
                        'none'; // hide discussion if showing materials
                        filterMaterials(targetTab);
                    }
                });
            });

            function filterMaterials(type) {
                let hasVisible = false;
                items.forEach(item => {
                    if (item.dataset.type === type) {
                        item.style.display = 'flex';
                        hasVisible = true;
                    } else {
                        item.style.display = 'none';
                    }
                });
            }
        });

        // Share Course function
        function shareCourse() {
            const url = window.location.href;
            const title = '{{ $course->title }}';
            
            if (navigator.share) {
                navigator.share({
                    title: title,
                    text: 'Check out this course on EngHub!',
                    url: url
                }).catch(console.error);
            } else {
                navigator.clipboard.writeText(url).then(() => {
                    alert('Course link copied to clipboard!');
                }).catch(err => {
                    console.error('Failed to copy: ', err);
                });
            }
        }
    </script>
</body>

</html>
