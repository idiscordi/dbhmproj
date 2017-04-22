<?php
	$serveraddr = 'localhost';
	$dbloginname = 'jtvaught';
	$dbloginpw = "owoh4che";
	$altpw = 'Shit4keMu5Hr00mz';
	$dbhost = 'turing';
	$dbconn;
	$sqlreturn;
	$retrow;
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
				echo("exception");
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
			
		}
		
		#form and submit query for adding a course
		function dbAddCourse() {
			
		}
		
		#form and submit query for adding application
		function dbAddApplication() {
			
		}
		
		#form and submit query for getting all students
		function dbGetStudents() {
			
			displayTablePage();
		}
		
		#form and submit query for getting all courses by dept
		function dbGetCoursesByDept() {
			
			displayTablePage();
		}
		
		#form and submit query for getting all courses by a student
		function dbGetCoursesByStudent() {
			
			displayTablePage();
		}
		
		
		function homepage() {
			?>
			
		<?php
		}
		
		#take user input for adding a student
		function addStudentPage() {
			?>
			
		<?php
		}
		
		#take user input for adding a course
		function addCoursePage() {
			?>
			
		<?php
		}
		
		#take user input for adding an application
		function addApplicationPage() {
			?>
			
		<?php
		}
		
		#display return from query as a table
		function displayTablePage() {
			?>
			
			<br>
		<?php
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
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "displayTable") {
			#PARSE AND DISPLAY TABLE
			
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "addStudent") {
			#HTML FOR TAKING USER INPUT FOR ADDING A STUDENT
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
			homePageButton();
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "addCourse") {
			#HTML FOR TAKING USER INPUT FOR ADDING A COURSE
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
			homePageButton();
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "addApplication") {
			#HTML FOR TAKING USER INPUT TO ADD AN APPLICATION
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
		
	dbConnect();
	dbDisconnect();
	
	?>
</body>
