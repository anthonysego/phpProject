<?php
// set up db connection values
$dsn = "mysql:dbname=student_data; charset=utf8";
$username = "root";
$password = "root";

// instantiate a PDO connection object
try {
	$conn = new PDO( $dsn, $username, $password );
	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
} 
catch ( PDOException $e ) { 
    echo "Connection failed: " . $e->getMessage();  
} 
	
	function returnStudents() {
		global $conn; 
		
		$sql = "SELECT * FROM students"; 
	    $rows = $conn->query( $sql );      // get the table rows 
	
	    $all_students = $rows->fetchAll(PDO::FETCH_ASSOC);
	
        $output = json_encode($all_students);  // creates an array of row objects
        echo $output;
	}

	function returnGPA() {
		global $conn; 
		
		$sql = "SELECT * FROM students, advisors WHERE students.advisor_id = advisors.advisor_id"; 
	    $rows = $conn->query( $sql );      // get the table rows 
	
	    $gpa = $rows->fetchAll(PDO::FETCH_ASSOC);
	
        $gpa_output = json_encode($gpa);  // creates an array of row objects
        echo $gpa_output;
	}

	

	if ($_SERVER['REQUEST_METHOD'] == 'GET') {

		 if(isset($_GET['sid']) && $_GET['sql']=='add') {
	        $id = $_GET['sid']; 
	        $fn = $_GET['first']; 
	        $ln = $_GET['last'];
	        $comp = $_GET['completed']; 
	        $attp = $_GET['attempted'];
	        $pts = $_GET['points']; 
	        $maj = $_GET['major'];
	        $advis = $_GET['advisor']; 
	        $em = $_GET['email'];

	        $insert_data = array($id, $fn, $ln, $comp, $attp, $pts, $maj, $advis, $em);

	        $sql = "INSERT INTO students VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
	        $st = $conn->prepare($sql);
	        $st->execute($insert_data); // prepared statement
	        echo "Record Inserted";
    }  
		 
		 elseif(isset($_GET['sid']) && $_GET['sql']=='update') {
			  $id = $_GET['sid']; 
		      $fn = $_GET['first']; 
		      $ln = $_GET['last'];
		      $comp = $_GET['completed']; 
		      $attp = $_GET['attempted'];
		      $pts = $_GET['points']; 
		      $maj = $_GET['major'];
		      $advis = $_GET['advisor']; 
		      $em = $_GET['email'];
			  
			  
			  $sql = "UPDATE students SET student_id = ?, first_name = ?, last_name = ?, hrs_completed = ?, hrs_attempted = ?, 
			  gpa_points = ?, major = ?, advisor_id = ?, email = ? WHERE student_id = $id";
			  $st = $conn->prepare($sql);
			  $st->execute(array($id, $fn, $ln, $comp, $attp, $pts, $maj, $advis, $em));  // prepared statement
			  
			  echo "Record Updated";
			  
			  
		 }
		 elseif(isset($_GET['sid']) && $_GET['sql']=='delete') {

			  $id = $_GET['sid'];
		
			  $sql = "DELETE FROM students WHERE student_id = $id";
			  $r = $conn->exec( $sql );
			  
			  echo "Record Deleted";
			  
		 }

		 elseif(isset($_GET['sid']) && $_GET['sql']=='getRecord') {

		 		$id = $_GET['sid'];
		
				$sql = "SELECT * FROM students WHERE student_id = $id"; 
			    $row = $conn->query( $sql );      // get the table rows 
			
			    $all_students = $row->fetchAll(PDO::FETCH_ASSOC);
			
		        $output = json_encode($all_students);  // creates an array of row objects
		        echo $output;

			}

			elseif(isset($_GET['sql']) && $_GET['sql']=='gpa') {

		 		returnGPA();

			}


		 else {  
		
  	          returnStudents();
  	          }
			
	}
?>