<?php
    define('_H_','127.0.0.1:3306');
    define('_U_','root'); 
    define('_P_',''); 
    define('_D_','cdcol');

/* Object Oriented CRUD Operations */

class Res{
    var $result;   //that var is only used in that class 
    public function _setResult($new_result){
        $this->result=$new_result;
    }
    public function getResult(){
        return $this->result;    
    }   
}

class Dbname{
    var $dbName;    //that var is only used in that class
    public function _setDbName($new_dbName){
        $this->dbname=$new_dbName;
    }
    public function getDbName(){        
        return $this->dbname;    
    }    
}

class NumRes{
    var $numResults;    //that var is only used in that class       
    public function _setNumResults($new_numResults){
        $this->numResults=$new_numResults;
    }        
    public function getNumResults(){
        return $this->numResults;    
    }     
}


class Database{
    //$this here refers to this scope ex $this->disconn
    var $curDbName;
    var $curHandle;
    var $curState;
    
    var $new_conn;
    var $connected;
    
    public function _setConn($new_conn){
        $this->conn=$new_conn;
    }
    public function getConn(){
        return $this->conn;    
    }

    public function _setConnState($connected){  /* 1  or 0 */
        $this->areWeConnected=$connected;
    }
    public function getConnState(){   /* 1  or 0 */
        return $this->areWeConnected;    
    }

    public function connect(){
        //$this here refers to the class Database scope ex: $this->disconnect()
        
        $curDbName=new Dbname;
        $curDbName->_setDbName(_D_);
        echo "Database name is: ".$curDbName->getDbName();
        
        $curHandle = new mysqli(_H_,_U_,_P_,$curDbName->getDbName());  //note the new mysqli vs mysql_connect 
        //$curConn=$this->getConn();
        
        if($curHandle){
            if ($curHandle->connect_errno) {
                echo '<div id="conn_MessageRed" style="color:red;font-weight:bold;">ERROR 001. We are NOT connected. Connect failed.</div>';
                //trigger_error('Database connection failed: '  . $curHandle->connect_error, E_USER_ERROR);
                $this->_setConnState(0);
                $curState=0;
                echo 'After CONNECTION ERROR, $curConn->getConnState() is: '.$this->getConnState().'<br>';
                die();
            }else{
                echo '<div id="conn_MessageGreen" style="color:green;font-weight:bold;">Success: A proper connection to MySQL was made! Host information: '.mysqli_get_host_info($curHandle).'</div>';
                $this->_setConnState(1);
                $curState=1;
                $this->_setConn($curHandle);
            }
            echo 'After connection, $this->getConnState() is: '.$this->getConnState().'<br>';
            echo 'After connection, $curState is: '.$curState.'<br>';
        }
    } 
    
    public function disconnect(){
                echo '<pre>'.'1 - function disconnect starts '.'</pre>';
                //$curConnState = 0;
                echo '<pre>'.'2 - Current connState(should be one): '.$this->getConnState().'</pre>';
                $ccc=$this->getConn();
                if(mysqli_close($ccc)){
                    //We reset everything
                    $this->_setConnState(0);
                    $this->_setConn(NULL);
                    echo '<div id="deconn_MessageGreen" style="color:green;font-weight:bold;">Now we are correctly disconnected</div>';
                } 

    }
    

    public function tableExists($table){
        echo "s3 - db: ".D."~tableExits starts<br>";
        echo "s4 - tableExists starts<br>";
        $tablesInDb = mysqli_query(Database::conHandle,'SHOW TABLES FROM '.D.' LIKE "'.$table.'"');
        if($tablesInDb){
            if(mysqli_num_rows($tablesInDb)==1){
                return true; 
            }else{ 
                return false; 
            }
        }
    }
    
    
    public function select($table, $rows = '*', $where = null, $order = null){
echo "s1 - select Starts<br>";
        //echo 'Table name is: '.$table.', Number of rows:'.$rows.'<br>';
        $q = 'SELECT '.$rows.' FROM '.$table;
        
        if($where != null){
            $q .= ' WHERE '.$where;
        }
        if($order != null){
            $q .= ' ORDER BY '.$order;
        }
echo "s2 - ".$q."<br>";
        if(self::tableExists($table)){ 
            
            $query = mysqli_query(parent::conn,$q);
            if($query){
                $this->numResults = mysqli_num_rows($query);
                for($i = 0; $i < $this->numResults; $i++){
                    $r = mysqli_fetch_array($query);
                    $key = array_keys($r); 
                    for($x = 0; $x < count($key); $x++){
                        // Sanitizes keys so only alphavalues are allowed
                        if(!is_int($key[$x])){
                            if(mysqli_num_rows($query) > 1){
                                $this->result[$i][$key[$x]] = $r[$key[$x]];
                            }else if(mysqli_num_rows($query) < 1){
                                $this->result = null; 
                            }else{
                                $this->result[$key[$x]] = $r[$key[$x]];
                            }
                        }
                    }
                }            
                return true; 
            }else{
                return false; 
            }
        }else{
          return false; 
        }

    }    
    
    public function insert()        {   }
    public function delete()        {   }
    public function update()    {   }


    //public function get_connection(){
        //return connect();
    //}





}    /* End Class Database */


//Database::connect();  //works OK

//include('crud.php');
$db = new Database();
$db->connect();
//$db->select($tableName);
$db->disconnect();
//$res = $db->getResult();
//print_r($res);