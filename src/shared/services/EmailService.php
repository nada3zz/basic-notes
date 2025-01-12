<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use NotesApp\Models\UserModel;
use NotesApp\Utils\Database;

function send_email($receiver_email, $subject, $body) {
    $mail = new PHPMailer(true);
    $config = include_once(__DIR__ . '/../Config/env.php');

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $config['SMTP_USERNAME'];
    $mail->Password = $config['SMTP_PASSWORD'];
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('info@gmail.com', 'Notes App');
    $mail->addAddress($receiver_email);
    $mail->Subject = $subject;
    $mail->Body = $body;

    $mail->send();
}

function send_reminders() {
    
    $database= new Database();
    $db = $database->connect();
    $userModel = new userModel($db);

    $reminders = $userModel->getUsersWithReminder();
    $current_datetime = new DateTime();

    foreach ($reminders as $reminder) {
        $reminder_date = new DateTime($reminder["reminder_date"]);
        if ($reminder_date > $current_datetime) {

            $time_difference = $reminder_date->diff($current_datetime);

            $subject = "Upcoming Reminder";
            $body = "Hello,\n\nThis is a reminder for your note on " . $reminder["reminder_date"] . ".";
            send_email($reminder["email"], $subject, $body);

            echo "Reminder sent to {$reminder['email']} in {$time_difference->format('%d days, %h hours, %i minutes')}\n";
        }
    }
}

if (php_sapi_name() === 'cli') {
    
    $schedule = "0 * * * *"; 
    echo "Scheduled job for: $schedule\n";

    $next_run = strtotime($schedule, time());
    while (true) {
        if (time() >= $next_run) {
            send_reminders();
            $next_run = strtotime($schedule, time());
        }
        sleep(60); 
    }
} else {
    echo "This script is meant to be run from the command line.\n";
}

?>
