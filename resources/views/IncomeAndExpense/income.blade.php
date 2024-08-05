<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income & Expense Tracker</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <h1 class="text-center">Income & Expense</h1>

                        <!-- Table -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Type</th>
                                            <th>Category</th>
                                            <th>Amount</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="entryTableBody">
                                        <!-- Entries will be dynamically added here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Define deleteEntry in the global scope
        async function deleteEntry(id) {
            if (confirm('Are you sure you want to delete this entry?')) {
                try {
                    const response = await fetch(`http://127.0.0.1:8000/api/deleteIncome/${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || 'Network response was not ok');
                    }

                    const result = await response.json();
                    alert(result.message); // Show success message
                    fetchEntries(); // Refresh the table

                } catch (error) {
                    alert('Error deleting entry: ' + error.message);
                }
            }
        }

        async function fetchEntries() {
            try {
                const response = await fetch('http://127.0.0.1:8000/api/getIncome', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Network response was not ok');
                }

                const result = await response.json();
                renderTable(result);
                
            } catch (error) {
                alert('Data not Fetched: ' + error.message);
            }
        }

        function renderTable(data) {
            $('#entryTableBody').empty();
            const allEntries = [...data.income, ...data.expense];
            allEntries.forEach(entry => {
                $('#entryTableBody').append(`
                    <tr>
                        <td>${entry.id}</td>
                        <td>${entry.type}</td>
                        <td>${entry.category}</td>
                        <td>${entry.amount}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editEntry(${entry.id})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteEntry(${entry.id})">Delete</button>
                        </td>
                    </tr>
                `);
            });
        }

        function editEntry(id) {
            window.location.href = `http://127.0.0.1:8000/incomeUpdate/${id}`;
        }

        // Initial fetch of entries
        $(document).ready(async function() {
            await fetchEntries();
        });
    </script>
</body>

</html>
