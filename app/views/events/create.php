<!DOCTYPE html>
<html lang="en">
<head>
  <title>Create Event</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background: linear-gradient(135deg, #e0eafc, #cfdef3);
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

    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
      background-color: #fff;
      padding: 25px;
      margin-bottom: 20px;
    }

    .ticket-type {
      border-top: 1px solid #eee;
      padding-top: 20px;
      margin-top: 20px;
    }

    .btn-add-ticket {
      background-color: #3498db;
      color: white;
      margin-bottom: 20px;
    }

    .btn-remove-ticket {
      color: #e74c3c;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h2>Create New Event</h2>
    
    <div class="card">
      <form action="/booking-system/events/store" method="POST" id="createEventForm">
        <!-- Event Details -->
        <div class="mb-3">
          <label for="name" class="form-label">Event Name</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>

        <div class="mb-3">
          <label for="date" class="form-label">Event Date</label>
          <input type="datetime-local" class="form-control" id="date" name="date" required>
        </div>

        <div class="mb-3">
          <label for="venue" class="form-label">Venue</label>
          <input type="text" class="form-control" id="venue" name="venue" required>
        </div>

        <!-- Ticket Types Section -->
        <h4 class="mt-4">Ticket Types</h4>
        <div id="ticketTypes">
          <div class="ticket-type">
            <div class="row">
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Ticket Name</label>
                  <input type="text" class="form-control" name="ticket_types[0][name]" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Price</label>
                  <input type="number" step="0.01" class="form-control" name="ticket_types[0][price]" required>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Quantity</label>
                  <input type="number" class="form-control" name="ticket_types[0][quantity]" required>
                </div>
              </div>
            </div>
          </div>
        </div>

        <button type="button" class="btn btn-add-ticket" onclick="addTicketType()">
          Add Another Ticket Type
        </button>

        <div class="text-center mt-4">
          <button type="submit" class="btn btn-primary">Create Event</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    let ticketTypeCount = 1;

    function addTicketType() {
      const template = `
        <div class="ticket-type">
          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Ticket Name</label>
                <input type="text" class="form-control" name="ticket_types[${ticketTypeCount}][name]" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" name="ticket_types[${ticketTypeCount}][price]" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label class="form-label">Quantity</label>
                <input type="number" class="form-control" name="ticket_types[${ticketTypeCount}][quantity]" required>
              </div>
            </div>
            <div class="col-md-1">
              <div class="mb-3">
                <label class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-link btn-remove-ticket" onclick="removeTicketType(this)">
                  ×
                </button>
              </div>
            </div>
          </div>
        </div>
      `;
      
      document.getElementById('ticketTypes').insertAdjacentHTML('beforeend', template);
      ticketTypeCount++;
    }

    function removeTicketType(button) {
      button.closest('.ticket-type').remove();
    }
  </script>
</body>
</html>