<?php
error_reporting(E_ALL);
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

// Query to fetch all posts in descending order
$sql = "SELECT * FROM post ORDER BY time_posted DESC";
$posts = $conn->query($sql);

// Query to fetch user data
$user_sql = "SELECT Username, First_Name, Last_Name, Age, Sex, Email FROM user";
$users = $conn->query($user_sql);

// Query to fetch pending requests with usernames
$pending_sql = "SELECT req_pending.*, user.Username FROM req_pending JOIN user ON req_pending.user_id = user.user_id WHERE req_pending.status = 'pending'";
$pending_requests = $conn->query($pending_sql);

$conn->close();
?>

<!DOCTYPE html>
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
        /* Your existing styles here */

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

        .table {
            border-radius: 15px 50px;
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
        }

        /* Define default styles for the background overlay */
        .background-overlay {
            position: fixed;
            width: 50%; /* Adjusts dynamically based on content */
            height: 100%; /* Set to match the height of card-body */
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

        .dropzone {
            border: 2px dashed #c8ced3;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
        }

        .dropzone:hover {
            border-color: blue;
        }

        .dropzone-message {
            font-size: 18px;
            color: #6c757d;
        }

        .dropzone-message i {
            font-size: 36px;
            margin-bottom: 15px;
        }

        .posted {
            box-shadow: 2px 2px 5px 8px rgba(0, 0, 0, 0.3);
        }

        .main-content {
            height: calc(100vh - 70px);
            /* Adjust based on your header height */
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <!-- New container for brand and icons -->
                <a class="navbar-brand" href="#"><b>TTC</b></a>
                <!-- Home Icon -->
                <a class="nav-link nav-link-icon me-4" href="#" alt="Home" onclick="location.reload();"><i
                        class="fas fa-home fa-2x icon-green"></i></a>
                <!-- Upload Icon -->
                <a class="nav-link nav-link-icon me-5" href="#" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="fas fa-cloud-upload-alt fa-2x icon-green" alt="Upload"></i>
                </a>
            </div>

            <div class="icons-right d-flex align-items-center">
                <ul class="navbar-nav">
                    <!-- Navigation items -->
                    <li class="nav-item">
                        <a class="nav-link me-3" href="#"><i class="fas fa-history fa-2x icon-green"
                                alt="Log Event History"></i></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle me-3" data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false"><i class="fas fa-user fa-2x icon-green" alt="Profile"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <!--Drop Down for Profile Icon-->
                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#profileModal">Profile</a>
                            </li>
                            <li><a class="dropdown-item" href="Index.php">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Modal for Profile -->
    <div id="profileModal" class="modal fade" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Admin Profile</h5>
                    <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Your profile form content here -->
                    <form action="update_profile.php" method="post">
                        <!-- Admin Name -->
                        <div class="mb-3">
                            <h5 class="c-title" id="organization_name">OROQUIETA MTB</h5>
                        </div>
                        <!-- Admin Email -->
                        <div class="mb-3">
                            <label for="adminEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="adminEmail" placeholder="Enter email" readonly>
                        </div>
                        <!-- Other Admin Information Fields -->
                        <!-- Add more fields as needed -->
                    </form>
                </div>
                <div class="modal-footer">
                    <!-- Close Button to close the modal -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="enableEditing()">Edit</button>
                    <button type="button" class="btn btn-primary" onclick="updateProfile()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Participants -->
    <div id="participantsModal" class="modal fade" tabindex="-1" aria-labelledby="participantsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="participantsModalLabel">List of Participants</h5>
                    <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody id="participantsTableBody">
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($user['Username']); ?></td>
                                            <td><?php echo htmlspecialchars($user['First_Name']); ?></td>
                                            <td><?php echo htmlspecialchars($user['Last_Name']); ?></td>
                                            <td><?php echo htmlspecialchars($user['Age']); ?></td>
                                            <td><?php echo htmlspecialchars($user['Sex']); ?></td>
                                            <td><?php echo htmlspecialchars($user['Email']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No participants available.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Upload -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload Form</h5>
                    <button type="button" class="btn-close" aria-label="Close" onclick="handleModalClose()"></button>
                </div>
                <div class="modal-body">
                    <!-- Your upload form content here -->
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="uploadTitle" class="form-label">Title:</label>
                            <input type="text" class="form-control" name="title" id="uploadTitle"
                                placeholder="Enter title">
                        </div>
                        <!-- Description -->
                        <div class="mb-3">
                            <label for="uploadDescription" class="form-label">Description:</label>
                            <textarea class="form-control" name="description" id="uploadDescription" rows="3"
                                placeholder="Enter description"></textarea>
                        </div>

                        <!-- Drag and Drop upload box -->
                        <div class="mb-3">
                            <label for="uploadFile" class="form-label">Upload your files:</label>
                            <input type="file" name="file" class="form-control" id="uploadFile" name="uploadFile"
                                accept=".pdf,.doc,.docx,.jpg,.png,.mp4" multiple>
                            <small class="form-text text-muted">Supported file formats: PDF, DOC, DOCX, JPG, PNG,
                                MP4</small>
                        </div>

                        <!-- Container with curvy box -->
                        <div id="mediaContainer" class="curvy-container bg-light p-3 rounded"
                            style="height: 200px; overflow-y: auto;">
                            <!-- Placeholder for images and videos -->
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Upload</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container-fluid mt-4 main-content">
        <div class="row">
            <!-- Left Sidebar -->
            <div class="col-lg-3">
                <div class="list-group position-sticky top-0">
                    <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#userRequestModal">User's Request</a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="container-fluid d-flex justify-content-center align-items-center col-lg-6" style="height: 100%;">
                <div id="post-container" class="mb-3" style="width: 100%; border: 2px solid;">
                    <!-- Dynamically insert posts -->
                    <?php if (!empty($posts)): ?>
                        <?php foreach ($posts as $post): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="c-title" id="organization_name">OROQUIETA MTB</h5>
                                    <div class="post">
                                        <h6 class="post-title"><?php echo htmlspecialchars($post['title']); ?></h6>
                                        <p class="time-posted">Time Posted: <span class="post-time"><?php echo htmlspecialchars($post['time_posted']); ?></span></p>
                                        <p class="post-description"><?php echo htmlspecialchars($post['pdescription']); ?></p>
                                        <!-- Media Container for Images and Videos -->
                                        <div class="post-media-container  curvy-container bg-light p-3 rounded d-flex justify-content-center align-items-center" style="background-image: url('image/bg.png'); background-size: cover; background-position: center; min-height: 300px;">
                                            <?php
                                                $files = explode(',', $post['file_uploaded']); // Assuming multiple files are separated by commas
                                                foreach ($files as $file) {
                                                    $file = trim($file);
                                                    $file_ext = pathinfo($file, PATHINFO_EXTENSION);
                                                    if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                        echo '<img class=" border border-subtle border-5 posted" src="' . htmlspecialchars($file) . '" alt="Image" style="max-width: 100%; height: auto; object-fit: contain; margin-bottom: 0;">';
                                                    } elseif (in_array($file_ext, ['mp4', 'webm', 'ogg'])) {
                                                        echo '<video src="' . htmlspecialchars($file) . '" controls style="max-width: 100%; height: auto; object-fit: contain; margin-bottom: 10px;"></video>';
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No posts available.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="col-lg-3">
                <div class="list-group position-sticky top-0">
                    <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#participantsModal">List of Participants</a>
                </div>
            </div>
        </div>
    </div>

    <!-- User's Request Modal -->
    <div id="userRequestModal" class="modal fade" tabindex="-1" aria-labelledby="userRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userRequestModalLabel">User's Request</h5>
                    <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Request ID</th>
                                    <th>Upload ID</th>
                                    <th>Username</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="requestTableBody">
                                <?php if (!empty($pending_requests)): ?>
                                    <?php foreach ($pending_requests as $request): ?>
                                        <tr data-req-id="<?php echo htmlspecialchars($request['req_id']); ?>">
                                            <td><?php echo htmlspecialchars($request['req_id']); ?></td>
                                            <td><?php echo htmlspecialchars($request['upload_id']); ?></td>
                                            <td><?php echo htmlspecialchars($request['Username']); ?></td>
                                            <td><?php echo htmlspecialchars($request['status']); ?></td>
                                            <td>
                                                <button class="btn btn-success" onclick="updateRequestStatus(<?php echo $request['req_id']; ?>, 'confirmed')">Confirm</button>
                                                <button class="btn btn-danger" onclick="updateRequestStatus(<?php echo $request['req_id']; ?>, 'denied')">Deny</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No pending requests.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Black transparent background overlay -->
    <div class="background-overlay"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Function to update request status
        function updateRequestStatus(reqId, status) {
            fetch('update_request_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ req_id: reqId, status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Request status updated successfully.');
                    // Reload the modal content or remove the row from the table
                    document.querySelector(`#requestTableBody tr[data-req-id="${reqId}"]`).remove();
                } else {
                    alert('Failed to update request status.');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>

</body>
</html>
