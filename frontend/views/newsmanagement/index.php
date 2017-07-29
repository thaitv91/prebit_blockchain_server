<?php  
use Yii;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Newsmanagement;
$this->title = 'News - PreBit';
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 top-dashboard">
        <h2>NEWS</h2>
         View all news and updates on this page
    </div>                    
</div>
<div class="row btc-donate-row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="title-btc-recenpost">
            <div class="pull-left">
                <h2>RECENT POSTS</h2>
            </div>
        </div><!--title-btc-recenpost-->
        <div class="content-btc-recenpost">
            <?php foreach ($model as $key => $value): ?>
                <div class="item-recenpost">
                    <div class="pull-left">
                        <h3>
                            <?php echo Html::a($value->title, '/news/view/'.$value->id, ['title' => $value->title,'data-pjax' => '0', 'class'=>'']) ?>
                        </h3>
                    </div>
                    <div class="pull-right date-recenpost">
                        <?php echo date('d/m/Y', $value->created_at);?>
                    </div>
                    <div style="clear: both"></div>
                    <p><?=$value->description;?></p>
                </div><!--item-->
            <?php endforeach ?>                            
        </div><!--content-btc-recenpost-->
    </div><!--col-lg-6-->
</div><!--btc-donate-row-->