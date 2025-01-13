<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles for the page */
        body {
            background: linear-gradient(135deg, #e0eafc, #cfdef3); /* Gradient background */
            font-family: 'Poppins', sans-serif; /* Consistent font family */
        }

        .container {
            max-width: 600px;
            margin-top: 5rem; /* Center the form vertically */
        }

        .card {
            border-radius: 10px; /* Rounded corners for the card */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Light shadow around the card */
            border: none;
        }

        .card-header {
            background-color: #2c3e50; /* Dark background for header */
            color: white; /* White text */
            text-align: center;
            padding: 1.5rem;
            font-weight: 600;
        }

        .card-body {
            padding: 2rem;
        }

        .form-control {
            border-radius: 5px;
            padding: 0.75rem;
            margin-bottom: 1.5rem; /* Spacing between fields */
        }

        .btn-primary {
            background-color: #007bff; /* Primary button color */
            border-color: #007bff;
            padding: 0.75rem 1.5rem;
            width: 100%;
            border-radius: 5px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #0069d9; /* Darker blue on hover */
            border-color: #0062cc;
        }

        .btn-link {
            color: #007bff; /* Link color */
            text-decoration: none;
            font-weight: 600;
        }

        .btn-link:hover {
            text-decoration: underline; /* Underline on hover for the link */
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form method="POST" action="register">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Register</button>
                            <div class="mt-3">
                                <a href="./login" class="btn btn-link">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
