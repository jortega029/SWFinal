<?php 
    if (isset($_POST['pass'])){
        $pass = crypt(trim($_POST['pass']),'st');
        $email = $_POST['email'];
        $link = mysqli_connect("localhost","id2920920_amaiajokin","","id2920920_quiz");
        $sql = "update usuarios set contrasena = '$pass' where email = '$email'";
        $sql2 = "update usuarios set intentosLogin = '0' where email = '$email'";
        $query = mysqli_query($link,$sql);
        $query2 = mysqli_query($link,$sql2);
        if ($query && $query2){
            echo "si";
        }
        else{
            echo "no";
        }

    }
?>