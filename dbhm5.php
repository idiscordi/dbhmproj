<?php
	#$serveraddr = 'localhost';
	#$dbloginname = 'jtvaught';
	#$dbloginpw = "owoh4Che";
	#$altpw = 'Shit4keMu5Hr00mz';
	#$dbhost = 'turing';
	$dbconn;
	$sqlreturn;
	$response;
	ini_set('display_errors', 1);
?>
<title>DB Homework 5 Project Site</title>
<body>
	<?php
		#handle making connection to the database
		function dbConnect() {
			global $dbconn, $dbhost, $dbloginname, $dbloginpw;
			
			try {
				#$dbconn = new PDO('mysql:host=turing;dbname=jtvaught', 
				#	$dbaseloginname, $dbloginpw, 
                #   array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));  
				$dbconn = mysqli_connect('turing', 'jtvaught', 'owoh4Che', 'jtvaught', 3306);
			}
			catch(Exception $e) {
				die('Error connecting to database.');
			}
         
			
			if(!$dbconn) {
				die('Error connecting to database.');
			}
		}
		
		#disconnect from database
		function dbDisconnect() {
			global $dbconn;
			
			if($dbconn) {
				mysqli_close($dbconn);
			}
		}
		
		#form and submit query for inserting a student
		function dbAddStudent() {
			global $dbconn, $response;
			$error = false;
			
			
			if($_REQUEST["studentName"] == "" || !ctype_alpha(str_replace(' ', '', $_REQUEST["studentName"]))) {
				$error = true;
				echo("<br>Invalid student name given.  May not contain numeral, apostrophe, or dash<br>");
			}
			
			if(!$error) {
				$query = "INSERT INTO Student (studentName, major) VALUES ('" . $_REQUEST["studentName"] . "'" .
					", '" . $_REQUEST["dept"] . "')";
				dbConnect();
				$response = mysqli_query($dbconn, $query);
			}
			if (!$response) {
				echo("<br>Unable to perform request.<br>");
			}
			else {
				echo("<br>Added.<br>");
			}
			
			dbDisconnect();
		}
		
		#form and submit query for adding a course
		function dbAddCourse() {
			global $dbconn, $response;
			$query;
			$error = false;
			dbConnect();
			
			if($_REQUEST["courseNum"] == "" || !ctype_digit($_REQUEST["courseNum"]) ||
				(ctype_digit($_REQUEST["courseNum"]) && $_REQUEST["courseNum"] >= 9999) ) {
					
				$error = true;
				echo("<br>Invalid course number given.  May only contain numerals 0-9, and less than 10000<br>");
			}
			if($_REQUEST["courseTitle"] == "") {
				$error = true;
				echo("<br>Invalid course title given.  You must enter a title.<br>");
			}
			if($_REQUEST["creditHours"] == "" || !ctype_digit($_REQUEST["creditHours"]) ||
				(ctype_digit($_REQUEST["creditHours"]) && $_REQUEST["creditHours"] > 9) ) {
				$error = true;
				echo("<br>Invalid course number given.  May only contain numerals 0-9, and less than 10<br>");
			}
			
			if(!$error) {
				$query = "INSERT INTO Course (deptCode, courseNum, title, creditHours) " .
						"VALUES ('" . $_REQUEST["dept"] . "', " . $_REQUEST["courseNum"] . ", '" .
						$_REQUEST["courseTitle"] . "', " . $_REQUEST["creditHours"] . ")";
				#echo($query);
				dbConnect();
				$response = mysqli_query($dbconn, $query);
			}
			if (!$response) {
				echo("<br>Unable to perform request.<br>");
			}
			else {
				echo("<br>Added.<br>");
			}
			dbDisconnect();
		}
		
		#form and submit query for adding application
		function dbAddApplication() {
			global $dbconn, $response;
			$queryStr;
			$error = false;
			
			if($_REQUEST["courseNum"] == "" || !ctype_digit($_REQUEST["courseNum"]) ||
				(ctype_digit($_REQUEST["courseNum"]) && $_REQUEST["courseNum"] >= 9999) ) {
				
				$error = true;
				echo("<br>Invalid course number given.  May only contain numerals 0-9, and less than 10000<br>");
			}
			if($_REQUEST["studentID"] == "" || !ctype_digit($_REQUEST["studentID"])) {
				$error = true;
				echo("<br>Invalid student name given.  May not contain numeral, apostrophe, or dash<br>");
			}
			
			if(!$error) {
				$query = "INSERT INTO Enrollment (studentID, courseNum, deptCode) VALUES " .
						"(" . $_REQUEST["studentID"] . ", " . $_REQUEST["courseNum"] . ", '" .
						$_REQUEST["dept"] . "')";
				dbConnect();
				$response = mysqli_query($dbconn, $query);
			}
			
			if(!$response) {
				echo("<br>Unable to perform request.<br>");
			}
			else {
				echo("<br>Added.<br>");
			}
			dbDisconnect();
		}
		
		#form and submit query for getting all students
		function dbGetStudents() {
			global $dbconn, $response;
			
			$query = "SELECT * FROM Student";
			dbConnect();
			
			$response = mysqli_query($dbconn, $query);
			if($response) {
				displayTablePage();
			}
			else {
				echo("<br>No results found.<br>");
			}
			
			dbDisconnect();
		}
		
		#form and submit query for getting all courses by dept
		function dbGetCoursesByDept() {
			global $dbconn, $response;

			$query = "SELECT * FROM Course WHERE deptCode='" . $_REQUEST["dept"] . "'";
			dbConnect();
			
			$response = mysqli_query($dbconn, $query);
			if($response) {
					displayTablePage();
			}
			else {
				echo("<br>No results found.<br>");
			}
			
			dbDisconnect();
		}
		
		#form and submit query for getting all courses by a student
		function dbGetCoursesByStudent() {
			global $dbconn, $response;
			$error = false;
			
			if(!ctype_digit($_REQUEST["studentID"])) {
				$error = true;
				echo("<br>Invalid student ID.  Numerals only.<br>");
			}
			
			if(!$error) {
				$query = "SELECT Course.deptCode, Course.courseNum, title, creditHours FROM" .
						" Course JOIN Enrollment ON Course.deptCode = Enrollment.deptCode " .
						"AND Course.courseNum = Enrollment.courseNum" .
						" WHERE studentID=" . $_REQUEST["studentID"] . "";
				dbConnect();
				$response = mysqli_query($dbconn, $query);
				if($response) {
					displayTablePage();
				}
				else {
					echo("<br>No results found.<br>");
				}
			}
			
			dbDisconnect();
		}
		
		
		function homepage() {
			?>
			<form method="POST">
				<label for="Selection">Command: </label>
				<select id="pageChoice" name="pageChoice">
					<option value="default">Select Command</option>
					<option value="addStudent">Add Student</option>
					<option value="addCourse">Add Course</option>
					<option value="addApplication">Add Enrollment App</option>
					<option value="getStudents">Show All Students</option>
					<option value="getCoursesByDept">Show Courses by Dept</option>
					<option value="getCourseByStudent">Show Courses by Student</option>
				</select>
				<input type="submit" name="choice" value="Submit"/>
			</form>
		<?php
		}
		
		#take user input for adding a student
		function addStudentPage() {
			?>
			<form method="POST">
				<label for="Selection">Major: </label>
				<select id="dept" name="dept">
					<option value="CSCE">CSCE</option>
					<option value="ELEG">ELEG</option>
					<option value="MATH">MATH</option>
					<option value="PHIL">PHIL</option>
				</select>
				<br>
				Student Name: <input type="text" name="studentName" id="studentName" value=""/>
				<br>
				<input type=hidden name="pageChoice" id="pageChoice" value="dbAddStudent"/>
				<input type="submit" name="choice" value="Submit"/>
			</form>
		<?php
		}
		
		#take user input for adding a course
		function addCoursePage() {
			?>
			<form method="POST">
				<label for="Selection">Department: </label>
				<select id="dept" name="dept">
					<option value="CSCE">CSCE</option>
					<option value="ELEG">ELEG</option>
					<option value="MATH">MATH</option>
					<option value="PHIL">PHIL</option>
				</select>
				<br>
				Course Number: <input type="text" name="courseNum" id="courseNum" value=""/>
				<br>
				Course Title: <input type="text" name="courseTitle" id="courseTitle" value=""/>
				<br>
				Credit Hours: <input type="text" name="creditHours" id="creditHours" value=""/>
				<br>
				<input type=hidden name="pageChoice" id="pageChoice" value="dbAddCourse"/>
				<input type="submit" name="choice" value="Submit"/>
			</form>
		<?php
		}
		
		#take user input for adding an application
		function addApplicationPage() {
			?>
			<form method="POST">
				<label for="Selection">Course Dept: </label>
				<select id="dept" name="dept">
					<option value="CSCE">CSCE</option>
					<option value="ELEG">ELEG</option>
					<option value="MATH">MATH</option>
					<option value="PHIL">PHIL</option>
				</select>
				<br>
				Student ID: <input type="text" name="studentID" id="studentID" value=""/>
				<br>
				Course Number: <input type="text" name="courseNum" id="courseNum" value=""/>
				<br>
				<input type=hidden name="pageChoice" id="pageChoice" value="dbAddApplication"/>
				<input type="submit" name="choice" value="Submit"/>
			</form>
		<?php
		}
		
		#display return from query as a table
		function displayTablePage() {
			global $response;
			$temp = $response->fetch_fields();
			try
		    {
				echo '<table>';

				// Output header row from keys.
				echo '<tr>';
				foreach($temp as $tempVal)
					echo '<th>' . $tempVal->name . '</th>';
				echo '</tr>';

				// Output data rows from keys.
				foreach ($response as $row) 
				{
					echo '<tr>';
					foreach($row as $key => $field) 
					   echo '<td>' . $field . '</td>';
					echo '</tr>';
				}
				echo '</table>';
		    }
			catch (Exception $e) 
			{
				die('Error : ' . $e->getMessage());
			}

			homePageButton();
		}
		
		#make button to return to homepage
		function homePageButton () {
			?>
			<form method="POST">
				<input type="hidden" name="pageChoice" value="default"/>
				<input type="submit" name="choice" value="Home"/>
			</form>
		<?php
		}
		
		if (!isset($_REQUEST["pageChoice"]) || $_REQUEST["pageChoice"] == "default") {
			#HTML FOR HOMEPAGE IF NO SELECTION SET
			homepage();
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "displayTable") {
			#PARSE AND DISPLAY TABLE
			displayTable();
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "addStudent") {
			#HTML FOR TAKING USER INPUT FOR ADDING A STUDENT
			addStudentPage();
			homePageButton();
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "addCourse") {
			#HTML FOR TAKING USER INPUT FOR ADDING A COURSE
			addCoursePage();
			homePageButton();
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "addApplication") {
			#HTML FOR TAKING USER INPUT TO ADD AN APPLICATION
			addApplicationPage();
			homePageButton();
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "getStudents") {
			#HANDLE LOGIC TO CALL AND GET STUDENTS
			dbGetStudents();
			?>
			
		<?php
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "getCoursesByDept") {
			#HTML FOR TAKING USER INPUT TO GET COURSES BY DEPT
			?>
			<form method="POST">
				<label for="Selection">Deptartment: </label>
				<select id="dept" name="dept">
					<option value="CSCE">CSCE</option>
					<option value="ELEG">ELEG</option>
					<option value="MATH">MATH</option>
					<option value="PHIL">PHIL</option>
				</select>
				<input type=hidden name="pageChoice" id="pageChoice" value="dbGetCoursesByDept"/>
				<input type="submit" name="choice" value="Submit"/>
			</form>
		<?php
			homePageButton();
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "getCourseByStudent") {
			#HTML FOR TAKING USER INPUT TO GET COURSES BY STUDENT
			?>
			<form method="POST">
				Student ID: <input type="text" name="studentID" id="studentID" value=""/>
				<input type=hidden name="pageChoice" id="pageChoice" value="dbGetCoursesByStudent"/>
				<input type="submit" name="choice" value="Submit"/>
			</form>
		<?php
			homePageButton();
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "dbAddStudent") {
			if($_REQUEST["studentName"] == "") {
				echo("Invalid or no name entered for the student.");
			}
			else {
				dbAddStudent();
			}
			
			homePageButton();
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "dbAddCourse") {
			$error = false;
			if($_REQUEST["courseNum"] == "") {
				echo("<br>Invalid or no entry for the course number.<br>");
				$error = true;
			}
			if($_REQUEST["courseTitle"] == "") {
				echo("<br>Invalid or no entry for the course title.<br>");
				$error = true;
			}
			if($_REQUEST["creditHours"] == "") {
				echo("<br>Invalid or no entry entered for the credit hours.<br>");
				$error = true;
			}
			
			if (!$error) {
				dbAddCourse();
			}
			
			homePageButton();
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "dbAddApplication") {
			$error = false;
			if($_REQUEST["studentID"] == "") {
				echo("Invalid or no entry entered for the student ID.");
				$error = true;
			}
			if($_REQUEST["courseNum"] == "") {
				echo("Invalid or no entry entered for the course number.");
				$error = true;
			}
			if (!$error) {
				dbAddApplication();
			}
			
			homePageButton();
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "dbGetCoursesByDept") {
			dbGetCoursesByDept();
			#homePageButton();
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "dbGetCoursesByStudent") {
			dbGetCoursesByStudent();
			#homePageButton();
		}
		dbConnect();
		dbDisconnect();
	?>
</body>
