# VFCashPHP
مكتبة استلام مدفوعات تلقائى من فودافون كاش

قم بوضع ملف VFCash.php بجوار كل ملف تستخدم كود فيه . مهم جدا

* كود عمل رابط صفحة الدفع : 
```php
include("VFCash.php");

$cash = VFCash("هنا معرفك");
$link = $cash->createPaymentLink("هنا رابط العودة","user id");
```
- قم بوضع معرفك فى الكود (احصل عليه من التطبيق) .
- رابط العودة: هو رابط يتم تحويل المستخدم عليه إذا اكتمل الدفع بنجاح . و يستخدم للتأكد من أن عملية الدفع تمت بنجاح .

 كمثال عملى لعمل صفحة رابط العودة :
 
لو افترضنا الآتى ~>
- دومين موقعك : https://example.com

  - هتفتح مدير ملفات استضافتك او عن طريق ftp هتدخل لمجلد public_html . و تنشئ ملف اسمه payment.php .
  - بذلك سنجعل رابط العودة هو :
    https://example.com/payment.php

- عندما يكمل المستخدم الدفع سيتم تحويله إلى هذا الرابط و يتم ارسال مفتاح عن طريق GET يسمى key به معرف العملية تقوم باستخدامه للتحقق من عملية الدفع .

طريقة تحقق من عملية الدفع ، بداخل ملف payment.php :
```php
include("VFCash.php");

$key = $_GET["key"];
$user_id = $_GET["extra"];

$cash = VFCash("هنا معرفك");
$data = $cash->checkPaymentStatus($key);
```
متغير $data هيكون بيه معلومات عملية الدفع كالآتي:
```json
{
"amount":"5.00",
"category":"VF-Cash",
"date":"Thu Nov 30 14:43:41 GMT+02:00 2023",
"id":"004952323000",
"phone":"01234567890",
"taken":true,
"user":"uSQ5ho94PQ4a4GreG"
}
```
شرح المفاتيح :

- amount ~> هو المبلغ اللى وصلك
- category ~> نوع محفظتك
- date ~> تاريخ الوصول
- id ~> رقم العملية
- phone ~> الرقم اللى حولك
- taken ~> بتكون true لو نجح الدفع
- user ~> هنا معرفك (اللى استلم الرسالة)


تقدر تاخد رقم العملية منه و تسجله عندك علشان تكون متأكد ان مفيش حد تانى ينضاف له فلوس .

