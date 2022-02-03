<?php




$postdata = array(
    'amount'=>$_POST['amount'], 
    'invoice_number'=> $_POST['invoice_number'], 
    'card_number'=>$_POST['card_number'], 
    'card_exp_month' => $_POST['card_exp_month'], 
    'card_exp_year' => $_POST['card_exp_year'], 
    'card_csv' => $_POST['card_csv'],
    'card_holder_name' => $_POST['card_holder_name']
);



if($postdata['card_number'] == '4012888888881881'){
    $data = array("status"=>"success", "code"=>1 , "data"=> $postdata);
}else{
    $data = array("status"=>"failed", "code"=>0 , "data"=> $postdata);
}

header('Content-Type: application/json');
echo json_encode($data);


?>
