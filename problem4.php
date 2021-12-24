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
            <h1>Analysis of Available resources summary</h1>
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
            <table class='table'>
                <?php
                if (isset($_POST['submit'])) {
                    $sql = "SELECT DISTINCT room_capacity FROM `classroom` ";
                    $result = mysqli_query($conn, $sql);
                    $data = mysqli_fetch_all($result);
                    $distinct_room_capacity = [];
                    $sum_resource = 0;
                    $sum_capacity = 0;
                    foreach ($data as $value) {
                        array_push($distinct_room_capacity, $value[0]);
                    }
                    $num_of_same_room_capacity = [];
                    for ($i = 0; $i < sizeof($distinct_room_capacity); $i++) {
                        $sql = "SELECT COUNT(room_capacity) FROM classroom WHERE room_capacity = '$distinct_room_capacity[$i]'";
                        $result = mysqli_query($conn, $sql);
                        $value = mysqli_fetch_array($result);
                        array_push($num_of_same_room_capacity, $value[0]);
                        $sum_resource += $value[0];
                    }
                    echo '<tr>';
                    echo '<th>Class Size</th>';
                    echo '<th>IUB Resource</th>';
                    echo '<th>Capacity</th>';
                    echo '</tr>';
                    for ($i = 0; $i < sizeof($distinct_room_capacity); $i++) {
                        echo '<tr>';
                        echo '<td>' . $distinct_room_capacity[$i] . '</td>';
                        echo '<td>' . $num_of_same_room_capacity[$i] . '</td>';
                        echo '<td>' . $distinct_room_capacity[$i] * $num_of_same_room_capacity[$i] . '</td>';
                        echo '</tr>';
                        $sum_capacity += $distinct_room_capacity[$i] * $num_of_same_room_capacity[$i];
                    }
                    echo '<tr>';
                    echo '<th>Total</th>';
                    echo '<td>' . $sum_resource . '</td>';
                    echo '<td>' . $sum_capacity . '</td>';
                    echo '</tr>';
                    echo "<table class='table'>
                <tr>
                    <th>Total Capacity with 6 slot 2 days</th>
                    <td>" . $sum_capacity * 12 . "</td>
                </tr>
                <tr>
                    <th>Total Capacity with 7 slot 2 days</th>
                    <td>" . $sum_capacity * 14 . "</td>
                </tr>
                <tr>
                    <th>Considering 3.5 average course load (6 slot)</th>
                    <td>" . round(($sum_capacity * 12) / 3.5, 2)  . "</td>
                </tr>
                <tr>
                    <th>Considering 3.5 average course load (7 slot)</th>
                    <td>" . round(($sum_capacity * 14) / 3.5, 2)  . "</td>
                </tr>
            </table>";
                }

                ?>
            </table>
        </div>
</body>

</html>