<?php

namespace App\Traits;
use DB;
use App\Models\Order;
use App\Models\Stock;
// use PHPMailer\PHPMailer\PHPMailer;

trait MAIL
{
    public static function orderCreateEndEmail($mail_body, $customer_email) {
        try {
            require base_path("vendor/autoload.php");

            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = config('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.username');
            $mail->Password = config('mail.password');
            $mail->SMTPSecure = config('mail.encryption');
            $mail->Port = config('mail.port');
            $mail->setFrom('sales@ukshop.my', 'AZURAMART');
            $mail->addAddress($customer_email);
            $mail->isHTML(true);

            $mail_body = view('admin.Mail.order_place')
            ->with('rows', $mail_body)
            ->render();

            $mail->Subject = 'Your Order Has been Placed in AZURAMART';
            $mail->Body    = $mail_body;

            $mail->send();
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        return 1;
    }

    public static function orderDispatchEmail($mail_body, $customer_email) {
        try {
            require base_path("vendor/autoload.php");

            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = config('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.username');
            $mail->Password = config('mail.password');
            $mail->SMTPSecure = config('mail.encryption');
            $mail->Port = config('mail.port');
            $mail->setFrom('sales@ukshop.my', 'AZURAMART');
            $mail->addAddress($customer_email);
            $mail->isHTML(true);

            $mail_body = view('admin.Mail.order_dispatch')
            ->with('rows', $mail_body)
            ->render();

            $mail->Subject = 'Your Order has been dispatched';
            $mail->Body    = $mail_body;

            $mail->send();
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        return 1;
    }

    public static function orderCancelEmail($mail_body, $customer_email) {
        try {
            require base_path("vendor/autoload.php");

            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = config('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.username');
            $mail->Password = config('mail.password');
            $mail->SMTPSecure = config('mail.encryption');
            $mail->Port = config('mail.port');
            $mail->setFrom('sales@ukshop.my', 'AZURAMART');
            $mail->addAddress($customer_email);
            $mail->isHTML(true);

            $mail_body = view('admin.Mail.order_cancel')
            ->with('rows', $mail_body)
            ->render();

            $mail->Subject = 'Your Order has been canceled';
            $mail->Body    = $mail_body;

            $mail->send();
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        return 1;
    }

    public static function orderDefaultEmail($mail_body, $customer_email) {
        try {
            require base_path("vendor/autoload.php");

            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = config('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.username');
            $mail->Password = config('mail.password');
            $mail->SMTPSecure = config('mail.encryption');
            $mail->Port = config('mail.port');
            $mail->setFrom('sales@ukshop.my', 'AZURAMART');
            $mail->addAddress($customer_email);
            $mail->isHTML(true);

            $mail_body = view('admin.Mail.order_default')
            ->with('rows', $mail_body)
            ->render();

            $mail->Subject = 'Your Order has been default';
            $mail->Body    = $mail_body;

            $mail->send();
    } catch (\Exception $e) {
        DB::rollback();
        return $e->getMessage();
    }
    return 1;
    }

    public static function orderReturntEmail($mail_body, $customer_email) {
        try {
            require base_path("vendor/autoload.php");

            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = config('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.username');
            $mail->Password = config('mail.password');
            $mail->SMTPSecure = config('mail.encryption');
            $mail->Port = config('mail.port');
            $mail->setFrom('sales@ukshop.my', 'AZURAMART');
            $mail->addAddress($customer_email);
            $mail->isHTML(true);

            $mail_body = view('admin.Mail.order_return')
            ->with('rows', $mail_body)
            ->render();

            $mail->Subject = 'Your Order has been returned';
            $mail->Body    = $mail_body;

            $mail->send();
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        return 1;
    }

    public static function orderArrivalEmail($mail_body,$send_to) {
        try {
            require base_path("vendor/autoload.php");

            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            $mail->SMTPDebug = 4;
            $mail->isSMTP();
            $mail->Host = config('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.username');
            $mail->Password = config('mail.password');
            $mail->SMTPSecure = config('mail.encryption');
            $mail->Port = config('mail.port');
            $mail->setFrom('sales@azuramart.com', 'AZURAMART');
            $mail->addAddress($send_to);
            $mail->isHTML(true);

            $mail_body = view('admin.Mail.order_arrive')
            ->with('rows', $mail_body)
            ->render();

            $mail->Subject = 'Your Order has been arrived';
            $mail->Body    = $mail_body;

            $mail->send();
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        return 1;
    }

    public static function greetingEmail($cust_info) {
        try {
            require base_path("vendor/autoload.php");
            $customer_email = $cust_info->email;

            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = config('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.username');
            $mail->Password = config('mail.password');
            $mail->SMTPSecure = config('mail.encryption');
            $mail->Port = config('mail.port');
            $mail->setFrom('sales@ukshop.my', 'AZURAMART');
            $mail->addAddress($customer_email);
            $mail->isHTML(true);

            $mail_body = view('admin.Mail.greeting')
            ->with('rows', $mail_body)
            ->render();

            $mail->Subject = 'Greetings from AZURAMART with customer link';
            $mail->Body    = $mail_body;

            $mail->send();
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        return 1;
    }

    private function send_email($email, $sub, $msg)
    {
        $sub    = $sub;
        $msg    = $msg;
        $from   = "syedsifat02@gmail.com";

        $msgBody  = '<html><body>';

        $msgBody .=  "$msg" . '<br><br>';

        $msgBody .= '</html></body>';

        $headers  = "Form: " . strip_tags($from) . "\r\n";
        $headers .= "Reply-To: " . strip_tags($from) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        $isSuccess = mail($email, $sub, $msgBody, $headers);

        return $isSuccess;
    }
}
