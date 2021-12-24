<?php

declare(strict_types=1);
include "conn.php";
require_once('C:/xampp/htdocs/jpgraph-4.3.4/jpgraph-4.3.4/src/jpgraph.php');
require_once('C:/xampp/htdocs/jpgraph-4.3.4/jpgraph-4.3.4/src/jpgraph_pie.php');

if (isset($_POST['submit'])) {
    $semester_name = $_POST['semester_name'];
    $year = $_POST['year'];
    $slot = $_POST['slot'];
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
    $data1 = array();
    $dataName = array();

    if ($slot == 6) {
        for ($i = 0; $i < sizeof($section_by_range); $i++) {
            $total += $section_by_range[$i];
            $six_total += round($section_by_range[$i] / 12, 2);
        }


        for ($i = 0; $i < sizeof($section_by_range); $i++) {
            array_push($data1, (($section_by_range[$i] / 12) / $six_total) * 100);
            array_push($dataName, round($section_by_range[$i] / 12, 2));
        }
    } elseif ($slot == 7) {
        for ($i = 0; $i < sizeof($section_by_range); $i++) {
            $total += $section_by_range[$i];
            $seven_total += round($section_by_range[$i] / 14, 2);
        }


        for ($i = 0; $i < sizeof($section_by_range); $i++) {
            array_push($data1, (($section_by_range[$i] / 14) / $seven_total) * 100);
            array_push($dataName, round($section_by_range[$i] / 14, 2));
        }
    }


    $data = array($data1[0], $data1[1], $data1[2], $data1[3], $data1[4], $data1[5], $data1[6], $data1[7]);
    $labels = array(
        "1-10, " . "$dataName[0]" . "\n(%.1f%%)",
        "11-20, " . "$dataName[1]" . "\n(%.1f%%)",
        "21-30, " . "$dataName[2]" . "\n(%.1f%%)",
        "31-35, " . "$dataName[3]" . "\n(%.1f%%)",
        "36-40, " . "$dataName[4]" . "\n(%.1f%%)",
        "41-50, " . "$dataName[5]" . "\n(%.1f%%)",
        "51-55, " . "$dataName[6]" . "\n(%.1f%%)",
        "56-65, " . "$dataName[7]" . "\n(%.1f%%)",
    );

    // Create the Pie Graph.
    $graph = new PieGraph(800, 800);
    $graph->SetShadow();

    // Set A title for the plot
    if ($slot == 6) {
        $graph->title->Set('6 slot section distribution');
    } else {
        $graph->title->Set('7 slot section distribution');
    }

    $graph->title->SetFont(FF_VERDANA, FS_BOLD, 12);
    $graph->title->SetColor('black');

    // Create pie plot
    $p1 = new PiePlot($data);
    $p1->SetCenter(0.5, 0.5);
    $p1->SetSize(0.3);

    // Setup the labels to be displayed
    $p1->SetLabels($labels);

    // This method adjust the position of the labels. This is given as fractions
    // of the radius of the Pie. A value < 1 will put the center of the label // inside the Pie and a value>= 1 will pout the center of the label outside the
    // Pie. By default the label is positioned at 0.5, in the middle of each slice.
    $p1->SetLabelPos(1);

    // Setup the label formats and what value we want to be shown (The absolute)
    // or the percentage.
    $p1->SetLabelType(PIE_VALUE_PER);
    $p1->value->Show();
    $p1->value->SetFont(FF_ARIAL, FS_NORMAL, 9);
    $p1->value->SetColor('darkgray');

    // Add and stroke
    $graph->Add($p1);
    $graph->Stroke();
}
