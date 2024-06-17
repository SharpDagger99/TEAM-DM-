<?php
session_start();  
  
$servername = "localhost";
$username = "root";              
$password = "";        
$dbname = "ttc";            
       
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = htmlspecialchars($_SESSION['user_id'], ENT_QUOTES, 'UTF-8');

// Query to fetch all posts in descending order
$sql = "SELECT * FROM post ORDER BY time_posted DESC";
$posts = $conn->query($sql);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TTC Homepage</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons (Optional) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        .icon-green {
            color: rgb(0, 0, 0);
        }

        .icon-green:hover {
            color: rgb(238, 159, 12);
        }

        .navbar-brand {
            font-size: 24px;
        }

        /* Center the search form */
        .search-form {
            margin: auto;
        }

        .icons-right {
            margin-left: auto;
        }

        .list-group-item {
            cursor: pointer;
        }

        /* Custom styles for the large dropdown */
        .dropdown-menu-center {
            width: 50vw;
            max-width: 400px;
            left: 80%;
            transform: translateX(-50%);
            top: 50px;
            /* Adjust this value to your preference */
            padding: 20px;
        }

        .dropdown-content {
            max-height: 300px;
            overflow-y: auto;
        }

        /* Add spacing to icons */
        .nav-link-icon {
            margin-right: 80px;
        }

        /* Style for image background */
        body {
            background-image: url('Image/bg.png');
            background-size: cover;
            background-position: 0 0;
            background-attachment: fixed;
            animation: moveBackground 60s linear infinite;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        @keyframes moveBackground {
            from {
                background-position: 0 0;
            }

            to {
                background-position: 100% 0;
            }
        }

        /* Set a fixed height for the no-events-message card body */
        #no-events-message .card-body {
            height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* Define default styles for the background overlay */
        .background-overlay {
            position: fixed;
            width: 65%;
            /* Adjusts dynamically based on content */
            height: 100%;
            /* Set to match the height of card-body */
            background: rgba(0, 0, 0, 0.356);
            top: 0;
            left: 49.50%;
            transform: translateX(-50%);
            z-index: -1;
        }

        /* Media query for smaller viewport sizes */
        @media (max-width: 768px) {
            .background-overlay {
                display: none;
                /* Hide the background overlay for smaller screens */
            }
        }

        @media (max-width: 760px) {
            .nav-link .nav-text {
                display: inline;
                margin-left: 8px;
            }
        }

        @media (min-width: 761px) {
            .nav-link .nav-text {
                display: none;
            }
        }


        .posted {
            box-shadow: 2px 2px 5px 8px rgba(0, 0, 0, 0.3);
        }

        .main-content {
            height: calc(95vh - 80px);
            /* Adjust based on your header height */
            overflow-y: auto;
        }

        .request-button {
            position: absolute;
            bottom: 15px;
            right: 15px;
        }

        .post {
            position: relative;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><b>TTC</b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon me-4" href="#" alt="Home" onclick="location.reload();">
                            <i class="fas fa-home fa-2x icon-green"></i><span class="nav-text">Home</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-3" href="#">
                            <i class="fas fa-history fa-2x icon-green" alt="Log Event History"></i><span
                                class="nav-text">History</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle me-3" data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false">
                            <i class="fas fa-user fa-2x icon-green" alt="Profile"></i><span
                                class="nav-text">Profile</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="Index.php">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid my-1 ">
        
            <!-- Right Sidebar -->
            <div class="col-12 col-md-2 my-md-2 m-0 position-sticky  ms-auto">
                <div class="list-group position-sticky">
                    <a href="#" class="list-group-item list-group-item-action">List of Participants</a>
                </div>
            </div>

        </div>
    </div>
    <!-- Main Container -->
    <div class="container-fluid my-1 main-content">
        <div class="row">
            <!-- Left Sidebar -->


            <!-- Main Content Post-->
            <!-- Main Content Post-->
            <div class="container main-content align-items-center col-md-8">
                <div id="post-container" class="mb-3">
                    <!-- Dynamically insert posts -->
                    <?php if (!empty($posts)): ?>
                        <?php foreach ($posts as $post): ?>
                            <?php
                            // Check if the user has already requested to participate
                            $post_id = htmlspecialchars($post['post_id'], ENT_QUOTES, 'UTF-8');

                            $stmt = $conn->prepare('SELECT COUNT(*) FROM req_pending WHERE upload_id = ? AND user_id = ?');
                            $stmt->bind_param('ii', $post_id, $user_id);
                            $stmt->execute();
                            $stmt->bind_result($already_requested);
                            $stmt->fetch();
                            $stmt->close();
                            ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="c-title" id="organization_name">OROQUIETA MTB</h5>
                                    <div class="post">
                                        <h6 class="post-title"><?php echo htmlspecialchars($post['title']); ?></h6>
                                        <p class="time-posted">Time Posted: <span
                                                class="post-time"><?php echo htmlspecialchars($post['time_posted']); ?></span>
                                        </p>
                                        <p class="post-description"><?php echo htmlspecialchars($post['pdescription']); ?></p>
                                        <!-- Media Container for Images and Videos -->
                                        <div class="post-media-container curvy-container bg-light p-3 rounded d-flex justify-content-center align-items-center"
                                            style="background-image: url('image/bg.png'); background-size: cover; background-position: center; min-height: 300px;">
                                            <?php
                                            $files = explode(',', $post['file_uploaded']); // Assuming multiple files are separated by commas
                                            foreach ($files as $file) {
                                                $file = trim($file);
                                                $file_ext = pathinfo($file, PATHINFO_EXTENSION);
                                                if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                    echo '<img class="border border-subtle border-5 posted" src="' . htmlspecialchars($file) . '" alt="Image" style="max-width: 100%; height: auto; object-fit: contain; margin-bottom: 0;">';
                                                } elseif (in_array($file_ext, ['mp4', 'webm', 'ogg'])) {
                                                    echo '<video src="' . htmlspecialchars($file) . '" controls style="max-width: 100%; height: auto; object-fit: contain; margin-bottom: 10px;"></video>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php if ($already_requested): ?>
                                        <button class="btn btn-secondary request-button" disabled>Already Requested</button>
                                    <?php else: ?>
                                        <a href="request_participation.php?post_id=<?php echo $post_id; ?>&user_id=<?php echo $user_id; ?>" class="btn btn-primary request-button">Request to Participate</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No posts available.</p>
                    <?php endif; ?>
                </div>
            </div>


        </div>
    </div>



    <!-- Main Container -->









    <!-- Black transparent background overlay -->
    <div class->background-overlay></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            displayRecentSearches();
            var searchInput = document.getElementById('search-input');
            var recentSearchesDropdown = document.getElementById('recent-searches-dropdown');

            searchInput.addEventListener('focus', function () {
                recentSearchesDropdown.style.display = 'block';
            });

            searchInput.addEventListener('blur', function () {
                // Delay hiding to allow click events to register
                setTimeout(function () {
                    recentSearchesDropdown.style.display = 'none';
                }, 200);
            });
        });

        function checkSearchInput() {
            var searchInput = document.getElementById('search-input').value.trim();
            if (searchInput === "") {
                return false;
            }
            saveSearchInput(searchInput);
            return true;
        }

        function saveSearchInput(searchInput) {
            var recentSearches = JSON.parse(localStorage.getItem('recentSearches')) || [];
            recentSearches = recentSearches.filter(search => search !== searchInput); // Remove if already present
            recentSearches.unshift(searchInput); // Add to the front
            if (recentSearches.length > 5) {
                recentSearches.pop();
            }
            localStorage.setItem('recentSearches', JSON.stringify(recentSearches));
            displayRecentSearches();
        }

        function displayRecentSearches() {
            var recentSearches = JSON.parse(localStorage.getItem('recentSearches')) || [];
            var recentSearchesList = document.getElementById('recent-searches-list');
            recentSearchesList.innerHTML = "";
            recentSearches.forEach(function (search) {
                var listItem = document.createElement('li');
                listItem.textContent = search;
                listItem.classList.add('dropdown-item');
                listItem.style.cursor = 'pointer';
                listItem.addEventListener('click', function () {
                    document.getElementById('search-input').value = search;
                    document.getElementById('recent-searches-dropdown').style.display = 'none';
                });
                recentSearchesList.appendChild(listItem);
            });
        }
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.request-button');
            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    const postId = this.getAttribute('data-post-id');
                    fetch('request_participation.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ post_id: postId })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Request to participate sent successfully!');
                            } else {
                                alert('Request to participate sent successfully.');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
</body>

</html>

<?php
$conn->close();
?>
