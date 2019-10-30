<link rel="shortcut icon" type="image/x-icon"
         href="<?= base_url(); ?>images/logo/<?php echo $this->config->item('fevicon_image'); ?>">
<style type="text/css">
/*only for index*/
header.posHeader .searchLocation {display: none;}
.searchIconHeaderLI.hidden-lg {display: none !important;}
body {padding-top: 0px;}
.navbar-toggle.searchBtn{display: none;}
.box9{background:#000;text-align:center;position:relative}
.box9 img{width:100%;height:auto}
.box9:hover img{opacity:.5}
.box9 .box-content{padding:30px 10px 30px;background:rgba(0,0,0,.65);position:absolute;top:0;left:0;bottom:0;right:0;opacity:0}
.box9:hover .box-content{/*top:10px;left:10px;bottom:10px;right:10px;*/opacity:1}
.box9 .title{font-weight:700;color:#fff;line-height:17px;margin:5px 0;position:absolute;bottom:55%}
.box9 .icon li a{line-height:35px;border-radius:50%}
.box9 .icon li a .fa {font-size: 20px !important;margin-top: 7px;}
.box9 .icon li a .fa:hover {font-size: 20px !important;margin-top: 7px;}
/*.box9 .icon{list-style:none;padding:0;margin:0;position:absolute; top: 35%;right: 35%;}*/
.box9 .icon{list-style:none;padding:0;position: absolute;left: 0;right: 0;top: 40%;}

.box9 .icon li{display:inline-block;opacity:0;transform:translateY(40px)}
.box9:hover .icon li{opacity:1;transform:translateY(0);transition-delay:.1s;}
/*.box9:hover .icon li:first-child{transition-delay:.1s}*/
/*.box9:hover .icon li:nth-child(2){transition-delay:.2s}*/
.box9 .icon li a{display:block;width:35px;height:35px;background:#cc0000;font-size:20px;color:#fff;margin-right:0px;transition:all .35s ease 0s}


.box9 .icon li a:hover{background:#fff;color:#cc0000;}


@media only screen and (max-width:990px){.box9{margin-bottom:20px}
}
@media (min-width: 320px) and (max-width: 480px){
    .daterangepicker.dropdown-menu{left: 4px; right: 4px;}
}
@media (min-width: 481px) and (max-width: 768px){
    .daterangepicker.dropdown-menu{left: 40%; right: 2%;}
}

</style>

<div class="loader"></div>
<?php
$this->load->view('site/includes/header');
$currency_result = $this->session->userdata('currency_result');
$product = $productDetails->row();
$browser = $_SERVER['HTTP_USER_AGENT'];
$name_browser = 'Chrome';
?>
<style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Droid+Sans);
.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('<?php echo base_url();?>images/spinner.gif') 50% 50% no-repeat #ffffff;
    background-size: auto;    
/*    background: url('<?php echo base_url();?>images/map_loader.gif') 50% 50% no-repeat rgb(255,255,255);background-size: 160px 120px;*/
}346802478
@-moz-keyframes blink {0%{opacity:1;} 50%{opacity:0;} 100%{opacity:1;}} /* Firefox */
@-webkit-keyframes blink {0%{opacity:1;} 50%{opacity:0;} 100%{opacity:1;}} /* Webkit */
@-ms-keyframes blink {0%{opacity:1;} 50%{opacity:0;} 100%{opacity:1;}} /* IE */
@keyframes blink {0%{opacity:1;} 50%{opacity:0;} 100%{opacity:1;}} /* Opera and prob css3 final iteration */
img.mic_pic_blink {

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

</style>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>css/daterangepicker.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>js/moment.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/daterangepicker.js"></script>
<style type="text/css">
    .headerLeft .searchLocation {
        display: none;
    }
    #search_result_form .form-field {position: relative;}
    .form-field #mic_pic {position: absolute;top: 9px;right: 9px;width: 20px;height: 20px;}

</style>
<script type="text/javascript">
    $(".headerLeft .searchLocation").html('');
	function seecatfun(catid)
	{
		$('#categorywiseId').val(catid);
		$('#exp_search_result_form').submit();
	}


</script>
<script>
        var isChrome = !!window.chrome && !!window.chrome.webstore;
        if (!isChrome) {
  $("#mic_pic").hide();
}
  function startDictation() {
          $("#mic_pic").addClass("mic_pic_blink");
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
        $("#mic_pic").removeClass("mic_pic_blink");
        $("#home_search").trigger("click");

        
      };

      recognition.onerror = function(e) {
            $("#mic_pic").removeClass("mic_pic_blink");
        recognition.stop();
      }

    }
  }
  function slugify(text)
{
    return text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
}
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("header.posHeader").removeClass("pageHeader");
    });
</script>
<section>

<div class="preloader-wrapper">
   <div class="preloader">
     <!--   <img src="http://prorabbi.website/nila/assets/images/preloader.gif" alt="NILA">-->
         </div>
   </div>

<div class="banner-container">



<!--owl-carousel owl-theme -->
<!--<div class="banner-carousel">
<?php
$ImgSrc = 'dummyProductImage.png';
if ($adminList->slider == "on") {

    $slider_loop = 1;

    if ($SliderList->num_rows() > 0) {
        foreach ($SliderList->result() as $Slider) {
            if ($Slider->image != '') {
                $ImgSrc = $Slider->image;
            } else {
                $ImgSrc = 'dummyProductImage.png';
            }
            ?>
			<div class="item <?php if ($slider_loop == 1) {
                $slider_loop = 2; ?>active<?php } ?>">
				<div class="banner_imgs" style="background-image: url('<?php echo base_url(); ?>images/slider/<?php echo $ImgSrc; ?>');"></div>
			</div>

        <?php }
    } else {
        $ImgSrc = 'dummyProductImage.png'; ?>

			<div class="item active">
				<div class="banner_imgs" style="background-image: url('<?php echo base_url(); ?>images/slider/<?php echo $ImgSrc; ?>');"></div>
			</div>


		<?php } ?>
		<?php } else {
} ?>


