<?php
  abstract class Model
  {
    protected $db;
    protected $instance;
    function connect(){
      $this->instance = DB::getInstance();
      $this->db = $this->instance->getConnection();
    }
  }

 ?>
