<?php>

public function check_username_exists($username){
    $query = $this->db->get_where('users', array('username' => $username));
    if(empty($query->row_array())){
    return true;
    } else {
    return false;}
    }
    public function check_email_exists($email){
    $query = $this->db->get_where('users', array('email' => $email));
    if(empty($query->row_array())){
    return true;
    } else {
    return false;
}
    }
    


</?php>
