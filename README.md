# YooKassa-Laravel-Controller

Это готовый контроллер для Laravel 8 и Yookassa SDK PHP для создания и обработки платежа через YooKassa 

Для работы контроллера вам необходимо:

1. Установить [Yookassa SDK PHP](https://github.com/yoomoney/yookassa-sdk-php)
```
composer require yoomoney/yookassa-sdk-php
```

2. Создать роуты

```
use App\Http\Controllers\PaymentController;

Route::any('/pay', [App\Http\Controllers\PaymentController::class, 'payCreate'])->name('pay.create');
Route::any('/pay/callback', [App\Http\Controllers\PaymentController::class, 'payCallback'])->name('pay.callback');
```
3. Добавить исключение в app/Http/Middleware/VerifyCsrfToken.php
<small>Это нужно для того, что бы yookassa смогла прислать вам каллбек со статусом операции</small>
```
  protected $except = [
        '/pay/callback',
    ];
```    

4. Скачать себе данный контроллер и допилить под собственные нужды
