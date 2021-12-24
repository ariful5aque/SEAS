<?php // content="text/plain; charset=utf-8"

include "conn.php";

require_once('C:/xampp/htdocs/jpgraph-4.3.4/jpgraph-4.3.4/src/jpgraph.php');
require_once('C:/xampp/htdocs/jpgraph-4.3.4/jpgraph-4.3.4/src/jpgraph_line.php');
require_once('C:/xampp/htdocs/jpgraph-4.3.4/jpgraph-4.3.4/src/jpgraph_bar.php');

if (isset($_POST['submit'])) {
    $semester_name = $_POST['semester_name'];
    $year = $_POST['year'];
    $range = array("1-10", "11-20", "21-30", "31-35", "36-40", "41-50", "51-55", "56-65");
    $school = array("SBE", "SELS", "SETS", "SLASS", "SPPH");
    $data = [];
    $sbe = [];
    $sels = [];
    $sets = [];
    $slass = [];
    $spph = [];
    for ($i = 0; $i < sizeof($school); $i++) {
        for ($j = 0; $j < 8; $j++) {
            $val = explode("-", $range[$j]);
            $sql =  "SELECT * FROM section WHERE semester = '$semester_name' AND year = '$year'  AND school_id = '$school[$i]' AND enrolled_student
        BETWEEN '$val[0]' AND '$val[1]'";
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);
            array_push($data, $num_rows);
        }
    }
    for ($j = 0; $j < 8; $j++) {
        $val = explode("-", $range[$j]);
        $sql =  "SELECT * FROM section WHERE semester = '$semester_name' AND year = '$year'  
        AND school_id = 'SBE' AND enrolled_student BETWEEN '$val[0]' AND '$val[1]'";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        array_push($sbe, $num_rows);
    }
    for ($j = 0; $j < 8; $j++) {
        $val = explode("-", $range[$j]);
        $sql =  "SELECT * FROM section WHERE semester = '$semester_name' AND year = '$year'  
        AND school_id = 'SELS' AND enrolled_student BETWEEN '$val[0]' AND '$val[1]'";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        array_push($sels, $num_rows);
    }
    for ($j = 0; $j < 8; $j++) {
        $val = explode("-", $range[$j]);
        $sql =  "SELECT * FROM section WHERE semester = '$semester_name' AND year = '$year'  
        AND school_id = 'SETS' AND enrolled_student BETWEEN '$val[0]' AND '$val[1]'";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        array_push($sets, $num_rows);
    }
    for ($j = 0; $j < 8; $j++) {
        $val = explode("-", $range[$j]);
        $sql =  "SELECT * FROM section WHERE semester = '$semester_name' AND year = '$year'  
        AND school_id = 'SLASS' AND enrolled_student BETWEEN '$val[0]' AND '$val[1]'";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        array_push($slass, $num_rows);
    }
    for ($j = 0; $j < 8; $j++) {
        $val = explode("-", $range[$j]);
        $sql =  "SELECT * FROM section WHERE semester = '$semester_name' AND year = '$year'  
        AND school_id = 'SPPH' AND enrolled_student BETWEEN '$val[0]' AND '$val[1]'";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        array_push($spph, $num_rows);
    }
    $total1 = $data[0] + $data[8] + $data[16] + $data[24] + $data[32];
    $total2 = $data[1] + $data[1 + 8] + $data[1 + 16] + $data[1 + 24] + $data[1 + 32];
    $total3 = $data[2] + $data[2 + 8] + $data[2 + 16] + $data[2 + 24] + $data[2 + 32];
    $total4 = $data[3] + $data[3 + 8] + $data[3 + 16] + $data[3 + 24] + $data[3 + 32];
    $total5 = $data[4] + $data[4 + 8] + $data[4 + 16] + $data[4 + 24] + $data[4 + 32];
    $total6 = $data[5] + $data[5 + 8] + $data[5 + 16] + $data[5 + 24] + $data[5 + 32];
    $total7 = $data[6] + $data[6 + 8] + $data[6 + 16] + $data[6 + 24] + $data[6 + 32];
    $total8 = $data[7] + $data[7 + 8] + $data[7 + 16] + $data[7 + 24] + $data[7 + 32];
}



$l1datay = array($total1, $total2, $total3, $total4, $total5, $total6, $total7, $total8);
$l2datay = array($sbe[0], $sbe[1], $sbe[2], $sbe[3], $sbe[4], $sbe[5], $sbe[6], $sbe[7]); //bar
$l3datay = array($sels[0], $sels[1], $sels[2], $sels[3], $sels[4], $sels[5], $sels[6], $sels[7]); //bar
$l4datay = array($sets[0], $sets[1], $sets[2], $sets[3], $sets[4], $sets[5], $sets[6], $sets[7]); //bar
$l5datay = array($slass[0], $slass[1], $slass[2], $slass[3], $slass[4], $slass[5], $slass[6], $slass[7]); //bar
$l6datay = array($spph[0], $spph[1], $spph[2], $sbe[3], $spph[4], $spph[5], $spph[6], $spph[7]); //bar
$datax = array($range[0], $range[1], $range[2], $range[3], $range[4], $range[5], $range[6], $range[7]);

// Create the graph. 
$graph = new Graph(800, 800);
$graph->SetScale('textlin');

$graph->img->SetMargin(60, 130, 20, 40);
$graph->SetShadow();

// Create the linear error plot
$l1plot = new LinePlot($l1datay);
$l1plot->SetColor('red');
$l1plot->SetWeight(2);
$l1plot->SetLegend('Total');

// Create the bar plot
$bplot = new BarPlot($l2datay);
$bplot->SetFillColor('orange');
$bplot->SetLegend('SBE');
$bplot->SetValuePos('center');

$b2plot = new BarPlot($l3datay);
$b2plot->SetFillColor("blue");
$b2plot->SetLegend('SELS');

$b3plot = new BarPlot($l4datay);
$b3plot->SetFillColor("blue");
$b3plot->SetLegend('SETS');

$b4plot = new BarPlot($l5datay);
$b4plot->SetFillColor("blue");
$b4plot->SetLegend('SLASS');

$b5plot = new BarPlot($l6datay);
$b5plot->SetFillColor("blue");
$b5plot->SetLegend('SPPH');

$gbplot = new GroupBarPlot(array($bplot, $b2plot, $b3plot, $b4plot, $b5plot));
// Add the plots to t'he graph
$graph->Add($gbplot);
$graph->Add($l1plot);

$graph->title->Set('Class size distribution ' . $semester_name . ' ' . $year);
$graph->xaxis->title->Set('Range of Enrolled Student ');
$graph->yaxis->title->Set('Sections');
$graph->yaxis->SetTitlemargin(40);
$graph->yaxis->SetLabelMargin(10);

$graph->title->SetFont(FF_FONT1, FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1, FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1, FS_BOLD);
$graph->yaxis->SetTitlemargin(40);
$graph->yaxis->SetLabelMargin(10);

$graph->xaxis->SetTickLabels($datax);
$graph->legend->SetPos(0.1, 0.1, 'right', 'top');
//$graph->xaxis->SetTextTickInterval(2);

// Display the graph
$graph->Stroke();
