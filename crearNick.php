<?php
    $nick = $_GET['nick'];
    $link = mysqli_connect("localhost","id2920920_amaiajokin","","id2920920_quiz");
    $sql = "insert into anonimos values('$nick',0,0,0)";
    mysqli_query($link,$sql);
    mysqli_close($link);
?>