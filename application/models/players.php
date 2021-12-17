<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 */
class Players extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function add_player($data)
    {
        $this->db->insert("players", $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
