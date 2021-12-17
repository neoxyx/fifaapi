<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Player extends CI_Controller {

    /**
     * ark Admin Panel for Codeigniter
     * Author: Jhon Jairo Valdés Aristizabal
     * downloaded from http://devzone.co.in
     *
     */
    public function __construct() {
        parent::__construct();
		$this->load->model("players");
    }

    public function index() {
		$this->load->library('curl');
		$result = $this->curl->simple_get('https://www.easports.com/fifa/ultimate-team/api/fut/item');
		$json_data = json_decode($result);
		$pages = $json_data->totalPages;
		
		for($i=1; $i<=$pages; $i++){
			$resultpages = $this->curl->simple_get('https://www.easports.com/fifa/ultimate-team/api/fut/item?page='.$i);
			$json_data_pages = json_decode($resultpages);
			$page = $json_data_pages->page;
			$totalPages = $json_data_pages->totalPages;
			$players = $json_data_pages->items;
			foreach($players as $player){
				$data = array(
                    'name' => $player->firstName.' '.$player->lastName,
                    'position' => $player->position,
                    'country' => $player->nation->name,
                    'team' => $player->club->name,
					'page' => $page,
					'totalPages'=>$totalPages,
                    'createdAt' => date('Y-m-d'),
                    'updatedAt' => date('Y-m-d')
                );
                $res = $this->players->add_player($data);
                if ($res == TRUE) {
					echo "Insertado jugador ".$player->firstName.' '.$player->lastName." de la pagina: ".$i."\n";
                } else {
                    echo "error";
                } 
			}
		}
    }

}
