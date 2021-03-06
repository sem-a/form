<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/scr/Exception.php';
    require 'phpmailer/scr/PHPMailer.php';

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->setLanguage('ru', 'phpmailer/language/');
    $mail->IsHTML(true);

    // От кого письмо
    $mail->setFrom('info@fls.guru', 'Фрилансер по жизни');
    // Кому отправить 
    $mail->addAdress('code@fls.guru');
    // Тема письма
    $mail->Subject = 'Привет! Это "Фрилансер по жизни"';

    // Рука
    $hand = "Правая";
    if ($_POST['hand'] == "left") {
        $hand = "Левая";
    }

    // Тело письма
    $body = '<h1>Встречайте супер письмо!</h1>';

    if (trim(!empty($_POST['name']))) {
        $body.='<p><strong>Имя:</strong>'.$_POST['name'].'</p>';
    }
    if (trim(!empty($_POST['email']))) {
        $body.='<p><strong>E-mail:</strong>'.$_POST['email'].'</p>';
    }
    if (trim(!empty($_POST['hand']))) {
        $body.='<p><strong>Рука:</strong>'.$_POST['hand'].'</p>';
    }
    if (trim(!empty($_POST['age']))) {
        $body.='<p><strong>Возраст:</strong>'.$_POST['age'].'</p>';
    }
    if (trim(!empty($_POST['message']))) {
        $body.='<p><strong>Сообщение:</strong>'.$_POST['message'].'</p>';
    }

    // Прикрепить файл
    if (!empty($_FILES['image']['tmp_name'])) {
        // Путь к загрузке файла
        $filePath = __DIR__ . "/files/" . $FILES['image']['name'];
        // грузим файл
        if (copy($_FILES['image']['tmp_name'], $filePath)) {
            $fileAttach = $filePath;
            $body.='<p><strong>Фото в приложении</strong></p>';
            $mail->addAttachment($fileAttach);
        }
    }

    $mail->Body = $body;

    // Отправляем
    if ($mail->send()) {
        $message = 'Ошибка';
    } else {
        $message = 'Данные отправлены!';
    }
    $response = ['message' => $message];

    header('Content-type: application/json');
    echo json_encode($response);
?>