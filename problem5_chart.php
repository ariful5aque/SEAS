<?php
include "conn.php";
require_once('C:/xampp/htdocs/jpgraph-4.3.4/jpgraph-4.3.4/src/jpgraph.php');
require_once('C:/xampp/htdocs/jpgraph-4.3.4/jpgraph-4.3.4/src/jpgraph_bar.php');

if (isset($_POST['submit'])) {
    $semester_name = $_POST['semester_name'];
    $year = $_POST['year'];
    $sql = "SELECT DISTINCT room_capacity FROM `classroom` ";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_all($result);
    $distinct_room_capacity = [];
    $sum_resource = 0;
    foreach ($data as $value) {
        array_push($distinct_room_capacity, $value[0]);
    }
    sort($distinct_room_capacity);
    $num_of_same_room_capacity = [];
    for ($i = 0; $i < sizeof($distinct_room_capacity); $i++) {
        $sql = "SELECT COUNT(room_capacity) FROM classroom WHERE room_capacity = '$distinct_room_capacity[$i]'";
        $result = mysqli_query($conn, $sql);
        $value = mysqli_fetch_array($result);
        array_push($num_of_same_room_capacity, $value[0]);
        $sum_resource += $value[0];
    }

    $enrolled_student = [];
    $total = 0;
    $total_difference = 0;
    for ($i = 0; $i < sizeof($distinct_room_capacity); $i++) {
        if ($i == 0) {
            $sql = "SELECT COUNT(enrolled_student) FROM section WHERE semester = '$semester_name' 
            AND year = '$year' AND enrolled_student <= '$distinct_room_capacity[$i]'";
        } else {
            $val = $distinct_room_capacity[$i - 1];
            $sql = "SELECT COUNT(enrolled_student) FROM section WHERE semester = '$semester_name' 
            AND year = '$year' AND enrolled_student BETWEEN '$val'
            AND '$distinct_room_capacity[$i]'";
        }
        $result = mysqli_query($conn, $sql);
        $value = mysqli_fetch_array($result);
        array_push($enrolled_student, $value[0]);
    }
}


$data1y = array(
    round($enrolled_student[0] / 12, 2),  round($enrolled_student[1] / 12, 2),  round($enrolled_student[2] / 12, 2),
    round($enrolled_student[3] / 12, 2),  round($enrolled_student[4] / 12, 2),  round($enrolled_student[5] / 12, 2),
    round($enrolled_student[6] / 12, 2)
);
$data2y = array(
    $num_of_same_room_capacity[0], $num_of_same_room_capacity[1], $num_of_same_room_capacity[2],
    $num_of_same_room_capacity[3], $num_of_same_room_capacity[4], $num_of_same_room_capacity[5], $num_of_same_room_capacity[6]
);

$datax = [];
for ($i = 0; $i < sizeof($distinct_room_capacity); $i++) {
    array_push($datax, $distinct_room_capacity[$i]);
}
// Create the graph. These two calls are always required
$graph = new Graph(800, 800);
$graph->SetScale("textlin");

$graph->SetShadow();
$graph->img->SetMargin(40, 30, 20, 40);

// Create the bar plots
$b1plot = new BarPlot($data1y);
$b1plot->SetFillColor("orange");
$b1plot->SetLegend('Resource Available');

$b2plot = new BarPlot($data2y);
$b2plot->SetFillColor("blue");
$b2plot->SetLegend("Semester's requirement");

// Create the grouped bar plot
$gbplot = new GroupBarPlot(array($b1plot, $b2plot));

// ...and add it to the graPH
$graph->Add($gbplot);

$graph->title->Set("Resource Utilization in " . $semester_name);
$graph->xaxis->title->Set("Disticnt Class Size");
$graph->yaxis->title->Set("Resource");

$graph->title->SetFont(FF_FONT1, FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1, FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1, FS_BOLD);
$graph->xaxis->SetTickLabels($datax);
$graph->legend->SetPos(0.3, 0.1, 'top', 'top');
// Display the graph
$graph->Stroke();