</div>---- us-hi-lahaina-0011 --->

    <div class="banner-container-bg" style="background-image: url('<?php echo base_url(); ?>images/slider/<?php echo $ImgSrc; ?>');"></div>

	<div class="container banner__content">
		<div class="mob-banner-h1">
			<h1><?php if ($this->lang->line('Book_unique_homes') != '') {
                echo stripslashes($this->lang->line('Book_unique_homes'));
            } else {
                "Book unique homes and";
            } ?>
            <div><?php if ($this->lang->line('experience_a_city') != '') {
                    echo stripslashes($this->lang->line('experience_a_city'));
                } else {
                   echo "experience a city like a local.";
                } ?></div></h1>
		</div> 
       <div class="col-lg-12 col-md-5 col-sm-7 banner-form visible-lg">
			<h1><?php if ($this->lang->line('Book_unique_homes') != '') {
                echo stripslashes($this->lang->line('Book_unique_homes'));
            } else {
                "Book unique homes and";
            } ?>
            <div><?php if ($this->lang->line('experience_a_city') != '') {
                    echo stripslashes($this->lang->line('experience_a_city'));
                } else {
                   echo "experience a city like a local.";
                } ?></div></h1><br>
       </div>
        <div class="col-lg-12 col-md-5 col-sm-7 banner-form searchForm" >

        <form name="search_properties" method="get" autocomplete="off" action="<?php echo base_url(); ?>property" id="search_result_form">
               <!--  <form name="search_properties" method="get" autocomplete="off" action="explore-experience" style="display: none;" id="search_result_form_exp"> -->
			<div class="form-field">
				<!-- <label><?php if ($this->lang->line('Where') != '') { echo stripslashes($this->lang->line('Where')); } else {
                    echo $this->lang->line("Where"); } ?></label> -->
                       <?php if ($this->lang->line('Please Enter the Location') != '') { $enter_location= stripslashes($this->lang->line('Please Enter the Location')); } else {
                    $enter_location= $this->lang->line("Please Enter the Location"); } ?>
				<input type="text" required="required" name="city" style="width: 100%;" placeholder="<?php  echo $enter_location; ?>" id="autocomplete" placeholder="<?php echo $enter_location ?>" required >
                <?php if (strpos($browser, $name_browser) !== false) { ?>	
                <img id="mic_pic" style="float: right;display: block;" src="images/googlemic.png" onclick="startDictation();"> 
                <?php } ?>		
			</div>
			<div class="form-field">
               <!--  <label><?php if ($this->lang->line('date') != '') { echo stripslashes($this->lang->line('date')); } else {
                    echo $this->lang->line("Date"); } ?></label> -->
				<div class="input-left">
				   <label><?php //if($this->lang->line('check_in') != ''){ echo stripslashes($this->lang->line('check_in')); } else { echo $this->lang->line('check_in'); } ?></label>
					<input type="text" id="startDate" readonly="readonly" placeholder="<?php if($this->lang->line('check_in') != ''){ echo stripslashes($this->lang->line('check_in')); } else { echo $this->lang->line('check_in'); } ?>" name="checkin">
				</div>
				<div class="input-right">
					<label><!-- <?php if($this->lang->line('check_out') != ''){ echo stripslashes($this->lang->line('check_out')); } else { echo $this->lang->line('check_out'); } ?> --></label>
					<input type="text" id="endDate" readonly="readonly" placeholder="<?php if($this->lang->line('check_out') != ''){ echo stripslashes($this->lang->line('check_out')); } else { echo $this->lang->line('check_out'); } ?>" name="checkout">
				</div>
			</div>

            <div class="form-field">
                <button class="banner-sub-btn theme-btn" type="submit" name="cmd">
                    <?php if ($this->lang->line('Search') != '') {
                        echo stripslashes($this->lang->line('Search'));
                    } else {
                        echo $this->lang->line("Search");
                    } ?> 
                    <!-- <i class="fa fa-search" aria-hidden="true"></i> -->
                </button>
            </div>

			<!-- <button class="banner-sub-btn" type="submit" name="cmd"><?php if ($this->lang->line('Search') != '') {
                    echo stripslashes($this->lang->line('Search'));
                } else {
                    echo $this->lang->line("Search");
                } ?></button> -->

            <!---
			<div class="banner-form-txt">
				<hr>
			</div>
			<div class="form-field-div">
				<ul>
					<li>
					<button  id="home_search" type="submit" onclick="search_form();" name="cmd" class="active form-field-btn"><?php if ($this->lang->line('homes') != '') { echo stripslashes($this->lang->line('homes'));  } else { echo "Homes"; } ?></button></li>
					<li>	<button type="button" onclick="search_form_exp();" class="form-field-btn"><?php if ($this->lang->line('explore-experience') != '') { echo stripslashes($this->lang->line('experience'));  } else { echo "Experience"; } ?></button></li>
					<li><a href="<?php echo base_url(); ?>all_listing" class="form-field-btn"><?php if ($this->lang->line('All') != '') { echo stripslashes($this->lang->line('All'));  } else { echo "All"; } ?></a></li>
				</ul>
				</div>

            -->
            </form>
	   </div>
    </div>
	
	

    <?php
        /*
            <div class="">
        <div class="">
            <?php if($adminList->slider == "on") { ?>
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ul class="carousel-inner">

                     <?php

                     $slider_loop=1;

                     foreach ($SliderList->result() as $Slider){

                if($Slider->image !=''){

                    $ImgSrc=$Slider->image;

                }else{

                    $ImgSrc='dummyProductImage.jpg';

                }
                  ?>
                <li class="item <?php if($slider_loop==1){ $slider_loop=2;?>active<?php }?>">
                <img src="images/slider/<?php echo $ImgSrc;?>" alt="<?php echo $Slider->slider_title; ?>">
                </li>
                <?php } ?>
                </ul>
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                   <span class="fa fa-chevron-left"></span></a><a class="right carousel-control"
                        href="#carousel-example-generic" data-slide="next"><span class="fa fa-chevron-right">
                        </span></a>
            </div>
            <?php } else { ?>
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                     <ul class="carousel-inner">

                    <?php
                    if($SliderList->row()->image !='')
                    {

                        $ImgSrc=$SliderList->row()->image;

                    }
                    else
                    {
                        $ImgSrc='dummyProductImage.jpg';

                    }
                    ?>
                    <?php $imagepath ="images/slider/"; ?>
                    <li class="item active" style="height: 600px;">
        <section class="content-section video-section" style="position: relative; height: 600px;">
            <div class="pattern-overlay">
        <?php {?>
        <iframe width="100%" height="130%" id="ytplayer" type="text/html" src="<?php echo $adminList->videoUrl;?>?playlist=&start=60&rel=0&autoplay=1&controls=0&showinfo=0&loop=1&iv_load_policy=3&enablejsapi=1" frameborder="0" ></iframe>
<?php } ?>
            </div>
        </section>
            </li>
            </ul>
            </div>
            <?php } ?>

            <div class="main-text hidden-xs">
                <div class="col-md-12 text-center">

                    <div class="container">
                    <h1><?php
                     if($adminList->home_title_1 != ''){
                        echo $adminList->home_title_1;
                    }
                    else{

                    if($this->lang->line('WELCOMEHOME') != '') { echo stripslashes($this->lang->line('WELCOMEHOME')); } else echo "WELCOME HOME";}  ?></h1>

                    <p style="font-size: 25px; color:  #111;"><?php
                         if($adminList->home_title_2 != ''){
                        echo $adminList->home_title_2;
                    }
                    else{
                    if($this->lang->line('Rentuniqueplacestostay') != '') { echo stripslashes($this->lang->line('Rentuniqueplacestostay')); } else echo "Rent unique places to stay"; }  ?></p>
                    </div>
            </div>
            </div>


         </div>
    </div>
        */
    ?>
