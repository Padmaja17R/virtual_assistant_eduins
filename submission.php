<?php
include("2.php");
$question = $_POST['question'];
$database = $_POST['database'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if($database == "Faculty"){
    $audio = false;
    if($question == "How many faculties are available Today"){
        $query = "select count(*) as count from faculty_availability where `Availability` = 'YES'";
    }
    else if($question == "How many faculties are Not available Today"){
        $query = "select count(*) as count from faculty_availability where `Availability` != 'YES'";
    }
    else if($question == "List Out CSE Faculty Details"){
        $query = "select * from faculty_availability where 1";
    }
    else{
        // $query = "SELECT * FROM faculty_availability WHERE 1";
        $audio = true;
        $query = "SELECT * FROM faculty_availability WHERE MATCH(Faculty_name,Department_name,Subject,Classes_on_that_day,Availability) AGAINST ('{$question}' IN NATURAL LANGUAGE MODE);";
        // $query = "SELECT * FROM faculty_availability WHERE Faculty_name REGEXP '%{$question}%' or Department_name like '%{$question}%' or Subject like '%{$question}%' or Classes_on_that_day like '%{$question}%' or Availability like '%{$question}%'";
        // echo $query;
    }
    $result = $conn->query($query);
    if ($result->num_rows == 1 && !$audio) {
        $row = $result->fetch_assoc();
        echo $row['count'];
    }
    else if ($result->num_rows > 1 || $audio) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo "id: " . $row["s_no"]. " - Name : " . $row["Faculty_name"]. " - Subject :  " . $row["Subject"]. "\n";
        }
    } else {
        echo "0 results";
    }
}
else if($database == "Student"){
    $audio = false;
    if($question == "How many Student Registered"){
        $query = "select count(*) as count from student_details where 1";
    }
    else if($question == "List Out Student Details"){
        $query = "select * from student_details where 1";
    }
    else{
        // $query = "SELECT * FROM faculty_availability WHERE 1";
        $audio = true;
        $query = "SELECT * FROM student_details WHERE MATCH(Name_of_the_student,Register_No) AGAINST ('{$question}' IN NATURAL LANGUAGE MODE)";
        // echo $query;
    }
    // else{
        
    //     $query = "SELECT * FROM faculty_availability WHERE 1";
    //     // $query = "SELECT * FROM faculty_availability WHERE Faculty_name like '%$question%' or Department_name like '%$question%' or Subject like '%$question%' or Classes_on_that_day like '%$question%' or Availabilit` like '%$question%'";
    // }
    $result = $conn->query($query);
    if ($result->num_rows == 1 && !$audio) {
        $row = $result->fetch_assoc();
        echo $row['count'];
    }
    else if ($result->num_rows > 1 || $audio) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo "id: " . $row["s_no"]. " - Name : " . $row["Name_of_the_student"]. " - Register No :  " . $row["Register_No"]. "\n";
        }
    } else {
        echo "0 results";
    }
}
//updating code
else if($database == "Location"){
    $audio = false;
    if($question == "How many locations are mentioned"){
        $query = "select count(*) as count from `location _identification`";
        //new code..
       // echo "<img src='assets/img/code-mic-150.png' width='40%' height ='40%'>";
    }
    else if($question == "List Out Locations and Identification"){
        $query = "select * from `location _identification`";
    }
    else{
        // $query = "SELECT * FROM faculty_availability WHERE 1";
        $audio = true;
        $query = "SELECT * FROM `location _identification` WHERE MATCH(location,directions) AGAINST ('{$question}' IN NATURAL LANGUAGE MODE);";
        
        //$query = "SELECT * FROM `location _identification` WHERE MATCH(`location`,`directions`) AGAINST ('{$question}' IN NATURAL LANGUAGE MODE)";
        // echo $query;
    }
    // else{
        
    //     $query = "SELECT * FROM faculty_availability WHERE 1";
    //     // $query = "SELECT * FROM faculty_availability WHERE Faculty_name like '%$question%' or Department_name like '%$question%' or Subject like '%$question%' or Classes_on_that_day like '%$question%' or Availabilit` like '%$question%'";
    // }
    $result = $conn->query($query);
    if ($result->num_rows == 1 && !$audio) {
        $row = $result->fetch_assoc();
        echo $row['count'];
    }
    else if ($result->num_rows > 1 || $audio) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo "Location: " . $row["location"]. " - Directions: " . $row["directions"]."\n";
        }
    } else {
        echo "0 results";
    }
}
else if($database == "NSS_Event"){
    $audio = false;
    if($question == "How many events have taken place"){
        $query = "select count(*) as count from nss_ncc_event_schedule";
    }
    else if($question == "List Out NSS Details"){
        $query = "select * from nss_ncc_event_schedule";
    }
    else{
        // $query = "SELECT * FROM faculty_availability WHERE 1";
        $audio = true;
        $query = "SELECT * FROM nss_ncc_event_schedule WHERE MATCH(`Date of event`,`Time of Event`,`Name of event`,`No of students participated`) AGAINST ('{$question}' IN NATURAL LANGUAGE MODE)";
        // echo $query;
    }
    // else{
        
    //     $query = "SELECT * FROM faculty_availability WHERE 1";
    //     // $query = "SELECT * FROM faculty_availability WHERE Faculty_name like '%$question%' or Department_name like '%$question%' or Subject like '%$question%' or Classes_on_that_day like '%$question%' or Availabilit` like '%$question%'";
    // }
    $result = $conn->query($query);
    if ($result->num_rows == 1 && !$audio) {
        $row = $result->fetch_assoc();
        echo $row['count'];
    }
    else if ($result->num_rows > 1 || $audio) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo "Date of Event: " . $row["Date of event"]. " - Time of Event : " . $row["Time of event"]. " - Name of Event :  " . $row["Name of event"]." - Students Participated :  " . $row["No of students participated"]. "\n";
        }
    } else {
        echo "0 results";
    }
}

