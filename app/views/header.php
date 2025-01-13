<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Custom styles for the navigation bar */
    header {
      background: linear-gradient(135deg,rgb(0, 33, 95),rgb(2, 18, 41)); /* Gradient background */
    }

    .navbar {
      padding: 10px 20px; /* Add some padding for better spacing */
    }

    .navbar-brand,
    .navbar-nav .nav-link {
      color: white; /* White text for navigation elements */
      font-family: 'Poppins', sans-serif; /* Consistent font family */
      font-weight: 600;
      transition: color 0.3s ease;
    }

    .navbar-nav .nav-item {
      margin-left: 20px; /* Add some spacing between navigation items */
    }

    .navbar-nav .nav-link:hover {
      color: #3498db; /* Change hover color for links to the primary blue */
    }

    .dropdown-menu {
      background-color: #34495e; /* Same dark blue for dropdown menu */
    }

    .dropdown-menu .dropdown-item:hover {
      background-color: #1abc9c; /* Change hover color for dropdown items */
    }

    .navbar-toggler-icon {
      background-color: white; /* White hamburger icon for mobile menu */
    }

    @media (max-width: 768px) {
      .navbar-nav {
        text-align: center; /* Center the navbar items on smaller screens */
      }
    }
  </style>
</head>
<body>
<header>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/booking-system">Booking System</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="/booking-system">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/booking-system/events">Events</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/booking-system/tickets/my">My Tickets</a>
          </li>

          <?php if (isset($_SESSION['user_id'])): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo htmlspecialchars($_SESSION['user_name']); ?>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                  <li><a class="dropdown-item" href="/booking-system/admin">Admin Dashboard</a></li>
                <?php endif; ?>
                <li><a class="dropdown-item" href="/booking-system/logout">Logout</a></li>
              </ul>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="/booking-system/login">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/booking-system/register">Register</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>


  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
