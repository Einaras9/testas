<?php
namespace skaiciuotuvas;
class math {
	
/**
	 * Visi skaičiai, kuriuos norime pridėti
	 *
	 * @var array
	 */
	
	/**
	 * Skaičiai, kuriuos laikome po kablelio
	 *
	 * @var array
	 */
	private $afterPoint = array();
	
	/**
	 * Didžiausias skaičius po kablelio
	 *
	 * @var int
	 */
	private $afterPointLength = 0;
	
	/**
	 * Galutinis rezultatas
	 *
	 * @var string
	 */
	private $result = 0;
	
	private $precision = 10;
	
	/**
	 * Constructor'ius
	 *
	 */
	public function __construct() {
		$this->precision = ini_get("precision")-1;
	}
	
	/**
	 * Prideda skaičiuos, kurie bus susumuoti
	 *
	 * @param string $number
	 */
	public function addNumber ($number) {
		$this->numbers[] = (string)$number;
	}
	
	/**
	 * Prideda du skaičius
	 *
	 * @param string $n1
	 * @param string $n2
	 * @return string
	 */
	private function doAdd ($n1, $n2) {
		
		if ($n1 == 0) return $n2;
		if ($n2 == 0) return $n1;
		
		if (strlen($n1) <= $this->precision && strlen($n2) <= $this->precision) {
			return (string)$n1+$n2;
		}
		
		$finalNumber = array();
		$c = 0;
		
		$n1 = (string)$n1;
		$n2 = (string)$n2;
		
		$m = max(strlen($n1), strlen($n2));
		$n1 = str_pad($n1, $m, " ", STR_PAD_LEFT);
		$n2 = str_pad($n2, $m, " ", STR_PAD_LEFT);
		
		$numbers1 = chunk_split($n1, $this->precision, ";");
		$numbers1 = substr($numbers1, 0, -1);
		$numbers1 = explode(";", $numbers1);
		$numbers1 = array_reverse($numbers1);
		
		$numbers2 = chunk_split($n2, $this->precision, ";");
		$numbers2 = substr($numbers2, 0, -1);
		$numbers2 = explode(";", $numbers2);
		$numbers2 = array_reverse($numbers2);
		
		$maxSize = max(count($numbers1), count($numbers2));
		
		for ($i=0;$i<$maxSize;$i++) {
			
			$totalZeros  = 0;
			$totalZeros1 = 0;
			$totalZeros2 = 0;
			for ($j=0;$j<strlen($numbers1[$i]);$j++) {
				if ($numbers1[$i][$j] == 0) {
					$totalZeros1++;
				} else {
					break;
				}
			}
			
			for ($j=0;$j<strlen($numbers1[$i]);$j++) {
				if ($numbers2[$i][$j] == 0) {
					$totalZeros2++;
				} else {
					break;
				}
			}
			
			$totalZeros = max($totalZeros1, $totalZeros2);
			
			$partialResult = (string)($numbers1[$i] + $numbers2[$i] + $c);
			$partialResult = str_pad($partialResult, strlen($partialResult)+$totalZeros, "0", STR_PAD_LEFT);
			if (strlen($partialResult) > max(strlen($numbers1[$i]),strlen($numbers2[$i]))) {
				$partialResult = (string)$partialResult;
				$c = $partialResult[0];
				$finalNumber[] = substr($partialResult, 1);
			} else {
				$c=0;
				$finalNumber[] = $partialResult;
			}
		}
		$finalNumber = array_reverse($finalNumber);
		$finalNumber = implode("", $finalNumber);
		if ($c != 0) $finalNumber = $c.$finalNumber;
		return $finalNumber;
	}
	
	/**
	 * Skaičiavimai
	 *
	 * @return string
	 */
	public function calc () {
		
		for ($i=0; $i<count($this->numbers);$i++) {
			$n = explode(".", $this->numbers[$i]);
			if (count($n) == 1) {
				$this->result = $this->doAdd($this->result, $this->numbers[$i]);
			} elseif (count($n) == 2) {
				$this->afterPoint[] = $n[1];
				$this->afterPointLength = max($this->afterPointLength, strlen($n[1]));
				$this->result = $this->doAdd($this->result, $n[0]);
			} else {
				trigger_error("<b>".$this->numbers[$i]."</b> is invalid !!", E_USER_ERROR);
			}
		}
		
		if ($this->afterPointLength > 0) {
			$r = 0;
			foreach ($this->afterPoint as $number) {
				$number = str_pad($number, $this->afterPointLength, "0", STR_PAD_RIGHT);
				$r = $this->doAdd($r, $number);
			}
			if (strlen($r) > $this->afterPointLength) {
				$this->result = $this->doAdd($this->result, substr($r, 0, -$this->afterPointLength));
				if (strrpos($r, "0") != strlen($r)-1)
					$this->result = $this->result.".".substr($r, 1);
			} else {
				$this->result = $this->result.".".$r;
			}
		}
		return $this->result;
	}
}



?>