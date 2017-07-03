<?php
/**
 * Created by PhpStorm.
 * User: yusida
 * Date: 3/20/17
 * Time: 10:08 AM
 */

namespace Modules\Villamanager\Http\Controllers\Api;


use Illuminate\Support\Facades\Mail;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Villamanager\Repositories\BookingRepository;

class MidtransController extends BasePublicController
{
    public $booking;
    public function __construct(BookingRepository $bookingRepository)
    {
        $this->booking = $bookingRepository;

        \Veritrans_Config::$serverKey = setting('villamanager::midtrans_server_key');;
        if(!setting('villamanager::midtrans_sandbox')){
            \Veritrans_Config::$isProduction = true;
        }
        \Veritrans_Config::$isSanitized = true;
        \Veritrans_Config::$is3ds = true;
    }

    public function notification()
    {
        $notification = new \Veritrans_Notification();

        $transaction = $notification->transaction_status;
        $type = $notification->payment_type;
        $order_id = $notification->order_id;
        $fraud = $notification->fraud_status;
        $booking = $this->booking->findByBookingNumber($order_id);

        if(!$booking)
            return 'not found';

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card'){
                if($fraud == 'challenge'){
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    $booking->status = 3;
                    $booking->save();
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    //send email
                    $this->sendEmail($booking);
                    echo "Transaction order_id: " . $order_id ." is challenged by FDS";
                }
                else {
                    // TODO set payment status in merchant's database to 'Success'
                    $booking->status = 1;
                    $booking->total_paid = $booking->remaining_payment;
                    $booking->remaining_payment = 0;
                    $booking->log = serialize($notification);
                    $booking->save();
                    $this->sendEmail($booking);
                    echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
                }
            }
        }
        else if ($transaction == 'settlement'){
            // TODO set payment status in merchant's database to 'Settlement'
            $booking->status = 1;
            $booking->total_paid = $booking->remaining_payment;
            $booking->remaining_payment = 0;
            $booking->log = serialize($notification);
            $booking->save();
            $this->sendEmail($booking);
            echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
        }
        else if($transaction == 'pending'){
            // TODO set payment status in merchant's database to 'Pending'
            $booking->status = 0;
            $booking->save();
            $this->sendEmail($booking);
            echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
        }
        else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            $booking->status = 4;
            $booking->save();
            $this->sendEmail($booking);
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
        }
        else if ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            $booking->status = 4;
            $booking->save();
            $this->sendEmail($booking);
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
        }
        else if ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            $booking->status = 5;
            $booking->save();
            $this->sendEmail($booking);
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
        }
    }


    public function sendEmail($booking)
    {
        //mail to user
        Mail::send($booking->emailTemplate(), ['booking' => $booking], function ($m) use ($booking) {

            $m->to($booking->email, $booking->first_name.' '.$booking->last_name)->subject('Booking Notification #'.$booking->booking_number.' :'.$booking->status());
        });

        //mail to villa owner
        Mail::send('emails.status-villa-booking', ['booking' => $booking], function ($m) use ($booking) {

            $m->to(setting('core::email'), setting('core::site-name'))->subject('Booking Notification #'.$booking->booking_number.' :'.$booking->status());
        });
    }

    public function finish()
    {
        $order_id = request('id');
        $status = \Veritrans_Transaction::status($order_id);

        $booking = $this->booking->findByBookingNumber($status->order_id);
        $transaction = $status->transaction_status;
        $type = $status->payment_type;
        $order_id = $status->order_id;
        $fraud = $status->fraud_status;

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card'){
                if($fraud == 'challenge'){
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    $booking->status = 3;
                    $booking->save();
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    //send email
                    $this->sendEmail($booking);
                    $message = "Transaction order_id: " . $order_id ." is challenged by FDS";
                }
                else {
                    // TODO set payment status in merchant's database to 'Success'
                    $booking->status = 1;
                    $booking->total_paid = $booking->remaining_payment;
                    $booking->remaining_payment = 0;
                    $booking->log = $status;
                    $booking->save();
                    $this->sendEmail($booking);
                    $message = "Transaction order_id: " . $order_id ." successfully captured using " . $type;
                }
            }
        }
        else if ($transaction == 'settlement'){
            // TODO set payment status in merchant's database to 'Settlement'
            $booking->status = 1;
            $booking->total_paid = $booking->remaining_payment;
            $booking->remaining_payment = 0;
            $booking->log = $status;
            $booking->save();
            $this->sendEmail($booking);
            $message = "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
        }
        else if($transaction == 'pending'){
            // TODO set payment status in merchant's database to 'Pending'
            $booking->status = 0;
            $booking->save();
            $this->sendEmail($booking);
            $message = "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
        }
        else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            $booking->status = 4;
            $booking->save();
            $this->sendEmail($booking);
            $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
        }
        else if ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            $booking->status = 4;
            $booking->save();
            $this->sendEmail($booking);
            $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
        }
        else if ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            $booking->status = 5;
            $booking->save();
            $this->sendEmail($booking);
            $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
        }

        return redirect()->to('bookings/payment/'.$booking->booking_number)
            ->withMessage($message);
    }



}