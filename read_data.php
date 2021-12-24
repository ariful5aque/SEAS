<?php
include "conn.php";
if (($open = fopen("C:\Users\arman\OneDrive\Desktop\data_for_project\csv-classSize.csv", "r")) !== FALSE) {

    while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
        $array[] = $data;
    }

    fclose($open);
}
echo "<pre>";
// //To display array data
// foreach ($array as $data) {
//     foreach ($data as $value) {
//         echo $value . ",";
//     }
//     echo "\n";
// }

// for ($i = 0; $i < sizeof($array); $i++) {
//     $data = $array[$i];
//     for ($k = 0; $k < sizeof($data); $k++) {
//         echo $data[$k] . ",";
//     }
//     echo "\n";
// }


function push_classroom()
{
    include "conn.php";
    if (($open = fopen("C:\Users\arman\OneDrive\Desktop\data_for_project\csv-classSize.csv", "r")) !== FALSE) {

        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
            $array[] = $data;
        }

        fclose($open);
    }

    for ($i = 1; $i < sizeof($array); $i++) {
        $data = $array[$i];

        $sql = "INSERT INTO classroom (classroom_id,room_capacity) VALUES ('$data[8]','$data[9]')";

        if (mysqli_query($conn, $sql)) {
            echo "DONE";
        } else {
            echo "ERROR";
        }
    }
}


function push_school()
{
    include "conn.php";
    if (($open = fopen("C:\Users\arman\OneDrive\Desktop\data_for_project\csv-classSize.csv", "r")) !== FALSE) {

        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
            $array[] = $data;
        }

        fclose($open);
    }

    for ($i = 1; $i < sizeof($array); $i++) {
        $data = $array[$i];

        $sql = "INSERT INTO school (school_id) VALUES ('$data[0]')";

        if (mysqli_query($conn, $sql)) {
            echo "DONE";
        } else {
            echo "ERROR";
        }
    }
}

function push_course()
{
    include "conn.php";
    if (($open = fopen("C:\Users\arman\OneDrive\Desktop\data_for_project\csv-classSize.csv", "r")) !== FALSE) {

        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
            $array[] = $data;
        }

        fclose($open);
    }

    for ($i = 1; $i < sizeof($array); $i++) {
        $data = $array[$i];

        $sql = "INSERT INTO course (course_id,course_name,no_of_credit) VALUES ('$data[1]','$data[11]','$data[4]')";

        if (mysqli_query($conn, $sql)) {
            echo "DONE";
        } else {
            echo "ERROR";
        }
    }
}

function push_faculty()
{
    include "conn.php";
    if (($open = fopen("C:\Users\arman\OneDrive\Desktop\data_for_project\csv-classSize.csv", "r")) !== FALSE) {

        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
            $array[] = $data;
        }

        fclose($open);
    }

    for ($i = 1; $i < sizeof($array); $i++) {
        $data = $array[$i];
        $val = explode("-", $data[12]);
        $str = explode(" ", $val[1]);
        $arr = array($str[1], $str[2]);
        $email = implode("", $arr);
        $email = $email . "@iub.edu.bd";

        $sql = "INSERT INTO faculty (faculty_id,faculty_name,email) VALUES ('$val[0]','$val[1]','$email')";

        if (mysqli_query($conn, $sql)) {
            echo "DONE";
        } else {
            echo "ERROR";
        }
    }
}


function push_section()
{
    include "conn.php";
    if (($open = fopen("C:\Users\arman\OneDrive\Desktop\data_for_project\csv-classSize.csv", "r")) !== FALSE) {

        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
            $array[] = $data;
        }

        fclose($open);
    }

    for ($i = 1; $i < sizeof($array); $i++) {
        $data = $array[$i];
        $val = explode("-", $data[12]);
        $arr = array($data[15], $data[13], $data[14]);
        $routine = implode("-", $arr);

        $sql = "INSERT INTO section (cssy_id,section_no,school_id,course_id,faculty_id,classroom_id,enrolled_student
        ,semester,year,section_routine) VALUES ('','$data[3]','$data[0]','$data[1]','$val[0]','$data[8]',
        '$data[6]','$data[17]','$data[16]','$routine')";

        if (mysqli_query($conn, $sql)) {
            echo "DONE";
        } else {
            echo "ERROR";
        }
    }
}

// push_school();
// push_classroom();
// push_faculty();
// push_course();
push_section();
