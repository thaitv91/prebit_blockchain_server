<?php 
use common\models\User;

$this->title = 'Downline Tree - PreBit';
?>
   <div class="top-dashboard no-margin-bottom-xs">
        <h2 class="title-general"><?=Yii::$app->languages->getLanguage()['downline_tree']?></h2>
    </div>                    
<div class="bor-xs">
    <div class="">
        <div class="title-downline-tree bg-dark-gray">
            <h3>Username</h3>
            <p><?=Yii::$app->languages->getLanguage()['there_are']?> <?=count($count)?> <?=Yii::$app->languages->getLanguage()['members_in_your_network']?></p>
        </div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="bg-down-white">			
					<div class="col-sm-4">
						<div class="easyui-panel" style="padding:5px">
					        <ul class="easyui-tree">
                                <?php 
                                echo '<li><span>'.$user->username.'</span>';
                                $child = $user->findDownlinetree($user->id);

                                if(!empty($child)){
                                    echo '<ul class="f2">';
                                    foreach ($child as $child) {
                                        // F2
                                        echo '<li data-options="state:\'closed\'"><span>'.$child->username.'</span>';
                                        $child2 = $child->findDownlinetree($child->id);

                                        if(!empty($child2)){
                                            echo '<ul>';
                                            foreach ($child2 as $child2) {
                                                // F3
                                                echo '<li data-options="state:\'closed\'"><span>'.$child2->username.'</span>';
                                                $child3 = $child2->findDownlinetree($child2->id);

                                                if(!empty($child3)){
                                                    echo '<ul>';
                                                    foreach ($child3 as $child3) {
                                                        // F4
                                                        echo '<li data-options="state:\'closed\'"><span>'.$child3->username.'</span>';
                                                        $child4 = $child3->findDownlinetree($child3->id);

                                                        if(!empty($child4)){
                                                            echo '<ul>';
                                                            foreach ($child4 as $child4) {
                                                                // F5
                                                                echo '<li data-options="state:\'closed\'"><span>'.$child4->username.'</span>';
                                                                $child5 = $child4->findDownlinetree($child4->id);

                                                                if(!empty($child5)){
                                                                    echo '<ul>';
                                                                    foreach ($child5 as $child5) {
                                                                        // F6
                                                                        echo '<li data-options="state:\'closed\'"><span>'.$child5->username.'</span>';
                                                                        $child6 = $child5->findDownlinetree($child5->id);

                                                                        if(!empty($child6)){
                                                                            echo '<ul>';
                                                                            foreach ($child6 as $child6) {
                                                                                // F7
                                                                                echo '<li data-options="state:\'closed\'"><span>'.$child6->username.'</span>';
                                                                                $child7 = $child6->findDownlinetree($child6->id);
                                                                                if(!empty($child7)){
                                                                                    echo '<ul>';
                                                                                    foreach ($child7 as $child7) {
                                                                                        // F8
                                                                                        echo '<li data-options="state:\'closed\'"><span>'.$child7->username.'</span>';
                                                                                        $child8 = $child7->findDownlinetree($child7->id);
                                                                                        if(!empty($child8)){
                                                                                            echo '<ul>';
                                                                                            foreach ($child8 as $child8) {
                                                                                                // F9
                                                                                                echo '<li data-options="state:\'closed\'"><span>'.$child8->username.'</span>';
                                                                                                $child9 = $child8->findDownlinetree($child8->id);
                                                                                                if(!empty($child9)){
                                                                                                    echo '<ul>';
                                                                                                    foreach ($child9 as $child9) {
                                                                                                        // F10
                                                                                                        echo '<li data-options="state:\'closed\'"><span>'.$child9->username.'</span>';
                                                                                                        $child10 = $child9->findDownlinetree($child9->id);
                                                                                                        if(!empty($child10)){
                                                                                                            echo '<ul>';
                                                                                                            foreach ($child10 as $child10) {
                                                                                                                // F11
                                                                                                                echo '<li data-options="state:\'closed\'"><span>'.$child10->username.'</span>';
                                                                                                                $child11 = $child10->findDownlinetree($child10->id);
                                                                                                                if(!empty($child11)){
                                                                                                                    echo '<ul>';
                                                                                                                    foreach ($child11 as $child11) {
                                                                                                                        // F12
                                                                                                                        echo '<li><span>'.$child11->username.'</span>';
                                                                                                                        $child12 = $child11->findDownlinetree($child11->id);


                                                                                                                    }
                                                                                                                    echo '</ul>';
                                                                                                                }else{
                                                                                                                    echo '</li>';
                                                                                                                }
                                                                                                                // END F11


                                                                                                            }
                                                                                                            echo '</ul>';
                                                                                                        }else{
                                                                                                            echo '</li>';
                                                                                                        }
                                                                                                        // END F10


                                                                                                    }
                                                                                                    echo '</ul>';
                                                                                                }else{
                                                                                                    echo '</li>';
                                                                                                }
                                                                                                // END F9


                                                                                            }
                                                                                            echo '</ul>';
                                                                                        }else{
                                                                                            echo '</li>';
                                                                                        }
                                                                                        // END F8


                                                                                    }
                                                                                    echo '</ul>';
                                                                                }else{
                                                                                    echo '</li>';
                                                                                }
                                                                                // END F7

                                                                            }
                                                                            echo '</ul>';
                                                                        }else{
                                                                            echo '</li>';
                                                                        }
                                                                        // END F6


                                                                    }
                                                                    echo '</ul>';
                                                                }else{
                                                                    echo '</li>';
                                                                }
                                                                // END F5


                                                            }
                                                            echo '</ul>';
                                                        }else{
                                                            echo '</li>';
                                                        }
                                                        // END F4


                                                    }
                                                    echo '</ul>';
                                                }else{
                                                    echo '</li>';
                                                }
                                                // END F3

                                            }
                                            echo '</ul>';
                                        }else{
                                            echo '</li>';
                                        }
                                        // END F2

                                    }
                                    echo '</ul>';
                                }else{
                                    echo '</li>';
                                }
                                ?>
					        </ul>
					    </div><!--tree-->
					</div>
				</div><!--bg-down-white-->
			</div>			
		</div>
	</div>   
</div><!--row-->






