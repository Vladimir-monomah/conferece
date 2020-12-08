<?php
    $stud=$GET['student'];
    $name=$GET['username']
?>

<?php
    $hostname="localhost";
    $username="admin";
    $password="14031999KIR";
    $dbName="registration";
    $usertable="reg";
    Mysql_connect ($hostname,$username,$password) or die ("Не могу подсоединиться");
    Mysql_select_db ($dbName) or die ("Не могу выбрать БД");
    $qure="Insert into $usertable valuses('$name','$phone','$photo')";
    $result=Mysql_query($qure);
    Mysql_close();
    print "Запись введена в БД! <br>";
?>