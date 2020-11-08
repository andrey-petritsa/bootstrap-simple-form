<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require '../vendor/autoload.php';

    ob_get_contents();
    ob_end_clean();
    
     if(isFormValid()) {
         $files = getFormFiles();
         $message = getMessage();
         sendMail($message, $files);
     }

    
    
    function isFormValid() {
        $allowedfileExtensions = array('jpg', 'png', 'ico', 'bpm', 'jpeg', 'psd', 'xcf');
        if(isset($_FILES['file']['name'])) {
            $total = count($_FILES['file']['name']);
        }
        else {
            echo json_encode(array('error' => "Вы не загрузили файлы или файл слишком большой"));
            return 0;
        }

        for( $i=0 ; $i < $total ; $i++ ) {
            $fileTmpPath = $_FILES['file']['tmp_name'][$i];
            $fileName = $_FILES['file']['name'][$i];
            $fileSize = $_FILES['file']['size'][$i];
            $fileType = $_FILES['file']['type'][$i];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            if (!in_array($fileExtension, $allowedfileExtensions)) {
                echo json_encode(array('error' => "Файлы ".$fileExtension." не поддерживаются"));
                return false;
            }
        }

        return true;
    }

    function getFormFiles() {
        $files = array();
        $total = count($_FILES['file']['name']);
        for( $i=0 ; $i < $total ; $i++ ) {
            $fileTmpPath = $_FILES['file']['tmp_name'][$i];
            $fileName = $_FILES['file']['name'][$i];
            $file_in_server = ['name' => $fileName, "path" => $fileTmpPath];
            array_push($files, $file_in_server);
        }
        return $files;
    }

    function getMessage() {
        $message = "<div style='font-size: 20px'>";
        if (!empty($_POST["theme"])) {
            $message .= "<b>Тема</b>: ". $_POST["theme"] . "<br>";    
        }
        if (!empty($_POST["task"])) {
            $message .= "<b>Задача</b>: ". $_POST["task"] . "<br>";    
        }
        if (!empty($_POST["name"])) {
            $message .= "<b>Имя</b>: ". $_POST["name"] . "<br>";    
        }   
        if (!empty($_POST["mail"])) {
            $message .= "<b>Почта</b>: ". $_POST["mail"] . "<br>";    
        } 
        $message .= "</div>";
        
        return $message;
    }


    function sendMail($html_message, $files) {
        $mail = new PHPMailer(true);
        $mail->setLanguage('ru', '/language/');
        $mail->CharSet  = 'UTF-8';
        try {
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
            $mail->isSMTP();                                            
            $mail->Host       = 'ssl://smtp.mail.ru';                    
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = 'fileform1678@mail.ru';                     
            $mail->Password   = '_7iA(Yki9%5B%3y';                               
            $mail->Port       = 465;                                    

            //Recipients
            $mail->setFrom('fileform1678@mail.ru', "Робот");
            $mail->addAddress('msipostal@gmail.com');     

            foreach($files as $file) {
                $mail->addAttachment($file['path'], $file['name']);
            }

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Заявка с сайта';
            $mail->Body    = $html_message;
            $mail->send();
            
            echo json_encode(array('success' => "Ваша заявка успешно зарегестрирована." ));
        }
        catch (Exception $e) {
            echo json_encode(array('error' => "Проблема с регистрацией заявки. Свяжитесь с администратором." ));
        }   
    }
?>