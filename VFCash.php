<?php
class VFCash{
    protected $link = "https://stormghosts.pythonanywhere.com/page/vfcash";
    protected $user_id;

    public function __construct($user_id){
        $this->user_id = $user_id;
    }

    public function createPaymentLink($callback_link,$extra){
        $link = $this->link . "?id=" . $this->user_id . "&cb=" . urlencode($callback_link);
        if(!empty($extra)){
            $link .= "&extra=" . $extra;
        }
        return $link;
    }

    public function checkPaymentStatus($key){
        $link = $this->link ."?sms_key=" . $key;
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
}

?>
