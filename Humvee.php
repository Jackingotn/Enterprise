
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Commander!</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/portfolio-item.css" rel="stylesheet">

    <!-- Personal CSS -->
    <link href="css/personal.css" rel="stylesheet">


    <script src='https://www.google.com/recaptcha/api.js'></script>
    <!-- Javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>

<body>
<?php
//get the session details
require_once("session.php");
//include db connect
include('dbconnect.php');
//get the purchased number and player name
$order = $_GET["Buy"];
$name = $_SESSION["name"];
//get the other player details
$sql = "SELECT * FROM Player WHERE Name = '$name'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $available = $row["Money"];
    }
} else {
    echo "0 results";
}
// get the number of humvees in the player army
$sql = "SELECT * FROM Player_Units WHERE Name = '$name' AND Unit_ID =4";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $num = $row["Num"];
    }
} else {
    echo "0 results";
}

// get the humvee details
$getunits = "SELECT * FROM Unit WHERE Unit_ID = 4";

$result = $conn->query($getunits);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $cost = $row['Cost'];


    }

} else {
    echo "0 results";
}
//get the maximum available calculate the new number of humvees and the cost
$max = $available / $cost;
$max = floor($max);
$num += $order;
$cost *= $order;

$max -= $order;
if ($available >= $cost) {
    $available -= $cost;
        //update the player cash
    $sql = "UPDATE Player SET Money='$available' WHERE Name='$name'";



    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error updating record: " . $conn->error;
    }
    //get the new humvees
    $sql = "UPDATE Player_Units SET Num='$num' WHERE Name='$name' and Unit_ID =4";


    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error updating record: " . $conn->error;
    }
}


?>



<div class="container">
    <nav class="navbar navbar-default">
        <div class="container-fluid">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Commander!</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="/index.php">Buy Units</a></li>
                    <li><a href="/territories.php">View Territories</a></li>
                    <li><a href="/playas.php">Players</a></li>
                </ul>



                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout.php" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="logout.php" method="POST" style="display: none;"><input type="hidden"></form></li>


                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>        </div>

<div class="container">

    <div class='panel panel-primary'><div class='panel-heading'><h3 class='panel-title'>Recruit Humvees</h3></div><div class='panel-body'>
            <!-- prepping the form for buying one -->
            <form method="Get" action="Humvee.php" accept-charset="UTF-8">

                <input name="Buy" type="hidden" value="1">

                <!-- Showing available cash -->
                <div class='col-sm-6'>
                    <h2>Cash Available: <?php echo $available ?></h2>

                    <img src="Humvee.jpg">

                    <br>
                    <div class="form-group">
                        <input class="form-control" type="submit"  value="Hire one">

                    </div>
            </form>
            <form method="Get" action="Humvee.php" accept-charset="UTF-8">
                <!-- prepping the max button -->
                <input name="Buy" type="hidden" value="<?php echo $max ?>">
                <div class="form-group">
                    <input class="form-control" type="submit"  value="Hire the maximum <?php echo $max ?> ">

                </div>
            </form>




        </div>


                <div class='col-sm-6'>
                    <h4>Stats</h4>



                    <?php
                    include('dbconnect.php');

                    //get the humvee details
                    $getunits = "SELECT * FROM Unit WHERE Unit_ID = 4";

                    $result = $conn->query($getunits);




                    echo "<table class=\"table table-striped task-table\">
<tr>
<th>Name</th>
<th>HP</th>
<th>Attack</th>
<th>Accuracy</th>
<th>Range</th>
<th>Cost</th>

</tr>";

                    //display the unit details
                    $cost = 0;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['UName'] . "</td>";
                        echo "<td>" . $row['HP'] . "</td>";
                        echo "<td>" . $row['Attack'] . "</td>";
                        echo "<td>" . $row['Acc'] . "</td>";
                        echo "<td>" . $row['Ran'] . "</td>";
                        echo "<td>" . $row['Cost'] . "</td>";

                        echo "</tr>";
                    }


                    echo "</table>";

                    ?>
                    <!-- Flavour Text -->
                    <h4>Equipment</h4>
                    <ul>
                        <li>Primary Weapon: <strong>2 Blaster rifles..?</strong></li>
                        <li>Secondary Weapon: <strong>1 Blaster Pistol..?</strong></li>
                        <li>Armour: <strong>Military-Grade Steel</strong></li>

                    </ul>


                    <p>I'm not sure who these guys are, but they look dangerous and they work for cheaper than you'd think</p>
                </div>



            </form>

        </div></div>
</div>

</body>
</html>