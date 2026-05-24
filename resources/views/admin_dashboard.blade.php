@php
    use Illuminate\Support\Facades\DB;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - C0DiA</title>
    <link rel="stylesheet" href="{{ asset('dashboard.css') }}">
    <style>
        .admin-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            text-align: center;
        }

        .stat-card h3 {
            color: #e60000;
            margin: 0 0 10px 0;
            font-size: 2em;
        }

        .stat-card p {
            color: #475569;
            margin: 0;
            font-size: 1.1em;
        }

        .admin-section {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .admin-section h3 {
            color: #e60000;
            margin-bottom: 15px;
            border-bottom: 2px solid #fee2e2;
            padding-bottom: 10px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .data-table th,
        .data-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .data-table th {
            background: #f8fafc;
            color: #e60000;
            font-weight: 600;
        }

        .data-table tr:hover {
            background: #f1f5f9;
        }

        .course-button {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            font-weight: 600;
            width: 100%;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
            position: relative;
            overflow: hidden;
        }

        .course-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .course-button:hover::before {
            left: 100%;
        }

        .course-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #764ba2, #667eea);
        }

        .course-button.active {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            box-shadow: 0 6px 20px rgba(79, 172, 254, 0.4);
        }

        .course-button.active:hover {
            background: linear-gradient(135deg, #00f2fe, #4facfe);
        }

        .course-enrollment {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }

        .enrollment-card {
            background: linear-gradient(145deg, #ffffff, #f8fafc);
            padding: 0;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.8);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
        }

        .enrollment-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #e60000, #ff4444, #ff8888);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .enrollment-card:hover::before {
            opacity: 1;
        }

        .enrollment-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .course-button {
            background: linear-gradient(135deg, #e60000 0%, #ff4444 50%, #ff8888 100%);
            color: white;
            border: none;
            padding: 25px 20px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
            font-weight: 700;
            font-size: 18px;
            width: 100%;
            box-shadow: 0 6px 25px rgba(230, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .course-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.7s ease;
        }

        .course-button:hover::before {
            left: 100%;
        }

        .course-button:hover {
            transform: translateY(-3px) scale(1.01);
            box-shadow: 0 15px 45px rgba(230, 0, 0, 0.5);
            background: linear-gradient(135deg, #ff8888 0%, #ff4444 50%, #e60000 100%);
        }

        .course-button:active {
            transform: translateY(-1px) scale(0.99);
        }

        .course-button.active {
            background: linear-gradient(135deg, #ff0000 0%, #ff6666 50%, #ffaaaa 100%);
            box-shadow: 0 10px 35px rgba(255, 0, 0, 0.6);
            animation: pulse-glow 2s infinite;
        }

        .course-button.active:hover {
            background: linear-gradient(135deg, #ffaaaa 0%, #ff6666 50%, #ff0000 100%);
        }

        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 10px 35px rgba(255, 0, 0, 0.6);
            }
            50% {
                box-shadow: 0 10px 35px rgba(255, 0, 0, 0.9);
            }
        }

        .course-details {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .course-details.show {
            display: block;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
            margin: 5px 0;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #e60000, #28a745);
            transition: width 0.3s ease;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-incomplete {
            background: #fff3cd;
            color: #856404;
        }

        .enrolled-user {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            border: 1px solid #e2e8f0;
        }

        .user-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .user-details {
            flex: 1;
        }

        .user-progress {
            text-align: right;
        }

        .user-progress-item {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .user-progress-item h4 {
            color: #e60000;
            margin: 0 0 5px 0;
        }

        .progress-courses {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .course-tag {
            background: #fee2e2;
            color: #e60000;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
        }
    </style>

    <script>
        function toggleCourseDetails(courseName) {
            const detailsSection = document.getElementById('course-details-' + courseName);
            const button = document.getElementById('course-btn-' + courseName);

            // Hide all other course details
            document.querySelectorAll('.course-details').forEach(section => {
                if (section.id !== 'course-details-' + courseName) {
                    section.classList.remove('show');
                }
            });

            // Remove active class from all buttons
            document.querySelectorAll('.course-button').forEach(btn => {
                if (btn.id !== 'course-btn-' + courseName) {
                    btn.classList.remove('active');
                }
            });

            // Toggle current course details
            detailsSection.classList.toggle('show');
            button.classList.toggle('active');
        }
    </script>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>C0DiA</h2>
        <a href="{{ route('admin.dashboard') }}">📊 Admin Dashboard</a>
        <a href="{{ route('logout') }}">🚪 Logout</a>
    </div>

    <!-- MAIN -->
    <div class="main">
        <!-- FEED -->
        <div class="feed">
            <h2>Admin Dashboard 👑</h2>
            <p>Welcome, Administrator {{ session('username') }}</p>

            <!-- STATISTICS CARDS -->
            <div class="admin-stats">
                <div class="stat-card">
                    <h3>{{ $stats['total_users'] }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="stat-card">
                    <h3>{{ $stats['total_posts'] }}</h3>
                    <p>Total Posts</p>
                </div>
                <div class="stat-card">
                    <h3>{{ $stats['total_comments'] }}</h3>
                    <p>Total Comments</p>
                </div>
                <div class="stat-card">
                    <h3>{{ $stats['total_reactions'] }}</h3>
                    <p>Total Reactions</p>
                </div>
                <div class="stat-card">
                    <h3>{{ $stats['total_certificates'] }}</h3>
                    <p>Total Certificates</p>
                </div>
                <div class="stat-card">
                    <h3>{{ $stats['total_login_logs'] }}</h3>
                    <p>Total Login Sessions</p>
                </div>
            </div>

            <!-- COURSE ENROLLMENTS -->
            <div class="admin-section">
                <h3>📚 Course Enrollment Statistics</h3>
                <p style="color: #666; margin-bottom: 10px;">Click on any course to view enrolled users and their progress</p>
                <div class="course-enrollment">
                    @foreach($course_enrollments as $enrollment)
                        @php
                            $courseIcon = match($enrollment->course_name) {
                                'C' => '💻',
                                'C++' => '⚡',
                                'Java' => '☕',
                                'Python' => '🐍',
                                'HTML' => '🌐',
                                default => '📚'
                            };
                        @endphp
                        <div class="enrollment-card">
                            <button class="course-button" id="course-btn-{{ $enrollment->course_name }}" onclick="toggleCourseDetails('{{ $enrollment->course_name }}')">
                                <span style="font-size: 24px; margin-bottom: 8px; display: block;">{{ $courseIcon }}</span>
                                {{ $enrollment->course_name }}<br>
                                <small style="font-size: 14px; opacity: 0.9; font-weight: 400;">{{ $enrollment->enrolled_count }} users enrolled</small>
                            </button>

                            <!-- Detailed enrollment section -->
                            <div class="course-details" id="course-details-{{ $enrollment->course_name }}">
                                <h4>📝 Enrolled Users in {{ $enrollment->course_name }}</h4>
                                @if(isset($course_details[$enrollment->course_name]) && $course_details[$enrollment->course_name]->count() > 0)
                                    @foreach($course_details[$enrollment->course_name] as $user)
                                        <div class="enrolled-user">
                                            <div class="user-info">
                                                <div class="user-details">
                                                    <strong>{{ $user->first }} {{ $user->last }}</strong>
                                                    <br>
                                                    <small style="color: #666;">{{ $user->username }} • {{ $user->email }}</small>
                                                </div>
                                                <div class="user-progress">
                                                    <span class="status-badge {{ $user->is_completed ? 'status-completed' : 'status-incomplete' }}">
                                                        {{ $user->is_completed ? 'Completed' : 'In Progress' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: {{ $user->progress_percentage }}%"></div>
                                            </div>
                                            <small style="color: #666;">
                                                Progress: {{ $user->current_lesson ?? 0 }}/6 lessons ({{ $user->progress_percentage }}%)
                                                @if($user->certificate_id)
                                                    • Certificate Earned ✅
                                                @endif
                                            </small>
                                        </div>
                                    @endforeach
                                @else
                                    <p style="text-align: center; color: #666; padding: 20px;">No users enrolled in this course yet.</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- RECENT USER REGISTRATIONS -->
            <div class="admin-section">
                <h3>👥 Recent User Registrations</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent_users as $user)
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->first }} {{ $user->last }}</td>
                                <td>{{ $user->email }}</td>
                                <td>User #{{ $user->id }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- RECENT LOGIN ACTIVITY -->
            <div class="admin-section">
                <h3>🔐 Recent Login Activity</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Login Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent_logins as $login)
                            <tr>
                                <td>{{ $login->username }}</td>
                                <td>{{ $login->first }} {{ $login->last }}</td>
                                <td>{{ \Carbon\Carbon::parse($login->login_time)->format('M d, Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            </div>

        </div>
    </div>

</body>
</html>
