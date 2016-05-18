<?php

class funcs
{
    function user_exist($login, $password)
    {
        $hashed_pass = md5($password);
        $connection = new PDO('mysql:host=localhost; port=65535; dbname=diplomDB', 'root', '');
        $result = $connection->query("SELECT id_member FROM memberlist where login='$login' and pass='$hashed_pass'");
        //var_dump ($result->fetchAll());
        $user_inf = $result->fetchAll();
        if (count($user_inf) == 1)
            return $user_inf[0]['id_member'];
        else return false;
    }

    function login($user_id)
    {
        session_start();
        $_SESSION["user_id"] = $user_id;
    }
    function logout()
    {
        session_start();
        unset($_SESSION['user_id']);
        session_destroy();
    }

    function get_user($id_user)
    {
        $connection = new PDO('mysql:host=localhost; port=65535; dbname=diplomDB', 'root', '');
        $result = $connection->query("SELECT * FROM memberlist where id_member='$id_user'")->fetch();
        return $result;
    }

    function get_user_name($id_user)
    {
        $connection = new PDO('mysql:host=localhost; port=65535; dbname=diplomDB', 'root', '');
        $result = $connection->query("SELECT name FROM memberlist where id_member='$id_user'")->fetchColumn();
        return $result;
    }
    /*function file_get_contents_curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }*/
    /*function file_get_contents_curl($url, $lowercase = true, $forceTagsClosed=true, $target_charset = DEFAULT_TARGET_CHARSET, $stripRN=true, $defaultBRText=DEFAULT_BR_TEXT, $defaultSpanText=DEFAULT_SPAN_TEXT) {
        $dom = new simple_html_dom(null, $lowercase, $forceTagsClosed, $target_charset, $stripRN, $defaultBRText, $defaultSpanText);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        $dom->load($data, $lowercase, $stripRN);
        return $dom;
    }*/
}


