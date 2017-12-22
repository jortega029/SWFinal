<?php 
if (isset($_POST['email'])){
    $email = $_POST['email'];
    $link = mysqli_connect("localhost","id2920920_amaiajokin","","id2920920_quiz");
    $sql = "select * from usuarios where email = '$email'";
    $usuarios = mysqli_query($link,$sql);
    $cont = mysqli_num_rows($usuarios);
    if ($cont == 1){
        $num = rand(000000,999999);
        $res = mail($email,"Recuperacion contraseña","Este es tu numero: ".$num);
        if ($res){
            echo $num;
        }
        else{
            echo "NO";
        }
    }
    else{
        echo "NO";
    }
}
?>