</div>


<!--<div>
<?php
//if ($SliderList->num_rows() > 0 ){
	//foreach ($SliderList->result() as $slider){ ?>
		<img src="<?php// echo base_url()?>images/slider/<?php// echo $slider->image; ?>">
	<?php //}

//}
?>
</div>-->




</section>
<section style="margin-top: 50px;">
    <div class="container">
        <div class="rowHead">
        <h3><?php if ($this->lang->line('explore_homestay') != '') {
                echo stripslashes($this->lang->line('explore_homestay'));
            } else echo "Explore Homestay"; ?></h3>

        </div>
        <div class="clearfix"></div>
        <div class="exploreBlock">
            <div class="row">
                <div class="col-sm-4">
                    <!-- <a id="explore_listing_mic" href="<?php echo base_url(); ?>explore_listing"> -->
                        <div class="split_item clear box9">
                            <div class="exploreImg" style="background-image: url('images/exploreIcon.jpg')"></div>
                            <div class="box-content">
                            
                                <ul class="icon">
                                <li><a title="<?php if ($this->lang->line('allHomes') != '') {
                                    echo stripslashes($this->lang->line('allHomes'));
                                } else echo "All Homes"; ?>" href="<?php echo base_url(); ?>explore_listing"><i style="font-size:30px" class="fa fa-home"></i></a></li>
                                <li><a title="<?php if ($this->lang->line('nearHomes') != '') {
                                    echo stripslashes($this->lang->line('nearHomes'));
                                } else {echo "Nearby Homes";} ?>" href="<?php if($nearby_city_is != ''){echo base_url().'property?city='.$nearby_city_is;}else{echo base_url().'explore_listing';} ?>"><i style="font-size:30px" class="fa fa-map-marker"></i></a></li>
                            </ul>
                           </div>
                       
                        <a href="<?php echo base_url(); ?>explore_listing"><h4><?php if ($this->lang->line('Homes') != '') {
                                    echo stripslashes($this->lang->line('Homes'));
                                } else echo "Homes"; ?></h4></a>
                    
                </div>
            </div>
                <div class="col-sm-4">
                    <!-- <a href="<?php echo base_url(); ?>property?city=<?php echo $nearby_city_is; ?>"> -->
                        <div class="split_item clear  box9">
                            <div class="exploreImg" style="background-image: url('images/exploreIcon1.jpg')"></div>
                             <div class="box-content">
                          
                                <ul class="icon">
                                <li><a title="<?php if ($this->lang->line('allexp') != '') {
                                    echo stripslashes($this->lang->line('allexp'));
                                } else echo "All Experiences"; ?>" href="<?php echo base_url(); ?>explore-experience"><i style="font-size:30px" class="fa fa-home"></i></a></li>
                                <li><a title="<?php if ($this->lang->line('nearexp') != '') {
                                    echo stripslashes($this->lang->line('nearexp'));
                                } else echo "Nearby Experiences"; ?>"  href="<?php if($nearby_city_is != ''){echo base_url().'explore-experience?city='.$nearby_city_is;}else{echo base_url().'explore-experience';} ?>"><i style="font-size:30px" class="fa fa-map-marker"></i></a></li>
                            </ul>
                            </div>
                          <a href="<?php echo base_url(); ?>explore-experience"><h4><?php if ($this->lang->line('Experiences') != '') {
                                    echo stripslashes($this->lang->line('Experiences'));
                                } else echo "Experiences"; ?></h4></a>
                    
                </div>
            </div>
            <div class="col-sm-4">
                    <a href="<?php echo base_url(); ?>popular"> 
                        <div class="split_item clear  box9">
                            <div class="exploreImg" style="background-image: url('images/exploreIcon.jpg')"></div>
                            <!-- <div class="box-content">
                          
                                <ul class="icon">
                                <li><a title="<?php if ($this->lang->line('allexp') != '') {
                                    echo stripslashes($this->lang->line('allexp'));
                                } else echo "All Experiences"; ?>" href="<?php echo base_url(); ?>explore-experience"><i style="font-size:30px" class="fa fa-home"></i></a></li>
                                <li><a title="<?php if ($this->lang->line('nearexp') != '') {
                                    echo stripslashes($this->lang->line('nearexp'));
                                } else echo "Nearby Experiences"; ?>"  href="<?php if($nearby_city_is != ''){echo base_url().'explore-experience?city='.$nearby_city_is;}else{echo base_url().'explore-experience';} ?>"><i style="font-size:30px" class="fa fa-map-marker"></i></a></li>
                            </ul>
                            </div> -->
                            <!-- <a href="<?php echo base_url(); ?>popular"> --><h4><?php if ($this->lang->line('popular') != '') {
                                    echo stripslashes($this->lang->line('popular'));
                                } else echo "Popular"; ?></h4>
                        </div>
                    </a>
                </div> 
            <div class="col-sm-3" style="display: none;">
                     <a <?php echo ( $user_id_is =='' ? 'data-toggle="modal" data-target="#signIn"' : 'href="'.base_url().'"users/"'.$user_id_is.'"/wishlists"'); ?>> 
                        <div class="split_item clear  box9">
                            <div class="exploreImg" style="background-image: url('images/exploreIconwishlist.png')"></div>
                            <!-- <div class="box-content">
                          
                                <ul class="icon">
                                <li><a title="<?php if ($this->lang->line('allexp') != '') {
                                    echo stripslashes($this->lang->line('allexp'));
                                } else echo "All Experiences"; ?>" href="<?php echo base_url(); ?>explore-experience"><i style="font-size:30px" class="fa fa-home"></i></a></li>
                                <li><a title="<?php if ($this->lang->line('nearexp') != '') {
                                    echo stripslashes($this->lang->line('nearexp'));
                                } else echo "Nearby Experiences"; ?>"  href="<?php if($nearby_city_is != ''){echo base_url().'explore-experience?city='.$nearby_city_is;}else{echo base_url().'explore-experience';} ?>"><i style="font-size:30px" class="fa fa-map-marker"></i></a></li>
                            </ul>
                            </div> -->
                            <h4 style="cursor: pointer;"><?php if ($this->lang->line('wishlist') != '') {
                                    echo stripslashes($this->lang->line('wishlist'));
                                } else echo "Wishlist"; ?></h4>
                        </div>
                    </a>
                </div> 
              <!--   <div class="col-sm-3">
                    <a id="explore_experience_mic" href="<?php echo base_url(); ?>explore-experience">
                        <div class="split_item clear">
                            <div class="exploreImg" style="background-image: url('images/exploreIcon1.jpg')"></div>
                            <div class="box-content">
                            <h4><?php if ($this->lang->line('Experiences') != '') {
                                    echo stripslashes($this->lang->line('Experiences'));
                                } else echo "Experiences"; ?></h4>
                            </div>
                        </div>
                    </a>
                </div> -->
                <!-- <div class="col-sm-3">
                    <a href="<?php echo base_url(); ?>explore-experience?city=<?php echo $nearby_city_is; ?>">
                        <div class="split_item clear">
                            <div class="exploreImg" style="background-image: url('images/nearby.png')"></div>
                            <h4><?php if ($this->lang->line('nearby_exp') != '') {
                                    echo stripslashes($this->lang->line('nearby_exp'));
                                } else echo "Nearby Experiences"; ?></h4>
                        </div>
                    </a>
                </div> -->
            </div>
        
    </div>
