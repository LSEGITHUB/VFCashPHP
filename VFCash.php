<?php
class VFCash{
    protected $link = "https://cash.darksidehost.com/page/vfcash";
    protected $user_id;

    public function __construct($user_id){
        $this->user_id = $user_id;
    }

    public function createPaymentLink($callback_link,$extra=null){
        $link = $this->link . "?id=" . $this->user_id . "&cb=" . urlencode($callback_link);
        if(!empty($extra)){
            $link .= "&extra=" . $extra;
        }
        return $link;
    }

    public function createPayeerPaymentLink($amount,$callback_link,$extra=null){
        $link = "https://cash.darksidehost.com/page/payeer?id=" . $this->user_id . "&a=". $amount . "&c=" . urlencode($callback_link);
        if(!empty($extra)){
            $link .= "&o=" . $extra;
        }
        return $link;
    }

    public function getPaymentStatus($key){
        $link = "https://stormghosts.pythonanywhere.com/page/vfcash?sms_key=" . $key;
        $curld = curl_init();
        curl_setopt($curld, CURLOPT_POST, true);
        $data = array();
        curl_setopt($curld, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curld, CURLOPT_URL, $link);
        curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curld);
        curl_close($curld);
        return json_decode($output,true);
    }

    public function checkPayment($phone,$amount,$cb,$extra=null){
        $link = $this->createPaymentLink($cb,$extra);
        $curld = curl_init();
        curl_setopt($curld, CURLOPT_POST, true);
        $data = array("phone"=>$phone ,"amount"=>$amount ,"api"=>true ,"to"=>"callback");
        curl_setopt($curld, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curld, CURLOPT_URL, $link);
        curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curld);
        curl_close($curld);
        return json_decode($output,true);
    }

    public function getNumber(){
        $link = "https://cash.darksidehost.com/rates/socpanel?id=" . $this->user_id;
        $curld = curl_init();
        curl_setopt($curld, CURLOPT_URL, $link);
        curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curld);
        curl_close($curld);
        return json_decode($output,true)["number"];
    }
    
    public function redirect($link){
        $link = "https://cash.darksidehost.com/redirect?l=".base64_encode($link);
        return $link;
    }
}

?>
