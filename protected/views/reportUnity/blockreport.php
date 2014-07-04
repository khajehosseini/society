<?php 

	$this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'cost-grid',
		'dataProvider'=>$model->search(	),
		'columns'=>array(
				'id',
				'amount'
		),
	));

	
	
	
	

?>