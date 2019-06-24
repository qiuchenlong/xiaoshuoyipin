<?php
namespace Think;
class CBonus{
    public $bonus;//红包
    public $bonus_num;//红包个数
    public $min=0.01;//单个红包限额
    
    public function __construct($num,$money){
        $this->bonus_num = $num;
        $this->bonus_money = $money;
    }

    public function compute(){
        $this->bonus = array();
        $total = $this->bonus_money;
        $num = $this->bonus_num;
        $i = 1;
        while($i < $this->bonus_num) 
        {
                $safe_total=($total-($num-$i)*$this->min)/($num-$i);//随机安全上限 
                $moneys=mt_rand($this->min*100,$safe_total*100)/100; 
                $total=$total-$moneys;  
                $this->bonus[] = $moneys;
                $i++;
        }
        $this->bonus[] = $total;  

  }





}

?>