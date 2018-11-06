<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$vehicleid = $timein = $slotid = "";
$vehicleid_err = $timein_err = $slotid_err = "";
$nowFormat = date('Y-m-d H:i:s', time());
$park_code = $rateid = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate vehicle_id
    $input_vehicleid = trim($_POST["vehicle_id"]);
    if(empty($input_vehicleid)){
        $vehicleid_err = "Please enter a Vehicle ID.";
    }else{
        $vehicleid = $input_vehicleid;
    }
    
    // Validate SLOTID
    $input_slotid = trim($_POST["slot_id"]);
    if(empty($input_slotid)){
        $slotid_err = "Please select your slot.";     
    } else{
        $slotid = $input_slotid;
    }

    
    // Check input errors before inserting in database
    if(empty($vehicleid_err) && empty($slotid_err) && empty($timein_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO slot (parkingcategory_id, slot_id) VALUES (?)";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_slotid);
            // Set parameters
            $param_slotid = $slotid;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){

                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Parking Slots</h2>
                    </div>
                    <p>Add Registration Plate and Parking Slot</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($vehicleid_err)) ? 'has-error' : ''; ?>">
                            <label>Vehicle Registration Plates</label>
                            <input type="text" name="vehicle_id" class="form-control" value="<?php echo $vehicleid; ?>">
                            <span class="help-block"><?php echo $vehicleid_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($slotid_err)) ? 'has-error' : ''; ?>">
                            <label>Parking Slot</label>
                            <select type="text" name = "slot_id" id="slot_id" class="form-control" value="<?php echo $slotid; 
                                $query1 = "SELECT parking_category_id FROM parkinglevels";
                                $result1 = mysqli_query($link, $query1);
                                ?>">
                            <?php while($row1 = mysqli_fetch_array($result1)):;?>
                            <option value="<?php echo $row1[0];?>"><?php echo $row1[0];?></option>
                            <?php endwhile;?>
                            </select>   
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>