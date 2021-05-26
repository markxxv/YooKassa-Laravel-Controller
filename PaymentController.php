<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;

use YooKassa\Client;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;
use YooKassa\Model\NotificationEventType;

class PaymentController extends Controller
{
    public function payCreate(Request $req)
    {

   	$clientId = 'ВАШ id МАГАЗИНА';
   	$clientSecret = 'ВАШ КЛЮЧЬ API';

   	$client = new Client();
    	$client->setAuth($clientId, $clientSecret);

    	$payment = $client->createPayment([
 	    'amount' => [
	         'value' => 102,
	         'currency' => 'RUB',
	    ],
	    'description' => 'Заказ №72', // Прописываем нужное описание
	    'capture' => true,
	    'confirmation' => [
	    'type' => 'redirect',
	        'return_url' => route('pay.callback'), // Задаём страницу на которую пользователь вернётся если нажмёт книпку вернутся в магазин на сайте yooMoney
	    ],
            'metadata' => [
	         'order_id' => 1, // Передаём номер заказа например через $rec->amount
            ],
	], uniqid('', true));

    	return redirect( $payment->getConfirmation()->getConfirmationUrl() );

    }


    public function payCallback(Request $req)
    {
    	if ($req->event == 'payment.succeeded' && $req->object['status'] == 'succeeded') {
    	   if ($req->object['paid'] === true) {
              # Запись ошибок в лог
    	      info( json_encode($req->object) ); 
          
              # Пример обновления статуса заказа в соответствующей модели
    	      // $order = Order::find($req->object['metadata']['order_id']); 
	      //    $order->payment = 'payed';
	      //    $order->payment_system = 'paypal';
	      //    $order->save();
    	   }
    	} else {
            # Запись ошибок в лог
    	    info( json_encode($req->object) ); 
    		
            # Пример записи ответа в модель заказа
            // $order = Order::find($req->object['metadata']['order_id']); 
	    //    $order->payment = 'error';
	    //    $order->payment_message = json_encode($req->object);
	    //    $order->save();
    	}

    }
}
