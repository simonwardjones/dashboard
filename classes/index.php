<?php 
class BankAccount{
	public $balance=0;
	public $type='';
	
	public function initType($input){
		$this->type=$input;
	}
	
	function displayBalance(){
		return 'Current Balance: '.$this->balance."<br />";
	}
	
	function withdraw($amount){
		if($this->balance<$amount){
			echo 'Not Enoungh Money In Account!'."<br />";
		}else{
			$this->balance=$this->balance-$amount;
		}
		
	}
	
	function deposit($amount){
		$this->balance = $this->balance + $amount;
	}
}

class SavingsAccount extends BankAccount{
	
}

$rob = new BankAccount;
$rob->deposit(1000);
$rob->withdraw(20);
$rob->initType('current');


$robSavings = new SavingsAccount;
$robSavings->deposit(10);
$robSavings->initType('saver');

//echo $rob->type;
echo $robSavings->type.' has '.$robSavings->displayBalance();

?>