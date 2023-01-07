
<?php

class controller{

     private $lc = "localhost";
     private $us = "root";
     private $pass = "";
     private $db = "user";

     private $conn ;

     function __construct()
     {
        $this->conn =  mysqli_connect($this->lc,$this->us,$this->pass,$this->db);
     }

    //------------------------------------------------Save Image and Return Path-----------------------
     function get_file_path($file,$path){

        $fname = "";
        $tmp_name = "";
       foreach($file as $key=>$value){
        if($key == "name"){
            $fname= $value;
        }
        else if($key == "tmp_name"){
            $tmp_name= $value;
        }
       }
       $ext = pathinfo($fname, PATHINFO_EXTENSION);
       $ext = strtolower($ext);
       $ext_list = array('jpg','png','jpeg','jfif');

       if(in_array($ext,$ext_list)){
            $r = rand(1000000,100000000);
            $p = $path.$r.$fname;
            move_uploaded_file($tmp_name,$p);
            return $p;
       }
       else{
            return 0;
       }


     }

    //------------------------------------------------Insert in Database-----------------------
    function insert_in_db($arr , $table){

        $query = "INSERT INTO ".$table." VALUES(NULL ";
        foreach($arr as $temp){
            $query .= ", '".$temp."'";
        }
        $query .= " )";
       //return $query;
       $res = mysqli_query($this->conn,$query);
       if($res){
        return 1;
       }
       else{
        return 0;
       }
    }

    //------------------------------------------------Delete in Database Through id-----------------------

    function delete_in_db($table,$id){

        $res = mysqli_query($this->conn,"SHOW COLUMNS FROM $table");
        $id_name = "";
        while($row = mysqli_fetch_assoc($res)){
            if($row["Key"] == "PRI"){
                $id_name = $row["Field"];
            }
        }
        $query = "DELETE FROM ".$table." WHERE ".$id_name."=".$id;
        $res = mysqli_query($this->conn,$query);

        return $res;
    }

     //------------------------------------------------SELECT DATA FROM id-----------------------

    function select_id($table,$id){
        $res = mysqli_query($this->conn,"SHOW COLUMNS FROM $table");
        $id_name = "";
        while($row = mysqli_fetch_assoc($res)){
            if($row["Key"] == "PRI"){
                $id_name = $row["Field"];
            }
        }
        $query = "SELECT * FROM ".$table." WHERE ".$id_name."=".$id;
        $res = mysqli_query($this->conn,$query);
        $row = mysqli_fetch_assoc($res);
        return $row;

    }


    //------------------------------------------------Create Update Form Through id-----------------------
    function update_form($table,$id){

        $res = mysqli_query($this->conn,"SHOW COLUMNS FROM $table");

        $id_name = "";
        while($row = mysqli_fetch_assoc($res)){
            if($row["Key"] == "PRI"){
                $id_name = $row["Field"];
            }
        }

        $res2 = mysqli_query($this->conn,"SELECT * FROM $table WHERE $id_name = $id ");
        $row2= mysqli_fetch_assoc($res2);

        $html = "";
       
        $html .= '<form action="" method="post" enctype="multipart/form-data">
        <div class="modal-body mx-2">';

        while($row = mysqli_fetch_assoc($res)){
            if($row["Key"] == "PRI"){
               echo '<input type="hidden" name="id" value="'.$row["Field"].'">';
            }
            else{
                echo '
      <input type="text" name="'.$row["Field"].'" value="'.$row["Field"].'" placeholder="Theater Name" class="form-control mt-3 w-100" id="">
      ';
            }
        }
       // $res2 = mysqli_query($this->conn,"SELECT * FROM $table");
       
        return $html;
    }

