<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Events</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
      <style>
         body {
         font-family: 'Roboto', sans-serif;
         background: linear-gradient(135deg, #e0eafc, #cfdef3); /* Gradient background */
         color: #333;
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
         .badge-status-upcoming {
         background-color: #fd7e14; /* Bright orange */
         color: white;
         }
         .event-status i {
         margin-right: 5px;
         }
         .event-card {
         border: none;
         border-radius: 10px;
         box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
         transition: transform 0.2s, box-shadow 0.2s;
         background-color: #fff;
         overflow: hidden;
         }
         .event-card:hover {
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
         margin-bottom: 1.5rem;
         }
         .event-details {
         font-size: 0.9rem;
         color: #6c757d;
         margin-bottom: 1.5rem;
         }
         .event-details p {
         margin-bottom: 0.5rem;
         }
         .admin-controls {
         text-align: right; /* Align button to the right */
         margin: 20px 0;
         }
         .btn-create {
         display: inline-flex;
         align-items: center;
         background-color: #007bff; /* Blue background */
         color: white;
         padding: 10px 15px;
         border-radius: 5px;
         text-decoration: none;
         font-weight: bold;
         font-size: 14px;
         transition: background-color 0.3s, transform 0.2s;
         }
         .btn-create i {
         margin-right: 8px;
         font-size: 16px;
         }
         .btn-create:hover {
         background-color: #0056b3; /* Darker blue on hover */
         transform: translateY(-2px); /* Slight lift effect */
         text-decoration: none;
         color: white;
         }
         .btn-create:active {
         transform: translateY(0); /* Reset lift on click */
         background-color: #004085;
         }
         .btn-primary {
         background-color: #3498db;
         border-color: #3498db;
         font-family: 'Poppins', sans-serif;
         font-weight: 500;
         transition: background-color 0.3s;
         float: right;
         }
         .btn-primary:hover {
         background-color: #2980b9;
         border-color: #2980b9;
         }
         @media (max-width: 768px) {
         .col-md-4 {
         width: 100%;
         }
         }
      </style>
   </head>
   <body>
      <div class="container mt-5">
         <h2>Available Events</h2>
         <?php if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin"): ?>
         <div class="admin-controls">
            <a href="/booking-system/events/create" class="btn btn-create">
            <i class="fas fa-plus"></i> Create New Event
            </a>
         </div>
         <?php endif; ?>
         <div class="row">
            <?php foreach ($events as $event): ?>
            <div class="col-md-4 mb-4">
               <div class="card event-card">
                  <div class="card-body">
                     <h5 class="card-title"><?= htmlspecialchars(
                        $event["name"]
                        ) ?></h5>
                     <p class="card-text"><?= htmlspecialchars(
                        $event["description"]
                        ) ?></p>
                     <div class="event-details">
                        <p><span class="label">Date:</span> <?= htmlspecialchars(
                           $event["date"]
                           ) ?></p>
                        <p><span class="label">Venue:</span> <?= htmlspecialchars(
                           $event["venue"]
                           ) ?></p>
                        <div class="event-status">
                           <?php if ($event["status"] === "active"): ?>
                           <span class="badge badge-status-active">
                           <i class="fas fa-check-circle"></i> Active
                           </span>
                           <?php elseif ($event["status"] === "cancelled"): ?>
                           <span class="badge badge-status-cancelled">
                           <i class="fas fa-times-circle"></i> Cancelled
                           </span>
                           <?php elseif ($event["status"] === "completed"): ?>
                           <span class="badge badge-status-completed">
                           <i class="fas fa-check-square"></i> Completed
                           </span>
                           <?php elseif ($event["status"] === "upcoming"): ?>
                           <span class="badge badge-status-upcoming">
                           <i class="fas fa-calendar-alt"></i> Upcoming
                           </span>
                           <?php endif; ?>
                        </div>
                     </div>
                     <?php if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin"): ?>
         <div class="admin-controls">
            <a href="" class="btn btn-create">
            <i class="fas fa-edit"></i> Edit Event
            </a>
         </div>
         <?php endif; ?>
                     <a href="./event/<?= $event[
                        "id"
                        ] ?>" class="btn btn-primary">View Details</a>
                  </div>
               </div>
            </div>
            <?php endforeach; ?>
         </div>
      </div>
   </body>
</html>