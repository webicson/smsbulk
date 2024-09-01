/* 
#  Copyright (c) 2022, Inetcaffe Ltd.
#  Original Author: Vladimir Gaitner
#
#  File Description:    
#                    API client to send bulk sms to different mobile providers randomaly to collect data about phone numbers
 */

<?php

class smssetup

   {

   private $host;
   private $user;
   private $password;
   private $db;
   private $mysqli;
   private $url;
   public $ch;





    public function __construct()

      {

       $host = "localhost";
       $user = "sqluser";
       $password = "xxxxxxxxxx";
       $db = "db10";


       $url = 'https://rest.nexmo.com/sms/json';
       $ch = curl_init($url);


       $mysqli = new mysqli($host,$user,$password,$db);
       if ($mysqli -> connect_errno) {
       echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
       exit();
       }

      }

  public function gennumber($prefix)
    
      {
    
      $finalnumber="";
    
      for($i = 0; $i <= 6; $i++)
        {

      $n1 = rand(0,9);
      $finalnumber = "$finalnumber" . "$n1";
  
        }
       
      return intval($prefix . $finalnumber);
      } 


  public function checkexist($phonenumber)
    {
       $mysqli = new mysqli("localhost","sqluser","xxxxxxxxxx","db10");
       if ($mysqli -> connect_errno) {
       echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
       exit();
       }



       $result = $mysqli->query("SELECT * FROM sms1 WHERE to0 = $phonenumber");    

       $row = mysqli_fetch_row($result);
       $id = $row[0];
       return $id;
      
   }

} //class bracket 
  
     $newsmssetup = new smssetup();

      $totel = array();
      $flag = 0;
      while ($flag == 0)
       {
        if (is_null($newsmssetup->checkexist($newsmssetup->gennumber(97150))))
          {
          $totel[] = $newsmssetup->gennumber(97150);
          $flag = 1;
          }
         else break;
       } 
      
      $flag = 0;
      while ($flag == 0)
       {
         if (is_null($newsmssetup->checkexist($newsmssetup->gennumber(97152))))
          {
          $totel[] = $newsmssetup->gennumber(97152);
          $flag = 1;
          }
        else break; 
      }


       $flag = 0;
       while ($flag == 0)
       {  
         if (is_null($newsmssetup->checkexist($newsmssetup->gennumber(97154))))
          {
          $totel[] = $newsmssetup->gennumber(97154);
          $flag = 1;
          }
        else break; 
       }

       $flag = 0;
       while ($flag == 0)
       {  
         if (is_null($newsmssetup->checkexist($newsmssetup->gennumber(97155))))
          {
          $totel[] = $newsmssetup->gennumber(97155);
          $flag = 1;
          }
         else break;
       }

       $flag = 0;
       while ($flag == 0)
       {
         if (is_null($newsmssetup->checkexist($newsmssetup->gennumber(97156))))
          {
          $totel[] = $newsmssetup->gennumber(97156);
          $flag = 1;
          }
         else break;
       }

       $flag = 0;
       while ($flag == 0)
       {
         if (is_null($newsmssetup->checkexist($newsmssetup->gennumber(97158))))
          {
          $totel[] = $newsmssetup->gennumber(97158);
          $flag = 1;
          }
        else break;
       }
       
//$totel[] = intval(971555555555);
$url = 'https://rest.nexmo.com/sms/json';
$ch = curl_init($url); 


$gID = 0;
$v1 = "";

$data = array();
for ($i=0;$i<=6;$i++)
{
$data = array("from"=>"TextFrom", "type"=>"unicode", "text"=>"some text to send according to local spam law in a country", "to"=>"$totel[$i]", "api_key"=>"xxxxxxxxxx", "api_secret"=>"xxxxxxxxxx"); 

foreach ($data as $x => $x_value) {

if ($x == "form")
$v1 = $x_value;
if ($x == "text")
$v2 = $x_value;
}

 $mysqli = new mysqli("localhost","sqluser","xxxxxxxxxx","db10");
       if ($mysqli -> connect_errno) {
       echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
       exit();
       }
$result = $mysqli -> query("INSERT INTO sms1 (from0) VALUES ('$v1')");
$gID = $mysqli -> insert_id;
$result = $mysqli -> query("UPDATE sms1 SET content = '$v2' WHERE id = $gID;");
echo "Returned rows are: " . $result;
  echo "\n";
  echo "insertID: " . $gID;

$payload = json_encode($data);
curl_setopt($ch , CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json; charset=utf-8'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,  CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch,  CURLOPT_TIMEOUT,60);
$result = curl_exec($ch);
print_r($result);
$decodedText = html_entity_decode($result);
$myArray = json_decode($decodedText, true);

foreach($myArray as $x => $x_value) {
if (is_array($x_value))
{
foreach($x_value as $y => $y_value)
{
foreach($y_value as $z => $z_value)
{
echo "Key=" . $z . ", Value=" . $z_value;
   echo "\n";

switch ($z){

  case "message-price":
     $result = $mysqli -> query("UPDATE sms1 SET messageprice = $z_value WHERE id = $gID;");
     break;
   case "remaining-balance":
     $result = $mysqli -> query("UPDATE sms1 SET remainingbalance = $z_value WHERE id = $gID;");
     break;
   case "status":
     $result = $mysqli -> query("UPDATE sms1 SET status = $z_value WHERE id = $gID;");
     break;
   case "message-id":
     //echo $z_value;
     //echo gettype($z_value);
     //$z_value = (string) $z_value;
     $result = $mysqli -> query("UPDATE sms1 SET messageid = '$z_value' WHERE id = $gID;");
     break;
   case "network":
     $result = $mysqli -> query("UPDATE sms1 SET network = $z_value WHERE id = $gID;");
     break;
   case "to":
     $result = $mysqli -> query("UPDATE sms1 SET to0 = '$z_value' WHERE id = $gID;");
     break;
   default:
     echo "variable was not detected";
     }

 echo "Returned rows are: " . $result;
 echo "\n";
 echo "updateID: " . $gID;


}
}
}
else
{
   echo "Key=" . $x . ", Value=" . $x_value;
   echo "\n";
if ($x == "message-count")
{
$result = $mysqli -> query("UPDATE sms1 SET messagecount = '$x_value' WHERE id = $gID");
echo "Returned rows are: " . $result;
  echo "\n";
  echo "insertID: " . $gID;
}
}
}

$result = $mysqli -> query("SELECT content FROM sms1 WHERE id = $gID");
if (!$result) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$row = mysqli_fetch_row($result);
var_dump($row); 

} //curl bracket

?>
