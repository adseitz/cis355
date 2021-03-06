<?php
class Persons {//Start Class

    //variables for the main attributes
    public $id;
    public $name;
    public $email;
    public $mobile;

    private $nameError = null;
    private $emailError = null;
    private $mobileError = null;

    private $title = "Person";

    function create_record() { // displays create form
        echo "
        <html>
            <head>
                <title>Create a $this->title</title>
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
                            <h3>Create a $this->title</h3>
                        </p>
                        <form class='form-horizontal' action='persons.php?fun=11' method='post'>
                    ";
        $this->control_group("name", $this->nameError, $this->name);
        $this->control_group("email", $this->emailError, $this->email);
        $this->control_group("mobile", $this->mobileError, $this->mobile);
        echo "
                            <div class='form-actions'>
                                <button type='submit' class='btn btn-success'>Create</button>
                                <a class='btn btn-danger' href='persons.php'>Back</a>
                            </div>
                        </form>
                    </div>
                </div> <!-- /container -->
            </body>
        </html>
                    ";
    }// end create function 
	
    function insert_record () { // inserts record info from 'create_record' into the database

        //error checking
        $valid = true;
        if (empty($this->name)) {
            $this->nameError = 'Please enter Name';
            $valid = false;
        }

        if (empty($this->email)) {
            $this->emailError = 'Please enter Email';
            $valid = false;
        }

        if (empty($this->mobile)) {
            $this->mobileError = 'Please enter Mobile';
            $valid = false;
        }

        //if no errors, insert user into database
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO fr_persons (name, email, mobile) values(?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($this->name,$this->email,$this->mobile));
            Database::disconnect();
            header("Location: persons.php");
        }
        else {
            $this->create_record();
        }
    }// end insert function
	
    function read_record(){ // displays read page

    $id = null;
    // if id isn't empty, load variable
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
    // if id is null send back to persons.php
    if ( null==$id ) {
        header("Location: persons.php");
    // else set variables to users name, email, and mobile
    } else { 
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM fr_persons where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $name = $data['name'];
        $email = $data['email'];
        $mobile = $data['mobile'];
        Database::disconnect();
    }
        // print out HTML with set variables from above
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
                            <h3>Read a $this->title</h3>
                        </p>
                    ";
        echo "
            <div class='form-horizontal' >
                      <div class='control-group'>
                        <label class='control-label'>Name</label>
                        <div class='controls'>
                        <label class='checkbox'>
                            $name
                        </label>
                        </div>
                      </div>
                   <div class='control-group'>
                        <label class='control-label'>Email Address</label>
                        <div class='controls'>
                            <label class='checkbox'>
                                $email
                            </label>
                        </div>
                      </div>
                      <div class='control-group'>
                        <label class='control-label'>Mobile Number</label>
                        <div class='controls'>
                            <label class='checkbox'>
                                $mobile
                            </label>
                        </div>
                      </div>
                        <div class='form-actions'>
                          <a class='btn btn-danger' href='persons.php'>Back</a>
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
        $sql = "SELECT * FROM fr_persons where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        if (!isset($this->nameError)){
        $this->name = $data['name'];}
        if (!isset($this->emailError)){
        $this->email = $data['email'];}
        if (!isset($this->mobileError)){
        $this->mobile = $data['mobile'];}
        Database::disconnect();

        echo "
        <html>
            <head>
                <title>Update a $this->title</title>
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
                            <h3>Update a $this->title</h3>
                        </p>
                        <form class='form-horizontal' action='persons.php?fun=33&id=$id' method='post'>
                    ";

        $this->control_group("name", $this->nameError, $this->name);
        $this->control_group("email", $this->emailError, $this->email);
        $this->control_group("mobile", $this->mobileError, $this->mobile);
        echo "
                            <div class='form-actions'>
                                <button type='submit' class='btn btn-success'>Update</button>
                                <a class='btn btn-danger' href='persons.php'>Back</a>
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
        header("Location: persons.php");
    }

    if ( !empty($_POST)) {
        $nameError = null;
        $emailError = null;
        $mobileError = null;

        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];

        $valid = true;
        if (empty($this->name)) {
            $this->nameError = 'Please enter Name';
            $valid = false;
        }

        if (empty($this->email)) {
            $this->emailError = 'Please enter Email';
            $valid = false;
        }

        if (empty($this->mobile)) {
            $this->mobileError = 'Please enter Mobile';
            $valid = false;
        }

        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE fr_persons  set name = ?, email = ?, mobile = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($name,$email,$mobile,$id));
            Database::disconnect();
            header("Location: persons.php");
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
                            <h3>Delete a $this->title</h3>
                        </p>
                    ";

        echo "
        <form class='form-horizontal' action='persons.php?fun=44' method='post'>
                      <input type='hidden' name='id' value='$id'/>
                      <p class='alert alert-error'>Are you sure to delete ?</p>
                      <div class='form-actions'>
                          <button type='submit' class='btn btn-danger'>Yes</button>
                          <a class='btn btn-success' href='persons.php'>No</a>
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
			$sql = "DELETE FROM fr_persons  WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			Database::disconnect();
			header("Location: persons.php");

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
					<a href='logout.php' class='btn btn-warning' style='float:right;'> Log out </a>
					<a class='btn btn-info' href='https://github.com/adseitz/cis355/tree/master/prog03' style='float:left;'>Github</a>
					</br></br>
                    <p class='row'>
                        <h3>
						<strong>
						$this->title" . "s" . " 
						</strong>
                        </h3>
                    </p>
                    <p>
                    </p>
                    <div class='row'>
                        <table class='table table-striped table-bordered'>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Title</th>
                                    <th>Upload Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                    ";
        $pdo = Database::connect();
        $sql = "SELECT * FROM fr_persons ORDER BY id DESC";
        foreach ($pdo->query($sql) as $row) {
            echo "<tr>";
            echo "<td>". $row["name"] . "</td>";
            echo "<td>". $row["email"] . "</td>";
            echo "<td>". $row["mobile"] . "</td>";
            echo "<td>". $row["title"] . "</td>";
            
            echo "<td width=250>";
            echo "<a class='btn btn-primary' href='upload.html'>SIMPLE</a>";
            echo "&nbsp;";
            echo "<a class='btn btn-primary' href='upload03.html'>BLOB</a>";
            echo "&nbsp;";
            echo "<a class='btn btn-primary' href='upload02.html'>PATH</a>";           
            echo "</td>";
                
            echo "<td width=250>";
            echo "<a class='btn' href='persons.php?id=".$row["id"]."&fun=2'>Read</a>";
            echo "&nbsp;";
            echo "<a class='btn btn-success' href='persons.php?id=".$row["id"]."&fun=3'>Update</a>";
            echo "&nbsp;";
            echo "<a class='btn btn-danger' href='persons.php?id=".$row["id"]."&fun=4'>Delete</a>";
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