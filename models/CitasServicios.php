<?php

namespace Model;

class CitasServicios extends ActiveRecord {
    protected static $tabla = 'citasservicios';
    protected static $columnasDB = ['id', 'citaid','serviciosid'];
    
    public $id;
    public $citaid;
    public $serviciosid;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->citaid = $args['citaid'] ?? '';
        $this->serviciosid = $args['serviciosid'] ?? '';
    }
}