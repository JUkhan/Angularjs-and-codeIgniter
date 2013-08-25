<?php

JCrud::$HOST="127.0.0.1";
JCrud::$DBNAME="sampledb";
JCrud::$USER="root";
JCrud::$PASS="";
    class JsonResponse
    {
             public $success;
             public $data;
             public $total;
             public $msg;
    }
    function response($data, $total, $msg, $isSuccess)
     {
         $json=new JsonResponse();
         $json->total=$total;
         $json->data=$data;
         $json->msg=$msg;
         $json->success=$isSuccess;
         echo json_encode($json);
     }
   
     function responseObj($json)
     {
         echo json_encode($json);
     }     

?>
