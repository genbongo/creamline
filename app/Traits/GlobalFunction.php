<?php

namespace App\Traits;

use App\Notification;
use Illuminate\Support\Carbon;

trait GlobalFunction {

    //##########################################################################
    // ITEXMO SEND SMS API - PHP - CURL-LESS METHOD
    // Visit www.itexmo.com/developers.php for more info about this API
    //##########################################################################
    public function global_itexmo($number,$message,$apicode,$passwd){
        $url = 'https://www.itexmo.com/php_api/api.php';
        $itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
        $param = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($itexmo),
            ),
        );
        $context  = stream_context_create($param);
        return file_get_contents($url, false, $context);
    }


    //create a function that will insert the data to notification table by order, emergency, quotas or no client transaction history w/n 2 months
    public function set_notification($action, $note_description, $id){
        //get the date
        $now = Carbon::now();

        //check if the notification is for emergency text
        if($action == "emergency_text"){
            if(Notification::insert(['note_description' => $note_description, 'order_id' => $id, 'stock_id' => 0, 'user_id' => 0, 'customer_id' => 0, 'created_at' => $now, 'updated_at' => $now])){
                return "Notification has been successfully set.";
            }
        }

        //check if the notification is for approved customer order
        if($action == "approved_customer_order"){
            if(Notification::insert(['note_description' => $note_description, 'order_id' => 0, 'stock_id' => 0, 'user_id' => 0, 'customer_id' => $id, 'created_at' => $now, 'updated_at' => $now])){
                return "Notification has been successfully set.";
            }
        }

        //check if the notification is for setting yearly quotas
        if($action == "set_yearly_quotas"){
            if(Notification::insert(['note_description' => $note_description, 'order_id' => 0, 'stock_id' => 0, 'user_id' => $id, 'customer_id' => 0, 'created_at' => $now, 'updated_at' => $now])){
                return "Notification has been successfully set.";
            }
        }

        
    }
}