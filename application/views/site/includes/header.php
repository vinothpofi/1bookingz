<!DOCTYPE html>
<?php 
$browser = $_SERVER['HTTP_USER_AGENT'];
$name_browser = 'Chrome';
if($_SESSION['language_code'] == 'ar') { ?>
 <html dir="rtl" lang="ar">
<?php } else { ?>
       
  <html>
<?php } ?>
   <head>
       <?php  echo $this->config->item('google_verification_code'); ?>
       <meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    <style type="text/css">
        .signUpIn .faceBook{
        padding: 11px !important;
            background: #3b65c3 !important;
    border-radius: 20px !important;
    }
    .signUpIn .googlePlus{
        
         background: #dd4b39 !important;
         padding: 11px !important;
    border-radius: 20px !important;
    }
   
    a.googlePlus.hide_signUp {
    background: #dc4638;
    color: #ffffff;
    border: none !important;
}
    a.dropdown-toggle{line-height: 5.5;    padding: 28px 0px;    color: #444;    text-decoration: none;}
    a.dropdown-toggle:hover{color: #444; text-decoration: none;}

form[name="search_properties"] .mic_pic_blink {

-moz-transition:all 1s ease-in-out;
-webkit-transition:all 1s ease-in-out;
-o-transition:all 1s ease-in-out;
-ms-transition:all 1s ease-in-out;
transition:all 1s ease-in-out;
/* order: name, direction, duration, iteration-count, timing-function */  
-moz-animation:blink normal 1s infinite ease-in-out; /* Firefox */
-webkit-animation:blink normal 1s infinite ease-in-out; /* Webkit */
-ms-animation:blink normal 1s infinite ease-in-out; /* IE */
animation:blink normal 1s infinite ease-in-out; /* Opera and prob css3 final iteration */
}​

form[name="search_properties"] {
position: relative;
}

form[name="search_properties"]  #mic_pic_list  { 
position: absolute;
top: 10px;
right: 116px;
width: 30px;
height: 30px;
}

      /* Absolute Center Spinner */
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

@media screen and (max-width: 767px) {
  form[name="search_properties"] #mic_pic_list { right: 25%;}
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
      <?php


         /*Setting current url page if user not logged in*/
         if ($this->session->fc_session_user_id == "") {
             $current_url = uri_string();
             $this->session->set_userdata(array('current_page_url' => $current_url));
         }
         /*Close*/
         if ($this->config->item('google_verification')) {
             echo stripslashes($this->config->item('google_verification'));
         }
         if ($this->lang->line('list_your') != '') {
             $listSpace = stripslashes($this->lang->line('list_your'));
         } else $listSpace = "RENT A PROPERTY";
         if ($this->lang->line('create_experience') != '') {
             $listExprience = stripslashes($this->lang->line('create_experience'));
         } else $listExprience = "Create Experience";
         if ($heading == '') {
             ?>
      <title>
         <?php echo $meta_title; ?>
      </title>
      <?php
         } else {
             ?>
      <title>
         <?php echo $heading; ?>
      </title>
      <?php }
         ?>
      <script type="text/javascript">
         var IsHomePage = 1;
         var IsExpriencePage = 0;
             <?php if ($this->uri->segment(1) != "") { ?>var IsHomePage = 0;<?php }?>
             <?php if ($current_controller != "experience") { ?>var IsExpriencePage = 1;<?php }?>
         var BaseURL = '<?php echo base_url();?>';
         var baseURL = '<?php echo base_url();?>';
      </script>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="title" content="<?php echo $meta_title; ?>"/>
      <meta name="keywords" content="<?php echo $meta_keyword; ?>"/>
      <meta name="description" content="<?php echo $meta_description; ?>"/>
      <meta name="robots" content="noindex,nofollow" />
      <link rel="shortcut icon" type="image/x-icon"
         href="<?= base_url(); ?>images/logo/<?php echo $this->config->item('fevicon_image'); ?>">
      <!-- <link href="https://fonts.googleapis.com/css?family=Mukta+Malar:300,400,500" rel="stylesheet"> -->
      <link rel="stylesheet" href="<?php echo base_url(); ?>css/font-muktamalar.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap3.3.7.min.css">
      <!-- Owl Stylesheets -->
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/owlcarousel/assets/owl.carousel.min.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/owlcarousel/assets/owl.theme.default.min.css">
      <?php if($_SESSION['language_code'] == 'ar'){ ?>
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style-arabic.css">
   <?php } else { ?>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
   <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/dashboard.css"> -->
   <?php } ?>

       <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700,800&display=swap" rel="stylesheet">
       <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
      <!-- script for image croping -->
      <script src="<?php echo base_url(); ?>js/jquery3.2.1.min.js"></script>
      <script src="<?php echo base_url(); ?>js/bootstrap3.3.7.min.js"></script>
      <!-- Owl javascript -->
      <script src="<?php echo base_url(); ?>assets/owlcarousel/owl.carousel.js"></script>
      <!-- Location Autocomplete API -->
      <script
         src="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http'; ?>://maps.googleapis.com/maps/api/js?key=<?php echo $this->config->item('google_developer_key'); ?>&libraries=places&dummy=.js"></script>
      <!-- Font Awesome -->
      <link rel="stylesheet" href="<?php echo base_url(); ?>css/font-awesome.min.css">
      <!-- Custom Jquery -->
      <script src="<?php echo base_url(); ?>js/customJs.js"></script>
      <link rel="stylesheet" href="<?php echo base_url(); ?>css/google-font.css">
	     
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/intlTelInput.css">
       <style type="text/css">
           /*body{font-family: Roboto !important;}*/
           body{font-family: 'Montserrat', sans-serif !important;}
           /*h1,h2,h3,h6 {font-family: Pacifico !important;}*/
       </style>

<script type="text/javascript">
    // Header Position
    $(window).scroll(function (event) {
        var scroll = $(window).scrollTop();
        if(scroll >= 100){$(".posHeader").addClass("fixedHeader");}
        else {$(".posHeader").removeClass("fixedHeader");}
        //Goto Top
        if(scroll >= 500){$(".gotoTop").css("opacity","1");}
        else{$(".gotoTop").css("opacity","0");}

    });
    $(document).ready(function(){
        $(".searchIconHeader").on("click", function(){
            $(".searchLocation").addClass("active");
        });
        $("header.posHeader").addClass("pageHeader");
        $("button.menuBtn").on("click", function(){
            if($("body.iti-mobile").hasClass('active')){
                $("body.iti-mobile").removeClass("active");
                $("button.menuBtn").removeClass("active");
            }else {
                $("body.iti-mobile").addClass("active");
                $("button.menuBtn").addClass("active");
            }
        });
        $("button.searchBtn").on("click", function(){
            if($(".searchLocation").hasClass('active')){
                $(".searchLocation").removeClass("active");
                $("button.searchBtn").removeClass("active");
            }else {
                $(".searchLocation").addClass("active");
                $("button.searchBtn").addClass("active");
            }
        });
    })
</script>

   </head>
   <body>
   <div class="gotoTop" >
       <i class="fa fa-angle-up"></i>
   </div>
<script type="text/javascript">
$(document).ready(function(){
  $(".gotoTop").on("click", function(){    
    $("body").scrollTop(0);
  });
});
</script>   
      <header class="posHeader">
          <!-- New Menu START -->
          <nav class="navbar navbar-inverse">
              <div class="container">
                  <!-- Logo -->
                  <div class="navbar-header">
                      <button type="button" class="navbar-toggle menuBtn" data-toggle="collapse" data-target="#myNavbar">
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                      </button>
                      <button type="button" class="navbar-toggle searchBtn" data-toggle="collapse" data-target="#mySearch">
                          <i class="fa fa-search" aria-hidden="true"></i>
                          <i class="fa fa-times" aria-hidden="true"></i>
                      </button>
                      <a class="navbar-brand" href="<?php echo base_url(); ?>">
                          <!-- <img src="images/logo/logo.svg"/> -->
                          <img src="<?php echo base_url(); ?>images/logo/<?php echo $this->config->item('logo_image');?>"/>
                      </a>
                  </div>
                  <div class="collapse navbar-collapse" id="myNavbar">
                      <ul class="nav navbar-nav navbar-right">
                          <!-- <li class="searchIconHeaderLI hidden-lg"><a href="#0" class="searchIconHeader"><i class="fa fa-search" aria-hidden="true"></i></a></li> -->
                          <!-- Add "active" class in "li" for Active Link -->
                          <li class=""><a href="<?php echo base_url(); ?>popular" onclick="set_signup_and_login_link('<?= uri_string(); ?>')"; ><?php if ($this->lang->line('popular') != '') {  echo stripslashes($this->lang->line('popular'));   } else echo "Popular"; ?></a></li>
                          <li class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                  <?php if ($this->lang->line('Become_Host') != '') {
                                      echo stripslashes($this->lang->line('Become_Host'));
                                  } else echo "Become a Host"; ?>
                                  <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                  <?php
                                  if ($this->session->userdata('fc_session_user_id')) { ?>
                                  <li><?php echo anchor('list_space', $listSpace); ?></li>
                                  <?php /* <li><?php echo anchor('manage_experience', $listExprience); ?></li> */ ?>


                                  <?php } else { ?>

                                  <li><a data-toggle="modal" data-target="#signUp"
                                         onclick="javascript:set_signup_and_login_link('list_space');"><?php echo $listSpace; ?></a>
                                  </li>
                                  <?php /* <li><a data-toggle="modal" data-target="#signUp"
                                         onclick="javascript:set_signup_and_login_link('manage_experience');"><?php echo $listExprience; ?></a>
                                  </li> */ ?>
                                  <?php } ?>

                              </ul>
                          </li>
                          <?php
                          if ($this->session->userdata('fc_session_user_id')=='') { ?>                              
                              <!-- <li>
                                      <a data-toggle="modal" data-target="#signUp"
                                              type="button"
                                              onclick="set_signup_and_login_link('<?= uri_string(); ?>');"><?php if ($this->lang->line('login_signup') != '') {
                                              echo stripslashes($this->lang->line('login_signup'));
                                          } else echo "Create  Account"; ?>
                                      </a>
                              </li> -->
                              <li>
                                  <a data-toggle="modal" data-target="#signIn"

                                          onclick="set_signup_and_login_link('<?= uri_string(); ?>');"><?php if ($this->lang->line('header_login') != '') {
                                          echo stripslashes($this->lang->line('header_login'));
                                      } else echo "Log in"; ?>
                                  </a>
                              </li>
                          <?php } ?>
                          
                          <!-- Use this tag for dashboard pages for mobile screen -->


                          <!-- left menu--->
                          <?php
                          if ($this->session->userdata('fc_session_user_id')) { ?>

                          <li class="dropdown">
                              <!-- <div class=""> -->
                                  <a class="dropdown-toggle" type="button" data-toggle="dropdown">
                                      <div class="userIcon">
                                          <?php
                                          if ($userDetails->row()->image != '' && file_exists('./images/users/' . $userDetails->row()->image)) {
                                              $imgSource = "images/users/" . $userDetails->row()->image;
                                          } else {
                                              $imgSource = "images/users/profile.png";
                                          }
                                          echo img($imgSource, TRUE, array('class'=>'hidden-xs'));
                                          ?>
                                       <span class="visible-xs"><?php echo $userDetails->row()->user_name.' '.$userDetails->row()->last_name; ?> <span class="caret"></span></span>
                                      </div> 
                                  </a>
                                  <ul class="dropdown-menu">
                                      <div class="dropdownIcon"></div>
                                      <li>
                                          <a href="<?php echo base_url(); ?>dashboard"><?php if ($this->lang->line('header_dashboard') != '') {
                                                  echo stripslashes($this->lang->line('header_dashboard'));
                                              } else echo "Dashboard"; ?></a>
                                      </li>
                                      <li class="visible-xs">
                                          <a href="<?php echo base_url(); ?>listing/all"><?php if ($this->lang->line('header_listing') != '') {
                                                  echo stripslashes($this->lang->line('header_listing'));
                                              } else echo "Your Listings"; ?></a>
                                      </li>
                                      <?php
                                      if ($experienceExistCount > 0) {
                                          ?>
                                          <li class="visible-xs">
                                              <a href="<?php echo base_url(); ?>experience/all"><?php if ($this->lang->line('My Experiences List') != '') {
                                                      echo stripslashes($this->lang->line('My Experiences List'));
                                                  } else echo "My Experiences List"; ?></a>
                                          </li>
                                      <?php } ?>
                                      <li class="visible-xs">
                                          <a href="<?php echo base_url(); ?>listing-reservation"><?php if ($this->lang->line('YourReservations') != '') {
                                                  echo stripslashes($this->lang->line('YourReservations'));
                                              } else echo "Your Reservations"; ?></a>
                                      </li>
                                      <li class="visible-xs">
                                          <a href="<?php echo base_url(); ?>trips/upcoming"><?php if ($this->lang->line('your_trips') != '') {
                                                  echo stripslashes($this->lang->line('your_trips'));
                                              } else echo "Your Trips"; ?></a>
                                      </li>
                                      <li class="">
                                          <a href="<?php echo base_url(); ?>users/<?php echo $loginCheck; ?>/wishlists"><?php if ($this->lang->line('wish_list') != '') {
                                                  echo stripslashes($this->lang->line('wish_list'));
                                              } else echo "Wish List"; ?></a>
                                      </li>
                                      <li class="visible-xs">
                                          <a href="<?php echo base_url(); ?>your-wallet"><?php if ($this->lang->line('Wallet') != '') {
                                                  echo stripslashes($this->lang->line('Wallet'));
                                              } else echo "Wallet";
                                              echo " (" . $currencySymbol . ' ' . currency_conversion('USD',$this->session->userdata('currency_type'),$userDetails->row()->referalAmount) . ")"; ?></a>
                                      </li>
                                      <li class="visible-xs">
                                          <a href="<?php echo base_url(); ?>settings"><?php if ($this->lang->line('settings_edit_prof') != '') {
                                                  echo stripslashes($this->lang->line('settings_edit_prof'));
                                              } else echo "Edit Profile"; ?></a>
                                      </li>
                                      <li class="visible-xs">
                                          <a href="<?php echo base_url(); ?>account-payout"><?php if ($this->lang->line('referrals_account') != '') {
                                                  echo stripslashes($this->lang->line('referrals_account'));
                                              } else echo "Account"; ?></a>
                                      </li>
                                      <li class="visible-xs">
                                          <a href="<?php echo base_url(); ?>your-wallet"><?php if ($this->lang->line('Wallet') != '') {
                                                  echo stripslashes($this->lang->line('Wallet'));
                                              } else echo "Wallet";
                                              echo " (" . $currencySymbol . ' ' . currency_conversion('USD',$this->session->userdata('currency_type'),$userDetails->row()->referalAmount) . ")"; ?></a>
                                      </li>
                                      <?php if ($this->lang->line('Logout') != '') {
                                          $logout = stripslashes($this->lang->line('Logout'));
                                          //echo $logout;
                                      } else $logout="Logout"; ?>


                                      <?php
                                      if ($this->session->userdata('fc_session_user_login_type') == "facebook") {
                                          ?>
                                          <li><?php echo anchor('fb-user-logout', "$logout"); ?></li>
                                          <?php
                                      } else {
                                          ?>
                                          <li><?php echo anchor('user-logout', "$logout"); ?></li>
                                          <?php
                                      }
                                      ?>
                                  </ul>
                              <!-- </div> -->
                          </li>
                          <?php } else { ?>

                          <?php } ?>
                          <!-- left menu--->


                      </ul>

                  </div>

                  <?php
                  //echo $current_controller.'cc'.$current_class;
                  if($current_controller=='landing' && $current_class=='index'){
//home page
                  }else{
                  ?>


                  <div class="searchLocation" >
                      <form action="<?= base_url(); ?><?php if ($current_controller != "experience") { ?>property<?php } else { ?>explore-experience<?php } ?>"
                            name="search_properties" autocomplete="off" method="get" id="property_search_form"
                            accept-charset="utf-8">
                          <?php if ($this->lang->line('try') != '') {
                              $try= stripslashes($this->lang->line('try'));
                          } else {
                              $try="Try";
                          } 
                          if ($this->lang->line('location') != '') {
                              $location= stripslashes($this->lang->line('location'));
                          } else {
                              $location="Location";
                          } 
                          ?>
                          <div class="form-group">
                              <input id="autocomplete" class="searchInput" value="<?php if ($this->input->get('city') != '') {
                                  echo $this->input->get('city');
                              } else {
                                  echo '';
                              } ?>" placeholder= '<?php echo $try.' '.$location; ?>'  name="city" type="text">
                              <?php if (strpos($browser, $name_browser) !== false) { ?>  
                <img id="mic_pic_list" style="float: right;display: block;" src="<?php echo base_url();?>images/googlemic.png" onclick="startDictation_header();"> 
                <?php } ?> 
                          </div>
                          <div class="form-group">
                              <button type="submit" class="searchBtn hidden-sm"><?php if ($this->lang->line('Search') != '') {
                                      echo  stripslashes($this->lang->line('Search'));
                                  } else {
                                      echo "Search";
                                  } ?></button>
                                  <button type="submit" class="searchBtn visible-sm"><?php if ($this->lang->line('Search') != '') {
                                      // echo  stripslashes($this->lang->line('Search'));
                                    ?>
                                    <i class="fa fa-search"></i>
                                    <?php
                                  } else {
                                      echo "Search";
                                  } ?></button>
                          </div>
                          <div class="exploreDetail">
                              <h6><?php if ($this->lang->line('explore_homestay') != '') {
                                      echo stripslashes($this->lang->line('explore_homestay'));
                                  } else echo "Explore Homestay"; ?></h6>
                              <div class="clear">
                                  <a href="<?php echo base_url(); ?>explore_listing"
                                     class="exploreBtn <?php if ($this->uri->segment(1) == 'explore_listing') { ?>active<?php } ?>"><?php if ($this->lang->line('Homes') != '') {
                                          echo stripslashes($this->lang->line('Homes'));
                                      } else echo "Homes"; ?></a>
                                  <a href="<?php echo base_url(); ?>explore-experience"
                                     class="exploreBtn <?php if ($this->uri->segment(1) == 'explore-experience') { ?>active<?php } ?>"><?php if ($this->lang->line('Experiences') != '') {
                                          echo stripslashes($this->lang->line('Experiences'));
                                      } else echo "Experiences"; ?></a>
                                  <a href="<?php echo base_url(); ?>all_listing" class="exploreBtn <?php if ($this->uri->segment(1) == 'all_listing') { ?>active<?php } ?>"><?php if ($this->lang->line('All') != '') { echo stripslashes($this->lang->line('All'));  } else { echo "All"; } ?></a>
                              </div>
                          </div>
                      </form>
                  </div>


              </div>

              <?php } ?>

          </nav>
          <!-- New Menu END -->

        <div class="loading" style="display: none;"></div>
        <!--  <?php if($flash_data != '') {?>
                    <div class="errorContainer" id="<?php echo $flash_data_type;?>">
                        <script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 4000);</script>
                        <p style="color:#000000; font-size:16px;"><span><?php echo $flash_data;?></span></p>
                    </div>
                    <?php } ?>
               <?php if ($this->session->flashdata('success') == TRUE): ?>
                    <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
                    <?php endif; ?> -->
         <div class="clear" style="display: none;">
            <div class="headerLeft l-header" >
               <div class="logo">
                   <?php if ($_SESSION['language_code'] == "ar") {
                       ?>

                       <a href="<?php echo base_url(); ?>"><?php echo $this->config->item('email_title_ar'); ?>
                           <img src="images/logo/<?php echo $this->config->item('logo_image'); ?>" alt=""></a>

                   <?php } else {

                       if ($this->uri->segment(1) != '') { ?>

                           <!--logo image part-->

                           <a href="<?php echo base_url(); ?>">
                               <?php //if (file_exists('./images/logo/' . $this->config->item('logo_image'))) { ?>
                               <img src="<?php echo base_url(); ?>images/logo/<?php echo $this->config->item('logo_image'); ?>"
                                    alt="Logo">
                               <?php //} else {
                               echo $this->config->item('email_title'); // } ?>
                           </a>

                           <!--end logo image part-->

                       <?php } else { ?>

                           <!--homepage logo part-->

                           <a href="<?php echo base_url(); ?>">
                               <?php //if (file_exists('./images/logo/' . $this->config->item('home_logo_image'))) { ?>
                               <img src="<?php echo base_url(); ?>images/logo/<?php echo $this->config->item('logo_image'); ?>"
                                    alt="Logo">
                               <?php //} else {
                               echo $this->config->item('email_title'); // } ?>
                           </a>


                           <!--end homepage logo part-->

                       <?php }
                   } ?>


                  <div class="menuArrow"><span class="icon"> > </span></div>
               </div>
               <div class="searchLocation">
                  <form
                     action="<?= base_url(); ?><?php if ($current_controller != "experience") { ?>property<?php } else { ?>explore-experience<?php } ?>"
                     name="search_properties" autocomplete="off" method="get" id="property_search_form"
                     accept-charset="utf-8">
                     <i class="fa fa-search" aria-hidden="true"></i>
                     <?php if ($this->lang->line('try') != '') {
                        $try= stripslashes($this->lang->line('try'));
                        } else {
                        $try="Try";
                        } ?>
                     <input id="autocomplete" class="searchInput" value="<?php if ($this->input->get('city') != '') {
                        echo $this->input->get('city');
                        } else {
                        echo '';
                        } ?>" placeholder= '<?php echo $try . " Ooty"; ?>'  name="city" type="text">
                         <?php if (strpos($browser, $name_browser) !== false) { ?>  
                <img id="mic_pic_list" style="float: right;display: block;" src="<?php echo base_url();?>images/googlemic.png" onclick="startDictation_header();"> 
                <?php } ?>    
                     <button type="submit" class="searchBtn"><?php if ($this->lang->line('Search') != '') {
                        echo  stripslashes($this->lang->line('Search'));
                        } else {
                        echo "Search";
                        } ?></button>
                     <div class="exploreDetail">
                        <h6><?php if ($this->lang->line('explore_homestay') != '') {
                           echo stripslashes($this->lang->line('explore_homestay'));
                           } else echo "Explore Homestay"; ?></h6>
                        <div class="clear">

                           <a href="<?php echo base_url(); ?>explore_listing"
                              class="exploreBtn <?php if ($this->uri->segment(1) == 'explore_listing') { ?>active<?php } ?>"><?php if ($this->lang->line('Homes') != '') {
                              echo stripslashes($this->lang->line('Homes'));
                              } else echo "Homes"; ?></a>
                           <a href="<?php echo base_url(); ?>explore-experience"
                              class="exploreBtn <?php if ($this->uri->segment(1) == 'explore-experience') { ?>active<?php } ?>"><?php if ($this->lang->line('Experiences') != '') {
                              echo stripslashes($this->lang->line('Experiences'));
                              } else echo "Experiences"; ?></a>

							  <a href="<?php echo base_url(); ?>all_listing" class="exploreBtn <?php if ($this->uri->segment(1) == 'all_listing') { ?>active<?php } ?>"><?php if ($this->lang->line('All') != '') { echo stripslashes($this->lang->line('All'));  } else { echo "All"; } ?></a>
                        </div>
                     </div>
                  </form>
               </div>
               <div class="responsiveMenu">
                  <div class="logo">
                     <?php if (file_exists('./images/logo/' . $this->config->item('logo_image'))) { ?>
                     <img src="<?php echo base_url(); ?>images/logo/<?php echo $this->config->item('logo_image'); ?>"
                        alt="Logo">
                     <?php } else {
                        echo $this->config->item('email_title');
                        } ?>
                     <div class="menuArrow"><span class="icon"> > </span></div>
                  </div>
                  <ul class="clearLeft">
                     <li><a href="<?= base_url(); ?>"><?php if ($this->lang->line('home') != '') {
                        echo stripslashes($this->lang->line('home'));
                        } else echo "Home"; ?> <i class="fa fa-home" aria-hidden="true"></i></a></li>
                     <li class="divider"></li>
                     <?php if ($this->session->userdata('fc_session_user_id')) { ?>
                     <li><?php echo anchor('list_space', $listSpace . '<i class="fa fa-building" aria-hidden="true"></i>'); ?></li>
                     <li><?php echo anchor('manage_experience', $listExprience . '<i class="fa fa-calendar-check-o" aria-hidden="true"></i>'); ?></li>
                     <?php } else { ?>
                     <li><a data-toggle="modal" data-target="#signUp"
                        onclick="javascript:set_signup_and_login_link('list_space');"><?php echo $listSpace; ?></a>
                     </li>
                     <li><a data-toggle="modal" data-target="#signUp"
                        onclick="javascript:set_signup_and_login_link('manage_experience');"><?php echo $listExprience; ?></a>
                     </li>
                     <?php } ?>
                     <?php if ($this->session->userdata('fc_session_user_id')) { ?>
                     <li class="divider"></li>
                     <li>
                        <a href="<?php echo base_url(); ?>dashboard"><?php if ($this->lang->line('header_dashboard') != '') {
                           echo stripslashes($this->lang->line('header_dashboard'));
                           } else echo "Dashboard"; ?> <i class="fa fa-user-o" aria-hidden="true"></i></a>
                     </li>
                     <li>
                        <a href="<?php echo base_url(); ?>listing/all"><?php if ($this->lang->line('header_listing') != '') {
                           echo stripslashes($this->lang->line('header_listing'));
                           } else echo "Your Listings"; ?> <i class="fa fa-suitcase" aria-hidden="true"></i></a>
                     </li>
                     <?php
                        if ($experienceExistCount > 0) {
                            ?>
                     <li>
                        <a href="<?php echo base_url(); ?>experience/all"><?php if ($this->lang->line('my_experience_list') != '') {
                           echo stripslashes($this->lang->line('my_experience_list')); } else echo "My Experiences List"; ?> <i class="fa fa-map-marker"
                           aria-hidden="true"></i></a>
                     </li>
                     <?php } ?>
                     <li>
                        <a href="<?php echo base_url(); ?>listing-reservation"><?php if ($this->lang->line('YourReservations') != '') {
                           echo stripslashes($this->lang->line('YourReservations'));
                           } else echo "Your Reservations"; ?> <i class="fa fa-map-o" aria-hidden="true"></i></a>
                     </li>
                     <li>
                        <a href="<?php echo base_url(); ?>trips/upcoming"><?php if ($this->lang->line('your_trips') != '') {
                           echo stripslashes($this->lang->line('your_trips'));
                           } else echo "Your Trips"; ?> <i class="fa fa-motorcycle" aria-hidden="true"></i></a>
                     </li>
                     <li>
                        <a href="users/<?php echo $loginCheck; ?>/wishlists"><?php if ($this->lang->line('wish_list') != '') {
                           echo stripslashes($this->lang->line('wish_list'));
                           } else echo "Wish List"; ?> <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                     </li>
                     <li>
                        <a href="<?php echo base_url(); ?>settings"><?php if ($this->lang->line('settings_edit_prof') != '') {
                           echo stripslashes($this->lang->line('settings_edit_prof'));
                           } else echo "Edit Profile"; ?> <i class="fa fa-edit" aria-hidden="true"></i></a>
                     </li>
                     <li>
                        <a href="<?php echo base_url(); ?>account-payout"><?php if ($this->lang->line('referrals_account') != '') {
                           echo stripslashes($this->lang->line('referrals_account'));
                           } else echo "Account"; ?> <i class="fa fa-dashboard" aria-hidden="true"></i></a>
                     </li>
                     <li>
                        <a href="<?php echo base_url(); ?>your-wallet">oyy<?php if ($this->lang->line('Wallet') != '') {
                           echo stripslashes($this->lang->line('Wallet'));
                           } else { echo "Wallet"; }
                           echo " (" . $currencySymbol . ' ' . currency_conversion('USD',$this->session->userdata('currency_type'),$userDetails->row()->referalAmount) . ")"; ?>
                        <i class="fa fa-google-wallet" aria-hidden="true"></i>
                        </a>
                     </li>
                     <?php
                        if ($this->session->userdata('fc_session_user_login_type') == "facebook") {
                            ?>
                     <li><?php echo anchor('fb-user-logout', 'Logout  <i class="fa fa-sign-out" aria-hidden="true"></i>'); ?></li>
                     <?php
                        } else {
                            ?>
                     <li><?php echo anchor('user-logout', 'Logout  <i class="fa fa-sign-out" aria-hidden="true"></i>'); ?></li>
                     <?php
                        }
                        } else {
                        ?>
                     <li class="divider"></li>
                     <li><a data-toggle="modal"
                        data-target="#signUp"
                        onclick="set_signup_and_login_link('<?= uri_string(); ?>');"><?php if ($this->lang->line('login_signup') != '') {
                        echo stripslashes($this->lang->line('login_signup'));
                        } else echo "Create  Account"; ?> <i class="fa fa-user-plus" aria-hidden="true"></i></a>
                     </li>
                     <li><a data-toggle="modal"
                        data-target="#signIn"
                        onclick="set_signup_and_login_link('<?= uri_string(); ?>');"><?php if ($this->lang->line('header_login') != '') {
                        echo stripslashes($this->lang->line('header_login'));
                        } else echo "Log in"; ?> <i class="fa fa-sign-in " aria-hidden="true"></i></a>
                     </li>
                     <?php
                        }
                        ?>
                  </ul>
               </div>
            </div>
            <div class="headerRight">
               <ul class="clear list_li">
                  <li>
                     <div class="dropdown">
                        <!-- <button class="dropdown-toggle" type="button"
                           onclick="set_signup_and_login_link('<?= uri_string(); ?>');window.location.href='<?php echo base_url(); ?>popular'">
                        <?php if ($this->lang->line('popular') != '') {
                           echo stripslashes($this->lang->line('popular'));
                           } else echo "Popular"; ?>
                        </button> -->
                        <a href="<?php echo base_url(); ?>popular" onclick="set_signup_and_login_link('<?= uri_string(); ?>')"; class="dropdown-toggle"><?php if ($this->lang->line('popular') != '') { echo stripslashes($this->lang->line('popular')); } else echo "Popular"; ?></a>
                     </div>
                  </li>
                  <li>
                     <div class="dropdown">
                        <button class="dropdown-toggle" type="button"
                           data-toggle="dropdown"><?php if ($this->lang->line('Become_Host') != '') {
                           echo stripslashes($this->lang->line('Become_Host'));
                           } else echo "Become a Host"; ?>
                        </button>
                        <ul class="dropdown-menu">
                           <div class="dropdownIcon"></div>
                           <?php
                              if ($this->session->userdata('fc_session_user_id')) { ?>
                           <li><?php echo anchor('list_space', $listSpace); ?></li>
                           <li><?php echo anchor('manage_experience', $listExprience); ?></li>
                           <?php } else { ?>
                           <li><a data-toggle="modal" data-target="#signUp"
                              onclick="javascript:set_signup_and_login_link('list_space');"><?php echo $listSpace; ?></a>
                           </li>
                           <li><a data-toggle="modal" data-target="#signUp"
                              onclick="javascript:set_signup_and_login_link('manage_experience');"><?php echo $listExprience; ?></a>
                           </li>
                           <?php } ?>
                        </ul>
                     </div>
                  </li>
                  <?php if ($this->session->userdata('fc_session_user_id')) {
                     if ($MyWishLists->num_rows() > 0) {
                         ?>
                  <li>
                     <div class="dropdown">


                        <button class="dropdown-toggle" type="button" data-toggle="dropdown"><?php if ($this->lang->line('Save') != '') { echo stripslashes($this->lang->line('Save')); } else echo "Save"; ?>
                        </button>
                        <ul class="dropdown-menu listings wishLis">
                           <div class="dropdownIcon"></div>
                           <div class="heading">
                              <div><?php if ($this->lang->line('Wish_list') != '') {
                                 echo stripslashes($this->lang->line('Wish_list'));
                                 } else echo "Wishlist"; ?></div>
                              <div onclick="javascript:window.location.href='<?php echo base_url(); ?>users/<?php echo $loginCheck; ?>/wishlists'"
                                 style="cursor: pointer;"><?php if ($this->lang->line('view_wish_list') != '') {
                                 echo stripslashes($this->lang->line('view_wish_list'));
                                 } else echo "View Wish Lists"; ?>
                              </div>
                           </div>
                           <?php
                              foreach ($MyWishLists->result() as $myWishes) {
                                  ?>
                           <div class="listings_R">
                              <div>
                                 <div class="h7"><?php echo $myWishes->name; ?></div>
                                 <a href="<?php echo base_url(); ?>user/<?php echo $loginCheck; ?>/wishlists/<?php echo $myWishes->id; ?>"><?php if ($this->lang->line('view_wish_list') != '') {
                                 echo stripslashes($this->lang->line('view_wish_list'));
                                 } else echo "View Wish Lists"; ?></a>
                              </div>
                              <div>
                                 <a href="<?php echo base_url(); ?>user/<?php echo $loginCheck; ?>/wishlists/<?php echo $myWishes->id; ?>"
                                    class="imgBlock"></a>
                              </div>
                           </div>
                           <?php
                              }
                              ?>
                        </ul>
                     </div>
                  </li>
                  <?php }
                     if ($latestBookedTrips->num_rows() > 0) { ?>
                  <li>
                     <div class="dropdown">


                        <button class="dropdown-toggle" type="button" data-toggle="dropdown"><?php if ($this->lang->line('tribs') != '') {
                                 echo stripslashes($this->lang->line('tribs'));
                                 } else echo "Trips"; ?>
                        </button>
                        <ul class="dropdown-menu listings">
                           <div class="dropdownIcon"></div>
                           <div class="heading">
                              <div><?php if ($this->lang->line('tribs') != '') {
                                 echo stripslashes($this->lang->line('tribs'));
                                 } else echo "Trips"; ?></div>
                              <div
                                 onclick="javascript:window.location.href='<?php echo base_url(); ?>trips/upcoming'"
                                 style="cursor: pointer;"><?php if ($this->lang->line('view_tribs') != '') {
                                 echo stripslashes($this->lang->line('view_tribs'));
                                 } else echo "View Trips"; ?>
                              </div>
                           </div>
                           <?php
                              foreach ($latestBookedTrips->result() as $bookedRentals):
                                  ?>
                           <div class="listings_R">
                              <div>
                                 <a href="<?php echo base_url(); ?>rental/<?php echo $bookedRentals->seourl; ?>"
                                    class="color1">
                                    <div>
                                       <span
                                          class="h7"><?php echo ucfirst($bookedRentals->product_title); ?> </span>
                                       - <?php if ($this->lang->line('Booked') != '') {
                                 echo stripslashes($this->lang->line('Booked'));
                                 } else echo "Booked"; ?>


                                    </div>
                                    <div class="reduceFont"><span
                                       class="number_s120"> <?php echo date('d', strtotime($bookedRentals->checkin)); ?> </span> <?php echo date('M', strtotime($bookedRentals->checkin)); ?>
                                       - <span
                                          class="number_s120"> <?php echo date('d', strtotime($bookedRentals->checkout)); ?> </span> <?php echo date('M', strtotime($bookedRentals->checkout)); ?>
                                       · <span
                                          class="number_s120"> <?php echo $bookedRentals->NoofGuest; ?> </span> <?php echo ($bookedRentals->NoofGuest > 1) ? 'guests' : 'guest'; ?>
                                    </div>
                                 </a>
                              </div>
                              <div>
                                 <?php
                                    $imageUrl = 'dummyProductImage.jpg';
                                    if ($bookedRentals->product_image != "" && file_exists('./images/rental/' . $bookedRentals->product_image)) {
                                        $imageUrl = $bookedRentals->product_image;
                                    }
                                    ?>
                                 <a href="#" class="imgBlock"
                                    style='background-image: url("<?php echo base_url(); ?>images/rental/<?php echo $imageUrl; ?>");'></a>
                              </div>
                           </div>
                           <?php endforeach; ?>
                        </ul>
                     </div>
                  </li>
                  <?php } ?>
                  <li>
                     <div class="dropdown">
                        <button class="dropdown-toggle" type="button" data-toggle="dropdown"><?php if ($this->lang->line('Messages') != '') {
                                 echo stripslashes($this->lang->line('Messages'));
                                 } else echo "Messages"; ?>
                        </button>



                        <ul class="dropdown-menu listings msg">
                           <div class="dropdownIcon"></div>
                           <a href="<?php echo base_url(); ?>inbox">
                              <li class="listings_R">

                                 <div>
                                    <h6><?php if ($this->lang->line('Message') != '') {
                                 echo stripslashes($this->lang->line('Message'));
                                 } else echo "Message"; ?> <span class="number_s120">(<?php echo $property_msg_count; ?>)</span></h6>


                                 </div>
                                 <div><span class="viewAll"
                                    onclick="javascript:window.location.href='<?php echo base_url(); ?>inbox'"> <?php if ($this->lang->line('view_all') != '') {
                                 echo stripslashes($this->lang->line('view_all'));
                                 } else echo "View All"; ?></span>
                                 </div>
                              </li>



                           </a>
                           <?php
                              if ($experienceExistCount > 0) {
                                  if (!empty($userDetails)) {

                                      ?>
                           <a href="<?php echo base_url(); ?>experience_inbox">
                              <li class="listings_R">
                                 <div>
                                    <h6><?php if ($this->lang->line('experience_message') != '') {
                                 echo stripslashes($this->lang->line('experience_message'));
                                 } else echo "Experience Message"; ?> <span
                                       class="number_s120">(<?php echo $experience_msg_count; ?>
                                       )</span>
                                    </h6>



                                 </div>
                                 <div><span class="viewAll"
                                    onclick="javascript:window.location.href='<?php echo base_url(); ?>experience_inbox'"><?php if ($this->lang->line('view_all') != '') {
                                 echo stripslashes($this->lang->line('view_all'));
                                 } else echo "View All"; ?></span>
                                 </div>
                              </li>
                           </a>
                           <?php }
                              } ?>
                        </ul>
                     </div>
                  </li>


                  <li>
                     <div class="dropdown">
                        <button class="dropdown-toggle" type="button" data-toggle="dropdown">
                           <div class="userIcon">
                              <?php
                                 if ($userDetails->row()->image != '' && file_exists('./images/users/' . $userDetails->row()->image)) {
                                     $imgSource = "images/users/" . $userDetails->row()->image;
                                 } else {
                                     $imgSource = "images/users/profile.png";
                                 }
                                 echo img($imgSource, TRUE, array());
                                 ?>
                           </div>
                        </button>
                        <ul class="dropdown-menu">
                           <div class="dropdownIcon"></div>
                           <li>
                              <a href="<?php echo base_url(); ?>dashboard"><?php if ($this->lang->line('header_dashboard') != '') {
                                 echo stripslashes($this->lang->line('header_dashboard'));
                                 } else echo "Dashboard"; ?></a>
                           </li>
                           <li>
                              <a href="<?php echo base_url(); ?>listing/all"><?php if ($this->lang->line('header_listing') != '') {
                                 echo stripslashes($this->lang->line('header_listing'));
                                 } else echo "Your Listings"; ?></a>
                           </li>
                           <?php
                              if ($experienceExistCount > 0) {
                                  ?>
                           <li>
                              <a href="<?php echo base_url(); ?>experience/all"><?php if ($this->lang->line('My Experiences List') != '') {
                                 echo stripslashes($this->lang->line('My Experiences List'));
                                 } else echo "My Experiences List"; ?></a>
                           </li>
                           <?php } ?>
                           <li>
                              <a href="<?php echo base_url(); ?>listing-reservation"><?php if ($this->lang->line('YourReservations') != '') {
                                 echo stripslashes($this->lang->line('YourReservations'));
                                 } else echo "Your Reservations"; ?></a>
                           </li>
                           <li>
                              <a href="<?php echo base_url(); ?>trips/upcoming"><?php if ($this->lang->line('your_trips') != '') {
                                 echo stripslashes($this->lang->line('your_trips'));
                                 } else echo "Your Trips"; ?></a>
                           </li>
                           <li>
                              <a href="<?php echo base_url(); ?>users/<?php echo $loginCheck; ?>/wishlists"><?php if ($this->lang->line('wish_list') != '') {
                                 echo stripslashes($this->lang->line('wish_list'));
                                 } else echo "Wish List"; ?></a>
                           </li>
                           <li>
                              <a href="<?php echo base_url(); ?>settings"><?php if ($this->lang->line('settings_edit_prof') != '') {
                                 echo stripslashes($this->lang->line('settings_edit_prof'));
                                 } else echo "Edit Profile"; ?></a>
                           </li>
                           <li>
                              <a href="<?php echo base_url(); ?>account-payout"><?php if ($this->lang->line('referrals_account') != '') {
                                 echo stripslashes($this->lang->line('referrals_account'));
                                 } else echo "Account"; ?></a>
                           </li>
                           <li>
                              <a href="<?php echo base_url(); ?>your-wallet"><?php if ($this->lang->line('Wallet') != '') {
                                 echo stripslashes($this->lang->line('Wallet'));
                                 } else echo "Wallet";
                                 echo " (" . $currencySymbol . ' ' . currency_conversion('USD',$this->session->userdata('currency_type'),$userDetails->row()->referalAmount) . ")"; ?></a>
                           </li>
						   <?php if ($this->lang->line('Logout') != '') {
                           $logout = stripslashes($this->lang->line('Logout'));
                           //echo $logout;
                           } else $logout="Logout"; ?>


                           <?php
                              if ($this->session->userdata('fc_session_user_login_type') == "facebook") {
                                  ?>
                           <li><?php echo anchor('fb-user-logout', "$logout"); ?></li>
                           <?php
                              } else {
                                  ?>
                           <li><?php echo anchor('user-logout', "$logout"); ?></li>
                           <?php
                              }
                              ?>
                        </ul>
                     </div>
                  </li>
                  <?php } else { ?>
                  <li>
                     <div class="dropdown">
                        <button class="dropdown-toggle" data-toggle="modal" data-target="#signUp"
                           type="button"
                           onclick="set_signup_and_login_link('<?= uri_string(); ?>');"><?php if ($this->lang->line('login_signup') != '') {
                           echo stripslashes($this->lang->line('login_signup'));
                           } else echo "Create  Account"; ?>
                        </button>
                     </div>
                  </li>
                  <li>
                     <div class="dropdown">
                        <button class="dropdown-toggle" data-toggle="modal" data-target="#signIn"
                           type="button"
                           onclick="set_signup_and_login_link('<?= uri_string(); ?>');"><?php if ($this->lang->line('header_login') != '') {
                           echo stripslashes($this->lang->line('header_login'));
                           } else echo "Log in"; ?>
                        </button>
                     </div>
                  </li>
                  <?php } ?>
               </ul>
            </div>
         </div>
      </header>
       <!---flash data alert message--->

      <?php if($flash_data != '') {?>
          <div class="alertDiv active" id="<?php echo $flash_data_type;?>">
              <script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 4000);</script>
              <b><span><?php echo $flash_data;?></span></b>
          </div>
      <?php } ?>
      <?php if ($this->session->flashdata('success') == TRUE): ?>
          <div class="alertDiv active"><b><?php echo $this->session->flashdata('success'); ?></b></div>
          <script>setTimeout("hideErrDiv('alert-success')", 3000);</script>
      <?php endif; ?>
      <!--Alert model-->
      <div id="model-alert" class="modal fade" role="dialog">
         <div class="modal-dialog modal-confirm">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                
                
               </div>


               <div class="modal-body">
                  <div class="signUpIn">
                     <div>
                        <h5 class="text-center" id="alert_message_content"></h5>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal"><?php if ($this->lang->line('Close') != '') { echo stripslashes($this->lang->line('Close')); } else echo "Close "; ?></button>
               </div>
            </div>
         </div>
      </div>


         <div id="model-alert-success" class="modal fade" role="dialog">
         <div class="modal-dialog modal-confirm">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <div class="icon-box">
                   

                  </div>
                 
               </div>


               <div class="modal-body">
                  <div class="signUpIn">
                     <div>
                        <p class="text-center" id="alert_message_content_success"></p>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal"><?php if ($this->lang->line('Close') != '') { echo stripslashes($this->lang->line('Close')); } else echo "Close "; ?></button>
               </div>
            </div>
         </div>
      </div>


	  <div id="model-alert-error" class="modal fade m__error" role="dialog">
         <div class="modal-dialog modal-confirm">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <div class="icon-box">
                     <i class="material-icons">&#xE87C;</i>

                  </div>
                  <h4 class="modal-title" style="color: #f15e5e;">Warning..!</h4>
               </div>


               <div class="modal-body">
                  <div class="signUpIn">
                     <div>
                        <p class="text-center" id="alert_message_content_error"></p>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal"><?php if ($this->lang->line('Close') != '') { echo stripslashes($this->lang->line('Close')); } else echo "Close "; ?></button>
               </div>
            </div>
         </div>
      </div>

      <script type="text/javascript">
         $(document).ready(function() {
       
        var Opera = (navigator.userAgent.match(/Opera|OPR\//) ? $("#mic_pic_list").hide() : $("#mic_pic_list").show());
      });
      function hideErrDiv(arg) {
      document.getElementById(arg).style.display = 'none';
      }
      function loader(){
      
        $('.loading').show();
      }
      var isChrome = !!window.chrome && !!window.chrome.webstore;
      if (!isChrome) {
      //$("#mic_pic").hide();
      }
        function startDictation_header() {
          $("#mic_pic_list").addClass("mic_pic_blink");
          if (window.hasOwnProperty('webkitSpeechRecognition')) {

      var recognition = new webkitSpeechRecognition();

      recognition.continuous = false;
      recognition.interimResults = false;

      recognition.lang = "en-US";
      recognition.start();

      recognition.onresult = function(e) {
        document.getElementById('autocomplete').value
                                 = e.results[0][0].transcript;
        recognition.stop();
        $("#mic_pic_list").removeClass("mic_pic_blink");
        $("#property_search_form").submit();

        
      };

      recognition.onerror = function(e) {
            $("#mic_pic_list").removeClass("mic_pic_blink");
        recognition.stop();
      }

    }
  }

      </script>

