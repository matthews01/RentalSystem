<?php 
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

include("navbar.php");
include("config/config.php");

// using the post method of connection
if(isset($_POST['send_message'])){
    $u_email = $_SESSION["email"];
    $property_id = $_POST['property_id'];
    
    $sql = "SELECT * FROM tenant WHERE email='$u_email'";
    $query = mysqli_query($db, $sql);

    if(mysqli_num_rows($query) > 0){
        $tenant = mysqli_fetch_assoc($query);
        $tenant_id = $tenant['tenant_id'];

        $sql1 = "SELECT * FROM chat WHERE property_id='$property_id' AND tenant_id='$tenant_id'";
        $query1 = mysqli_query($db, $sql1);
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        h2 { color: white; }
        label { color: white; }
        span { color: #673ab7; font-weight: bold; }
        .container { margin-top: 3%; width: 60%; padding-right: 10%; padding-left: 10%; }
        .btn-primary { background-color: #337ab7; }
        .display-chat { height: 300px; background-color: lightgrey; margin-bottom: 4%; overflow: auto; padding: 15px; }
        .message { background-color: #c616e469; color: white; border-radius: 5px; padding: 5px; margin-bottom: 3%; }
    </style>
        <script>
        function validateForm() {
            var message = document.forms["chatForm"]["message"].value;
            if (message == "") {
                alert("Message cannot be empty");
                return false;
            }
        }
    </script>
</head>
<body>
<div class="container">
    <center><h3>Send Messages</h3></center>
    <div class="display-chat">
        <?php
        if(mysqli_num_rows($query1) > 0){
            while($row = mysqli_fetch_assoc($query1)){
        ?>
        <div class="message">
            <p><span><?php echo $row['message']; ?></span></p>
        </div>
        <?php
            }
        } else {
        ?>
        <div class="message">
            <p>No previous chat available.</p>
        </div>
        <?php
        }
        ?>
    </div>
    <form class="form-horizontal" method="POST" action="">
        <div class="form-group">
            <div class="col-sm-10"> 
                <input type="hidden" name="property_id" value="<?php echo $property_id; ?>">    
                <input type="hidden" name="tenant_id" value="<?php echo $tenant_id; ?>">      
                <textarea name="message" class="form-control" placeholder="Type your message here..."></textarea>
            </div>
            <div class="col-sm-2">
                <input type="submit" name="send_message1" class="btn btn-primary" value="Send">
            </div>
        </div>
    </form>
</div>
<center><button onclick="goBack()" class="btn btn-success">Go Back</button></center>
<script>
function goBack() {
    window.history.back();
}
</script>
</body>
</html>
<?php
    }
}

if(isset($_POST['send_message1'])){
    $u_email = $_SESSION["email"];
    $message = $_POST['message'];
    $property_id = $_POST['property_id'];
    $tenant_id = $_POST['tenant_id'];

    $sql = "INSERT INTO chat(message, property_id, tenant_id) VALUES ('$message', '$property_id', '$tenant_id')";
    $query = mysqli_query($db, $sql);
    
    if($query){
        header("Refresh:0");
    }
}
?>
