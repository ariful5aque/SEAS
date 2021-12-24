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
            <h1>Analysis of Classroom Requirement Summary</h1>
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
            <div class="col-xl-6">
                <div>
                    <h3>Generate Chart</h3>
                </div>
                <form action="problem_chart.php" method="POST">
                    <div class="form-group" style="max-width: 80%; ">
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
                        <label for="slot">Slot:</label>
                        <select class="form-control" name="slot">
                            <option value="6">6 slot chart</option>
                            <option value="7">7 slot chart</option>
                        </select>

                        <input class="btn btn-dark" type="submit" name="submit" value="Submit">
                    </div>
                </form>
            </div>





            <table class="table">
                <?php
                if (isset($_POST['submit'])) {
                    $semester_name = $_POST['semester_name'];
                    $year = $_POST['year'];
                    $sql = "SELECT * FROM section WHERE semester = '$semester_name' AND year = '$year'  AND enrolled_student
            BETWEEN '1' AND '10'";
                    $result = mysqli_query($conn, $sql);
                    $section_by_range = array();
                    array_push($section_by_range, mysqli_num_rows($result));

                    $sql2 = "SELECT * FROM section WHERE semester = '$semester_name' AND year = '$year'  AND enrolled_student
            BETWEEN '11' AND '20'";
                    $result2 = mysqli_query($conn, $sql2);
                    array_push($section_by_range, mysqli_num_rows($result2));

                    $sql3 = "SELECT * FROM section WHERE semester = '$semester_name' AND year = '$year'  AND enrolled_student
            BETWEEN '21' AND '30'";
                    $result3 = mysqli_query($conn, $sql3);
                    array_push($section_by_range, mysqli_num_rows($result3));

                    $sql4 = "SELECT * FROM section WHERE semester = '$semester_name' AND year = '$year'  AND enrolled_student
            BETWEEN '31' AND '35'";
                    $result4 = mysqli_query($conn, $sql4);
                    array_push($section_by_range, mysqli_num_rows($result4));

                    $sql5 = "SELECT * FROM section WHERE semester = '$semester_name' AND year = '$year'  AND enrolled_student
            BETWEEN '36' AND '40'";
                    $result5 = mysqli_query($conn, $sql5);
                    array_push($section_by_range, mysqli_num_rows($result5));

                    $sql6 = "SELECT * FROM section WHERE semester = '$semester_name' AND year = '$year'  AND enrolled_student
            BETWEEN '41' AND '50'";
                    $result6 = mysqli_query($conn, $sql6);
                    array_push($section_by_range, mysqli_num_rows($result6));

                    $sql7 = "SELECT * FROM section WHERE semester = '$semester_name' AND year = '$year'  AND enrolled_student
            BETWEEN '51' AND '55'";
                    $result7 = mysqli_query($conn, $sql7);
                    array_push($section_by_range, mysqli_num_rows($result7));

                    $sql8 = "SELECT * FROM section WHERE semester = '$semester_name' AND year = '$year'  AND enrolled_student
            BETWEEN '56' AND '65'";
                    $result8 = mysqli_query($conn, $sql8);
                    array_push($section_by_range, mysqli_num_rows($result8));
                    $total = 0;
                    $six_total = 0;
                    $seven_total = 0;
                    echo '<h1>';

                    echo 'Class Size Table for ' . $semester_name . ' ' . $year;

                    echo '</h1>';
                    echo '<th>Class Size</th>';
                    echo '<th>Sections</th>';
                    echo '<th>6 slot</th>';
                    echo '<th>7 slot</th>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>1-10</td>';
                    echo '<td>' . $section_by_range[0] . '</td>';
                    $total += $section_by_range[0];
                    echo '<td>' . round($section_by_range[0] / 12, 2) . '</td>';
                    $six_total += round($section_by_range[0] / 12, 2);
                    echo '<td>' .  round($section_by_range[0] / 14, 2) . '</td>';
                    $seven_total += round($section_by_range[0] / 14, 2);
                    echo '</tr>';
                    echo '<td>11-20</td>';
                    echo '<td>' . $section_by_range[1] . '</td>';
                    $total += $section_by_range[1];
                    echo '<td>' . round($section_by_range[1] / 12, 2) . '</td>';
                    $six_total += round($section_by_range[1] / 12, 2);
                    echo '<td>' .  round($section_by_range[1] / 14, 2) . '</td>';
                    $seven_total += round($section_by_range[1] / 14, 2);
                    echo '</tr>';
                    echo '<td>21-30</td>';
                    echo '<td>' . $section_by_range[2] . '</td>';
                    $total += $section_by_range[2];
                    echo '<td>' . round($section_by_range[2] / 12, 2) . '</td>';
                    $six_total += round($section_by_range[2] / 12, 2);
                    echo '<td>' .  round($section_by_range[2] / 14, 2) . '</td>';
                    $seven_total += round($section_by_range[2] / 14, 2);
                    echo '</tr>';

                    $var1 = 31;
                    $var2 = 35;
                    for ($i = 0; $i < 5; $i++) {
                        echo '<tr>';
                        echo '<td>' . $var1 . '-' . $var2 . '</td>';
                        echo '<td>' . $section_by_range[$i + 3] . '</td>';
                        $total += $section_by_range[$i + 3];
                        echo '<td>' . round($section_by_range[$i + 3] / 12, 2) . '</td>';
                        $six_total += round($section_by_range[$i + 3] / 12, 2);
                        echo '<td>' .  round($section_by_range[$i + 3] / 14, 2) . '</td>';
                        $seven_total += round($section_by_range[$i + 3] / 14, 2);
                        echo '</tr>';
                        if ($i === 1 or $i === 3) {
                            $var1 += 5;
                            $var2 += 10;
                        } elseif ($i === 2) {
                            $var1 += 10;
                            $var2 += 5;
                        } else {
                            $var1 += 5;
                            $var2 += 5;
                        }
                    }
                    echo '<td>Total</td>';
                    echo '<td>' . $total . '</td>';
                    echo '<td>' . $six_total . '</td>';
                    echo '<td>' .  $seven_total . '</td>';
                    echo '</tr>';
                }

                ?>


            </table>

        </div>
</body>

</html>