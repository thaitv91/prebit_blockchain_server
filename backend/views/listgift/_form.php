<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ListGift */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="list-gift-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'options' => ['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'name', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name </label><div class="col-md-6 col-sm-9">{input}{hint}{error}</div>'])->textInput(['placeholder' => 'Name', 'class' => 'form-control', 'type'=>'text'])->label(false) ?>

    <?= $form->field($model, 'color', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Color </label><div class="col-sm-9">{input}{hint}{error}</div>'])->dropDownList($model->colorpicker, ['class' => 'col-xs-10 col-sm-5'])->label(FALSE);?>
    
    <?= $form->field($model, 'thumbnail', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Thumbnail </label><div class="col-md-6 col-sm-9"><div class="upload"><i class="fa fa-upload uploadButton" aria-hidden="true"></i>{input}{hint}<span class="fileName">Select file..</span></div>{error}</div>'])->textInput(['placeholder' => 'Name', 'class' => 'form-control id-input-file', 'type'=>'text'])->label(false) ?>
    <input id="uploadthumbnail" type="file">

    <div class="form-group field-listgift-name required">
        <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> </label>
        <div id="upload_picture" class="col-md-6 col-sm-9">
            <?php if($model->isNewRecord){}else{?>
            <img width="300" src="<?=Yii::$app->params['site_url_front_end'];?>/uploads/luckywheel/<?=$model->thumbnail?>">
            <?php }?>
        </div>
    </div>
    

    <div class="space-4"></div>

    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <?= Html::submitButton($model->isNewRecord ? '<i class="ace-icon fa fa-check bigger-110"></i> Create' : '<i class="ace-icon fa fa-check bigger-110"></i> Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            &nbsp; &nbsp; &nbsp;
            <?php 
            if($model->isNewRecord){
                echo Html::a('<i class="ace-icon fa fa-undo bigger-110"></i>Cancel', '/listgift/index/', ['title' => Yii::t('app', 'Cancel'),'data-pjax' => '0', 'class'=>'btn', 'type'=>'reset']);
            }
            ?>
            
        </div>
    </div>

    <div class="hr hr-24"></div>

    <?php ActiveForm::end(); ?>

</div>


<?=$this->registerJs("
    $('#listgift-color').ace_colorpicker();
")?>

<?=$this->registerJs("
    $('.id-input-file').click(function() {
        $('#uploadthumbnail').click();
    })
")?>

<?=$this->registerJs("
    $('#uploadthumbnail').change(function(e) {
        var file_data = $(this).prop('files')[0];   
        var form_data = new FormData();                 
        form_data.append('file', file_data);                            
        $.ajax({
            url: '/listgift/updategift/',
            //dataType: 'html',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(php_script_response){
                var img = php_script_response;
                $('#listgift-thumbnail').val(php_script_response);
                $('#upload_picture').html('<img id=\"avatar\" style=\"cursor:pointer\" class=\"editable img-responsive\" src=\"".Yii::$app->params['site_url_front_end']."uploads/luckywheel/'+img+'\" />');
                
            }
        });
    });
")?>
