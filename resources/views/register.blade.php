<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Register</h2>
                <form id="registration-form">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">User Name</label>
                        <input type="text" class="form-control" id="userName" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Contact Number</label>
                        <input type="tel" class="form-control" id="contact" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm-password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm-password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registration-form');
            if (form) {
                form.addEventListener('submit', async function(event) {
                    event.preventDefault(); // Prevent the default form submission

                    const fullName = document.getElementById('name').value;
                    const userName = document.getElementById('userName').value;
                    const email = document.getElementById('email').value;
                    const contactNo = document.getElementById('contact').value;
                    const password = document.getElementById('password').value;
                    const confirmPassword = document.getElementById('confirm-password').value;

                    // Validate if passwords match
                    if (password !== confirmPassword) {
                        alert('Passwords do not match');
                        return;
                    }

                    try {
                        const response = await fetch('http://127.0.0.1:8000/api/register', { // Adjust the URL to match your Laravel setup
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json' // Updated to match the content type expected by Laravel
                            },
                            body: JSON.stringify({
                                fullName,
                                userName,
                                email,
                                contactNo,
                                password,
                                password_confirmation: confirmPassword // Laravel expects the confirmation field to be named this way
                            })
                        });

                        if (!response.ok) {
                            const errorData = await response.json();
                            throw new Error(errorData.message || 'Network response was not ok');
                        }

                        const result = await response.json();
                        alert('Registration successful');
                        window.location.href = `http://127.0.0.1:8000/`;
                        // Handle successful registration here (e.g., redirect or clear the form)

                    } catch (error) {
                        alert('Registration failed: ' + error.message);
                        // Handle errors here
                    }
                });
            } else {
                console.error('Form with ID "registration-form" not found.');
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
