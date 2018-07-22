<?php
class Events {//Start Class

    public $id;

    public $date;
    public $time;
    public $location;
    public $description;

    private $dateError = null;
    private $timeError = null;
    private $locationError = null;
    private $descriptionError = null;

    private $title = "Event";

    function create_record() { // displays create form
        echo "
        <html>
            <head>
                <title>Create an $this->title</title>
                    ";
        echo "
                <meta charset='UTF-8'>
                <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' rel='stylesheet'>
                <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js'></script>
                    ";
        echo "
            </head>
            <body>
                <div class='container'>
                    <div class='span10 offset1'>
                        <p class='row'>
                            <h3>Create an $this->title</h3>
                        </p>
                        <form class='form-horizontal' action='event.php?fun=11' method='post'>
                    ";
        $this->control_group("event_date", $this->dateError, $this->date);
        $this->control_group("event_time", $this->timeError, $this->time);
        $this->control_group("event_location", $this->locationError, $this->location);
        $this->control_group("event_description", $this->descriptionError, $this->description);
        echo "
                            <div class='form-actions'>
                                <button type='submit' class='btn btn-success'>Create</button>
                                <a class='btn btn-danger' href='event.php'>Back</a>
                            </div>
                        </form>
                    </div>
                </div> <!-- /container -->
            </body>
        </html>
                    ";
    }// end create function
	
