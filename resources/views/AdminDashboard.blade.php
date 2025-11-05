<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/AdminDashboard.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/Logo_white.svg') }}">
</head>

<body>
    <nav class="sidebar">
        <a href="{{ route('Donation') }}">
            <div class="sidebar-icon">
                <img src="/assets/images/Logo_white.svg" alt="Site Logo">
            </div>
        </a>

        <div class="sidebar-icon active">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M3 17v2h6v-2H3zM3 5v2h10V5H3zm10 16v-2h8v-2h-8v-2h-2v6h2zM7 9v2H3v2h4v2h2V9H7zm14 4v-2H11v2h10zm-6-4h2V7h4V5h-4V3h-2v6z" />
            </svg>
        </div>
    </nav>

    <div class="main-content">
        <header class="header">
            <h1>Admin Dashboard</h1>
        </header>

        <div class="stats-cards">
            <div class="stat-card total">
                <div class="icon-wrapper">
                    <!-- SVG -->
                </div>
                <div class="info">
                    <h3>Total Applicants</h3>
                    <p>{{ $totalApplicants }}</p>
                </div>
            </div>

            <div class="stat-card checking">
                <div class="icon-wrapper">
                    <!-- SVG -->
                </div>
                <div class="info">
                    <h3>In Checking</h3>
                    <p>{{ $inChecking }}</p>
                </div>
            </div>

            <div class="stat-card accepted">
                <div class="icon-wrapper">
                    <!-- SVG -->
                </div>
                <div class="info">
                    <h3>Accepted</h3>
                    <p>{{ $accepted }}</p>
                </div>
            </div>

            <div class="stat-card rejected">
                <div class="icon-wrapper">
                    <!-- SVG -->
                </div>
                <div class="info">
                    <h3>Rejected</h3>
                    <p>{{ $rejected }}</p>
                </div>
            </div>
        </div>

        <div class="table-section">
            <div class="table-controls">
                <div class="search-filter">
                    <input type="text" placeholder="Search">
                    <button class="filter-button" onclick="toggleDropdown()">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 24 24" width="20"
                            fill="currentColor">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z" />
                        </svg>
                        Filter
                    </button>
                    <div class="filter-dropdown" id="filterDropdown">
                        <a href="#">Latest</a>
                        <a href="#">Earliest</a>
                        <a href="#">Pending</a>
                        <a href="#">Rejected</a>
                        <a href="#">Accepted</a>
                        <a href="#">Alphabetical</a>
                    </div>
                </div>
                <div class="pagination">
                    <button>&lt;</button>
                    <span>Page 1 of 1</span>
                    <button>&gt;</button>
                </div>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Created On</th>
                        <th>Application ID</th>
                        <th>Full Name</th>
                        <th>Donation Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donations as $donation)
                        <tr class="donation-row"
                            data-id="{{ $donation->id }}"
                            data-name="{{ $donation->name }}"
                            data-description="{{ $donation->description }}"
                            data-category="{{ $donation->category }}"
                            data-target="{{ $donation->target_amount }}"
                            data-status="{{ $donation->status }}"
                            data-image="{{ asset('storage/' . $donation->cover_image) }}">
                            
                            <td>{{ $donation->created_at->format('d/m/Y') }}</td>
                            <td>{{ $donation->id }}</td>
                            <td>{{ $donation->name }}</td>
                            <td>{{ Str::limit($donation->description, 50) }}</td>
                            <td>
                                @if($donation->status === 'pending')
                                    <span class="status-tag in-checking">In Checking</span>
                                @elseif($donation->status === 'approved')
                                    <span class="status-tag approved">Approved</span>
                                @else
                                    <span class="status-tag rejected">Rejected</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="detailed-view" id="detailedView" style="display:none;">
            <h2>Detailed View</h2>
            <div class="detail-card">
                <div class="image-wrapper">
                    <img id="detailImage" src="https://via.placeholder.com/200x150/d7d7d7/000000?text=Banner" alt="Donation Banner">
                </div>
                <div class="info">
                    <div>
                        <div class="detail-item">
                            <strong>Donation Name :</strong>
                            <span id="detailName">-</span>
                        </div>
                        <div class="detail-item">
                            <strong>Donation Target :</strong>
                            <span id="detailTarget">-</span>
                        </div>
                        <div class="detail-item">
                            <strong>Description :</strong>
                            <span id="detailDescription">-</span>
                        </div>
                        <div class="detail-item">
                            <strong>Category :</strong>
                            <span id="detailCategory">-</span>
                        </div>
                    </div>

                    <div class="detail-actions">
                        <form id="approveForm" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="approve-button">Approve</button>
                        </form>

                        <form id="rejectForm" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="reject-button">Reject</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


    
    <script>
        function toggleDropdown() {
            document.getElementById("filterDropdown").classList.toggle("show");
        }

        window.onclick = function (event) {
            if (!event.target.matches('.filter-button, .filter-button *')) {
                var dropdowns = document.getElementsByClassName("filter-dropdown");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
 
        function toggleDropdown() {
            document.getElementById("filterDropdown").classList.toggle("show");
        }

        // Hide dropdown if click outside
        window.onclick = function (event) {
            if (!event.target.matches('.filter-button, .filter-button *')) {
                var dropdowns = document.getElementsByClassName("filter-dropdown");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }

        // --- DETAIL VIEW INTERAKTIF ---
        const rows = document.querySelectorAll('.donation-row');
        const detailView = document.getElementById('detailedView');

        const detailName = document.getElementById('detailName');
        const detailTarget = document.getElementById('detailTarget');
        const detailDescription = document.getElementById('detailDescription');
        const detailCategory = document.getElementById('detailCategory');
        const detailImage = document.getElementById('detailImage');

        const approveForm = document.getElementById('approveForm');
        const rejectForm = document.getElementById('rejectForm');

        rows.forEach(row => {
            row.addEventListener('click', () => {
                const id = row.dataset.id;
                const name = row.dataset.name;
                const target = row.dataset.target;
                const description = row.dataset.description;
                const category = row.dataset.category;
                const image = row.dataset.image;

                // Update detail view content
                detailName.textContent = name;
                detailTarget.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(target);
                detailDescription.textContent = description;
                detailCategory.textContent = category;
                detailImage.src = image || 'https://via.placeholder.com/200x150/d7d7d7/000000?text=No+Image';

                // Update form actions dynamically
                approveForm.action = `/admin/donation/${id}/approve`;
                rejectForm.action = `/admin/donation/${id}/reject`;

                // Show detailed view
                detailView.style.display = 'block';
            });
        });
        
    </script>

</body>

</html>