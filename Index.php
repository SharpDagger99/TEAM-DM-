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

    <style>

        /* Your existing CSS styles */ 
    body {
        position: relative;
        /* Add padding-top to make space for the logo */
        padding-top: 100px;
        background-image: url('Image/bg.png');
        background-size: cover;
        background-attachment: fixed;
        animation: moveBackground 20s linear infinite;
    }

    @keyframes moveBackground {
        from {
            background-position: 0 0;
        }
        to {
            background-position: 100% 0;
        }
    }

    .modal-header .logo-container {
        position: absolute;
        top: 1%;
        left: 50%;
        transform: translateX(-50%);
        z-index: 999;
    }

    .modal-header .logo-container img {
        max-width: 100px;
        max-height: 100px;
    }

    .modal-title {
        margin-top: 60px; /* Adjust as needed */
    }

    #forgotModal .modal-body {
        padding-top: 30px; /* Adjust the top padding as needed */
    }

    </style>
</head>

<body>

    <!-- Login Modal -->
        <div id="loginModal" class="modal fade" tabindex="-1" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="logo-container">
                            <img src="Image/Logo.png" alt="Logo">
                        </div>
                        <h5 class="modal-title">Login as User</h5>
                    </div>
                    <div class="modal-body">
                        <form action="login.php" method="POST"> <!-- Changed action to login.php -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                            </div>
                            <div class="mb-3 position-relative">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                <i class="fas fa-eye eye-icon" onclick="togglePasswordVisibility('password')"></i>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                            <div class="text-center my-2">or</div>
                            <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#adminLoginModal">Login as Admin</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signupModal">Sign Up</button>
                    </div>
                </div>
            </div>
        </div>


    <!-- Sign Up Modal -->
<div id="signupModal" class="modal fade" tabindex="-1" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="logo-container">
                    <img src="Image/Logo.png" alt="Logo">
                </div>
                <h5 class="modal-title">Sign Up</h5>
            </div>
            <div class="modal-body">
                <form id="signupForm" action="userphp.php" method="POST">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="signup-username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="signup-username" name="signup-username" placeholder="Enter your username" required>
                        </div>
                        <div class="col">
                            <label for="signup-password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="signup-password" name="signup-password" placeholder="Enter your password" required>
                            <i class="fas fa-eye eye-icon" onclick="togglePasswordVisibility('signup-password')"></i>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm-password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Confirm your password" required>
                        <i class="fas fa-eye eye-icon" onclick="togglePasswordVisibility('confirm-password')"></i>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="firstname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter your first name" required>
                        </div>
                        <div class="col">
                            <label for="lastname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter your last name" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="age" class="form-label">Age</label>
                            <input type="text" class="form-control" id="age" name="age" placeholder="Enter your age" required>
                        </div>
                        <div class="col">
                            <label for="sex" class="form-label">Sex</label>
                            <select class="form-select" id="sex" name="sex" required>
                                <option value="" selected disabled>Select sex</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <!-- Remove nested <form> tag -->
                    <button type="submit" class="btn btn-primary w-100" name="signup-submit">Sign Up</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Close</button>
            </div>
        </div>
    </div>
</div>


    <!-- Admin Login Modal -->
        <div id="adminLoginModal" class="modal fade" tabindex="-1" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="logo-container">
                            <img src="Image/Logo.png" alt="Logo">
                        </div>
                        <h5 class="modal-title">Login as Admin</h5>
                    </div>
                    <div class="modal-body">
                        <form action="connection.php" method="POST">
                            <div class="mb-3">
                                <label for="admin-username" class="form-label">Email</label>
                                <input type="text" class="form-control" id="admin-username" name="admin-username" placeholder="Enter your email" required>
                            </div>
                            <div class="mb-3">
                                <label for="admin-password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="admin-password" name="admin-password" placeholder="Enter your password" required>
                                <!-- Display comment for incorrect email/password -->
                                <div id="login-error" class="invalid-feedback">Email or Password is Incorrect! Please try again.</div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <!-- Add a button for "Open Admin via Gmail confirmation" -->
                        <!-- <button type="button" class="btn btn-success w-100" onclick="sendEmailConfirmation()">Open Admin via Gmail confirmation</button>
                    </div> -->

                    <!-- Center the "OR" text below the Login button -->
                    <div class="modal-body">
                        <div class="text-center my-2">OR</div>
                        <div class="modal-footer">
                            <!-- Add a button to switch to user login -->
                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Login as User</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>




                            

   



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Your JavaScript functions
        document.addEventListener('DOMContentLoaded', function() {
            var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();
        });

        function togglePasswordVisibility(inputId) {
            const passwordInput = document.getElementById(inputId);
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }
        
            document.getElementById("signupForm").addEventListener("submit", function(event) {
            // Retrieve password and confirm password fields
            var password = document.getElementById("signup-password").value;
            var confirmPassword = document.getElementById("confirm-password").value;

            // Check if password and confirm password match
            if (password !== confirmPassword) {
                // Prevent form submission
                event.preventDefault();

                // Display error message
                alert("Password and Confirm Password do not match. Please try again.");
            }
        });

    </script>
</body>

</html>
