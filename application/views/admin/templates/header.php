<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width"/>
    <base href="<?php echo base_url(); ?>">
    <title><?php echo $heading . ' - ' . $title; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>images/logo/<?php echo $fevicon; ?>">
    <!-- css files -->
    <link href="css/admin/reset.css" rel="stylesheet" type="text/css" media="screen">
    <!--<link href="css/bootstrap3.3.7.min.css" rel="stylesheet" type="text/css" media="screen">-->
    <link href="css/admin/layout.css" rel="stylesheet" type="text/css" media="screen">
    <link href="css/admin/themes.css" rel="stylesheet" type="text/css" media="screen">
    <link href="css/admin/typography.css" rel="stylesheet" type="text/css" media="screen">
    <link href="css/admin/styles.css" rel="stylesheet" type="text/css" media="screen">
    <!-- <link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'> -->
    <link href='<?php echo base_url(); ?>css/f_family.css' rel='stylesheet' type='text/css'>
    <link href="css/admin/jquery.jqplot.css" rel="stylesheet" type="text/css" media="screen">
    <link href="css/admin/jquery-ui-1.8.18.custom.css" rel="stylesheet" type="text/css" media="screen">
    <link href="css/admin/data-table.css" rel="stylesheet" type="text/css" media="screen">
    <link href="css/admin/form.css" rel="stylesheet" type="text/css" media="screen">

    <link href="css/admin/ui-elements.css" rel="stylesheet" type="text/css" media="screen">
    <link href="css/admin/wizard.css" rel="stylesheet" type="text/css">
    <link href="css/admin/sprite.css" rel="stylesheet" type="text/css" media="screen">
    <link href="css/admin/gradient.css" rel="stylesheet" type="text/css" media="screen">
    <link href="css/admin/developer.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link href='<?php echo base_url(); ?>css/f_aws.css' rel='stylesheet' type='text/css'> -->
    <!-- <link rel="stylesheet" type="text/css" media="all" href="css/site/colorbox.css" /> -->

    <script type="text/javascript">
        var BaseURL = '<?php echo base_url();?>';
        var baseURL = '<?php echo base_url();?>';
    </script>
    <!-- script files -->
    <script src="js/admin/jquery-1.7.1.min.js"></script>
    <script src="js/admin/jquery-ui-1.8.18.custom.min.js"></script>
    <script src="js/admin/jquery.ui.touch-punch.js"></script>
    <script src="js/admin/chosen.jquery.js"></script>
    <script src="js/admin/uniform.jquery.js"></script>
    <script src="js/admin/bootstrap-dropdown.js"></script>
    <script src="js/admin/bootstrap-colorpicker.js"></script>
    <script src="js/admin/sticky.full.js"></script>
    <script src="js/admin/jquery.noty.js"></script>
    <script src="js/admin/selectToUISlider.jQuery.js"></script>
    <script src="js/admin/fg.menu.js"></script>
    <script src="js/admin/jquery.tagsinput.js"></script>

    <script src="js/admin/jquery.cleditor.js"></script>
    <script src="js/admin/jquery.tipsy.js"></script>
    <script src="js/admin/jquery.peity.js"></script>
    <script src="js/admin/jquery.simplemodal.js"></script>
    <script src="js/admin/jquery.jBreadCrumb.1.1.js"></script>
    <script src="js/admin/jquery.colorbox-min.js"></script>
    <script src="js/admin/jquery.idTabs.min.js"></script>
    <script src="js/admin/jquery.multiFieldExtender.min.js"></script>
    <script src="js/admin/jquery.confirm.js"></script>
    <script src="js/admin/elfinder.min.js"></script>
    <script src="js/admin/accordion.jquery.js"></script>
    <script src="js/admin/autogrow.jquery.js"></script>
    <script src="js/admin/check-all.jquery.js"></script>
    <script src="js/admin/data-table.jquery.js"></script>
    <script src="js/admin/ZeroClipboard.js"></script>
    <script src="js/admin/TableTools.min.js"></script>
    <script src="js/admin/jeditable.jquery.js"></script>
    <script src="js/admin/ColVis.min.js"></script>
    <script src="js/admin/duallist.jquery.js"></script>
    <script src="js/admin/easing.jquery.js"></script>
    <script src="js/admin/full-calendar.jquery.js"></script>
    <script src="js/admin/input-limiter.jquery.js"></script>
    <script src="js/admin/inputmask.jquery.js"></script>
    <script src="js/admin/iphone-style-checkbox.jquery.js"></script>
    <script src="js/admin/meta-data.jquery.js"></script>
    <script src="js/admin/quicksand.jquery.js"></script>
    <script src="js/admin/raty.jquery.js"></script>
    <script src="js/admin/smart-wizard.jquery.js"></script>
    <script src="js/admin/stepy.jquery.js"></script>
    <script src="js/admin/treeview.jquery.js"></script>
    <script src="js/admin/ui-accordion.jquery.js"></script>
    <script src="js/admin/vaidation.jquery.js"></script>
    <script src="js/admin/mosaic.1.0.1.min.js"></script>
    <script src="js/admin/jquery.collapse.js"></script>
    <script src="js/admin/jquery.cookie.js"></script>
    <script src="js/admin/jquery.autocomplete.min.js"></script>
    <script src="js/admin/localdata.js"></script>
    <script src="js/admin/excanvas.min.js"></script>
    <script src="js/admin/jquery.jqplot.min.js"></script>
    <script src="js/admin/chart-plugins/jqplot.dateAxisRenderer.min.js"></script>
    <script src="js/admin/chart-plugins/jqplot.cursor.min.js"></script>
    <script src="js/admin/chart-plugins/jqplot.logAxisRenderer.min.js"></script>
    <script src="js/admin/chart-plugins/jqplot.canvasTextRenderer.min.js"></script>
    <script src="js/admin/chart-plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
    <script src="js/admin/chart-plugins/jqplot.highlighter.min.js"></script>
    <script src="js/admin/chart-plugins/jqplot.pieRenderer.min.js"></script>
    <script src="js/admin/chart-plugins/jqplot.categoryAxisRenderer.min.js"></script>
    <script src="js/admin/chart-plugins/jqplot.pointLabels.min.js"></script>
    <script src="js/admin/chart-plugins/jqplot.meterGaugeRenderer.min.js"></script>
    <script src="js/admin/jquery.MultiFile.js"></script>
    <script src="js/admin/custom-scripts.js"></script>
    <script src="js/admin/validation.js"></script>
    <script type="text/javascript" src="js/admin/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
    <script type="text/javascript">
        tinyMCE.init({
            /*General options*/
            mode: "specific_textareas",
            editor_selector: "mceEditor",
            theme: "advanced",
            plugins: "safari,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

            /*Theme options*/ /*save removed*/
            theme_advanced_buttons1: "ewdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
            theme_advanced_buttons4: "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
            theme_advanced_toolbar_location: "top",
            theme_advanced_toolbar_align: "left",
            theme_advanced_statusbar_location: "bottom",
            theme_advanced_resizing: true,
            file_browser_callback: "ajaxfilemanager",
            relative_urls: false,
            convert_urls: false,
            /*Example content CSS (should be your site CSS)*/
            content_css: "css/example.css",

            /*Drop lists for link/image/media/template dialogs*/
            template_external_list_url: "js/template_list.js",
            external_link_list_url: "js/link_list.js",
            external_image_list_url: "js/image_list.js",
            media_external_list_url: "js/media_list.js",

            /*Replace values for the template plugin*/
            template_replace_values: {
                username: "Some User",
                staffid: "991234"
            }
        });

        function ajaxfilemanager(field_name, url, type, win) {
            var ajaxfilemanagerurl = '<?php echo base_url();?>js/tinymce/jscripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php';
            switch (type) {
                case "image":
                    break;
                case "media":
                    break;
                case "flash":
                    break;
                case "file":
                    break;
                default:
                    return false;
            }
            tinyMCE.activeEditor.windowManager.open({
                url: '<?php echo base_url();?>js/tinymce/jscripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php',
                width: 782,
                height: 440,
                inline: "yes",
                close_previous: "no"
            }, {
                window: win,
                input: field_name
            });

            return false;
            var fileBrowserWindow = new Array();
            fileBrowserWindow["file"] = ajaxfilemanagerurl;
            fileBrowserWindow["title"] = "Ajax File Manager";
            fileBrowserWindow["width"] = "782";
            fileBrowserWindow["height"] = "440";
            fileBrowserWindow["close_previous"] = "no";
            tinyMCE.openWindow(fileBrowserWindow, {
                window: win,
                input: field_name,
                resizable: "yes",
                inline: "yes",
                editor_id: tinyMCE.getWindowArg("editor_id")
            });

            return false;
        }
    </script>

    <script type="text/javascript">
        function hideErrDiv(arg)
        {
            document.getElementById(arg).style.display = 'none';
        }
    </script>

    <script>
        $(document).ready(function ()
        {
            $('#cboxClose').click(function ()
            {
                $("#details").hide();
                return false;
            });

            $(".cboxClose").click(function ()
            {
                $("#cboxOverlay,#colorbox,#draggable").hide();
                window.location.href = baseURL + 'admin';
            });

            $("#onLoad").click(function ()
            {
                $('#onLoad').css({
                    "background-color": "#f00",
                    "color": "#fff",
                    "cursor": "inherit"
                }).text("Open this window again and this message will still be here.");
                return false;
            });

        });
    </script>
    <style>
        select.ui-datepicker-month {
            color: #000;
        }
        .header_center {
            width: 300px;
            border: 1px solid #f00;
            float: left;
        }
        .loading {
            position: fixed;
            z-index: 999;
            height: 2em;
            width: 2em;
            overflow: show;
            margin: auto;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }

        /* Transparent Overlay */
        .loading:before {
            content: '';
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(rgba(20, 20, 20,.5), rgba(0, 0, 0, .5));

            background: -webkit-radial-gradient(rgba(20, 20, 20,.5), rgba(0, 0, 0,.5));
        }

        /* :not(:required) hides these rules from IE9 and below */
        .loading:not(:required) {
            /* hide "loading..." text */
            font: 0/0 a;
            color: transparent;
            text-shadow: none;
            background-color: transparent;
            border: 0;
        }

        .loading:not(:required):after {
            content: '';
            display: block;
            font-size: 10px;
            width: 1em;
            height: 1em;
            margin-top: -0.5em;
            -webkit-animation: spinner 1500ms infinite linear;
            -moz-animation: spinner 1500ms infinite linear;
            -ms-animation: spinner 1500ms infinite linear;
            -o-animation: spinner 1500ms infinite linear;
            animation: spinner 1500ms infinite linear;
            border-radius: 0.5em;
            -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
            box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
        }

        /* Animation */

        @-webkit-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @-moz-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @-o-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<?php
