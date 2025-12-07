# AutoCash

مكتبة `AutoCash` مكتبة لاستلام المدفوعات تلقائيًا في مصر والعراق.

## المتطلبات

- PHP 7.4 أو أحدث
- تفعيل cURL في PHP

## التثبيت

بعد تحميل المكتبة، تأكد من إضافة الملف إلى مشروعك واستيراده بشكل صحيح.

## طريقة الاستخدام

```php
<?php

require_once 'AutoCash.php';

// تهيئة المكتبة مع user_id و panel_id
$user_id = "YOUR_USER_ID";
$panel_id = "YOUR_PANEL_ID";
$autocash = new AutoCash($user_id, $panel_id);

// إنشاء رابط دفع
$payment_link = $autocash->createPaymentLink($extra = "username");
echo "رابط الدفع: " . $payment_link;

// إنشاء رابط دفع ل Payeer
//Payeer توقف عن العمل بداية من 05/01/2026
//$payeer_link = $autocash->createPayeerPaymentLink(100, "https://yourcallback.url");
//echo "رابط دفع Payeer: " . $payeer_link;

// إنشاء رابط دفع ل OKX
$okx_link = $autocash->createOKXPaymentLink(100, $extra = "username");
echo "رابط دفع OKX: " . $okx_link;

// إنشاء رابط دفع ل Binance
$binance_link = $autocash->createBinancePaymentLink(100, $extra = "username");
echo "رابط دفع Binance: " . $binance_link;


// إحضار بيانات العملية 
$key = $_GET["key"]; //معرف العملية
$status = $autocash->getPaymentStatus($key);

// تكون $status من نوع array وتحتوي على بيانات كالمثال التالي:
/*$status = [
    "amount" => "5.00",
    "category" => "VF-Cash",
    "date" => "Thu Nov 30 14:43:41 GMT+02:00 2023",
    "id" => "004952323000",
    "phone" => "01234567890",
    "taken" => true,
    "user" => "uSQ5ho94PQ4a4GreG"
];*/

// التحقق من عملية دفع تلقائيًا
$check = $autocash->checkPayment("01034567890", 100);

// التحقق من عملية دفع تلقائى OKX
$check = $autocash->checkOKXPayment($amount = 100, $txid = "معرف العملية");

// التحقق من عملية دفع تلقائى Binance
$check = $autocash->checkBinancePayment($amount = 100, $txid = "معرف العملية");

// تكون $check من نوع array وتحتوي على بيانات كالمثال التالي:
/*$check = [
    "status" => true,
    "message" => "تم إكمال عملية الدفع بنجاح بمبلغ 60 جنية.",
    "key" => "معرف العملية"
];*/

// الحصول على معلومات لوحة التحكم
$info = $autocash->getInfo();
echo "number: " . $info["number"];
echo "rate: " . $info["rate"];
echo "currency: " . $info["currency"];

// إنشاء رابط إعادة توجيه لإخفاء بيانات رابط الدفع
$redirect_link = $autocash->redirect($payment_link);
echo "رابط إعادة التوجيه: " . $redirect_link;

?>
```

