<?php 

namespace App\Model;

/**
* @package App\Model
* @author Mohammed JEMMOUDI
*/
class Question {

	public $id;
	public $userId;
	public $sentence;
	public $createdAt;

	public __construct () {
		$this->createdAt = date('Y-m-d H:i:s');
	}

    public function __sleep() {
        return array(
            'id',
            'userId',
            'sentence',
            'createdAt',
        );
    }

}