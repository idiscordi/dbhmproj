<?php
	$serveraddr = 'localhost';
	$dbloginname = 'jtvaught';
	$dbloginpw = "owoh4che";
	$sqlreturn;
	$retrow;
	ini_set('display_errors', 1);
?>
<title>DB Homework 5 Project Site</title>
<body>
	<?php
	
		function dbConnect() {
			
		}
		
		function dbDisconnect() {
			
		}
		
		function dbAddStudent() {
			
		}
		
		function dbAddCourse() {
			
		}
		
		function dbAddApplication() {
			
		}
		
		function dbGetStudents() {
			
		}
		
		function dbGetCoursesByDept() {
			
		}
		
		function dbGetCoursesByStudent() {
			
		}
		
		function homepage() {
			
		}
		
		function addStudentPage() {
			
		}
		
		function addCoursePage() {
			
		}
		
		function addApplicationPage() {
			
		}
		
		function displayTablePage() {
			
		}
		
		function homePageButton () {
			
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
				<input type="submit" name="choice" value="choice"/>
			</form>
		<?php 
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "displayTable") {
			#PARSE AND DISPLAY TABLE
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "addStudent") {
			#HTML FOR TAKING USER INPUT FOR ADDING A STUDENT
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "addCourse") {
			#HTML FOR TAKING USER INPUT FOR ADDING A COURSE
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "addApplication") {
			#HTML FOR TAKING USER INPUT TO ADD AN APPLICATION
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "getStudents") {
			#HANDLE LOGIC TO CALL AND GET STUDENTS
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "getCourseByDept") {
			#HTML FOR TAKING USER INPUT TO GET COURSES BY DEPT
		}
		else if(isset($_REQUEST) && $_REQUEST["pageChoice"] == "getCourseByStudent") {
			#HTML FOR TAKING USER INPUT TO GET COURSES BY STUDENT
		}
	?>
</body>