</section>
<?php
if ($experienceExistCount > 0) {
    if ($featuredExperiences->num_rows() > 0) {
        ?>
        <section>
            <div class="container">
                <div class="rowSpace">
                    <div class="rowHead clear">
                        <h3><?php if ($this->lang->line('featured_experience') != '') {
                                echo stripslashes($this->lang->line('featured_experience'));
                            } else echo "Featured Experience"; ?></h3>
                    </div>
                    <div class="owl-carousel owl-theme experience-carousel">
                        <?php
                        foreach ($featuredExperiences->result() as $experience) {

                            $cur_Date = date('Y-m-d');

                            /*$sel_price = "select min(price) as min_price,currency from " . EXPERIENCE_DATES . " where experience_id ='" . $experience->experience_id . "' and status='1' and from_date>'" . $cur_Date . "'";

                            $priceData = $this->landing_model->ExecuteQuery($sel_price);
                            if ($priceData->num_rows() > 0) {
                                $experience_currency = $priceData->row()->currency;
                                $experience_price = $priceData->row()->min_price;
                            } else {
                                $experience_currency = $this->session->userdata('currency_type');
                                $experience_price = 0;
                            }*/
                            $experience_currency = $experience->currency;
                            $experience_price = $experience->price;
                            $base=base_url();
                            $img_base = realpath('images/experience/' . $experience->product_image);
                            $url = getimagesize($img_base);
                            if (!is_array($url)) {
                                $img = "1";
                            } else {
                                $img = "0";
                            }
                            ?>
                            <div class="item">
                                <a href="<?php echo base_url(); ?>view_experience/<?php echo $experience->experience_id; ?>" target="_blank" >
                                    <?php if ($experience->product_image != '' && $img == '0') { ?>
                                        <div class="myPlace"
                                             style="background-image: url('<?php echo base_url(); ?>images/experience/<?php echo $experience->product_image; ?>')"></div>
                                    <?php } else { ?>
                                        <div class="myPlace"
                                             style="background-image: url('<?php echo base_url(); ?>images/experience/dummyProductImage.jpg')"></div>
                                    <?php } ?>
                                    <div class="bottom">
                                        <div class="loc">
										<?php

											if ($experience->city!='' && $experience->type_title!='') {
												//echo $experience->type_title . " . " . $experience->city;
                                                $prod_tiltle=language_dynamic_enable("experience_title",$this->session->userdata('language_code'),$experience);

                                                $prod_tiltle1=language_dynamic_enable("city", $this->session->userdata('language_code'), $experience);
                                                    //echo ucfirst($prod_tiltle1);
                                                    echo ucfirst($prod_tiltle." ". $prod_tiltle1);

											}else if ($experience->type_title!=''){
												//echo $experience->type_title;
                                                $prod_tiltle=language_dynamic_enable("type_title",$this->session->userdata('language_code'),$experience);
                                                    echo ucfirst($prod_tiltle);
											}else if ($experience->city=''){
												//echo $experience->city;
                                                $prod_tiltle=language_dynamic_enable("city",$this->session->userdata('language_code'),$experience);
                                                    echo ucfirst($prod_tiltle);
											}

										?>
										</div>
                                        <h5><?php
                                      //  print_r($featuredExperiences->result());
                                            $prod_tiltle=language_dynamic_enable("experience_title",$this->session->userdata('language_code'),$experience);
                                             echo ucfirst($prod_tiltle);

                                            ?></h5>
                                        <div class="price"><span class="number_s"><?php
                                                if ($experience_currency != $this->session->userdata('currency_type')) {
                                                    echo $currencySymbol;
                                                    if ($currency_result->$experience_currency) {
                                                        //$price = $experience_price / $currency_result->$experience_currency;
														$price = currency_conversion($experience_currency, $this->session->userdata('currency_type'), $experience_price);
                                                    } else {
                                                        $price = currency_conversion($experience_currency, $this->session->userdata('currency_type'), $experience_price);
                                                    }
                                                    echo number_format($price, 2);
                                                } else {
                                                    echo $currencySymbol;
                                                    $priceExp = $experience_price;
                                                    echo number_format($priceExp, 2);
                                                }
                                                ?></span> <?php echo $this->session->userdata('currency_type');?>
                                            <?php
                                            if($this->lang->line('per_person') != '') {
                                                echo $per= stripslashes($this->lang->line('per_person'));
                                            } else echo $per= "per person";
                                            ?>
                                        </div>
                                        <div class="clear">
                                            <div class="starRatingOuter">
                                                <?php
                                                $avg_val = round($experience->avg_val);
                                                $num_reviewers = $experience->num_reviewers;
                                                ?>
                                                <div class="starRatingInner"
                                                     style="width: <?php echo($avg_val * 20); ?>%;"></div>
                                            </div>
                                            <span class="ratingCount"><?php echo $num_reviewers; ?><?php if ($this->lang->line('Reviews') != '') {
                                                    echo stripslashes($this->lang->line('Reviews'));
                                                } else echo "Reviews"; ?></span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}
//echo '<pre>';print_r($CityDetails->num_rows());exit;
if ($CityDetails->num_rows() > 0) {
    foreach ($CityDetails->result() as $CityRows) {
        $city_name = $CityRows->name;
    //  echo '<pre>';  print_r($city_name);
        if ($CityRows->state_name != '') {
            $StateNameLi = "," . str_replace(' ', '+', $CityRows->state_name);
        } else {
            $StateNameLi = "";
        }
        if ($CityRows->country != '') {
            $CountryLi = "," . str_replace(' ', '+', $CityRows->country);
        } else {
            $CountryLi = "";
        }
       // echo '<pre>';  print_r($city_name);
        if (count($CityName[$city_name]) > 0) {
            ?>
            <section class="card-section">
                <div class="container">
                    <div class="rowSpace dev">
                        <div class="rowHead clear" data-alt="test">
                            <h3><?php if ($this->lang->line('Home in') != '') {
                                    echo stripslashes($this->lang->line('Home in'));
                                } else echo "Home in"; ?>
                                <?php 
                                // if($this->session->userdata('language_code') =='en')
                                //     {
                                //         $cityname = $CityRows->name;
                                //     }
                                //     else
                                //     {
                                //         $cityAr='name_'.$this->session->userdata('language_code');
                                //         if($CityRows->$cityAr == '') { 
                                //             $cityname=$CityRows->$cityAr;
                                //         }
                                //         else{
                                //             $cityname=$CityRows->$cityAr;
                                //         }
                                //     }
                                      $cityname=language_dynamic_enable("name",$this->session->userdata('language_code'),$CityRows);
                                 //echo '<pre>'; print_r($CityRows) ;
                                echo ucfirst($cityname); ?></h3>
                            <!-- <a href="<?= base_url(); ?>property?city=<?php echo $city_name . $StateNameLi . $CountryLi; ?>"
                               class="seeAll"><?php if ($this->lang->line('See_all') != '') {
                                    echo stripslashes($this->lang->line('See_all'));
                                } else echo "See all"; ?> <span class="icon">></span></a> -->
                        </div>

                    <div class="card-section-bg">
                            
                        <div class="owl-carousel owl-theme homes-carousel">
                                <?php foreach ($CityName[$city_name] as $CityRowss) {
                                    //print_r($CityRowss);
                                    ?>
                                    <div class="item" >
                                        <a href="<?php echo base_url(); ?>rental/<?php echo $CityRowss->seourl; ?>" target="_blank">
                                            <?php
                                            $base=base_url();
                                            $img_base = realpath('images/rental/' . $CityRowss->product_image);
                                            $url = getimagesize($img_base);

                                            if (!is_array($url)) {
                                                $img = "1"; //no
                                            } else {
                                                $img = "0";  //yes
                                            }
                                            if ($CityRowss->product_image != '' && $img == '0') { ?>
                                                <div class="card-image"><div class="myPlace"
                                                     style="background-image: url('<?php echo base_url(); ?>images/rental/<?php echo $CityRowss->product_image; ?>')"></div></div>
                                            <?php } else { ?>
                                                <div class="card-image"><div class="myPlace"
                                                     style="background-image: url('<?php echo base_url(); ?>images/rental/dummyProductImage.jpg')"></div></div>
                                            <?php } ?>
                                            <div class="bottom">
                                               <div class="loc" style="display: none;">
                                               <?php
                                                $list_value_val=language_dynamic_enable("list_value",$this->session->userdata('language_code'),$CityRowss);
     echo ucfirst($list_value_val.' ');
     $city_val=language_dynamic_enable("city",$this->session->userdata('language_code'),$CityRowss);
     echo ucfirst($city_val);
                                                        
                                                  
                                                  
                                            ?> </div>
                                                <h5><?php 
                                                   
                                                 $prod_tiltle=language_dynamic_enable("product_title",$this->session->userdata('language_code'),$CityRowss);
     //echo ucfirst($city_val);
                                                 echo ucfirst($prod_tiltle);
                                                 // echo ucfirst($CityRowss->product_title);

                                                    ?> </h5>
                                                <?php
                                                $avg_val = round($CityRowss->avg_val);
                                                $num_reviewers = $CityRowss->num_reviewers;
                                                ?>
                                                <div class="price"><span class="number_s"><?php
                                                        if ($CityRowss->currency != $this->session->userdata('currency_type')) {
                                                            echo $currencySymbol;
                                                            $currency = $CityRowss->currency;
                                                            if ($currency_result->$currency) {
                                                               // $price = $CityRowss->price / $currency_result->$currency;
                                                               $price = currency_conversion($currency, $this->session->userdata('currency_type'), $CityRowss->price);
                                                            } else {
                                                                $price = currency_conversion($currency, $this->session->userdata('currency_type'), $CityRowss->price);
                                                            }
                                                            echo number_format($price, 2);
                                                        } else {
                                                            echo $currencySymbol;
                                                            $price = $CityRowss->price;
                                                            echo number_format($price, 2);
                                                        } ?></span><?php echo $this->session->userdata('currency_type');
                                                        ?>
                                                         <?php if($CityRowss->instant_pay == 'Yes'){ ?><svg fill="currentColor" preserveAspectRatio="xMidYMid meet" height="1em" width="1em" viewBox="0 0 40 40" class="svg_instsant_pay" style="vertical-align: middle;"><g><path d="m29.8 12.6q0.4 0.5 0.1 1l-12 25.8q-0.3 0.6-1 0.6-0.1 0-0.3 0-0.4-0.2-0.6-0.5t-0.1-0.6l4.4-18.1-9 2.3q-0.1 0-0.3 0-0.4 0-0.7-0.2-0.4-0.4-0.3-0.9l4.5-18.4q0.1-0.3 0.4-0.5t0.6-0.2h7.3q0.4 0 0.7 0.2t0.3 0.7q0 0.2-0.1 0.4l-3.8 10.3 8.8-2.2q0.2 0 0.3 0 0.4 0 0.8 0.3z"></path></g></svg><?php } ?>
                                                        <?php
                                                            if($this->lang->line('per_night') != '') {
                                $per= stripslashes($this->lang->line('per_night'));
                            } else $per= "per night"; ?>
                                                     <span style="font-size:14px;"><?php echo $per;  ?> </span> 
                                                </div>
                                            <div class="bottom-text">
                                                <p>
                                                    Lorem ipsum dolor sit amet, in elit nominati usu. Mei ea vivendo maluisset, hinc graece facilisis pr [more]
                                                </p>
                                            </div>
                                            <div class="bottom-icons">
                                                <span class="user-limit">5</span>
                                            </div>
                                                <div class="clear">
                                                    <div class="starRatingOuter">
                                                        <div class="starRatingInner"
                                                             style="width: <?php echo($avg_val * 20); ?>%;"></div>
                                                    </div>
                                                    <span
                                                            class="ratingCount"> <?php echo $num_reviewers . " "; ?><?php if ($this->lang->line('Reviews') != '') {
                                                            echo stripslashes($this->lang->line('Reviews'));
                                                        } else echo "Reviews"; ?> </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                </div>
                    </div>
                </div>
            </section>
            <?php
        }
    }
}
if (count($adv_result) > 0) {
    foreach ($adv_result as $data) {
        ?>
        <section>
            <div class="container">
                <div class="frontAdd">
                    <div class="row">
                        <div class="col-md-6 swapBlock">
                            <img src="<?php echo base_url() ?>images/advertisment/<?php echo $data->image; ?>">
                        </div>
                        <div class="col-md-6 swapBlock">
                            <h3 class="swapBlock__title"><?php 
                            if($this->session->userdata('language_code') =='en')
                                    {
                                        $adv_title = $data->title;
                                    }
                                    else
                                    {
                                        $adv_titleAr='title_'.$this->session->userdata('language_code');
                                        if($data->$adv_titleAr == '') { 
                                            $adv_title=$data->title;
                                        }
                                        else{
                                            $adv_title=$data->$adv_titleAr;
                                        }
                                    }
                                    echo $adv_title; ?></h3>
                            <h4><?php 
                            if($this->session->userdata('language_code') =='en')
                                    {
                                        $desc = $data->description;
                                    }
                                    else
                                    {
                                        $descAr='description_'.$this->session->userdata('language_code');
                                        if($data->$descAr == '') { 
                                            
                                            $desc=$data->description;
                                        }
                                        else{
                                            $desc=$data->$descAr;
                                        }
                                    }
                                    echo $desc;  ?></h4>
                            <a href="<?php echo $data->link; ?>" target="_blank"
                               class="btnStyle1 theme-btn"><?php if ($this->lang->line('See What You Can Earn') != '') {
                                    echo stripslashes($this->lang->line('See What You Can Earn'));
                                } else echo "See What You Can Earn"; ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}
if ($CityDetails->num_rows() > 0) {
    ?>
    <section>
        <div class="container">
            <div class="rowSpace">
                <div class="rowHead clear">
                   <h3><?php if ($this->lang->line('recomendes_you') != '') {
                            echo stripslashes($this->lang->line('recomendes_you'));
                        } else {
                            "Recommended for you";
                        } ?></h3>
                </div>
                <div class="owl-carousel owl-theme featured-carousel">
                    <?php
                    foreach ($CityDetails->result() as $CityRows) {
                        $Cityname = str_replace(' ', '+', $CityRows->name);
                        if ($CityRows->state_name != '') {
                            $StateName = "," . str_replace(' ', '+', $CityRows->state_name);
                        } else {
                            $StateName = " ";
                        }
                        if ($CityRows->country != '') {
                            $Country = "," . str_replace(' ', '+', $CityRows->country);
                        } else {
                            $Country = " ";
                        }
                        ?>
                        <div class="item" >
                            <a href="<?= base_url(); ?>property?city=<?php echo $Cityname . $StateName . $Country; ?>" target= "_blank">
                                <div class="myPlace"
                                     style="background-image: url('<?php echo base_url(); ?>images/city/<?php echo (file_exists('./images/city/' . $CityRows->citythumb)) ? $CityRows->citythumb : 'no-image-found.jpg'; ?>')"></div>
                                <div class="bottom">
                                    <div class="f_des"><?php
                                    if($this->session->userdata('language_code') =='en')
                                    {
                                        $cityname = $CityRows->name;
                                    }
                                    else
                                    {
                                        $cityAr='name_'.$this->session->userdata('language_code');
                                        if($CityRows->$cityAr == '') { 
                                            $cityname=$CityRows->$cityAr;
                                        }
                                        else{
                                            $cityname=$CityRows->$cityAr;
                                        }
                                    }
                                  //  echo $Ncity;
                                // echo trim(stripslashes($cityname)); ?></div>

                                 <h5><?php  $cityname=language_dynamic_enable("name",$this->session->userdata('language_code'),$CityRows);
                                    echo ucfirst($cityname); ?></h5>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}
$j = 0;
echo form_open('explore-experience', array('method' => 'POST', 'id' => 'exp_search_result_form'));
echo '<input name="type_id[]" type="hidden" id="categorywiseId">';
echo form_close();
//if ($CityDetails->num_rows() > 0) {

  //  foreach ($CityDetails->result() as $CityRows) {
        //$sel_featuredExpType = "SELECT * FROM " . EXPERIENCE_TYPE . " WHERE  featured = 1 and status='Active' ";
        //$featuredExperiencesType = $this->landing_model->ExecuteQuery($sel_featuredExpType);
		//print_r($featuredExperiencesType->result());
if ($experienceExistCount > 0) {
		if($featuredExperiences_Cat_type->num_rows() > 0 )
		{
			foreach($featuredExperiences_Cat_type->result() as $result)
			{
				$exp_type_id = $result->id;
				if ($exp_type_id != '') {

				    $get_featured_all = "select exp.*,exp.experience_title as exp_title,et.id as e_type_id,et.experience_title,ph.product_image , (select IFNULL(count(R.id),0) from " . EXPERIENCE_REVIEW . " as R where R.review_type='0' and R.product_id= exp.experience_id and R.status='Active') as num_reviewers , (select IFNULL(avg(Rw.total_review),0) from " . EXPERIENCE_REVIEW . " as Rw where Rw.review_type='0' and Rw.product_id= exp.experience_id and Rw.status='Active') as avg_val from " . EXPERIENCE . " as exp left join " . EXPERIENCE_PHOTOS . " as ph on ph.product_id=exp.experience_id inner join " . EXPERIENCE_TYPE . " as et on et.id=exp.type_id LEFT JOIN  " . EXPERIENCE_DATES . " d  on d.experience_id=exp.experience_id  where exp.status='1' and exp.type_id = " . $exp_type_id . " and  d.from_date >'" . date('Y-m-d') . "' and exp.status='1' AND EXISTS ( select c.id FROM fc_experience_dates c where c.status='0' and c.experience_id=exp.experience_id)  AND EXISTS (select count(td.id) FROM fc_experience_time_sheet td where td.status='1' and td.experience_id=exp.experience_id) group by  exp.experience_id order by exp.added_date desc limit 0,8";

					$Cat_Type[$exp_type_id] = $this->landing_model->ExecuteQuery($get_featured_all);

					//echo $Cat_Type[$exp_type_id]->num_rows();
					//exit;
					if ($Cat_Type[$exp_type_id]->num_rows() > 0){
                    ?>
						<section>
							<div class="container">
								<div class="rowSpace">
									<div class="rowHead clear">
										<h3><?php if ($this->lang->line('experiences_in') != '') {
												echo stripslashes($this->lang->line('experiences_in'));
											} else echo "Experiences in"; ?>
                                            <?php
                                                $prod_tiltle=language_dynamic_enable("experience_title",$this->session->userdata('language_code'), $Cat_Type[$exp_type_id]->row());
                                                echo " " . $prod_tiltle;
                                                //$Cat_Type[$exp_type_id]->row()->experience_title; 
                                            ?>

                                            </h3>

										<a href="javascript:;" onclick="seecatfun('<?php echo $exp_type_id;?>');"
										   class="seeAll"><?php if ($this->lang->line('See_all') != '') {
												echo stripslashes($this->lang->line('See_all'));
											} else echo "See all"; ?> <span class="icon"> </span></a>
									</div>
									<div class="owl-carousel owl-theme experience-carousel">
										<?php 
//                                         echo "<pre>";
// print_r($Cat_Type[$exp_type_id]->result());
                                        foreach ($Cat_Type[$exp_type_id]->result() as $experience) {
											$experience_currency = $experience->currency;
											$experience_price = $experience->price;
											if ($experience->product_image != '' && file_exists('images/experience/' . $experience->product_image)) {
												$ImgSrc = $experience->product_image;
											} else {
												$ImgSrc = 'dummyProductImage.jpg';
											}
											?>
											<div class="item">
												<a href="<?php echo base_url(); ?>view_experience/<?php echo $experience->experience_id; ?>">
													<div class="myPlace"
														 style="background-image: url('<?php echo base_url(); ?>images/experience/<?php echo $ImgSrc; ?>')"></div>
													<div class="bottom">

														<!--<div class="loc">Nightlife · New York</div>-->
														<div class="loc">
                                                            <?php 

                                                          //  echo $experience->location;

                                                            $prod_tiltle=language_dynamic_enable("location",$this->session->userdata('language_code'),$experience);
                                                           echo ucfirst($prod_tiltle);
                                                            ?></div>
														<h5>

                                                            <?php

															//echo ucfirst($experience->exp_title);
                                                            $prod_tiltle=language_dynamic_enable("exp_title",$this->session->userdata('language_code'),$experience);
                                                            echo ucfirst($prod_tiltle);

															?> 

                                                        </h5>
														<div class="price"><span class="number_s"><?php //echo $CityRowss->price;
																if ($experience_currency != $this->session->userdata('currency_type')) {
																	echo $currencySymbol;
																	$currency = $CityRowss->currency;
																	if ($currency_result->$experience_currency) {
																		$price = $experience_price / $currency_result->$experience_currency;
																	} else {
																		$price = currency_conversion($experience_currency, $this->session->userdata('currency_type'), $experience_price);
																	}
																	echo number_format($price, 2);
																} else {
																	echo $currencySymbol;
																	$priceEx = $experience_price;
																	echo number_format($priceEx, 2);
																}
																?></span> <?php echo $this->session->userdata('currency_type');  ?><span style="font-size:14px;"><?php if ($this->lang->line('per_person') != '') {
                                                echo ' '.stripslashes($this->lang->line('per_person'));
                                            } else echo " per person"; ?></span>
														</div>
														<div class="clear">
															<div class="starRatingOuter">
																<?php
																$avg_val = round($experience->avg_val);
																$num_reviewers = $experience->num_reviewers;
																?>
																<div class="starRatingInner"
																	 style="width: <?php echo($avg_val * 20); ?>%;"></div>
															</div>
															<span
																	class="ratingCount"><?php echo $num_reviewers; ?><?php if ($this->lang->line('Reviews') != '') {
																	echo stripslashes($this->lang->line('Reviews'));
																} else echo "Reviews"; ?></span>
														</div>
													</div>
												</a>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</section>
            <?php
					}
				}
			}
        }
}
?>


    <!-- <section>
            <div class="container">
                <div class="frontAdd">
                    <div class="row">
                        
                        <div class="col-md-6 swapBlock">
                             <h3 class="title swapBlock__title">HomesStayDNN Rental App</h3>
                             
            <h4 style="text-align: justify;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</h4>
            <div style="margin-top: 10px;" class="col-md-6">
            <a href="https://play.google.com/" target="_blank" class=""><img style="width: 210px; height: 60px;" src="<?php echo base_url(); ?>images/google-play.png"></a>
        </div>
        <div style="margin-top: 10px;" class="col-md-6">
            <a href="https://www.apple.com/" target="_blank" class=""><img style="width: 210px; height: 60px;" src="<?php echo base_url(); ?>images/apple-play.png"></a>
        </div>
                        </div>
                        <div class="col-md-6 swapBlock">
                             <img style="width: auto;" class="" src="<?php echo base_url(); ?>images/mobile-screen.png">
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
<?php

if (count($prefooter_result) > 0) {
    ?>
    <section>
        <div class="container">
            <div class="footerTop">
                <div class="row">
                    <?php
                    foreach ($prefooter_result as $pre_data) {
                        ?>
                        <div class="col-sm-4">
                            <div class="splitF_top noBorder clear">
                              <a href="<?php echo $pre_data->footer_link; ?>">  <img src="<?php echo base_url(); ?>images/prefooter/<?php echo $pre_data->image; ?>"
                                     class="icon"></a>
                                <div class="right">
                                   <a href="<?php echo $pre_data->footer_link; ?>" target="_blank"> <h5><?php 
                                 // echo $this->session->userdata('language_code');
                                    if($this->session->userdata('language_code') =='en')
                                    {
                                        $footerField = $pre_data->footer_title;
                                    }
                                    else
                                    {

                                        $footerTitleAr='footer_title_'.$this->session->userdata('language_code');
                                        if($pre_data->$footerTitleAr == '') { 
                                            $footerField=$pre_data->footer_title;
                                        }
                                        else{
                                            $footerField=$pre_data->$footerTitleAr;
                                        }
                                    }
                                    echo $footerField;
                                    ?></h5></a>
                                    <p><?php 
                                  if($this->session->userdata('language_code') =='en')
                                    {
                                        $footerDesc = $pre_data->description;
                                    }
                                    else
                                    {

                                        $footerDescAr='description_'.$this->session->userdata('language_code');
                                        if($pre_data->$footerDescAr == '') { 
                                            $footerDesc=$pre_data->description;
                                        }
                                        else{
                                            $footerDesc=$pre_data->$footerDescAr;
                                        }
                                    }
                                    echo $footerDesc;
                                     ?></p>
                                </div>
                            </div>

                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}
?>
<?php
$this->load->view('site/includes/footer');
?>
<script type="text/javascript">
   jQuery(document).ready(function($) {
     $('.loader').fadeOut();
     var Body = $('body');
     Body.addClass('preloader-site');
   });
   $(window).load(function(){
     $('.preloader-wrapper').fadeOut();
     $('body').removeClass('preloader-site');
   });
</script>

<style type="text/css">
    header {
        box-shadow: none;
    }
</style>

<script>
    $(document).ready(function () {
        $('.experience-carousel').owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                    autoplay: true
                },
                480: {
                    items: 2,
                    nav: false,
                    autoplay: true
                },
                600: {
                    items: 3,
                    nav: false,
                    autoplay: true
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                    margin: 16
                }
            }
        });
        
        /*$('.banner-carousel').owlCarousel({
            loop: true,			
            nav : false,
            margin: 10,
            responsiveClass: true,
            autoplay:true,
            autoplayTimeout:3000,
            // autoplayHoverPause:true,
            responsive: {
                0: {
                    items: 1,
                    nav: false
                }
            }
        });*/

        $('.homes-carousel').owlCarousel({
            loop: true,
			
            margin: 10,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                    autoplay: true
                },
                480: {
                    items: 2,
                    nav: false,
                    autoplay: true
                },
                600: {
                    items: 3,
                    nav: false,
                    autoplay: true
                },
                1000: {
                    items: 3,
                    nav: true,
                    loop: false,
                    margin: 16
                }
            }
        });

        $('.featured-carousel').owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                    autoplay: true
                },
                480: {
                    items: 2,
                    nav: false,
                    autoplay: true
                },
                600: {
                    items: 3,
                    nav: false,
                    autoplay: true
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                    margin: 16
                }
            }
        });
    });
