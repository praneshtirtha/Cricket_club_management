<?php
session_start();

if (!isset($_SESSION['club_registered']) || !$_SESSION['club_registered']) {
    $_SESSION['error_message'] = "Please register a club first.";
    header("Location: register_club.php");
    exit();
}

$clubId = $_SESSION['ClubID'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Committee Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Yellow-green background for the form */
        .form-container {
            background-color: #cceecc; /* Light yellow-green color */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .committee-member {
            margin-bottom: 20px; /* Added bottom margin between each member form */
            padding-bottom: 15px; /* Padding to create space */
            border-bottom: 1px solid #ddd; /* Adds a line between each form */
        }

        .add-member-text {
            text-align: center;
            font-size: 18px;
            color: #555;
            margin-top: 20px;
        }

        input:focus {
            border-color: #80c904;
            outline: none;
            box-shadow: 0 0 5px #80c904;
        }

        /* Added space after End Date field */
        .buttons-container {
            margin-top: 30px; /* Add more space after the last input field */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <h2 class="form-header">Management Committee Registration</h2>

                    <!-- Display Success or Error Message -->
                    <?php
                    if (isset($_SESSION['success_message'])) {
                        echo "<p class='text-success'>" . $_SESSION['success_message'] . "</p>";
                        unset($_SESSION['success_message']);
                    }

                    if (isset($_SESSION['error_message'])) {
                        echo "<p class='text-danger'>" . $_SESSION['error_message'] . "</p>";
                        unset($_SESSION['error_message']);
                    }
                    ?>

                    <form action="save_committee.php" method="POST">
                        <input type="hidden" name="clubId" value="<?php echo $clubId; ?>">

                        <!-- Committee Member Fields -->
                        <div id="committee-members">
                            <div class="committee-member">
                                <label for="memberName[]" class="form-label">Member Name:</label>
                                <input type="text" name="memberName[]" class="form-control" placeholder="Member Name" required>

                                <label for="role[]" class="form-label">Role:</label>
                                <input type="text" name="role[]" class="form-control" placeholder="Role" required>

                                <label for="phoneNumber[]" class="form-label">Phone Number:</label>
                                <input type="text" name="phoneNumber[]" class="form-control" placeholder="Phone Number" required>

                                <label for="email[]" class="form-label">Email:</label>
                                <input type="email" name="email[]" class="form-control" placeholder="Email" required>

                                <label for="startDate[]" class="form-label">Start Date:</label>
                                <input type="date" name="startDate[]" class="form-control" required>

                                <label for="endDate[]" class="form-label">End Date:</label>
                                <input type="date" name="endDate[]" class="form-control">
                            </div>
                        </div>

                        <!-- Buttons container with extra space -->
                        <div class="buttons-container text-center">
                            <button type="button" class="btn btn-info w-100 mb-3" id="addMore">Add More Members</button>

                            <button type="submit" class="btn btn-primary w-100 mb-3">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add more committee member input fields when clicked
        document.getElementById('addMore').addEventListener('click', function () {
            const container = document.getElementById('committee-members');
            
            // Create new member input form
            const newMember = document.createElement('div');
            newMember.classList.add('committee-member');
            newMember.innerHTML = `
                <label for="memberName[]" class="form-label">Member Name:</label>
                <input type="text" name="memberName[]" class="form-control" placeholder="Member Name" required>

                <label for="role[]" class="form-label">Role:</label>
                <input type="text" name="role[]" class="form-control" placeholder="Role" required>

                <label for="phoneNumber[]" class="form-label">Phone Number:</label>
                <input type="text" name="phoneNumber[]" class="form-control" placeholder="Phone Number" required>

                <label for="email[]" class="form-label">Email:</label>
                <input type="email" name="email[]" class="form-control" placeholder="Email" required>

                <label for="startDate[]" class="form-label">Start Date:</label>
                <input type="date" name="startDate[]" class="form-control" required>

                <label for="endDate[]" class="form-label">End Date:</label>
                <input type="date" name="endDate[]" class="form-control">
            `;
            container.appendChild(newMember);

            // Insert the "Add New Member Here" text between the forms
            const addText = document.createElement('div');
            addText.classList.add('add-member-text');
            addText.innerHTML = `<p>Add New Member Here</p>`;
            container.appendChild(addText);
        });

        // Clear placeholder text when input is focused
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', () => {
                input.placeholder = '';
            });
            input.addEventListener('blur', () => {
                const placeholderMap = {
                    "memberName[]": "Member Name",
                    "role[]": "Role",
                    "phoneNumber[]": "Phone Number",
                    "email[]": "Email",
                    "startDate[]": "Start Date",
                    "endDate[]": "End Date"
                };
                input.placeholder = placeholderMap[input.name] || '';
            });
        });
    </script>
</body>
</html>
