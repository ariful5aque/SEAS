<?php
include 'conn.php';
session_start();

if (isset($_POST['login'])) {
    $id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $password =  mysqli_real_escape_string($conn, $_POST['password']);
    $_SESSION['id'] = $id;

    $sql = "SELECT * FROM user WHERE user_id = $id and password = $password";
    $result = mysqli_query($conn, $sql);
    $num_row = mysqli_num_rows($result);
    $data = mysqli_fetch_array($result);


    if ($num_row > 0 and $data['user_type'] == "core_analysis_team") {
        header('Location: core_dash.php');
    } elseif ($num_row > 0 and $data['user_type'] == "faculty") {
        header('Location: faculty_dash.php');
    } elseif ($num_row > 0 and $data['user_type'] == "dept_head") {
        header('Location: dept_head_dash.php');
    }
}
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
    <link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <title>Login Page</title>
</head>

<body id="body">
    <section>
        <div id="main" class="container">
            <div id="second_part" class="container">
                <h1 style="text-align: center;">INDEPENDENT UNIVERSITY, BANGLADESH</h1>
                <h3 style="text-align: center;">SEAS USER LOGIN</h3>
                <form class="login100-form" action="" method="POST">

                    <div class="wrap-input100 m-t-85 m-b-35" data-validate="Enter username">
                        <input class="input100" name="user_id">
                        <span class="focus-input100" data-placeholder="Username"></span>
                    </div>

                    <div class="wrap-input100 m-b-50" data-validate="Enter password">
                        <input class="input100" type="password" name="password">
                        <span class="focus-input100" data-placeholder="Password"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <input name="login" class="login100-form-btn" type="submit" value="Login">
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

</html>