$admin_currencyCode = $this->session->userdata('fc_session_admin_currencyCode');

if ($admin_currencyCode == '' && $allPrev == '1')
{
    if (!isset($pg))
    {
        ?>
        <script>
            window.location.href = "<?php echo base_url();?>admin/adminlogin/admin_global_settings_form";
        </script>
        <?php
    }
}
?>

<body id="theme-default" class="full_block">
<div class="loading" style="display: none;"></div>
<div id="actionsBox" class="actionsBox">
    <div id="actionsBoxMenu" class="menu">
        <span id="cntBoxMenu">0</span>
        <a class="button box_action">Archive</a>
        <a class="button box_action">Delete</a>
        <a id="toggleBoxMenu" class="open"></a>
        <a id="closeBoxMenu" class="button t_close">X</a>
    </div>
    <div class="submenu">
        <a class="first box_action">Move...</a>
        <a class="box_action">Mark as read</a>
        <a class="box_action">Mark as unread</a>
        <a class="last box_action">Spam</a>
    </div>
</div>

<?php
$this->load->view('admin/templates/sidebar.php');
?>

<div id="container" class="active">
    <div id="header" class="white_gel">
        <div class="header_left">

            <div id="responsive_mnu">
                <a href="#responsive_menu" class="fg-button" id="hierarchybreadcrumb"><span
                            class="responsive_icon"></span>Menu</a>
                <div id="responsive_menu" class="hidden">
                    <ul id="sidenav" class="accordion_mnu collapsible">

                        <li>
                            <a href="<?php echo base_url(); ?>admin/dashboard/admin_dashboard" <?php if ($currentUrl == 'dashboard') {
                                echo 'class="active"';
                            } ?>> Dashboard</a>
                        </li>

                        <li>
                            <h6 style="margin: 10px 0;padding-left:40px;font-weight:normal;color:#0D68AF;">
                                Managements
                            </h6>
                        </li>

                        <?php extract($privileges);
                        if ($allPrev == '1') { ?>
                            <li><a href="#" <?php if ($currentUrl == 'adminlogin') {
                                    echo 'class="active"';
                                } ?>
                                > Admin<span class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'adminlogin' || $currentUrl == 'sitemapcreate') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>
                                >
                                    <li>
                                        <a href="admin/adminlogin/display_admin_list" <?php if ($currentPage == 'display_admin_list') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Admin Users List</a>
                                    </li>
                                    <li>
                                        <a href="admin/adminlogin/change_admin_password_form" <?php if ($currentPage == 'change_admin_password_form') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Change Password</a></li>
                                    <li>
                                        <a href="admin/adminlogin/admin_global_settings_form" <?php if ($currentPage == 'admin_global_settings_form') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Settings</a></li>
                                    <li>
                                        <a href="admin/adminlogin/admin_smtp_settings" <?php if ($currentPage == 'admin_smtp_settings') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>SMTP Settings</a>
                                    </li>
                                    <li>
                                        <a href="admin/sitemap/create_sitemap" <?php if ($currentPage == 'create_sitemap') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Sitemap Creation
                                        </a>
                                    </li>
                                    <li>								<a href="admin/adminlogin/update_advertisement" <?php if ($currentPage == 'update_advertisement') {									echo 'class="active"';								} ?>><span class="list-icon">&nbsp;</span>Advertisement Update								</a>							</li>
                                </ul>
                            </li>

                            <li>
                                <a href="#" <?php if ($currentUrl == 'subadmin') {
                                    echo 'class="active"';
                                } ?>> Subadmin<span class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'subadmin') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/subadmin/display_subadmin_dashboard" <?php if ($currentPage == 'display_subadmin_dashboard') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/subadmin/display_sub_admin" <?php if ($currentPage == 'display_sub_admin') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Subadmin List
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/subadmin/add_sub_admin_form" <?php if ($currentPage == 'add_sub_admin_form') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Add New Subadmin
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        <?php }
                        if ((isset($Representatives) && is_array($Representatives)) && in_array('0', $Representatives) || $allPrev == '1') { ?>
                            <li>
                                <a href="#" <?php if ($currentUrl == 'Representatives') {
                                    echo 'class="active"';
                                } ?>> Representatives<span class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'Representatives') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/rep/display_rep_dashboard" <?php if ($currentPage == 'display_rep_dashboard') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/users/display_user_list" <?php if ($currentPage == 'display_user_list') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Users Users List
                                        </a>
                                    </li>
                                    <?php if ($allPrev == '1' || in_array('1', $user)) { ?>
                                        <li>
                                            <a href="admin/users/add_user_form" <?php if ($currentPage == 'add_user_form') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Add New User
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li>
                                        <a href="admin/rep/export_rep_details" <?php if ($currentPage == 'export_rep_details') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Export Rep. List
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        <?php }
                        if ((isset($Members) && is_array($Members)) && in_array('0', $Members) || $allPrev == '1') { ?>
                            <li>
                                <a href="admin/users/display_user_dashboard" <?php if ($currentUrl == 'users') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon users"></span>Guest<span class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'users') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/users/display_user_dashboard" <?php if ($currentPage == 'display_user_dashboard') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/users/display_user_list" <?php if ($currentPage == 'display_user_list') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Guest List
                                        </a>
                                    </li>
                                    <?php if ($allPrev == '1' || in_array('1', $Members)) { ?>
                                        <li>
                                            <a href="admin/users/add_user_form" <?php if ($currentPage == 'add_user_form') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Add New Guest
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li>
                                        <a href="admin/users/export_user_details" <?php if ($currentPage == 'export_user_details') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Export Guest List
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php }
                        if ((isset($Host) && is_array($Host)) && in_array('0', $Host) || $allPrev == '1') { ?>
                            <li>
                                <a href="admin/seller/display_seller_dashboard" <?php if ($currentUrl == 'seller') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon users_2"></span>Host<span class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'seller') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/seller/display_seller_dashboard" <?php if ($currentPage == 'display_seller_dashboard') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/seller/display_seller_list" <?php if ($currentPage == 'display_seller_list') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Host List
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/seller/display_archieve_seller" <?php if ($currentPage == 'display_archieve_seller') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Host Archive List
                                        </a>
                                    </li>
                                    <?php if ($allPrev == '1' || in_array('1', $Host)) { ?>
                                        <li>
                                            <a href="admin/seller/add_seller_form" <?php if ($currentPage == 'add_seller_form') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Add New Host
                                            </a>
                                        </li>
                                        <li>
                                            <a href="admin/seller/customerExcelExport" <?php if ($currentPage == 'customerExcelExport') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Export Host List
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>

                        <?php } ?>

                        <?php if ((isset($RentalTypes) && is_array($RentalTypes)) && in_array('0', $RentalTypes) || $allPrev == '1') { ?>
                            <li>
                                <a href="admin/listattribute/display_attribute_listspace" <?php if ($currentUrl == 'listattribute') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon folder"></span>Rental Types&nbsp;<i class="fa fa-info-circle fa-lg tipRight" original-title="Manage Property Types"></i><span
                                            class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'listattribute') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/listattribute/display_attribute_listspace" <?php if ($currentPage == 'display_attribute_listspace') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Rental Type
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/listattribute/display_listspace_values" <?php if ($currentPage == 'display_listspace_values') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Rental Type Values
                                        </a>
                                    </li>
                                    <?php if ($allPrev == '1' || in_array('1', $ListSpace)) { ?>
                                        <li style="display:none">
                                            <a href="admin/listattribute/add_attribute_listform" <?php if ($currentPage == 'add_attribute_listform') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Add New Rental Type</a>
                                        </li>
                                        <li>
                                            <a href="admin/listattribute/add_listspace_value_form" <?php if ($currentPage == 'add_listspace_value_form') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Add Rental Type Values
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>



                        <?php if ((isset($Amenities) && is_array($Amenities)) && in_array('0', $Amenities) || $allPrev == '1') { ?>
                            <li>
                                <a href="admin/attribute/display_attribute_list" <?php if ($currentUrl == 'attribute') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon cog_3"></span> Amenities &nbsp;<i class="fa fa-info-circle fa-lg tipRight" original-title="Facilities of property like car parking, smoke detector etc.."></i><span class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'attribute') {
                                    echo 'style="display: block;"';

                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/attribute/display_attribute_list" <?php if ($currentPage == 'display_attribute_list') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Amenities
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/attribute/display_list_values" <?php if ($currentPage == 'display_list_values') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Amenities Values
                                        </a>
                                    </li>
                                    <?php if ($allPrev == '1' || in_array('1', $List)) { ?>
                                        <li>
                                            <a href="admin/attribute/add_attribute_form" <?php if ($currentPage == 'add_attribute_form') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Add New Amenities
                                            </a>
                                        </li>
                                        <li>
                                            <a href="admin/attribute/add_list_value_form" <?php if ($currentPage == 'add_list_value_form') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Add Amenities Value
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>

                        <?php } ?>

                        <?php if ((isset($Features) && is_array($Features)) && in_array('0', $Features) || $allPrev == '1') { ?>
                            <li>
                                <a href="admin/listings/display_attribute_list" <?php if ($currentUrl == 'listings') {
                                    echo 'class="active"';
                                } ?>>
                                    <span class="nav_icon folder"></span>Features&nbsp;<i class="fa fa-info-circle fa-lg tipRight" original-title="Manage Property Attributes"></i>
                                    <span class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'listings') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>


                                    <li>
                                        <a href="admin/listings/attribute_values" <?php if ($currentPage == 'attribute_values') {
                                            echo 'class="active"';
                                        } ?>>
                                            <span class="list-icon">&nbsp;</span>Features Types
                                        </a>
                                    </li>
                                    <?php if ($allPrev == '1' || in_array('1', $Listing)) { ?>
                                        <li>
                                            <a href="admin/listings/add_new_attribute" <?php if ($currentPage == 'add_new_attribute') {
                                                echo 'class="active"';
                                            } ?>>
                                                <span class="list-icon">&nbsp;</span>Add New Features
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>


                        <?php if ((isset($Rentals) && is_array($Rentals)) && in_array('0', $Rentals) || $allPrev == '1') { ?>
                            <li>
                                <a href="admin/product/display_rental_dashboard" <?php if ($currentUrl == 'product' || $currentUrl == 'comments') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon folder"></span> Rentals&nbsp;<i class="fa fa-info-circle fa-lg tipRight" original-title="Manage Properties"></i><span class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'product' || $currentUrl == 'comments') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/product/display_rental_dashboard" <?php if ($currentPage == 'display_rental_dashboard') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/product/display_product_list" <?php if ($currentPage == 'display_product_list') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Rental List
                                        </a>
                                    </li>
                                    <?php if ($allPrev == '1' || in_array('1', $Properties)) { ?>
                                        <li>
                                            <a href="admin/product/add_product_form" <?php if ($currentPage == 'add_product_form') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Add New Rental
                                            </a>
                                        </li>
                                        <li>
                                            <a href="admin/product/customerExcelExport" <?php if ($currentPage == 'display_user_product_list') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Export Rental List
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php }
                        if ((isset($RentalTransaction) && is_array($RentalTransaction)) && in_array('0', $RentalTransaction) || $allPrev == '1') { ?>
                            <li>
                                <a href="admin/order/display_order_paid" <?php if ($currentUrl == 'bookingpayment' || $currentUrl == 'order' || $this->uri->segment(1, 0) == 'order-review') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon coverflow"></span> Rental Transaction&nbsp;<i class="fa fa-info-circle fa-lg tipRight" original-title="Property Transaction"></i><span class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'bookingpayment' || $currentUrl == 'order' || $this->uri->segment(1, 0) == 'order-review') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/order/display_order_paid" <?php if ($currentPage == 'display_order_paid') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Successful Payment
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/order/display_order_pending" <?php if ($currentPage == 'display_order_pending') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Failed Payment
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/order/display_listing_order" <?php if ($currentPage == 'display_listing_order') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Rental Listing Payment<i class="fa fa-info-circle fa-lg tipRight" original-title="Manage guest listed property"></i>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="admin/bookingpayment/display_receivable" <?php if ($currentPage == 'display_receivable') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Receivable & Payable
                                        </a>
                                    </li>

                                    <li>
                                        <a href="admin/order/customerExcelExport/Paid" <?php if ($currentPage == 'customerExcelExport') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Export Successful Payment
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/order/customerExcelExport/Pending" <?php if ($currentPage == 'customerExcelExport') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Export Failed Payment
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/order/customerExcelExportlist" <?php if ($currentPage == 'customerExcelExport') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Export Rental Listing

                                        </a>
                                    </li>

                                    <li>
                                        <a href="admin/bookingpayment/customerExcelExportReceivable" <?php if ($currentPage == 'customerExcelExportReceivable') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Exp Receivable & Payable
                                        </a>
                                    </li>



                                </ul>
                            </li>
                        <?php } ?>




                        <?php if ((isset($RentalBookingStatus) && is_array($RentalBookingStatus)) && in_array('0', $RentalBookingStatus) || $allPrev == '1') { ?>
                            <li>
                                <a href="admin/attribute/display_attribute_list" <?php if ($currentUrl == 'account') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon cog_3"></span> Rental Booking Status&nbsp;<i class="fa fa-info-circle fa-lg tipRight" original-title="Manage property booking and listing"></i><span class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'account') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>

                                    <li>
                                        <a href="admin/account/display_newbooking" <?php if ($currentPage == 'display_newbooking') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>New Booking
                                        </a>
                                    </li>
                                    <?php if ($allPrev == '1' || in_array('1', $BookingStatus)) { ?>
                                        <li>
                                            <a href="admin/account/display_book_confirmed" <?php if ($currentPage == 'display_book_confirmed') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Completed Booking
                                            </a>
                                        </li>
                                        <li>
                                            <a href="admin/account/display_book_expired" <?php if ($currentPage == 'display_book_expired') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Expired Booking
                                            </a>
                                        </li>
                                        <li>
                                            <a href="admin/account/customerExcelExportNewBooking/enquiry" <?php if ($currentPage == 'customerExcelExportNewBooking') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Export New Booking</a>
                                        </li>
                                        <li>
                                            <a href="admin/account/customerExcelExportNewBooking/booked" <?php if ($currentPage == 'customerExcelExportNewBooking') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Exp Completed Booking
                                            </a>
                                        </li>
                                        <li>
                                            <a href="admin/account/customerExcelExportExpired" <?php if ($currentPage == 'customerExcelExportExpired') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Exp Expired Booking</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php }
                        if ((isset($Experience) && is_array($Experience)) && in_array('0', $Experience) || $allPrev == '1') {
                            ?>
                            <li>
                                <a href=""<?php if ($currentUrl == 'experience') {
                                    echo 'class="active"';
                                } ?> ><span class="nav_icon book"></span> Experience <span
                                            class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'experience') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?> >

                                    <li>
                                        <a href="<?php echo 'admin/experience/experienceTypeList'; ?>" <?php if ($currentPage == 'experieceTypeList') {
                                            echo 'class="active"';
                                        } ?>> Experience Type List
                                        </a>
                                    </li>
                                    <?php if ($allPrev == '1' || in_array('1', $Experience)) { ?>
                                        <li>
                                            <a href="<?php echo 'admin/experience/addExperienceType_from'; ?>" <?php if ($currentPage == 'addExperienceType_from') {
                                                echo 'class="active"';
                                            } ?>> Add Experience Type
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li>
                                        <a href="<?php echo 'admin/experience/experienceList'; ?>" <?php if ($currentPage == 'experienceList') {
                                            echo 'class="active"';
                                        } ?>> Experience List
                                        </a>
                                    </li>
                                    <?php if ($allPrev == '1' || in_array('1', $Experience)) { ?>
                                        <li>
                                            <a href="<?php echo 'admin/experience/add_experience_form_new'; ?>" <?php if ($currentPage == 'addExperiece') {
                                                echo 'class="active"';
                                            } ?>> Add Experience
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php
                        }



                        if ((isset($ExperienceTransaction) && is_array($ExperienceTransaction)) && in_array('0', $ExperienceTransaction) || $allPrev == '1') { ?>
                            <li>
                                <a href="admin/experience_order/display_order_paid" <?php if ($currentUrl == 'experience_order' || $this->uri->segment(1, 0) == 'experience_order-review') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon coverflow"></span> Experience Transaction<span class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl =='experience_bookingpayment' || $currentUrl == 'experience_order' || $this->uri->segment(1, 0) == 'experience_order-review') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/experience_order/display_order_paid" <?php if ($currentPage == 'display_order_paid') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Successful Payment
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/experience_order/display_order_pending" <?php if ($currentPage == 'display_order_pending') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Failed Payment
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/experience_order/display_listing_order" <?php if ($currentPage == 'display_listing_order') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Experience Listing Payment
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/experience_bookingpayment/display_receivable" <?php if ($currentPage == 'display_receivable') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Receivable & Payable
                                        </a>
                                    </li>

                                    <li>
                                        <a href="admin/experience_order/customerExcelExport/Paid" <?php if ($currentPage == 'customerExcelExport') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Export Successful Payment
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/experience_order/customerExcelExport/Pending" <?php if ($currentPage == 'customerExcelExport') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Export Failed Payment
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/experience_order/customerExcelExportlist" <?php if ($currentPage == 'customerExcelExportlist') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Export Experience Listing
                                        </a>
                                    </li>

                                    <li>
                                        <a href="admin/experience_bookingpayment/customerExcelExportReceivable" <?php if ($currentPage == 'customerExcelExportReceivable') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Exp Receivable & Payable
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        <?php } ?>


                        <?php
                        if ((isset($ExperienceBookingStatus) && is_array($ExperienceBookingStatus)) && in_array('0', $ExperienceBookingStatus) || $allPrev == '1') { ?>
                            <li>
                                <a href="admin/experience_account/display_attribute_list" <?php if ($currentUrl == 'experience_account') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon cog_3"></span>Experience Booking Status<span
                                            class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'experience_account') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>

                                    <li>
                                        <a href="admin/experience_account/display_newbooking" <?php if ($currentPage == 'display_newbooking') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>New Booking
                                        </a>
                                    </li>
                                    <?php if ($allPrev == '1' || in_array('1', $BookingStatus)) { ?>
                                        <li>
                                            <a href="admin/experience_account/display_book_confirmed" <?php if ($currentPage == 'display_book_confirmed') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Upcom. Completed Booking
                                            </a>
                                        </li>
                                        <li>
                                            <a href="admin/experience_account/display_book_expired" <?php if ($currentPage == 'display_book_expired') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Expired Booking</a>
                                        </li>
                                        <li>
                                            <a href="admin/experience_account/customerExcelExportNewBooking/enquiry" <?php if ($currentPage == 'customerExcelExportNewBooking') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Export New Booking
                                            </a>
                                        </li>
                                        <li>
                                            <a href="admin/experience_account/customerExcelExportNewBooking/booked" <?php if ($currentPage == 'customerExcelExportNewBooking') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Exp Completed Booking
                                            </a>
                                        </li>
                                        <li>
                                            <a href="admin/experience_account/customerExcelExportExpired" <?php if ($currentPage == 'customerExcelExportExpired') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Exp Expired Booking
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php }

                        if ((isset($Commission) && is_array($Commission)) && in_array('0', $Commission) || $allPrev == '1') {
                            ?>
                            <li>
                                <a href="#" <?php if ($currentUrl == 'commission' || $currentUrl == 'experience_commission') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon folder"></span>Commissions<span class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'commission' || $currentUrl == 'experience_commission') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>

                                    <?php if ($allPrev == '1') { ?>
                                        <li>
                                            <a href="admin/commission/display_commission_list" <?php if ($currentPage == 'display_commission_list') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Commission List
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <li>
                                        <a href="admin/commission/display_commission_tracking_lists" <?php if ($currentPage == 'display_commission_tracking_lists' && $currentUrl == 'commission') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Rental Commission Tracking
                                        </a>
                                    </li>

                                    <li>
                                        <a href="admin/commission/display_wallet_payments_list" <?php if ($currentPage == 'display_wallet_payments_list') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Rental Wallet Payments
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/experience_commission/display_commission_tracking_lists" <?php if ($currentPage == 'display_commission_tracking_lists' && $currentUrl == 'experience_commission') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Experience Commission Tracking</a>
                                    </li>
                                </ul>
                            </li>
                        <?php }
                        if ((isset($Review) && is_array($Review)) && in_array('0', $Review) || $allPrev == '1') { ?>
                            <li>
                                <a href="admin/review/display_review_list" <?php if ($currentUrl == 'experience_review' || $currentUrl == 'review' || $this->uri->segment(1, 0) == 'experience_review') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon folder"></span> Review <span class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'experience_review' || $currentUrl == 'review' || $this->uri->segment(1, 0) == 'experience_review') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/review/display_review_list" <?php if ($currentPage == 'display_review_list') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Review List
                                        </a>
                                    </li>
                                    <?php //if ($experienceExistCount > 0) { ?>
                                    <li>
                                        <a href="admin/experience_review/display_experience_review_list" <?php if ($currentPage == 'display_experience_review_list') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Experience Review List
                                        </a>
                                    </li>
                                    <?php //} ?>
                                </ul>
                            </li>
                        <?php }

                        if ((isset($Dispute) && is_array($Dispute)) && in_array('0', $Dispute) || $allPrev == '1') { ?>
                            <li><a href="admin/dispute/display_review_list" <?php if ($currentUrl == 'dispute' || $currentUrl == 'experience_dispute') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon folder"></span> Cancellation <span class="up_down_arrow">&nbsp;</span></a>
                                <ul class="acitem" <?php if ($currentUrl == 'dispute' || $currentUrl == 'experience_dispute') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/dispute/display_dispute_list" <?php if ($currentPage == 'display_dispute_list') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Rental Dispute List
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/dispute/cancel_booking_list" <?php if ($currentPage == 'cancel_booking_list') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Rental Cancel Booking Lists
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/dispute/cancel_booking_payment" <?php if ($currentPage == 'cancel_booking_payment') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Rental Cancellation Payment</a>
                                    </li>
                                    <li>
                                        <a href="admin/experience_dispute/display_experience_dispute_list" <?php if ($currentPage == 'display_experience_dispute_list') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Experience Cancel Booking Lists
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/dispute/cancel_experience_booking_payment" <?php if ($currentPage == 'cancel_experience_booking_payment') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Experience Cancellation Payment
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php }




                        if ((isset($Couponcode) && is_array($Couponcode)) && in_array('0', $Couponcode) || $allPrev == '1') { ?>
                            <li>
                                <a href="admin/couponcards/display_couponcards" <?php if ($currentUrl == 'couponcards') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon record"></span> Coupon Codes<span class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'couponcards') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/couponcards/display_couponcards" <?php if ($currentPage == 'display_couponcards') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Coupon code List
                                        </a>
                                    </li>
                                    <?php if ($allPrev == '1' || in_array('1', $Couponcode)) { ?>
                                        <li>
                                            <a href="admin/couponcards/add_couponcard_form" <?php if ($currentPage == 'add_couponcard_form') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Add Coupon code
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php }


                        if ((isset($PaymentGateway) && is_array($PaymentGateway)) && in_array('0', $PaymentGateway) || $allPrev == '1') { ?>
                            <li>
                                <a href="admin/paygateway/display_gateway" <?php if ($currentUrl == 'paygateway') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon shopping_cart_2"></span> Payment Gateway
                                </a>
                            </li>
                            <?php
                        }

                        if ((isset($Currency) && is_array($Currency)) && in_array('0', $Currency) || $allPrev == '1') { ?>
                            <li>
                                <a href="admin/currency/display_currency_list" <?php if ($currentUrl == 'currency') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon globe"></span> Manage Currency<span class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'currency') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/currency/display_currency_list" <?php if ($currentPage == 'display_currency_list') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Currency List
                                        </a>
                                    </li>
                                    <?php if ($allPrev == '1' || in_array('1', $Currency)) { ?>
                                        <li>
                                            <a href="admin/currency/add_currency_form" <?php if ($currentPage == 'add_currency_form') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Add currency
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li>
                                        <a href="admin/currency/currencyConversion" <?php if ($currentPage == 'currencyConversion') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Currency Conversion
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php }


                        if ((isset($Language) && is_array($Language)) && in_array('0', $Language) || $allPrev == '1') { ?>
                            <li>
                                <a href="admin/multilanguage" <?php if ($currentUrl == 'multilanguage') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon cog_3"></span> Manage Language
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'multilanguage') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/multilanguage/display_language_list" <?php if ($currentPage == 'display_language_list') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Site Language
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/multilanguage/display_user_language" <?php if ($currentPage == 'display_user_language') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>User Language
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php }

                        if ((isset($ManageCountry) && is_array($ManageCountry)) && in_array('0', $ManageCountry) || $allPrev == '1') { ?>
                            <li><a href="admin/location/display_location_list" <?php if ($currentUrl == 'location') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon globe"></span> Manage Country<span
                                            class="up_down_arrow">&nbsp;</span></a>
                                <ul class="acitem" <?php if ($currentUrl == 'location') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/location/display_location_list" <?php if ($currentPage == 'display_location_list') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Country List
                                        </a>
                                    </li>
                                    <?php if ($allPrev == '1' || in_array('1', $ManageCountry)) { ?>
                                        <li><a href="admin/location/add_tax_form" <?php if ($currentPage == 'add_tax_form') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Add State</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php }
                        if ((isset($City) && is_array($City)) && in_array('0', $City) || $allPrev == '1') { ?>
                            <li>
                                <a href="admin/city/display_city_list" <?php if ($currentUrl == 'city') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon record"></span> Manage City<span class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'city') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/city/display_city_list" <?php if ($currentPage == 'display_city_list') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>City List
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/city/display_featured_cities" <?php if ($currentPage == 'display_featured_cities') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Featured City List
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php }


                        if ((isset($Pages) && is_array($Pages)) && in_array('0', $Pages) || $allPrev == '1') { ?>
                            <li>
                                <a href="admin/cms/display_cms" <?php if ($currentUrl == 'cms') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon documents"></span> Manage Static Pages<span class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'cms') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/cms/display_cms" <?php if ($currentPage == 'display_cms') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>List of pages
                                        </a>
                                    </li>
                                    <?php if ($allPrev == '1' || in_array('1', $Pages)) { ?>
                                        <li>
                                            <a href="admin/cms/add_cms_form" <?php if ($currentPage == 'add_cms_form') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Add Main Page
                                            </a>
                                        </li>
                                        <li>
                                            <a href="admin/cms/add_lang_page" <?php if ($currentPage == 'add_lang_page') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Add Language Page
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php }


                        if ((isset($Newsletter) && is_array($Newsletter)) && in_array('0', $Newsletter) || $allPrev == '1') { ?>
                            <li>
                                <a href="admin/newsletter/display_newsletter" <?php if ($currentUrl == 'newsletter') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon mail"></span> Newsletter Template<span
                                            class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'newsletter') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/newsletter/display_subscribers_list" <?php if ($currentPage == 'display_subscribers_list') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Subscription List
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/newsletter/display_subscriber_newsletter" <?php if ($currentPage == 'display_subscriber_newsletter') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Subscriber Template List
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/newsletter/display_newsletter" <?php if ($currentPage == 'display_newsletter') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Email Template List
                                        </a>
                                    </li>
                                    <?php if ($allPrev == '1' || in_array('1', $Newsletter)) { ?>
                                        <li>
                                            <a href="admin/newsletter/add_newsletter" <?php if ($currentPage == 'add_newsletter') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Add Email Template</a>
                                        </li>
                                        <li><a href="admin/newsletter/mass_email" <?php if ($currentPage == 'mass_email') {
                                                echo 'class="active"';
                                            } ?>><span class="list-icon">&nbsp;</span>Mass E-Mail Campaigns
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php }


                        if ((isset($Banner) && is_array($Banner)) && in_array('0', $Banner) || $allPrev == '1'){ ?>
                            <li><a href="#" <?php if($currentUrl=='slider' || $currentUrl=='comments'){ echo 'class="active"';} ?>><span class="nav_icon folder"></span> Banner<span class="up_down_arrow">&nbsp;</span></a>
                                <ul class="acitem" <?php if($currentUrl=='slider' || $currentUrl=='comments'){ echo 'style="display: block;"';}else{ echo 'style="display: none;"';} ?>>
                                    <li><a href="admin/slider/display_slider_list" <?php if($currentPage=='display_slider_list'){ echo 'class="active"';} ?>><span class="list-icon">&nbsp;</span>Banner List</a></li>
                                    <?php if ($allPrev == '1' || in_array('1', $Slider)){ ?>
                                        <li><a href="admin/slider/add_slider_form" <?php if($currentPage=='add_slider_form'){ echo 'class="active"';} ?>><span class="list-icon">&nbsp;</span>Add New Banner</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php }
                        if ((isset($Prefooter) && is_array($Prefooter)) && in_array('0', $Prefooter) || $allPrev == '1'){ ?>

                            <li>
                                <a href="#" <?php if ($currentUrl == 'prefooter' || $currentUrl == 'comments') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon folder"></span>Prefooter<span class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'prefooter' || $currentUrl == 'comments') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/prefooter/display_prefooter_list" <?php if ($currentPage == 'display_prefooter_list') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Prefooter List
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php }
                        if ((isset($Backup) && is_array($Backup)) && in_array('0', $Backup) || $allPrev == '1') { ?>
                            <li>
                                <a href="#" <?php if ($currentUrl == 'dropbox') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon folder"></span>Backup<span class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'dropbox') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/backup/dbBackup" <?php if ($currentPage == 'add_prefooter_form') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Database Backup
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php }



                        if ((isset($Enquiries) && is_array($Enquiries)) && in_array('0', $Enquiries) || $allPrev == '1') { ?>
                            <li>
                                <a href="admin/contact_us/display_contactus"><span class="nav_icon globe"></span> Enquiries
                                </a>
                            </li>
                        <?php }

                        if ((isset($FAQManagement) && is_array($FAQManagement)) && in_array('0', $FAQManagement) || $allPrev == '1') { ?>

                            <li>
                                <a href="#" <?php if ($currentUrl == 'help' || $currentUrl == 'help') {
                                    echo 'class="active"';
                                } ?>><span class="nav_icon folder"></span>FAQ Management<span
                                            class="up_down_arrow">&nbsp;</span>
                                </a>
                                <ul class="acitem" <?php if ($currentUrl == 'help' || $currentUrl == 'help') {
                                    echo 'style="display: block;"';
                                } else {
                                    echo 'style="display: none;"';
                                } ?>>
                                    <li>
                                        <a href="admin/help/display_main_menu" <?php if ($currentPage == 'display_main_menu') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Categories
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/help/display_sub_menu" <?php if ($currentPage == 'display_sub_menu') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>Sub topic
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin/help/question_and_ans" <?php if ($currentPage == 'question_and_ans') {
                                            echo 'class="active"';
                                        } ?>><span class="list-icon">&nbsp;</span>FAQ
                                        </a>
                                    </li>

                                </ul>
                            </li>

                        <?php } ?>


                        <?php
                        $manualUpdateStatus = $this->db->select('manual_currency_status')->where('id','1')->get('fc_admin')->row()->manual_currency_status;
                        if($manualUpdateStatus==1) { ?>
                            <li><a href="admin/CurrencyManual" <?php if($currentUrl=='CurrencyManual'){ echo 'class="active"';} ?>><span class="nav_icon folder"></span> Manual Currency Update</a></li>
                        <?php } ?>

                    </ul>
                </div>
            </div>
        </div>
        <?php
        extract($privileges);
        /*$havingTodayCurrency = $this->db->select('curren_id')->where('created_date',date('Y-m-d'))->get('fc_currency_cron')->row();
        print_r($havingTodayCurrency);
        if(count($havingTodayCurrency) > 0)
        {
            echo 'Yes';
        }
        else
        {
            echo 'No';
        }*/
        ?>
        <!--<div class="header_center"><div style="margin:0 auto;color:#F00;font-size:12px;font-weight:bold;">Test</div></div>-->
        <script type="text/javascript">
            $(document).ready(function(){
                $(".dropdown-menu").on("click", function(){
                    if($(this).hasClass("active")){
                        $(this).removeClass("active");
                    }else {
                        $(this).addClass("active");
                    }
                });
            });
        </script>
        <div class="header_right">

            <div id="user_nav" <?php if ($allPrev != '1'){ ?>style="width: 250px;"<?php } ?>>

                <ul>

                    <li class="user_thumb"><span class="icon"><img src="images/user_thumb.png" width="30" height="30" alt="User"></span>
                    </li>
                    <li class="user_info">
                        <?php if ($allPrev == '1') { ?>
                            <span class="user_name">Administrator</span>
                            <!-- <span>
							<a href="<?php echo base_url(); ?>" target="_blank" class="tipBot" title="View Site">Visit Site
							</a> &#124;
							<a href="admin/adminlogin/admin_global_settings_form" class="tipBot"
							   title="Edit account details">Settings
							</a>
							</span> -->
                        <?php } else { ?>
                            <span class="user_name">Representative </span>
                            <!-- <span>
							<a target="_blank" class="tipBot"
							   title=""><?php echo $this->session->userdata('fc_session_admin_name'); ?>
							</a> &#124;
							<a href="admin/adminlogin/change_admin_password_form" class="tipBot"
							   title="Click to change your password">Change Password
							</a>
						</span> -->
                        <?php } ?>
                    </li>
                    <li class="bootstrap-dropdown dropdown-menu">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        <ul class="dropdown-menuList">
                            <li>
                                <a href="<?php echo base_url(); ?>">
                                    <span><i class="fa fa-television" aria-hidden="true"></i></span>
                                    Visit Site</a>
                            </li>
                            <li>
                                <a href="admin/adminlogin/admin_global_settings_form">
                                    <span><i class="fa fa-cog" aria-hidden="true"></i></span>
                                    Settings</a>
                            </li>
                            <li>
                                <a href="admin/adminlogin/admin_logout" class="tipBot">
                                    <span><i class="fa fa-sign-out" aria-hidden="true"></i></span>
                                    Logout</a>
                            </li>
                        </ul>
                    </li>
                    <!-- <li class="logout">
                        <a href="admin/adminlogin/admin_logout" class="tipBot" title="Logout">
                            <span class="icon"><img src="images/admin_logout.png" width="30" height="30" alt="User">
                            </span>Logout
                        </a>
                    </li> -->
                </ul>
            </div>
        </div>
    </div>
    <div class="page_title">
        <span class="title_icon"><span class="computer_imac"></span></span>
        <h3><?php echo $heading; ?></h3>
    </div>
    <?php if (validation_errors() != '') { ?>
        <div id="validationErr" style="float:right">
            <script>setTimeout("hideErrDiv('validationErr')", 10000);</script>
            <p><?php echo validation_errors(); ?></p>
        </div>
    <?php } ?>
    <?php if ($flash_data != '') { ?>
        <div class="errorContainer" id="<?php echo $flash_data_type; ?>">
            <script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 10000);</script>
            <p><span><?php echo $flash_data; ?></span></p>
        </div>
    <?php } ?>

    <!-- Preloader -->
    <script type="text/javascript">
        $(window).load(function () {
            $("#spinner").fadeOut("slow");
        })
    </script>
    <!-- Preloader -->

    <div id="spinner"></div>
