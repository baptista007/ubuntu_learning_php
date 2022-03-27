<?php

class BaseModel {
    /**
     *
     * @var PDODb 
     */
    protected $db = null;
    
    function __construct() {
        $this->db = new PDODb(DB_TYPE, DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT, DB_CHARSET);
    }
}

