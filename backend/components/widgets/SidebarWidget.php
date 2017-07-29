<?php 
namespace backend\components\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\db\Query;
use yii\widgets\Menu;


class SidebarWidget extends Widget
{
	public function init()
    {
        
    }

	public function run()
    {
    	?>
    	<!-- <div class="sidebar-shortcuts" id="sidebar-shortcuts">
            <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                <button class="btn btn-success">
                    <i class="ace-icon fa fa-signal"></i>
                </button>

                <button class="btn btn-info">
                    <i class="ace-icon fa fa-pencil"></i>
                </button>

                <button class="btn btn-warning">
                    <i class="ace-icon fa fa-users"></i>
                </button>

                <button class="btn btn-danger">
                    <i class="ace-icon fa fa-cogs"></i>
                </button>
            </div>

            <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                <span class="btn btn-success"></span>

                <span class="btn btn-info"></span>

                <span class="btn btn-warning"></span>

                <span class="btn btn-danger"></span>
            </div>
        </div>/.sidebar-shortcuts -->
        	<?php
            echo Menu::widget([
            	'activateItems' => true,
		        'activateParents' => true,
		        'activeCssClass' => 'active',
                'items' => [
                    ['label' => '<i class="menu-icon fa fa-tachometer"></i><span class="menu-text"> Dashboard </span>', 'url' => ['site/index']],
                    ['label' => '<i class="menu-icon fa fa-user"></i><span class="menu-text"> User Management </span>', 'url' => ['/user/index'],], 
                    ['label' => '<i class="menu-icon fa fa-upload"></i><span class="menu-text"> Deposit Management </span>', 'url' => ['/shmanagement/index']], 
                    ['label' => '<i class="menu-icon fa fa-download"></i><span class="menu-text"> GH Management </span>', 'url' => ['/ghmanagement/index']], 
                    ['label' => '<i class="menu-icon fa fa-newspaper-o"></i><span class="menu-text"> News Management </span>', 'url' => ['/newsmanagement/index']], 
                    ['label' => '<i class="menu-icon fa fa-cogs"></i><span class="menu-text"> Fee Management </span><b class="arrow fa fa-angle-down"></b>', 
                        'url' => 'javascript:void(0)', 
                        'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
                        'items' => [
                            ['label' => 'Get Token', 'url' => ['tokenmanagement/gettoken']],
                            ['label' => 'Buy Token', 'url' => ['tokenmanagement/index']],
                            ['label' => 'Token Transfer', 'url' => ['tokenmanagement/transfer']],
                        ]
                    ], 
                    ['label' => '<i class="menu-icon fa fa-cogs"></i><span class="menu-text"> Bitcoin wallet </span><b class="arrow fa fa-angle-down"></b>', 
                        'url' => 'javascript:void(0)', 
                        'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
                        'items' => [
                            ['label' => 'SH/GH wallet', 'url' => ['bitcoinwallet/walletpacket/1']],
                            ['label' => 'Token wallet', 'url' => ['bitcoinwallet/walletpacket/2']],
                            ['label' => 'Charity wallet', 'url' => ['bitcoinwallet/walletpacket/3']],
                            ['label' => 'Luckydraw wallet', 'url' => ['bitcoinwallet/walletpacket/4']],
                            ['label' => 'Penalty wallet', 'url' => ['bitcoinwallet/walletpacket/5']],
                            ['label' => 'Cash withdraw wallet', 'url' => ['bitcoinwallet/walletpacket/6']],
                            ['label' => 'Ticket wallet', 'url' => ['bitcoinwallet/walletpacket/7']],
                        ]
                    ], 
                    ['label' => '<i class="menu-icon fa fa-cogs"></i><span class="menu-text"> Bonus Management </span><b class="arrow fa fa-angle-down"></b>', 
                        'url' => 'javascript:void(0)', 
                        'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
                        'items' => [
                            ['label' => 'Referral Bonus', 'url' => ['bonusmanagement/referralbonus']],
                            ['label' => 'Manager Bonus', 'url' => ['bonusmanagement/managerbonus']],
                        ]
                    ], 
                    ['label' => '<i class="menu-icon fa fa-comments"></i><span class="menu-text"> Message </span><b class="arrow fa fa-angle-down"></b>', 
                    			'url' => 'javascript:void(0)', 
                    			'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
                    			'items' => [
                            		['label' => 'Compose', 'url' => ['message/compose']],
                                    ['label' => 'Notification', 'url' => ['message/notification']],
                            		['label' => 'Inbox', 'url' => ['message/inbox']],
                            		['label' => 'Sent', 'url' => ['message/sent']],
                        		]
                    ],
                    ['label' => '<i class="menu-icon fa fa-newspaper-o"></i><span class="menu-text"> Cash Withdraw</span>', 'url' => ['/cashwithdraw/index']], 
                    ['label' => '<i class="menu-icon fa fa-cogs"></i><span class="menu-text"> Ticket Management </span><b class="arrow fa fa-angle-down"></b>', 
                        'url' => 'javascript:void(0)', 
                        'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
                        'items' => [
                            ['label' => 'Get Ticket', 'url' => ['tickettransfer/getticket']],
                            ['label' => 'Ticket transfer', 'url' => ['tickettransfer/index']],
                        ]
                    ], 
                    ['label' => '<i class="menu-icon fa fa-newspaper-o"></i><span class="menu-text"> Block Management </span>', 'url' => ['/blockmanagement/index']], 
                    ['label' => '<i class="menu-icon fa fa-cogs"></i><span class="menu-text"> Charity </span><b class="arrow fa fa-angle-down"></b>', 
                        'url' => 'javascript:void(0)', 
                        'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
                        'items' => [
                            ['label' => 'Charity program', 'url' => ['charityprogram/index']],
                            ['label' => 'Charity donors', 'url' => ['charitydonors/index']],
                        ]
                    ], 
                    ['label' => '<i class="menu-icon fa fa-cogs"></i><span class="menu-text"> Lucky Draw </span><b class="arrow fa fa-angle-down"></b>', 
                        'url' => 'javascript:void(0)', 
                        'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
                        'items' => [
                            ['label' => 'List Gift', 'url' => ['listgift/index']],
                            ['label' => 'Lucky Wheel', 'url' => ['luckywheel/index']],
                            ['label' => 'List User Won', 'url' => ['giftuser/index']],
                        ]
                    ], 
                    ['label' => '<i class="menu-icon fa fa-newspaper-o"></i><span class="menu-text"> Top 10 </span>', 'url' => ['/top10/index']], 
                    ['label' => '<i class="menu-icon fa fa-newspaper-o"></i><span class="menu-text"> Buy Bitcoin </span>', 'url' => ['/buybtc/index']], 
                    ['label' => '<i class="menu-icon fa fa-cogs"></i><span class="menu-text"> Setting </span><b class="arrow fa fa-angle-down"></b>', 
                        'url' => 'javascript:void(0)', 
                        'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
                        'items' => [
                            ['label' => 'General setting', 'url' => ['setting/general']],
                            ['label' => 'Location setting', 'url' => ['countries/index']],
                            ['label' => 'Level setting', 'url' => ['levelsetting/index']],
                        ]
                    ], 
                    ['label' => '<i class="menu-icon fa fa-newspaper-o"></i><span class="menu-text"> Currency</span>', 'url' => ['/currency/index']],
                    
                ],
                'encodeLabels' => false,
                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
                'options' => array('class' => 'nav nav-list'),

            ]);
            ?>
            <!-- <li class="active">
                <a href="index.html">
                    <i class="menu-icon fa fa-tachometer"></i>
                    <span class="menu-text"> Dashboard </span>
                </a>

                <b class="arrow"></b>
            </li>

            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-desktop"></i>
                    <span class="menu-text">
                        UI &amp; Elements
                    </span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li class="">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-caret-right"></i>

                            Layouts
                            <b class="arrow fa fa-angle-down"></b>
                        </a>

                        <b class="arrow"></b>

                        <ul class="submenu">
                            <li class="">
                                <a href="top-menu.html">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Top Menu
                                </a>

                                <b class="arrow"></b>
                            </li>

                            <li class="">
                                <a href="two-menu-1.html">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Two Menus 1
                                </a>

                                <b class="arrow"></b>
                            </li>

                            <li class="">
                                <a href="two-menu-2.html">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Two Menus 2
                                </a>

                                <b class="arrow"></b>
                            </li>

                            <li class="">
                                <a href="mobile-menu-1.html">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Default Mobile Menu
                                </a>

                                <b class="arrow"></b>
                            </li>

                            <li class="">
                                <a href="mobile-menu-2.html">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Mobile Menu 2
                                </a>

                                <b class="arrow"></b>
                            </li>

                            <li class="">
                                <a href="mobile-menu-3.html">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Mobile Menu 3
                                </a>

                                <b class="arrow"></b>
                            </li>
                        </ul>
                    </li>

                    <li class="">
                        <a href="typography.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Typography
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="elements.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Elements
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="buttons.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Buttons &amp; Icons
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="content-slider.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Content Sliders
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="treeview.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Treeview
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="jquery-ui.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            jQuery UI
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="nestable-list.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Nestable Lists
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-caret-right"></i>

                            Three Level Menu
                            <b class="arrow fa fa-angle-down"></b>
                        </a>

                        <b class="arrow"></b>

                        <ul class="submenu">
                            <li class="">
                                <a href="#">
                                    <i class="menu-icon fa fa-leaf green"></i>
                                    Item #1
                                </a>

                                <b class="arrow"></b>
                            </li>

                            <li class="">
                                <a href="#" class="dropdown-toggle">
                                    <i class="menu-icon fa fa-pencil orange"></i>

                                    4th level
                                    <b class="arrow fa fa-angle-down"></b>
                                </a>

                                <b class="arrow"></b>

                                <ul class="submenu">
                                    <li class="">
                                        <a href="#">
                                            <i class="menu-icon fa fa-plus purple"></i>
                                            Add Product
                                        </a>

                                        <b class="arrow"></b>
                                    </li>

                                    <li class="">
                                        <a href="#">
                                            <i class="menu-icon fa fa-eye pink"></i>
                                            View Products
                                        </a>

                                        <b class="arrow"></b>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-list"></i>
                    <span class="menu-text"> Tables </span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li class="">
                        <a href="tables.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Simple &amp; Dynamic
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="jqgrid.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            jqGrid plugin
                        </a>

                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>

            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-pencil-square-o"></i>
                    <span class="menu-text"> Forms </span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li class="">
                        <a href="form-elements.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Form Elements
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="form-elements-2.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Form Elements 2
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="form-wizard.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Wizard &amp; Validation
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="wysiwyg.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Wysiwyg &amp; Markdown
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="dropzone.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Dropzone File Upload
                        </a>

                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>

            <li class="">
                <a href="widgets.html">
                    <i class="menu-icon fa fa-list-alt"></i>
                    <span class="menu-text"> Widgets </span>
                </a>

                <b class="arrow"></b>
            </li>

            <li class="">
                <a href="calendar.html">
                    <i class="menu-icon fa fa-calendar"></i>

                    <span class="menu-text">
                        Calendar

                        <span class="badge badge-transparent tooltip-error" title="2 Important Events">
                            <i class="ace-icon fa fa-exclamation-triangle red bigger-130"></i>
                        </span>
                    </span>
                </a>

                <b class="arrow"></b>
            </li>

            <li class="">
                <a href="gallery.html">
                    <i class="menu-icon fa fa-picture-o"></i>
                    <span class="menu-text"> Gallery </span>
                </a>

                <b class="arrow"></b>
            </li>

            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-tag"></i>
                    <span class="menu-text"> More Pages </span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li class="">
                        <a href="profile.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            User Profile
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="inbox.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Inbox
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="pricing.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Pricing Tables
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="invoice.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Invoice
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="timeline.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Timeline
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="email.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Email Templates
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="login.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Login &amp; Register
                        </a>

                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>

            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-file-o"></i>

                    <span class="menu-text">
                        Other Pages

                        <span class="badge badge-primary">5</span>
                    </span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li class="">
                        <a href="faq.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            FAQ
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="error-404.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Error 404
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="error-500.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Error 500
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="grid.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Grid
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="blank.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Blank Page
                        </a>

                        <b class="arrow"></b>
                    </li>
                </ul>
            </li> -->

        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
            <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>
    	<?php
    }

}    	