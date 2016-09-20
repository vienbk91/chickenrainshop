<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class BooksWritersTable extends Table
{
	public function initialize(array $config)
	{
		$this->belongsTo('Books');
		$this->belongsTo('Writers');
	}
}