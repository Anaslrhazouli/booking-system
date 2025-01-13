<div class="container mt-4">
    <h2>Admin Dashboard</h2>
    
    <!-- Statistics Cards -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text display-4"><?php echo $totalUsers; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Events</h5>
                    <p class="card-text display-4"><?php echo $totalEvents; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Tickets</h5>
                    <p class="card-text display-4"><?php echo $totalTickets; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recent Users</h5>
                    <ul class="list-group">
                        <?php foreach ($recentUsers as $user): ?>
                            <li class="list-group-item">
                                <?php echo htmlspecialchars($user['name']); ?> - 
                                <?php echo htmlspecialchars($user['email']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recent Events</h5>
                    <ul class="list-group">
                        <?php foreach ($recentEvents as $event): ?>
                            <li class="list-group-item">
                                <?php echo htmlspecialchars($event['name']); ?> - 
                                <?php echo htmlspecialchars($event['date']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Ticket Bookings -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recent Ticket Bookings</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>User</th>
                                    <th>Ticket Type</th>
                                    <th>Booking Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ticketBookings as $booking): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($booking['event_name']); ?></td>
                                        <td>
                                            <?php echo htmlspecialchars($booking['user_name']); ?><br>
                                            <small class="text-muted"><?php echo htmlspecialchars($booking['user_email']); ?></small>
                                        </td>
                                        <td><?php echo htmlspecialchars($booking['ticket_type']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>