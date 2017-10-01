<?php
    require_once "database/dbinfo.php";
    require_once "database/connect.php";

    class Table {
        public $id;
        protected $table_name;
        protected $table_id;
        protected $data;
        protected $column_aliases;
        function __construct($id = null){
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

        public function update_assoc($table){
            foreach($table as $key => $value){
                foreach($this->column_aliases as $alias => $column_name){
                    if($key == $alias || $key == $column_name){
                        $this->update($column_name, $value);
                    }
                }
            }
        }
        public function update($what, $value){
            $sql = "UPDATE $this->table_name SET ? = ? WHERE $this->table_name.$this->table_id = ?";
            $stmt = $connection->prepare($sql);
            
            if(is_string($value)){
                $stmt->bind_param("ssi", $what, $value, $this->id);
            }elseif(is_int($value)){
                $stmt->bind_param("si", $what, $value, $this->id);
            }else{
                $stmt->close(); 
                throw new Exception('Unable to update '.$this->table_name.'  with id = '. $this->id .'due to invalid value = '.$value);                
            }
            
            $flag = $stmt->execute();   
            $stmt->close(); 
            if(!$flag){
                throw new Exception('Unable to update '.$this->table_name.'  with id ='. $this->id);
            }
            $this->$what = $value;
        }
         

    }
?>