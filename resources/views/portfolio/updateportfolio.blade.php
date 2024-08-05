<!-- resources/views/components/head.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income & Expense Create</title>
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
                        <h1 class="text-center">Update Portfolio</h1>
                        <div class="modal-body">
                            <form id="entryForm">
                                <div class="form-group">
                                    <label for="entryType">Type</label>
                                    <select class="form-control" id="entryType">
                                        <option value="income">Income</option>
                                        <option value="expense">Expense</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="entryCategory">Category</label>
                                    <input type="text" class="form-control" id="entryCategory" required>
                                </div>
                                <div class="form-group">
                                    <label for="entryAmount">Amount</label>
                                    <input type="number" class="form-control" id="entryAmount" required>
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
        let entries = [];
        let entryId = 1;

        $(document).ready(function() {
            $('#entryForm').on('submit', function(e) {
                e.preventDefault();
                let entryType = $('#entryType').val();
                let entryCategory = $('#entryCategory').val();
                let entryAmount = $('#entryAmount').val();

                let entry = {
                    id: entryId,
                    type: entryType,
                    category: entryCategory,
                    amount: entryAmount
                };
                entries.push(entry);
                entryId++;

                $('#entryForm')[0].reset();
                renderTable();
            });
        });

        function renderTable() {
            $('#entryTableBody').empty();
            entries.forEach(entry => {
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
            // Implement edit functionality here
        }

        function deleteEntry(id) {
            entries = entries.filter(entry => entry.id !== id);
            renderTable();
        }
    </script>
</body>
</html>
