<?php

printForm();

#-----------------------------------------------------------------------------
// display the entry form for course search
function printForm(){

    echo '<h2>Course Lookup</h2>';

    // print user entry form
    echo "<form action='courses.php'>";
    echo "Course Prefix (Department)<br/>";
    echo "<input type='text' placeholder='CS' name='prefix'><br/>";
    echo "Course Number<br/>";
    echo "<input type='text' placeholder='116' name='courseNumber'><br/>";
    echo "Instructor<br/>";
    echo "<input type='text' placeholder='gpcorser' name='instructor'><br/>";
    echo "Day of Week<br/>";
    echo "<input type='text' placeholder='M, T, W, R' name='days'><br/>";
    echo "<input type='submit' value='Submit'>";
    echo "</form>";
}
?>
