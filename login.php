<?php
function generateCode($length=6) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";

    $code = "";

    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {

        $code .= $chars[mt_rand(0,$clen)];
    }

    return $code;

}


mysql_connect("localhost", "root", "");

mysql_select_db("testdb");


if(isset($_POST['but_login']))

{
    $query = mysql_query("SELECT user_id, user_password FROM users WHERE user_login='".mysql_real_escape_string($_POST['login'])."' LIMIT 1");

    $data = mysql_fetch_assoc($query);



    if($data['user_password'] === md5(md5($_POST['password'])))

    {
        $hash = md5(generateCode(10));



        if(!@$_POST['not_attach_ip'])

        {

            $insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";

        }


        mysql_query("UPDATE users SET user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'");

        echo 'log in succsses';


    }

    else

    {

        print "Вы ввели неправильный логин/пароль";

    }

}
?>