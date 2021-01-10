<?php
function generatePassword()
    {
      $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
      $count = mb_strlen($chars);
      $length = 8;

      for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
      }

      return $result;
    }

function smtpmailer($to, $from, $from_name, $subject, $body)
    {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;

        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp-auth.mailprotect.be';
        $mail->Port = 465;
        $mail->Username = 'planner@robiny.be';
        $mail->Password = 'verdicktyzewyn123';

   //   $path = 'reseller.pdf';
   //   $mail->AddAttachment($path);

        $mail->IsHTML(true);
        $mail->From="planner@robiny.be";
        $mail->FromName=$from_name;
        $mail->Sender=$from;
        $mail->AddReplyTo($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($to);
        if(!$mail->Send())
        {
            $error ="Please try Later, Error occured while Processing...";
            return $error;
        }
        else
        {
            $error = "Thanks You !! Your email is sent.";
            return $error;
        }
    }
    $sendmailto = $_SESSION['mail'];
    $to   = $sendmailto;
    $from = 'planner@robiny.be';
    $name = 'planner';
    $subj = 'Schoolplanner - Nieuw wachtwoord';
    $msg = "Hey! <br><br>  Dit is jouw nieuw wachtwoord:". generatePassword() . "<br> <br> Groetjes, <br> Planner <br><br><br><a href='www.google.com'>Klik hier om naar de planner te gaan</a>";

    $error=smtpmailer($to,$from, $name ,$subj, $msg);
    header('Location:index.php');
?>
