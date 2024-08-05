<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Portfolio</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .sidebar {
            height: 100vh;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 10px;
            text-decoration: none;
            color: #000;
            display: block;
        }
        .sidebar a:hover {
            background-color: #ddd;
        }
        .main-content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            @include('sidebar') <!-- Include the sidebar here -->

            <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
                <!-- Main Content -->
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center">Create Portfolio</h1>
                        <div class="modal-body">
                            <form id="entryForm">
                                <div class="form-group">
                                    <label for="entryCategory">Name</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#entryForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission
                
                // Gather the form data
                const formData = {
                    name: $('#name').val(),
                    
                };

                $.ajax({
                    url: '/api/storePortfolio',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Handle the success response
                        alert('Entry saved successfully!');
                        $('#entryForm')[0].reset(); // Reset the form fields
                    },
                    error: function(xhr) {
                        // Handle the error response
                        alert('An error occurred: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>
