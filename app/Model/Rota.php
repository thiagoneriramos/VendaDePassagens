<?php
	class Rota extends AppModel {

		public $name = 'Rota';
		public $virtualFields = array(
			 'trajeto' => 'CONCAT(inicio, " - " , fim, " - " , data_hora)'
			 );

		public $hasOne = array('Veiculo','Promocao');  

		   
	}