    //------------------------------------------------Create Form from data-----------------------
    function create_form($data){
        $html = "";
        $html .= '<form action="" method="post" enctype="multipart/form-data">
        <div class="modal-body mx-2">';

        foreach($data as $key=>$val){
            if (str_contains($key, 'id')) { 
               $html .= ' <input type="hidden" name="'.$key.'" value="'.$val.'">';
            }
            else{
                $html .= '<input type="text" name="'.$key.'" value="'.$val.'"  class="form-control mt-3 w-100" >';
            }
        }

        $html .= ' </div>
        <div class="modal-footer d-flex justify-content-center">
          <button type="submit" name="sub_up" class="btn btn-primary w-100">Update</button>
        </div>
        </form>';


        return $html;
    }

     //------------------------------------------------Update data from data-----------------------

    function update_data($data , $table){
        $id_col = "";
        $id_val = 0;
        $query = "UPDATE $table SET ";
        $count = count($data);
        $c=0;
        $cc = $count-2;
        foreach($data as $key=>$val){
          
            if($c < $count-1){

                if(str_contains($key, 'id')){
                    $id_col = $key;
                    $id_val = $val;
                }
                else{

                    if($c < $cc){
                        $query .= $key." = '".$val."',";
                    }
                    else{
                        $query .= $key." = '".$val."' ";
                    }

                }
            }
          

            $c++;
        }
         $query .= "WHERE $id_col =  $id_val";

              $res= mysqli_query($this->conn,$query);
              
            return $res;
    }

    function table_data($table , $a){
        $c =1 ;
        $res1 = mysqli_query($this->conn,"SHOW COLUMNS FROM $table");
        $res2 = mysqli_query($this->conn,"SELECT * FROM $table");
        $col_name = array();
        $id_col = "";
        $output = '
       <div class="card shadow mb-4">
                               <div class="card-header py-3">
                                   <h6 class="m-0 font-weight-bold text-primary">Movies</h6>
                                </div>
                              <div class="card-body">
                                     <div class="table-responsive">
                                         <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead><tr>';
               while($row = mysqli_fetch_assoc($res1)){
                    array_push($col_name,$row["Field"]);
                    $output .= '<th>'.$row["Field"].'</th>';
               }

        $output .= '<th>Actions</th>  </tr></thead>               
        <tbody>';

        while($row = mysqli_fetch_assoc($res2)){
            $output .= ' <tr>';
            
            foreach($col_name as $val){
                
                if(str_contains($val, 'id')){
                    $id_col = $val;
                   
                }

                if($a == $c ){
                    $output .= '<td class="tdc"><img src ="'.$row[$val].'" height="200px" "></td>';

                }
                else{
                    $output .= '<td class="tdc">'.$row[$val].'</td>';
                }

               $c++;
            }

            $output .= '<td class="tdc"><a class="btn btn-danger" href="'.basename($_SERVER['PHP_SELF']).'?d_id='.$row[$id_col].'">Delete</a>
            <a class="btn btn-primary mt-3" href="'.basename($_SERVER['PHP_SELF']).'?u_id='.$row[$id_col].'">Update</a>
            
            </td>';

            $output .= ' </tr>';
        }

        $output .= '</tbody>
        </table>
    </div>
</div>
</div>
';
    // $output = '<table class="table table-bordered">
    //                 <thead>
    //                     <tr>';
    //                         <th></th>
    //                     </tr>
    //                 </thead>
    //         </table>';




return $output;


    }



    
function encrypt($token){      
    $cipher_method = 'aes-128-ctr';     
    $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);     
    $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));     
    $crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);     
    unset($token, $cipher_method, $enc_key, $enc_iv);        
    return $crypted_token;    

}

function decrypt($crypted_token){      
    list($crypted_token, $enc_iv) = explode("::", $crypted_token);;     
    $cipher_method = 'aes-128-ctr';     
    $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);     
    $token = openssl_decrypt($crypted_token, $cipher_method, $enc_key, 0, hex2bin($enc_iv));     
    unset($crypted_token, $cipher_method, $enc_key, $enc_iv);      
    return $token;    
}    



}








?>