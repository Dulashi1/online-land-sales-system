<!DOCTYPE html>
<html>

<head>
    <title>Mailing Subscriptions</title>
    <link rel="stylesheet" type="text/css" href="./css/dashboard.css">
</head>

<body>
    <div class="wrapper">
        <div class="sidebar">
            <div class="sidebarHead">
                
                <h1>Bhumi Land</h1>
                
            </div>
            <br><br>
            <ul>
                <li><a href="./index.html">Home</a></li>
                <li><a href="./about us.html">About us</a></li>
                <li><a href="Lands main page.html">Land</a></li>
                <li><a href="./payment.html">Payment plan</a></li>
                <li><a href="./contact us.html">Contact us</a></li>
                <li><a href="./user_info.php">User Info</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div>
                <h2>Edit Mailing Subscriptions</h2>
            </div>
            <?php
            include 'config.php'; //subscription page html,display subscription types in mailing list table
                                 

            // Check if the email parameter is present in the URL
            if (isset($_GET['email'])) {
                // Retrieve the email value from the URL parameter
                $email = $_GET['email'];

                // Query the mailing_list table to get existing subscriptions
                $subscriptionsQuery = "SELECT subscription_type FROM mailing_list WHERE mailingEmail = '$email'";
                $subscriptionsResult = mysqli_query($conn, $subscriptionsQuery);

                // Fetch the subscriptions from the result and store them in the array
                if ($row = mysqli_fetch_assoc($subscriptionsResult)) {
                    $existingSubscriptions = explode(',', $row['subscription_type']);//if there are existig subscriptions for email address
                    //retrieves value of subscription type  column and splits to an array called explode
                    //assumes subscription types are stored as a comma seprated string
                } else {
                    $existingSubscriptions = [];//if no row fetched ,no exisiting subscriptions it sets as an empty array
                }
            } else {
                // Redirect to contact.php if no email is present
                //if request method is not post
                //php scrpt was accessed without necessary form submiss
                header("Location: contact.php");
                exit;
            }
            ?>
            <form method="POST" action="updateSubscriptionTypes.php">
                <input type="hidden" id="email" name="email" value="<?php echo $email; ?>" required>
                <br><br>
                <div class="selectDiv">
                    <label for="subscription1">News:</label>
                    <input type="checkbox" id="subscription1" name="subscription[]" value="news" <?php if (in_array('news', $existingSubscriptions)) echo 'checked'; ?>>
                </div>
                <br>
                <div class="selectDiv">
                    <label for="subscription2">New Updates:</label>
                    <input type="checkbox" id="subscription2" name="subscription[]" value="updates" <?php if (in_array('updates', $existingSubscriptions)) echo 'checked'; ?>>
                </div>
                <br>
                <div class="selectDiv">
                    <label for="subscription3">Account Notifications:</label>
                    <input type="checkbox" id="subscription3" name="subscription[]" value="notifications" <?php if (in_array('notifications', $existingSubscriptions)) echo 'checked'; ?>>
                </div>
                <br>
                <input type="submit" value="Update Subscriptions">
            </form>
            <br><br>
            <button class="unsubBtn"><a href="mailingUnsubscribe.php?email=<?php echo $email; ?>">Unsubscribe</a></button>
        </div>
    </div>
</body>

</html>
