<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $model->title;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 top-dashboard">
        <h2>NEWS</h2>
         View all news and updates on this page
    </div>                    
</div>
			
<div class="bg-view-news">
	<div class="container">		
		<div class="row">
			<div class="group-back">
				<?php echo Html::a('Back', '/news/index', ['class'=>'btn btn-success btn-lg col-xs-12']) ?>				
			</div>			
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 main-con">
				<h3 class="title-newss"><?=$model->title; ?></h3>			
				<span><i class="fa fa-calendar"></i> <?php echo date('d/m/Y', $model->created_at);?></span>
				<p class="content-news"><?=$model->content;?></p>
			</div>
		</div>
	</div>	
</div>