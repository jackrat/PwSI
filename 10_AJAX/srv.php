<?php

date_default_timezone_set("Europe/Warsaw");
$daneWE = "";
if (isset($_GET["a"]) && isset($_GET["b"]))
   $daneWE = "<br />a: " . $_GET["a"] . "<br />b: " . $_GET["b"];
echo (date("H:i:s"));
echo ($daneWE);
echo ($daneWE);



class ddd
{

   public function check_username_exists($username)
   {
      $query = $this->db->get_where('users', array('username' => $username));
      if (empty($query->row_array())) {
         return true;
      } else {
         return false;
      }
   }
   public function check_email_exists($email)
   {
      $query = $this->db->get_where('users', array('email' => $email));
      if (empty($query->row_array())) {
         return true;
      } else {
         return false;
      }
   }
}
