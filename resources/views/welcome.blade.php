<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Login</h2>
                <form id="loginForm">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <!-- <a href="#" class="link-primary">Forgot Password?</a> -->
                        <a href="{{ url('register') }}" class="link-primary">Register</a>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                var formData = $(this).serialize(); // Serialize form data

                $.ajax({
                    url: "{{ url('api/login') }}", // Your API route
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token
                    },
                    success: function(response) {
                        if (response.accessToken) {
                            // Handle successful login
                            console.log('Token:', response.token);
                            // For example, store token in local storage
                            localStorage.setItem('token', response.token);
                            // Redirect to another page
                            window.location.href = '/income'; // Adjust redirect as needed
                        } else {
                            // Handle errors here
                            console.error('Login failed:', response);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle errors here
                        console.error('AJAX Error:', error);
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
