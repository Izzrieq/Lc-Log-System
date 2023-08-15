
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';

error_reporting(E_ALL);

if (isset($_POST["send"])) {
    try {
        $mail = new PHPMailer(true);

        // Your SMTP configuration here...
        $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'izzrieqilhan@gmail.com';
    $mail->Password = 'ybrfqfcwwhxyvzbx';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('izzrieqilhan@gmail.com');

    $mail->addAddress($_POST["email"]);

    $mail->isHTML(true);
    $mail->Subject = $_POST["subject"];
    $mail->Body = $_POST["message"];


        $mail->send();

        echo "
        <script>
        alert('Sent Successfully');
        document.location.href = '../../bliss-actioncomplain.php';
        </script>
        ";
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
} else {
    echo "OTW";
}
?>


