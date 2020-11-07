<?php
    $json = json_encode($_POST);
    echo json_encode($json);
    //$message = "Заявка с формы регистрации\r\nФИО: ".$name."\r\nТелефон: ".$telephone."\r\nПочта: ".$email."\r\nДата рождения: ".$date."\r\nГород: ".$city;
    //mail("andrey@petritsa.ru", "avonbiz.ru Регистрация", $message);
?>