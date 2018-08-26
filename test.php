<?php

$objPQ = new SplPriorityQueue(); 

$objPQ->insert('A',3); 
$objPQ->insert('C',1); 
$objPQ->insert('D',3);

echo $objPQ->current()."<BR>"; 