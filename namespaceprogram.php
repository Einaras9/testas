<?php
include "namespaceclass.php";
include "namespaceclass2.php";
//padarytas pakeitimas
$obj1=new antras\math();
$obj2=new skaiciuotuvas\math();

use antras\math as A;
$math = new A();

use skaiciuotuvas\math as B;
$math = new B();


$fn=10**7;
$obj1=new A($fn);
$obj1-> fibionaci ();
print ($obj1-> get_answer());
print ("<br>");
$obj1-> setdata (500);
$obj1-> fibionaci ();
print ($obj1-> get_answer());
print ("<br>");

// 2class
$calc = new B();
$calc->addNumber("20");
$calc->addNumber("20");
$result = $calc->calc();
print "\nThe result is: ".$result."\n\n\n";
print ("<br>");
?>