    function insert_record () {// inserts record info from 'create_record' into the database

        $valid = true;
        if (empty($this->date)) {
            $this->dateError = 'Please enter Date';
            $valid = false;
        }

        if (empty($this->time)) {
            $this->timeError = 'Please enter Time';
            $valid = false;
        }

        if (empty($this->location)) {
            $this->locationError = 'Please enter Location';
            $valid = false;
        }

        if (empty($this->description)) {
            $this->descriptionError = 'Please enter Description';
            $valid = false;
        }
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO events (event_date,event_time,event_location,event_description) values(?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($this->date,$this->time,$this->location,$this->description));
            Database::disconnect();
            header("Location: event.php");
        }
        else {
            $this->create_record();
        }
    }// end insert function
	
    function read_record(){ // displays read page

    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }

    if ( null==$id ) {
        header("Location: event.php");
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM events where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $date = $data['event_date'];
        $time = $data['event_time'];
        $location = $data['event_location'];
        $description = $data['event_description'];
        Database::disconnect();
    }

        echo "
        <html>
            <head>
                    ";
        echo "
                <meta charset='UTF-8'>
                <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' rel='stylesheet'>
                <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js'></script>
                    ";
        echo "
            </head>
            <body>
                <div class='container'>
                    <div class='span10 offset1'>
                        <p class='row'>
                            <h3>Read an $this->title</h3>
                        </p>
                    ";
        echo "
            <div class='form-horizontal' >
                      <div class='control-group'>
                        <label class='control-label'>Date</label>
                        <div class='controls'>
                        <label class='checkbox'>
                            $date
                            </label>
                        </div>
                      </div>
                   <div class='control-group'>
                        <label class='control-label'>Time</label>
                        <div class='controls'>
                            <label class='checkbox'>
                                $time
                            </label>
                        </div>
                      </div>
                      <div class='control-group'>
                        <label class='control-label'>Location</label>
                        <div class='controls'>
                            <label class='checkbox'>
                                $location
                            </label>
                        </div>
                      </div>
                        <div class='control-group'>
                        <label class='control-label'>Description</label>
                        <div class='controls'>
                            <label class='checkbox'>
                                $description
                            </label>
                        </div>
                      </div>
                        <div class='form-actions'>
                          <a class='btn btn-danger' href='event.php'>Back</a>
                       </div>
                    </div>
                </div>
                </div>
                </body>
                </html>
        ";
    }// end read function

    function update_record() { // displays update form

        $id = $_GET['id'];

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM events where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        if (!isset($this->dateError)){
        $this->date = $data['event_date'];}
        if (!isset($this->timeError)){
        $this->time = $data['event_time'];}
        if (!isset($this->locationError)){
        $this->location = $data['event_location'];}
        if (!isset($this->descriptionError)){
        $this->description = $data['event_description'];}
        Database::disconnect();

        echo "
        <html>
            <head>
                <title>Update an $this->title</title>
                    ";
        echo "
                <meta charset='UTF-8'>
                <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' rel='stylesheet'>
                <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js'></script>
                    ";
        echo "
            </head>
            <body>
                <div class='container'>
                    <div class='span10 offset1'>
                        <p class='row'>
                            <h3>Update an $this->title</h3>
                        </p>
                        <form class='form-horizontal' action='event.php?fun=33&id=$id' method='post'>
                    ";

        $this->control_group("event_date", $this->dateError, $this->date);
        $this->control_group("event_time", $this->timeError, $this->time);
        $this->control_group("event_location", $this->locationError, $this->location);
        $this->control_group("event_description", $this->descriptionError, $this->description);
        echo "
                            <div class='form-actions'>
                                <button type='submit' class='btn btn-success'>Update</button>
                                <a class='btn btn-danger' href='event.php'>Back</a>
                            </div>
                        </form>
                    </div>
                </div> <!-- /container -->
            </body>
        </html>
                    ";
    }// end update function
	
    function refresh_record() { // updates record info from 'update_record' in the database

    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }

    if ( null==$id ) {
        header("Location: event.php");
    }

    if ( !empty($_POST)) {
        $dateError = null;
        $timeError = null;
        $locationError = null;
        $descriptionError = null;

        $date = $_POST['event_date'];
        $time = $_POST['event_time'];
        $location = $_POST['event_location'];
        $description = $_POST['event_description'];

        $valid = true;
        if (empty($this->date)) {
            $this->dateError = 'Please enter Date';
            $valid = false;
        }

        if (empty($this->time)) {
            $this->timeError = 'Please enter Time';
            $valid = false;
        }

        if (empty($this->location)) {
            $this->locationError = 'Please enter Location';
            $valid = false;
        }

        if (empty($this->description)) {
            $this->descriptionError = 'Please enter Description';
            $valid = false;
        }

        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE events  set event_date = ?, event_time = ?, event_location = ?, event_description = ?  WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($date,$time,$location,$description,$id));
            Database::disconnect();
            header("Location: event.php");
        } else {
                 $this->update_record();
    }
    }
    }// end refresh function

    function delete_record(){ // displays delete page

        $id = $_GET['id'];

        echo "
        <html>
            <head>
                    ";
        echo "
                <meta charset='UTF-8'>
                <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' rel='stylesheet'>
                <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js'></script>
                    ";
        echo "
            </head>
            <body>
                <div class='container'>
                    <div class='span10 offset1'>
                        <p class='row'>
                            <h3>Delete an $this->title</h3>
                        </p>
                    ";

        echo "
        <form class='form-horizontal' action='event.php?fun=44' method='post'>
                      <input type='hidden' name='id' value='$id'/>
                      <p class='alert alert-error'>Are you sure to delete ?</p>
                      <div class='form-actions'>
                          <button type='submit' class='btn btn-danger'>Yes</button>
                          <a class='btn btn-success' href='event.php'>No</a>
                        </div>
                    </form>
				</div>
				</div>
			</body>
		</html>
        ";
    }// end delete function
	
    function remove_record(){ // removes record selected from 'delete_record' from the database

		if ( !empty($_GET['id'])) {
			$id = $_REQUEST['id'];
		}

		if ( !empty($_POST)) {


			$id = $_POST['id'];

			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "DELETE FROM events  WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			Database::disconnect();
			header("Location: event.php");

		}
	}// end remove function

    function list_records() { // lists records (made like an index or home of sorts)
        echo "
        <html>
            <head>
                <title>$this->title" . "s" . "</title>
                    ";
        echo "
                <meta charset='UTF-8'>
                <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' rel='stylesheet'>
                <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js'></script>
                    ";
        echo "
            </head>
            <body>
                <div class='container'>
                    <p class='row'>
                        <h3>$this->title" . "s" . " <a class='btn btn-danger' href='https://github.com/adseitz/cis355/tree/master/prog01'>Github</a>
                        <a class='btn btn-success' href='customer.php'>Customers</a>
                        </h3>
                    </p>
                    <p>
                        <a href='event.php?fun=1' class='btn btn-success'>Create</a>
                    </p>
                    <div class='row'>
                        <table class='table table-striped table-bordered'>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Location</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                    ";
        $pdo = Database::connect();
        $sql = "SELECT * FROM events ORDER BY id DESC";
        foreach ($pdo->query($sql) as $row) {
            echo "<tr>";
            echo "<td>". $row["event_date"] . "</td>";
            echo "<td>". $row["event_time"] . "</td>";
            echo "<td>". $row["event_location"] . "</td>";
            echo "<td>". $row["event_description"] . "</td>";
            echo "<td width=250>";
            echo "<a class='btn' href='event.php?id=".$row["id"]."&fun=2'>Read</a>";
            echo "&nbsp;";
            echo "<a class='btn btn-success' href='event.php?id=".$row["id"]."&fun=3'>Update</a>";
            echo "&nbsp;";
            echo "<a class='btn btn-danger' href='event.php?id=".$row["id"]."&fun=4'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
        Database::disconnect();
        echo "
							</tbody>
                        </table>
                    </div>
                </div>
            </body>
        </html>
                 ";
    } // end list function

    function control_group ($label, $labelError, $val) {
        echo "<div class='control-group";
        echo !empty($labelError) ? 'error' : '';
        echo "'>";
        echo "<label class='control-label'>$label</label>";
        echo "<div class='controls'>";
        echo "<input name='$label' type='text' placeholder='$label' value='";
        echo !empty($val) ? $val : '';
        echo "'>";
        if (!empty($labelError)) {
            echo "<span class='help-inline'>";
            echo $labelError;
            echo "</span>";
        }
        echo "</div>";
        echo "</div>";
        echo "&nbsp;";
    } // end control group function
	
} // end Class
?>
   