</script>




<script type="text/javascript">
      $(document).ready(function() {
       
        var Opera = (navigator.userAgent.match(/Opera|OPR\//) ? $("#mic_pic").hide() : $("#mic_pic").show());
        $('#config-text').keyup(function() {
          eval($(this).val());
        });
        
        $('.configurator input, .configurator select').change(function() {
          updateConfig();
        });

        $('.demo i').click(function() {
          $(this).parent().find('input').click();
        });

        $('#startDate').daterangepicker({
          singleDatePicker: true,
          minDate: new Date()
          //startDate: moment().subtract(6, 'days')
        });

        $('#endDate').daterangepicker({
          singleDatePicker: true,
          minDate: new Date()
          //startDate: moment()
        });
        $('#startDate').on('apply.daterangepicker', function (ev, picker) {
               chkoutFunction();
               $('#endDate').val('');
              $(this).val(picker.startDate.format('MM/DD/YYYY'));
               $('#endDate').trigger('click');
               

            });

        function chkoutFunction() {

                $('#endDate').daterangepicker({
         
                    "singleDatePicker": true,

                    "minDate": $('#startDate').val()

                    

                });
            }
 $('#startDate').val('');
        $('#endDate').val('');
        updateConfig();

        function updateConfig() {
          var options = {};

          if ($('#singleDatePicker').is(':checked'))
            options.singleDatePicker = true;
          
          if ($('#showDropdowns').is(':checked'))
            options.showDropdowns = true;

          if ($('#showWeekNumbers').is(':checked'))
            options.showWeekNumbers = true;

          if ($('#showISOWeekNumbers').is(':checked'))
            options.showISOWeekNumbers = true;

          if ($('#timePicker').is(':checked'))
            options.timePicker = true;
          
          if ($('#timePicker24Hour').is(':checked'))
            options.timePicker24Hour = true;

          if ($('#timePickerIncrement').val().length && $('#timePickerIncrement').val() != 1)
            options.timePickerIncrement = parseInt($('#timePickerIncrement').val(), 10);

          if ($('#timePickerSeconds').is(':checked'))
            options.timePickerSeconds = true;
          
          if ($('#autoApply').is(':checked'))
            options.autoApply = true;

          if ($('#dateLimit').is(':checked'))
            options.dateLimit = { days: 7 };

          if ($('#ranges').is(':checked')) {
            options.ranges = {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days': [moment().subtract(6, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            };
          }

          if ($('#locale').is(':checked')) {
            $('#rtl-wrap').show();
            options.locale = {
              direction: $('#rtl').is(':checked') ? 'rtl' : 'ltr',
              format: 'MM/DD/YYYY HH:mm',
              separator: ' - ',
              applyLabel: 'Apply',
              cancelLabel: 'Cancel',
              fromLabel: 'From',
              toLabel: 'To',
              customRangeLabel: 'Custom',
              daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
              monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
              firstDay: 1
            };
          } else {
            $('#rtl-wrap').hide();
          }

          if (!$('#linkedCalendars').is(':checked'))
            options.linkedCalendars = false;

          if (!$('#autoUpdateInput').is(':checked'))
            options.autoUpdateInput = false;

          if (!$('#showCustomRangeLabel').is(':checked'))
            options.showCustomRangeLabel = false;

          if ($('#alwaysShowCalendars').is(':checked'))
            options.alwaysShowCalendars = true;

          if ($('#parentEl').val().length)
            options.parentEl = $('#parentEl').val();

          if ($('#startDate').val().length) 
            options.startDate = $('#startDate').val();

          if ($('#endDate').val().length)
            options.endDate = $('#endDate').val();
          
          if ($('#minDate').val().length)
            options.minDate = $('#minDate').val();

          if ($('#maxDate').val().length)
            options.maxDate = $('#maxDate').val();

          if ($('#opens').val().length && $('#opens').val() != 'right')
            options.opens = $('#opens').val();

          if ($('#drops').val().length && $('#drops').val() != 'down')
            options.drops = $('#drops').val();

          if ($('#buttonClasses').val().length && $('#buttonClasses').val() != 'btn btn-sm')
            options.buttonClasses = $('#buttonClasses').val();

          if ($('#applyClass').val().length && $('#applyClass').val() != 'btn-success')
            options.applyClass = $('#applyClass').val();

          if ($('#cancelClass').val().length && $('#cancelClass').val() != 'btn-default')
            options.cancelClass = $('#cancelClass').val();

          $('#config-text').val("$('#demo').daterangepicker(" + JSON.stringify(options, null, '    ') + ", function(start, end, label) {\n  console.log(\"New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')\");\n});");

          $('#config-demo').daterangepicker(options, function(start, end, label) { console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')'); }).click();;
          
        }

      });
      function search_form()
      {
       var place= $('#autocomplete').val();
        if(place == ''){
            boot_alert('Please Enter City');
            return false;
        }
       else{
          $('#search_result_form').attr('action', 'property');
        $('#search_result_form').submit();
       }
      }
       function search_form_exp()
      {
        var place= $('#autocomplete').val();
        if(place == ''){
            boot_alert('Please Enter City');
            return false;
        }
        else
        {
         $('#search_result_form').attr('action', 'explore-experience');
        $('#search_result_form').submit();
        }
        
      }
      </script>