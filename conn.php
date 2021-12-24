<?php
$conn = mysqli_connect("localhost", "root", "", "seas");

if (!$conn) {
    echo 'Connection error: ' . mysqli_connect_error();
}
