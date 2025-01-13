<!DOCTYPE html>
<html lang="en">
<head>
  <title>Event Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background: linear-gradient(135deg, #e0eafc, #cfdef3); /* Gradient background */
      color: #333;
    }
    .event-status {
    margin-top: 10px;
    font-size: 14px;
    font-weight: bold;
  }

  .badge-status-active {
    background-color: #28a745; /* Bright green */
    color: white;
  }

  .badge-status-cancelled {
    background-color: #dc3545; /* Strong red */
    color: white;
  }

  .badge-status-completed {
    background-color: #6c757d; /* Subtle gray */
    color: white;
  }


  .event-status i {
    margin-right: 5px;
  }
    .admin-controls {
      margin-bottom: 30px;
      text-align: right;
    }

    .btn-create {
      background-color: #2ecc71;
      border-color: #27ae60;
      color: white;
      padding: 10px 20px;
      font-family: 'Poppins', sans-serif;
      font-weight: 500;
      transition: background-color 0.3s;
    }

    .btn-create:hover {
      background-color: #27ae60;
      border-color: #219a52;
      color: white;
    }

    .container {
      max-width: 960px;
      margin: 20px auto;
    }

    h2 {
      font-family: 'Poppins', sans-serif;
      font-weight: 700;
      color: #2c3e50;
      margin-bottom: 30px;
      text-align: center;
    }

    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s, box-shadow 0.2s;
      background-color: #fff;
      overflow: hidden;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 8px 14px rgba(0, 0, 0, 0.15);
    }

    .card-body {
      padding: 25px;
    }

    .card-title {
      font-family: 'Poppins', sans-serif;
      font-weight: 600;
      color: #3498db;
      margin-bottom: 15px;
    }

    .card-text {
      font-size: 16px;
      line-height: 1.6;
      color: #555;
      margin-bottom: 8px;
    }

    .card-text .label {
      font-weight: 600;
      color: #7f8c8d;
      margin-right: 5px;
    }

    .text-muted {
      color: #7f8c8d !important;
      font-style: italic;
    }

    .btn-primary {
      background-color: #3498db;
      border-color: #3498db;
      font-family: 'Poppins', sans-serif;
      font-weight: 500;
      transition: background-color 0.3s;
    }

    .btn-primary:hover {
      background-color: #2980b9;
      border-color: #2980b9;
    }

    .mt-4 a {
      display: block;
      width: fit-content;
      margin: 20px auto 0;
    }

    .alert-info {
      background-color: #e7f4fd;
      border-color: #bbdefb;
      color: #1a73e8;
    }

    @media (max-width: 768px) {
      .col-md-6 {
        width: 100%;
      }
    }
  </style>
</head>
<body>


  <div class="container mt-5">
    <h2><?= htmlspecialchars($event['name']) ?></h2>
    <p><?= htmlspecialchars($event['description']) ?></p>
    <div class="event-status">
      <?php if ($event['status'] === 'active'): ?>
        <span class="badge badge-status-active">
          <i class="fas fa-check-circle"></i> Active
        </span>
      <?php elseif ($event['status'] === 'cancelled'): ?>
        <span class="badge badge-status-cancelled">
          <i class="fas fa-times-circle"></i> Cancelled
        </span>
      <?php elseif ($event['status'] === 'completed'): ?>
        <span class="badge badge-status-completed">
          <i class="fas fa-check-square"></i> Completed
        </span>
      <?php endif; ?>
    </div>
    <p class="card-text"><span class="label">Date:</span> <?= htmlspecialchars($event['date']) ?></p>
    <p class="card-text"><span class="label">Venue:</span> <?= htmlspecialchars($event['venue']) ?></p>
    <?php if ($event['status'] === 'active'): ?>
    <h3 class="card-title">Available Tickets</h3>
    <?php foreach ($ticketTypes as $ticket): ?>
      <div class="card mb-4">
        <div class="card-body">
          <h5><?= htmlspecialchars($ticket['name']) ?></h5>
          <p class="card-text"><span class="label">Price:</span> $<?= htmlspecialchars($ticket['price']) ?></p>
          <p class="card-text"><span class="label">Available:</span> <?= htmlspecialchars($ticket['quantity']) ?></p>
          <form method="POST" action="/booking-system/tickets/book">
            <input type="hidden" name="ticket_type_id" value="<?= $ticket['id'] ?>">
            <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
            <button type="submit" class="btn btn-primary">Book Now</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
    <?php else: ?>
      <p class="text-muted">Tickets are not available for this event as it is <?= $event['status'] ?>.</p>
    <?php endif; ?>
    <div class="mt-4">
      <a href="/booking-system/events" class="btn btn-primary">Browse More Events</a>
    </div>
  </div>
</body>
</html>
