<?php
require_once 'auth.php'; 
check_login();

// Check for notifications
$notifications = []; // Placeholder for notifications, you need to implement fetching actual notifications

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form fields are set and not empty
    if (isset($_POST["event_title"], $_POST["event_description"], $_POST["event_date"], $_POST["event_time"], $_POST["event_location"], $_POST["guest_list"], $_POST["additional_info"]) && 
        !empty($_POST["event_title"]) && !empty($_POST["event_description"]) && !empty($_POST["event_date"]) && !empty($_POST["event_time"]) && !empty($_POST["event_location"]) && !empty($_POST["guest_list"]) && !empty($_POST["additional_info"])) {
        
        // Extract form data
        $event_title = $_POST["event_title"];
        $event_description = $_POST["event_description"];
        $event_date = $_POST["event_date"];
        $event_time = $_POST["event_time"];
        $event_location = $_POST["event_location"];
        $guest_list = $_POST["guest_list"];
        $additional_info = $_POST["additional_info"];

        // Send invitations (simulate for demonstration)
        // Here, you would integrate with email or SMS sending functionality
        $invitations_sent = sendInvitations($event_title, $event_date, $event_time, $event_location, $guest_list, $additional_info);

        if ($invitations_sent) {
            $success_message = "Event created successfully and invitations sent.";
            // Display event details under notification popup
            $event_details = [
                'title' => $event_title,
                'description' => $event_description,
                'date' => $event_date,
                'time' => $event_time,
                'location' => $event_location,
                'additional_info' => $additional_info
            ];
        } else {
            $error_message = "Failed to send invitations. Please try again later.";
        }
    } else {
        $error_message = "Please fill in all the required fields.";
    }
}

// Function to send invitations
function sendInvitations($title, $date, $time, $location, $guests, $additional_info) {
    // Send emails to guests (for demonstration purposes)
    // Here, you would integrate with actual email sending functionality
    $guest_list = explode(",", $guests);
    foreach ($guest_list as $guest) {
        $message = "You're invited to the event: $title\nDate: $date\nTime: $time\nLocation: $location\nAdditional Info: $additional_info";
        // Send email to $guest
        // Example:
        // mail($guest, "Invitation to Event: $title", $message);
    }
    return true; // Simulated successful sending
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Buddy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom CSS */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            padding-top: 50px;
        }
        .notification-icon {
            position: relative;
        }
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: red;
            color: #fff;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 12px;
        }
        .notification-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 9999;
        }
        .notification-popup.active {
            display: block;
        }
        .popup-slider {
            width: 100%;
            height: 20px;
            background-color: #ddd;
            border-radius: 10px;
            margin-bottom: 10px;
            overflow: hidden;
        }
        .popup-slider-inner {
            height: 100%;
            background-color: #007bff;
            width: 0;
            transition: width 2s;
        }
        .popup-slider-complete {
            width: 100%;
        }
        .popup-message {
            display: none;
            font-weight: bold;
            text-align: center;
        }
        .popup-message.active {
            display: block;
        }
        .navbar-brand i {
            margin-right: 5px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#"><i class="fas fa-calendar-alt"></i>Event Buddy</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
                </li>
                <li class="nav-item notification-icon">
                    <a class="nav-link" id="notificationToggle" href="#"><i class="fas fa-bell"></i><span class="notification-badge">1</span></a>
                    <div class="notification-popup" id="notificationPopup">
                        <div class="popup-slider">
                            <div class="popup-slider-inner"></div>
                        </div>
                        <div class="popup-message" id="popupMessage">Sent!</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Event Creation Form -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Create New Event</h2>
            <?php if (isset($success_message)) { ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success_message; ?>
                </div>
            <?php } ?>
            <?php if (isset($error_message)) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php } ?>
            <form method="post" id="eventForm">
                <div class="mb-3">
                    <label for="event_title" class="form-label"><i class="fas fa-heading"></i> Event Title</label>
                    <input type="text" class="form-control" id="event_title" name="event_title" required>
                </div>
                <div class="mb-3">
                    <label for="event_description" class="form-label"><i class="fas fa-file-alt"></i> Event Description</label>
                    <textarea class="form-control" id="event_description" name="event_description" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="event_date" class="form-label"><i class="far fa-calendar-alt"></i> Event Date</label>
                    <input type="date" class="form-control" id="event_date" name="event_date" required>
                </div>
                <div class="mb-3">
                    <label for="event_time" class="form-label"><i class="far fa-clock"></i> Event Time</label>
                    <input type="time" class="form-control" id="event_time" name="event_time" required>
                </div>
                <div class="mb-3">
                    <label for="event_location" class="form-label"><i class="fas fa-map-marker-alt"></i> Event Location</label>
                    <input type="text" class="form-control" id="event_location" name="event_location" required>
                </div>
                <div class="mb-3">
                    <label for="guest_list" class="form-label"><i class="fas fa-users"></i> Guest List</label>
                    <textarea class="form-control" id="guest_list" name="guest_list" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="additional_info" class="form-label"><i class="fas fa-info-circle"></i> Additional Info</label>
                    <textarea class="form-control" id="additional_info" name="additional_info" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-plus-circle"></i> Create Event</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#eventForm").submit(function(e) {
            e.preventDefault();
            // Simulate sending event
            sendEvent();
        });

        $("#notificationToggle").click(function(e) {
            e.preventDefault();
            $(".notification-popup").toggleClass("active");
        });
    });

    function sendEvent() {
        // Simulate sending event
        $(".popup-slider-inner").addClass("popup-slider-complete");
        setTimeout(function() {
            $("#popupMessage").addClass("active");
        }, 2000);
        setTimeout(function() {
            $(".notification-popup").removeClass("active");
        }, 4000);
    }
</script>
</body>
</html>
