<?php

class AutoCash{
    protected $link = "https://cash.darksidehost.com/";
    protected $user_id;
    protected $panel_id;

    public function __construct($user_id, $panel_id){
        $this->user_id = $user_id;
        $this->panel_id = $panel_id;
    }

    public function createPaymentLink($extra=null){
        $link = $this->link . "page/vfcash?id=" . $this->panel_id;
        if(!empty($extra)){
            $link .= "&extra=" . $extra;
        }
        return $link;
    }

    public function createPayeerPaymentLink($amount,$callback_link,$extra=null){
        $link = $this->link . "page/payeer?id=" . $this->user_id . "&a=". $amount . "&c=" . urlencode($callback_link);
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

    public function checkPayment($phone,$amount,$extra=null){
        $link = $this->createPaymentLink($extra);
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

    public function getInfo(){
        $link = $this->link . "rates/socpanel?id=" . $this->panel_id;
        $curld = curl_init();
        curl_setopt($curld, CURLOPT_URL, $link);
        curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curld);
        curl_close($curld);
        return json_decode($output,true);
    }
    
    public function getNumber(){
        return $this->getInfo()["number"];
    }
    
    public function redirect($link){
        $link = $this->link . "redirect?l=".base64_encode($link);
        return $link;
    }
}

?>
