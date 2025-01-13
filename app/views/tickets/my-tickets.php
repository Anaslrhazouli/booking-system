<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
   
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #e0eafc, #cfdef3); /* Gradient background */
            color: #333;
        }

        .container {
            max-width: 960px;
            margin: 20px auto; /* Added top/bottom margin */
        }

        h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: #2c3e50; /* Darker heading color */
            margin-bottom: 30px;
            text-align: center; /* Center the main title */
        }
        .card-text .label {
    font-weight: 600; /* Or 500, adjust as desired */
    color: #7f8c8d; /* A slightly darker gray, or any color you prefer */
    margin-right: 5px; /* Add a little spacing between label and value */
}
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s; /* Transition for box-shadow too */
            background-color: #fff; /* White card background */
            overflow: hidden; /* Prevents content from overflowing rounded corners */
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
            color: #3498db; /* Blue for event titles */
            margin-bottom: 15px;
        }

        .card-text {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 8px;
        }

        .text-muted {
            color: #7f8c8d !important; /* Slightly darker muted text */
            font-style: italic;
        }

        .text-center {
            text-align: center;
        }

        .img-fluid {
            max-width: 200px;
            margin: 15px auto;
            display: block;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow for QR code */
        }

        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            transition: background-color 0.3s; /* Smooth transition for hover */
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .mt-4 a {
            display: block;
            width: fit-content;
            margin: 20px auto 0; /* Added top margin */
        }

        .alert-info {
            background-color: #e7f4fd; /* Light blue alert */
            border-color: #bbdefb;
            color: #1a73e8; /* Darker blue text */
        }

        @media (max-width: 768px) {
            .col-md-6 {
                width: 100%;
            }
            .img-fluid {
                max-width: 150px;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>My Tickets</h2>

        <?php if (empty($tickets)): ?>
            <div class="alert alert-info">
                You don't have any tickets yet.
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($tickets as $ticket): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title"><?= htmlspecialchars($ticket['event_name']) ?></h3>
                                <p class="card-text">
    <span class="label">Date:</span> <?= htmlspecialchars($ticket['event_date']) ?>
</p>
<p class="card-text">
    <span class="label">Venue:</span> <?= htmlspecialchars($ticket['venue']) ?>
</p>
<p class="card-text">
    <span class="label">Ticket Type:</span> <?= htmlspecialchars($ticket['ticket_type']) ?>
</p>
<p class="card-text">
    <span class="label">Booking Date:</span> <?= htmlspecialchars($ticket['booking_date']) ?>
</p>

<p class="card-text">
                                    <span class="label">Status:</span>
                                    <?php if ($ticket['status'] === 'active'): ?>
    <span class="badge bg-success">
        <i class="fas fa-check-circle"></i> Active
    </span>
<?php elseif ($ticket['status'] === 'used'): ?>
    <span class="badge bg-secondary">
        <i class="fas fa-check-circle"></i> Used
    </span>
<?php elseif ($ticket['status'] === 'cancelled'): ?>
    <span class="badge bg-danger">
        <i class="fas fa-ban"></i> Cancelled
    </span>
<?php else: ?>
    <span class="badge bg-warning">Unknown</span>
<?php endif; ?>
                                </p>
                                <div class="text-center">
                                    <img src="/booking-system/public/qrcodes/<?= htmlspecialchars(basename($ticket['qr_code_path'])) ?>" alt="QR Code" class="img-fluid" />
                                </div>

                                <p class="card-text text-center"><small class="text-muted">Please show this code at the event entrance</small></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="mt-4">
            <a href="/booking-system/events" class="btn btn-primary">Browse More Events</a>
        </div>
    </div>
</body>
</html>