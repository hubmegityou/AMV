<?php
    require_once __DIR__."/../database/dbinfo.php";
    require_once __DIR__."/../database/connect.php";
    $connection = db_connection();    
    
    class Table {
        public $id;
        protected $table_name;
        protected $table_id;
        protected $data;
        protected $column_aliases;
        function __construct($id = null){
            global $connection;
            if($id){
                $this->id = $id;
                //$id_var_name = "db_".str_replace("_tab", "_id", $this->table_name); //$id_var_name = 'db_flight_info_id'
                //$this->table_id = ${$id_var_name}; // $this->table_id = content of $db_flight_info_id
                $sql = "SELECT * FROM $this->table_name WHERE $this->table_id = ?";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param("i", $id);
                $flag = $stmt->execute();
                $dataSet = $stmt->get_result();
                $this->data = $dataSet->fetch_array(MYSQLI_ASSOC);   
                $stmt->close();

                if(!$flag){
                    throw new Exception('Unable to get '.$this->table_name.' with id = '. $this->id);
                }
            }else{
                $sql = "INSERT INTO $this->table_name () VALUES ()";
                $stmt = $connection->prepare($sql);
                $flag = $stmt->execute();
                $this->id = $stmt->insert_id;   
                $stmt->close();
                if(!$flag){
                    throw new Exception('Unable to create new '.$this->table_name);
                }
            }
        }
        /*This is so bad, refactor it someday */
        public function update_assoc($table){
            require __DIR__."/../definitions.php";

            foreach($table as $key => $value){
                foreach($name_to_tab_and_column as $keyname => $tab_and_column){
                    if($key == $keyname && $tab_and_column[0] == $this->table_name){ // check if the key is for this class                        
                        foreach($value_to_number as $value_name => $number){ //if so then translate value name to number
                            if($value == $value_name){
                                $this->update($tab_and_column[1], $number); //and update appropriate column
                            }
                        }
                    }
                }
            }
        }
        public function update($what, $value){
           // echo("Updating ".$what."\r\n");
           // echo(" with val = ".$value."\r\n");
            global $connection;
            
            $sql = "UPDATE `".$this->table_name."` SET `$what` = ? WHERE `".$this->table_id."` = ?";
            $stmt = $connection->prepare($sql);
            
            if(is_string($value)){
                $stmt->bind_param("si", $value, $this->id);
            }elseif(is_int($value)){
                $stmt->bind_param("ii", $value, $this->id);
            }else{
                $stmt->close(); 
                throw new Exception('Unable to update '.$this->table_name.'  with id = '. $this->id .' due to invalid value = '.$value);                
            }
            
            $flag = $stmt->execute();   
            $stmt->close(); 
            if(!$flag){
                throw new Exception('Unable to update '.$this->table_name.'  with id = '. $this->id);
            }
            $this->$what = $value;
        }
         

    }
?>