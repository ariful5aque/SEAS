<?php
include "conn.php";
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Document</title>
    <style>
        body {
            background-image: linear-gradient(to right, rgba(255, 230, 230, 0.2), rgba(142, 117, 181, 0.2));
            background-color: rgb(0, 0, 0);
            color: cornsilk;
        }

        .breadcrumb {

            background-color: #bf80ff;

        }

        h1,
        .h1 {
            font-size: 2.5rem;
            color: #f2e6ff;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #e6ccff;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 20px;
            border-style: solid;
            border-color: #a6a6a6;
            border-radius: 5px;
            border-width: 1px;
            border-collapse: separate;
            border-spacing: 15px;
            background-image: linear-gradient(to right, rgba(255, 0, 0, 0), rgba(255, 0, 0, 0.2));
        }
    </style>
</head>

<body>
    <div class="container">
        <div>
            <h1>Analysis of Resource usage summary</h1>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div>
                    <h3>Generate Table</h3>
                </div>
                <form action="" method="POST">
                    <div class="form-group" style="max-width: 70%; color:cornsilk">
                        <label for="semester_name">Semester:</label>
                        <select class="form-control" name="semester_name">

                            <?php

                            $sql = "SELECT DISTINCT semester FROM section";
                            $result = mysqli_query($conn, $sql);
                            echo "<option value= --select-->--select--</option>";

                            while ($rows =  mysqli_fetch_assoc($result)) {
                                $semester_name = $rows['semester'];
                                echo "<option value= '$semester_name'>$semester_name</option>";
                            }

                            ?>
                        </select>
                        <label for="year">Year:</label>
                        <select class="form-control" name="year">

                            <?php

                            $sql = "SELECT DISTINCT year FROM section";
                            $result = mysqli_query($conn, $sql);
                            echo "<option value= --select-->--select--</option>";

                            while ($rows =  mysqli_fetch_assoc($result)) {
                                $year = $rows['year'];
                                echo "<option value= '$year'>$year</option>";
                            }

                            ?>
                        </select>
                        <input class="btn btn-dark" type="submit" name="submit" value="Submit">
                    </div>
                </form>
            </div>


            <?php
            if (isset($_POST['submit'])) {
                $semester_name = $_POST['semester_name'];
                $year = $_POST['year'];
                // Student enrolled calculation
                $school = array("SBE", "SELS", "SETS", "SLASS", "SPPH");
                $sql = "SELECT enrolled_student FROM section WHERE semester = '$semester_name' AND year = '$year'";
                $result = mysqli_query($conn, $sql);
                $num_rows = mysqli_num_rows($result);

                $sql2 = "SELECT SUM(enrolled_student) FROM section WHERE semester = '$semester_name' AND year = '$year'";
                $result2 = mysqli_query($conn, $sql2);
                $data = mysqli_fetch_row($result2);
                // total enrolled student


                $total_enrolled = $data[0];
                $data_school_wise = [];
                $num_rows_school_wise = [];
                for ($i = 0; $i < sizeof($school); $i++) {
                    $sql = "SELECT enrolled_student FROM section WHERE semester = '$semester_name' AND year = '$year'AND school_id = '$school[$i]'";
                    $result = mysqli_query($conn, $sql);
                    $num_rows_wise = mysqli_num_rows($result);
                    array_push($num_rows_school_wise, $num_rows_wise);
                    $sql2 = "SELECT SUM(enrolled_student) FROM section WHERE semester = '$semester_name' AND year = '$year' AND school_id = '$school[$i]'";
                    $result2 = mysqli_query($conn, $sql2);
                    $data_wise = mysqli_fetch_row($result2);
                    array_push($data_school_wise, $data_wise[0]);
                }


                //Average enrolled total
                $avg_enrolled = round(intval($data[0]) / intval($num_rows), 2);
                $avg_enrolled_school_wise = [];

                // array of average enrolled school wise
                for ($i = 0; $i < sizeof($data_school_wise); $i++) {
                    $avg = round(intval($data_school_wise[$i]) / intval($num_rows_school_wise[$i]), 2);
                    array_push($avg_enrolled_school_wise, $avg);
                }


                //  Room Capacity calculation
                $sql3 = "SELECT SUM(classroom.room_capacity) FROM section 
        JOIN classroom ON section.classroom_id = classroom.classroom_id 
        WHERE semester = '$semester_name' AND year = '$year'";
                $result3 = mysqli_query($conn, $sql3);
                $sum_of_room_capacity = mysqli_fetch_row($result3);
                $sum_of_room_capacity = $sum_of_room_capacity[0];
                // total room capacity


                $room_capacity_school_wise = [];
                for ($i = 0; $i < sizeof($school); $i++) {
                    $sql = "SELECT SUM(classroom.room_capacity) FROM section 
            JOIN classroom ON section.classroom_id = classroom.classroom_id
            WHERE semester = '$semester_name' AND year = '$year' AND school_id = '$school[$i]'";
                    $result = mysqli_query($conn, $sql);
                    $data_wise = mysqli_fetch_row($result);
                    array_push($room_capacity_school_wise, $data_wise[0]);
                }
                // room capacity school wise


                $avg_room = round(intval($sum_of_room_capacity) / intval($num_rows), 2);
                $avg_room_school_wise = [];
                // avg room capacity

                // avg room capacity school wise
                for ($i = 0; $i < sizeof($data_school_wise); $i++) {
                    $avg = round(intval($room_capacity_school_wise[$i]) / intval($num_rows_school_wise[$i]), 2);
                    array_push($avg_room_school_wise, $avg);
                }

                // Difference calculation
                $differnce = [];
                for ($i = 0; $i < sizeof($school); $i++) {
                    $diff = $avg_room_school_wise[$i] - $avg_enrolled_school_wise[$i];
                    array_push($differnce, $diff);
                }

                // percentage calculation
                $percentage = [];
                for ($i = 0; $i < sizeof($school); $i++) {
                    $percent = round($differnce[$i] / $avg_room_school_wise[$i], 2) * 100;
                    array_push($percentage, $percent);
                }
                echo "<table class='table'>";
                echo '<tr>
                <th>School</th>
                <th>Sum</th>
                <th>Avg Enrolled</th>
                <th>Avg Room</th>
                <th>Difference</th>
                <th>Unused % </th>

                </tr>';
                for ($i = 0; $i < sizeof($school); $i++) {
                    echo '<tr>
                    <td>' . $school[$i] . '</td>
                    <td>' . $data_school_wise[$i] . '</td>
                    <td>' . $avg_enrolled_school_wise[$i] . '</td>
                    <td>' . $avg_room_school_wise[$i] . '</td>
                    <td>' . $differnce[$i] . '</td>
                    <td>' . $percentage[$i] . "%" . '</td>
                    </tr>';
                }
                echo '</table>';

                $total_differnce = $avg_room - $avg_enrolled;

                $total_unused = round($total_differnce / $avg_room, 2) * 100;

                echo "<table class='table'>
            <tr>
                <th>Total Enrolled</th>
                <td> $total_enrolled </td>
            </tr>
            <tr>
                <th>Avg Enrolled</th>
                <td> $avg_enrolled</td>
            </tr>
            <tr>
                <th>Avg Room</th>
                <td>$avg_room </td>
            </tr>
            <tr>
                <th>Difference</th>
                <td>$total_differnce</td>
            </tr>
            <tr>
                <th>Unused %</th>
                <td>$total_unused %</td>
            </tr>
        </table>";
            }

            ?>


        </div>

</body>

</html>