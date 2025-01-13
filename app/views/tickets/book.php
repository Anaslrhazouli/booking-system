<!DOCTYPE html>
<html>
<head>
  <title>Book Ticket</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Custom styles for the confirmation page */
    .container {
      background-color: #f2f2f2; /* Light gray background */
      padding: 20px; /* Add some padding for better spacing */
    }

    .card {
      border-color: #ddd; /* Adjust border color */
    }

    .card-header,
    .card-body {
      padding: 15px; /* Consistent padding for header and body */
    }

    .card-header {
      background-color: #2c3e50; /* Same dark blue for header */
      color: white; /* White text for header */
    }

    .alert-danger {
      background-color: #f14e4e; /* Adjust alert danger color */
      border-color: #ea4a4a; /* Adjust alert danger border */
      color: white; /* White text for alert */
    }

    h2,
    h4,
    h5 {
      margin-bottom: 10px; /* Consistent spacing for headings */
    }

    .btn-primary,
    .btn-secondary {
      margin-right: 10px; /* Spacing between buttons */
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h2>Confirm Booking</h2>
      </div>
      <div class="card-body">
        <?php if (isset($error)): ?>
          <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
          </div>
        <?php endif; ?>

        <div class="mb-3">
          <h4><?= htmlspecialchars($event['name']) ?></h4>
          <p>Date: <?= htmlspecialchars($event['date']) ?></p>
          <p>Venue: <?= htmlspecialchars($event['venue']) ?></p>
        </div>

        <div class="mb-3">
          <h5>Selected Ticket</h5>
          <p>Type: <?= htmlspecialchars($ticketType['name']) ?></p>
          <p>Price: $<?= htmlspecialchars($ticketType['price']) ?></p>
        </div>

        <form method="POST" action="/booking-system/tickets/book">
          <input type="hidden" name="event_id" value="<?= htmlspecialchars($event['id']) ?>">
          <input type="hidden" name="ticket_type_id" value="<?= htmlspecialchars($ticketType['id']) ?>">

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" required id="terms">
            <label class="form-check-label" for="terms">
              I agree to the terms and conditions
            </label>
          </div>

          <button type="submit" class="btn btn-primary">Confirm Booking</button>
          <a href="/booking-system/event/<?= htmlspecialchars($event['id']) ?>" class="btn btn-secondary">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</body>
</html>