else if($database == "TimeTable"){
    $audio = false;
    if($question == "How many days is working"){
        $query = "select count(DISTINCT day) as count from `timetable`";
    }
    else if($question == "List the timetable"){
        $query = "select * from `timetable`";
    }
    else{
        // $query = "SELECT * FROM faculty_availability WHERE 1";
        $audio = true;
        $query = "ALTER TABLE timetable ADD FULLTEXT(department,year,day,time,subject)";

        $query = "SELECT * FROM timetable WHERE MATCH(department,year,day,time,subject) AGAINST ('{$question}' IN NATURAL LANGUAGE MODE)";
        // echo $query;
    }
    // else{
        
    //     $query = "SELECT * FROM faculty_availability WHERE 1";
    //     // $query = "SELECT * FROM faculty_availability WHERE Faculty_name like '%$question%' or Department_name like '%$question%' or Subject like '%$question%' or Classes_on_that_day like '%$question%' or Availabilit` like '%$question%'";
    // }
    $result = $conn->query($query);
    if ($result->num_rows == 1 && !$audio) {
        $row = $result->fetch_assoc();
        echo $row['count'];
    }
    else if ($result->num_rows > 1 || $audio) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo "Department: " . $row["department"]. " - Year : " . $row["year"]. " - Day :  " . $row["day"]. " - Time :  " . $row["time"]." - Subject :  " . $row["subject"]. "\n";
        }
    } else {
        echo "0 results";
    }
}
//code ends..
else{
    $audio = false;
    // echo $question;
    if($question == "How many Books We have"){
        $query = "select count(*) as count from Library_details where 1";
    }
    else if($question == "List Out Books Details"){
        $query = "select * from Library_details where 1";
        // echo $query;
    }
    else{
   // $query = "SELECT * FROM faculty_availability WHERE 1";
        $audio = true;
        $query = "SELECT * FROM Library_details WHERE MATCH(Department,Year,Book_name,Author) AGAINST ('{$question}' IN NATURAL LANGUAGE MODE)";
        //  echo $query;
    }
    // else{
        
    //     $query = "SELECT * FROM faculty_availability WHERE 1";
    //     // $query = "SELECT * FROM faculty_availability WHERE Faculty_name like '%$question%' or Department_name like '%$question%' or Subject like '%$question%' or Classes_on_that_day like '%$question%' or Availabilit` like '%$question%'";
    // }
    $result = $conn->query($query);
    if ($result->num_rows == 1 && !$audio) {
        $row = $result->fetch_assoc();
        echo $row['count'];
    }
    else if ($result->num_rows > 1 || $audio) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            // echo $row;
          echo "id: " . $row["s_no"]. " - Department : " . $row["Department"]." - Year : " . $row["Year"]." - Book_name : " . $row["Book_name"]." - Author : " . $row["Author"]."\n";
        }
    } 
    else {
        echo "0 results";
    }
}
// echo json_encode($data);
exit;
?>/