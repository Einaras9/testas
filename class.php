<?php

interface

class seq 
{
protected $ans1=1, $n1=1, $fn;
function __construct($in){
    $this->fn=$in   ;
}
function setdata($in){
    $this->fn=$in;
}
   function fibionaci ()
   {
        $a=0;
        $b=1;
        $ans=0;
        $n=2;
            while ($ans<$this->fn)
            {
            $n++;
           // print ($ans."<br>");
                $ans=$a+$b;
            
                $a=$b;
                $b=$ans;
            }
            $this->ans1=$b;
            $this->n1=$n;
    }
    function add(){
        $this->ans1= $this->ans1+$this->n1;
        
    }
    function show(){
        print ($this->ans1."<br>");
        print ($this->n1);
    }
    function get_answer(){
        return $this->ans1;
        
    }

    function progresija(){
        for ($x = 0; $x < 10; $x++) {
            $array[$x] = $x * 4;
        }

 }

        
        
    }

    function get_n(){
        return $this->n1;
        
    }



?> 