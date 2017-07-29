<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\LuckyWheel */

$this->title = 'Create Lucky Wheel';
$this->params['breadcrumbs'][] = ['label' => 'Lucky Wheels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <div class="page-header">
        <h1>
            Lucky Wheel
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Create Lucky Wheel
            </small>
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
        <?php if(Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger" role="alert">
                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>
        
            <!-- set total gift lucky wheel -->
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">Gift quatity for lucky wheel</h4>
                        <span class="help-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>Số lượng từng loại giải thưởng cho một chương trình</span>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main no-padding">
                            <form id="frmGiftquatity" action="javascript:;">
                                <!-- <legend>Form</legend> -->
                                <table class="table table-striped table-bordered table-hover" id="simple-table">
                                    <thead>
                                        <tr>
                                            <th>Gift</th>
                                            <th>Quatity</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($gift_luckywheel as $key => $value) { ?>
                                        <tr class="giftquatitysetting">
                                            <td>
                                                <?=$value->getGift($value->id_gift)->name;?>
                                            </td>
                                            <td>
                                                <input required type="number" min="0" class="giftquatity" data="<?=$value->id?>" value="<?php if(!empty($value->quatity)){echo $value->quatity;}else{echo '0';}?>">
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                                <div class="form-actions center">
                                    <button data-loading-text="Updating..." class="loading-btn btn btn-success" type="submit">
                                        Update
                                        <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--END / set total gift lucky wheel  -->

            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">Gift on spin wheel</h4>
                        <span class="help-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>Sắp xếp các ô giải thưởng trên vòng quay</span>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main no-padding">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="widget-header" style="margin-top:15px;border:1px solid #ddd">
                                    <h5 class="widget-title">Gift on spin wheel</h5>
                                </div>
                                <div class="dd" id="nestable">
                                    <ol class="dd-list spinwheel">
                                        <?php 
                                        if(!empty($spinwheel)){
                                            foreach ($spinwheel as $key => $gift) { 
                                        ?>
                                            <li class="dd-item" data-id="<?=$gift->id_gift?>">
                                                <div class="dd-handle">
                                                    <?=$gift->getGift($gift->id_gift)->name;?>
                                                </div>
                                                <a class="red removethis btn btn-danger" href="javascript:;">
                                                    <i class="ace-icon fa fa fa-trash bigger-130"></i>
                                                </a>
                                            </li>
                                        <?php } } ?>
                                    </ol>
                                </div>

                                <input id="nestable-output" type="hidden">
                            </div>    

                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="widget-header" style="margin-top:15px;border:1px solid #ddd">
                                    <h5 class="widget-title">Gift for lucky wheel</h5>
                                </div>
                                <div id="listgift">
                                    <ol class="dd-list">
                                        <?php foreach ($gift_luckywheel as $key => $value) { ?>
                                        <li class="dd-item" data-id="<?=$value->id_gift?>">
                                            <div class="dd-handle">
                                                <?=$value->getGift($value->id_gift)->name;?>
                                            </div>
                                            <a class="green addthis btn btn-success" href="javascript:;" data="<?=$value->id_gift?>" title="<?=$value->getGift($value->id_gift)->name;?>">
                                                <i class="ace-icon fa fa fa-plus bigger-130"></i>
                                            </a>
                                        </li>
                                        <?php }?>
                                    </ol>
                                </div>
                            </div>

                            <div class="clear-fix"></div>

                            <div class="form-actions center" style="margin-bottom:0;">
                                <button id="update_spinwheel" data-loading-text="Updating..." class="loading-btn btn btn-success" type="submit">
                                    Update
                                    <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
                                </button>
                            </div>

                            
                        </div>
                    </div>    
                </div>
            </div>


        </div>
    </div>    
</div>   


<?=$this->registerJs("
    $('.loading-btn').on(ace.click_event, function () {
        var btn = $(this);
        btn.button('loading')
        setTimeout(function () {
            btn.button('reset')
        }, 2000)
    });

    var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };

    $('.dd').nestable({maxDepth : 1}).on('change', function() {
        updateOutput($('#nestable').data('output', $('#nestable-output')));
    });
    
    updateOutput($('#nestable').data('output', $('#nestable-output')));

    
")?>

<?=$this->registerJs("
jQuery(function(){
    $('#frmGiftquatity').submit(function(){
        var arr = [];
        var level = $('.giftquatitysetting');
        for(var i = 0; i < level.length; i++){
            var id = $(level[i]).find('.giftquatity').attr('data');
            var quatity = $(level[i]).find('.giftquatity').val();
            arr.push({id : id, quatity : quatity});
        }
        $.ajax({
            type: \"POST\", 
            url:'/luckywheel/updategiftquatity', 
            data: {arr:arr}, 
            success: function (data) {
            }
        });
    })
})
")?>  

<?=$this->registerJs("
    $('#listgift a').click(function(){
        var id = $(this).attr('data');
        var label = $(this).attr('title');
        $('.spinwheel').append('<li data-id=\"'+id+'\" class=\"dd-item\"><div class=\"dd-handle\">'+label+'</div><a class=\"red removethis btn btn-danger\" href=\"javascript:;\">\<i class=\"ace-icon fa fa fa-trash bigger-130\"></i></a></li>');
        updateOutput($('#nestable').data('output', $('#nestable-output')));
    })

    $('#nestable').on('click', '.removethis', function() {
        $(this).parent().remove();
        updateOutput($('#nestable').data('output', $('#nestable-output')));
    })
")?>

<?=$this->registerJs("
    $('#update_spinwheel').click(function(){
        var id = ".$id.";
        var spinwheel = $('#nestable-output').val();
        $.ajax({
            type: 'POST', 
            url:'" . Yii::$app->urlManager->createUrl(["luckywheel/updatespinwheel"]) . "', 
            data: {id : id, spinwheel : spinwheel}, 
            success: function (data) {
            }
        });   
    })
")?>