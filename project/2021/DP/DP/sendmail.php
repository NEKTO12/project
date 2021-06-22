use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru', 'phpmailer/language/');
$mail->IsHTML(true);

$mail->setForm('info@fls.guru', 'Сайт'); 
$mail->addAddress('rybalkoandre11@gmail.com');
$mail->subject = 'Нужна помощь!';

$body ='<h1> Требуется помощь! </h1>';
if(trim(!empty($_POST['name']))){
    $body.='<p><strong>Имя: </strong>' .$_POST['name'].'</p>';

}
if(trim(!empty($_POST['email']))){
    $body.='<p><strong>E-mail: </strong>' .$_POST['email'].'</p>';

}
if(trim(!empty($_POST['message']))){
    $body.='<p><strong>Сообщение: </strong>' .$_POST['message'].'</p>';
}
if (!empty($_FILES['image']['tmp_name'])){
    $filePath=__DIR__ . "/files/". $_FILES['image']['name'];
    if (copy($_FILES['image']['tmp_name'], $filePath)){
    $fileAttach = $filePath;
    $body.='<p><strong>Фото в приложении</strong>';
    $mail->addAttachment($fileAttach);
    }
}

$mail->Body = $body;

if(!$mail->send())
{
    $massage = 'Ошибка';
}else{
    $massage = 'Данные отправлены!';
}
$response = ['massage'=>$massage];

header('Content-type: application/json');
echo json_encode($response);
?>