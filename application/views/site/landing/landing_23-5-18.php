<?php
$this->load->view('site/includes/header');
$currency_result = $this->session->userdata('currency_result');
?>
<style type="text/css">
    .headerLeft .searchLocation {
        display: none;
    }
</style>
<script type="text/javascript">
    $(".headerLeft .searchLocation").html('');
</script>
<section>



<div class="banner-container">
<div class="banner-container-bg"></div>

<div class="owl-carousel owl-theme banner-carousel">
<?php if($adminList->slider == "on") {
		$slider_loop=1;
 
		if($SliderList->num_rows() > 0){
		 foreach ($SliderList->result() as $Slider){ 
			if($Slider->image !=''){
				$ImgSrc=$Slider->image;
			}else{
				$ImgSrc='dummyProductImage.png';
			}
?>
			<div class="item <?php if($slider_loop==1){ $slider_loop=2;?>active<?php }?>">
				<div class="banner_imgs" style="background-image: url('<?php echo base_url(); ?>images/slider/<?php echo $ImgSrc;?>');"></div>
			</div>
			
        <?php } } else { $ImgSrc='dummyProductImage.png'; ?>
			
			<div class="item active">
				<div class="banner_imgs" style="background-image: url('<?php echo base_url(); ?>images/slider/<?php echo $ImgSrc;?>');"></div>
			</div>
			
			
		<?php } ?> 
		<?php } else {} ?>
		
		
</div>

<div class="container">
        <h1 class="homeTitle">
            
            <?php if ($this->lang->line('Book_unique_homes') != '') {
                echo stripslashes($this->lang->line('Book_unique_homes'));
            } else {
                "Book unique homes and";
            } ?>
            <div><?php if ($this->lang->line('experience_a_city') != '') {
                    echo stripslashes($this->lang->line('experience_a_city'));
                } else {
                   echo "experience a city like a local.";
                } ?></div>
        </h1>
        
        <?php if ($this->lang->line('try') != '') {
                    $try= stripslashes($this->lang->line('try'));
                } else {
                    $try="Try";
                } ?>
                
                <?php if ($this->lang->line('Search') != '') {
                    $sear= stripslashes($this->lang->line('Search'));
                } else {
                    $sear="Search";
                } ?>
        
        <div class="searchLocation homeSearch">
            <?php echo form_open('property', array('name' => 'search_properties', 'autocomplete' => 'off', 'method' => 'get', 'id' => 'property_search_form')); ?>
            <i class="fa fa-search" aria-hidden="true"></i>
            <?php
            echo form_input('city', '', array('required' => 'required', 'class' => 'searchInput', 'id' => 'autocomplete', 'placeholder' => "$try Ooty"));
            
            echo form_submit('cmd', "$sear", array('class' => 'searchBtn', 'placeholder' => "$try Ooty"));
            ?>
            <div class="exploreDetail">
            
                <h6><?php if ($this->lang->line('explore_homestay') != '') { echo stripslashes($this->lang->line('explore_homestay'));  } else { echo "Explore Homestay"; } ?></h6>
                <div class="clear">
                    <a href="<?php echo base_url(); ?>explore_listing" class="exploreBtn active"><?php if ($this->lang->line('homes') != '') { echo stripslashes($this->lang->line('homes'));  } else { echo "Homes"; } ?></a>
                    <a href="<?php echo base_url(); ?>explore-experience" class="exploreBtn"><?php if ($this->lang->line('explore-experience') != '') { echo stripslashes($this->lang->line('experience'));  } else { echo "Experience"; } ?></a>
					 <a href="<?php echo base_url(); ?>all_listing" class="exploreBtn "><?php if ($this->lang->line('All') != '') { echo stripslashes($this->lang->line('All'));  } else { echo "All"; } ?></a>
                </div>
            </div>
            <?php echo form_close(); ?>
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
        <h3><?php if ($this->lang->line('explore_homestay') != '') {
                echo stripslashes($this->lang->line('explore_homestay'));
            } else echo "Explore Homestay"; ?></h3>
        <div class="exploreBlock">
            <div class="row">
                <div class="col-sm-3">
                    <a href="<?php echo base_url(); ?>explore_listing">
                        <div class="split_item clear">
                            <div class="exploreImg" style="background-image: url('images/exploreIcon.jpg')"></div>
                            <h4><?php if ($this->lang->line('Homes') != '') {
                                    echo stripslashes($this->lang->line('Homes'));
                                } else echo "Homes"; ?></h4>
                        </div>
                    </a>
                </div>
                <div class="col-sm-3">
                    <a href="<?php echo base_url(); ?>explore-experience">
                        <div class="split_item clear">
                            <div class="exploreImg" style="background-image: url('images/exploreIcon1.jpg')"></div>
                            <h4><?php if ($this->lang->line('Experiences') != '') {
                                    echo stripslashes($this->lang->line('Experiences'));
                                } else echo "Experiences"; ?></h4>
                        </div>
                    </a>
                </div>
            </div>
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
                            } else echo "Featured Experience"; ?> </h3>
                    </div>
                    <div class="owl-carousel owl-theme experience-carousel">
                        <?php
                        foreach ($featuredExperiences->result() as $experience) {
                            $cur_Date = date('Y-m-d');
                            $sel_price = "select min(price) as min_price,currency from " . EXPERIENCE_DATES . " where experience_id ='" . $experience->experience_id . "' and status='1' and from_date>'" . $cur_Date . "'";
                            $priceData = $this->landing_model->ExecuteQuery($sel_price);
                            if ($priceData->num_rows() > 0) {
                                $experience_currency = $priceData->row()->currency;
                                $experience_price = $priceData->row()->min_price;
                            } else {
                                $experience_currency = $this->session->userdata('currency_type');
                                $experience_price = 0;
                            }
                            $experience_currency = $experience->currency;
                            $experience_price = $experience->price;
                            $base = base_url();
                            $url = getimagesize($base . 'images/experience/' . $experience->product_image);
                            if (!is_array($url)) {
                                $img = "1";
                            } else {
                                $img = "0";
                            }
                            ?>
                            <div class="item">
                                <a href="<?php echo base_url(); ?>view_experience/<?php echo $experience->experience_id; ?>">
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
										
											if ($experience->city!='' && $experience->type_title!=''){
												echo $experience->type_title . " . " . $experience->city;
											}else if ($experience->type_title!=''){
												echo $experience->type_title;
											}else if ($experience->city=''){
												echo $experience->city;
											}
										
										?>
										</div>
                                        <h5><?php
                                            echo ucfirst($experience->experience_title);
                                           
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
if ($CityDetails->num_rows() > 0) {
    foreach ($CityDetails->result() as $CityRows) {
        $city_name = $CityRows->name;
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
        if (count($CityName[$city_name]) > 0) {
            ?>
            <section>
                <div class="container">
                    <div class="rowSpace">
                        <div class="rowHead clear" data-alt="test">
                            <h3><?php if ($this->lang->line('Home in') != '') {
                                    echo stripslashes($this->lang->line('Home in'));
                                } else echo "Home in"; ?>
                                <?php echo ucfirst($city_name); ?></h3>
                            <a href="<?= base_url(); ?>property?city=<?php echo $city_name . $StateNameLi . $CountryLi; ?>"
                               class="seeAll"><?php if ($this->lang->line('See_all') != '') {
                                    echo stripslashes($this->lang->line('See_all'));
                                } else echo "See all"; ?> <span class="icon">></span></a>
                        </div>
                        <div class="owl-carousel owl-theme homes-carousel">
                            <?php foreach ($CityName[$city_name] as $CityRowss) {
                                ?>
                                <div class="item">
                                    <a href="<?php echo base_url(); ?>rental/<?php echo $CityRowss->seourl; ?>">
                                        <?php
                                        $base = base_url();
                                        $url = getimagesize($base . 'images/rental/' . $CityRowss->product_image);
                                        if (!is_array($url)) {
                                            $img = "1"; //no
                                        } else {
                                            $img = "0";  //yes
                                        }
                                        if ($CityRowss->product_image != '' && $img == '0') { ?>
                                            <div class="myPlace"
                                                 style="background-image: url('<?php echo base_url(); ?>images/rental/<?php echo $CityRowss->product_image; ?>')"></div>
                                        <?php } else { ?>
                                            <div class="myPlace"
                                                 style="background-image: url('<?php echo base_url(); ?>images/rental/dummyProductImage.jpg"></div>
                                        <?php } ?>
                                        <div class="bottom">
                                           <div class="loc">
										   <?php  
											   
											   if ($CityRowss->list_value!='' && $CityRowss->city!=''){
												   echo $CityRowss->list_value . " . " . $CityRowss->city;
											   }else if ($CityRowss->list_value!=''){
												   echo $CityRowss->list_value;
											   }else if ($CityRowss->city!=''){
												   echo $CityRowss->city;
											   }
										?> </div>
                                            <h5><?php
                                              echo ucfirst($CityRowss->product_title);
												
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
                                                    } ?></span> <?php echo $this->session->userdata('currency_type'); echo ' <span style="font-size:14px;">Per night</span>'; ?>
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
                            <h3><?php echo $data->title; ?></h3>
                            <h4><?php echo $data->description; ?></h4>
                            <a href="<?php echo $data->link; ?>"
                               class="btnStyle1"><?php if ($this->lang->line('See What You Can Earn') != '') {
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
                    <h3><?php if ($this->lang->line('Featured_destinations') != '') {
                            echo stripslashes($this->lang->line('Featured_destinations'));
                        } else {
                            "Featured destinations";
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
                        <div class="item">
                            <a href="<?= base_url(); ?>property?city=<?php echo $Cityname . $StateName . $Country; ?>">
                                <div class="myPlace"
                                     style="background-image: url('<?php echo base_url(); ?>images/city/<?php echo (file_exists('./images/city/' . $CityRows->citythumb)) ? $CityRows->citythumb : 'no-image-found.jpg'; ?>')"></div>
                                <div class="bottom">
                                    <div class="f_des"><?php echo trim(stripslashes($CityRows->name)); ?></div>
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
if ($CityDetails->num_rows() > 0) {
	
    foreach ($CityDetails->result() as $CityRows) {
        $sel_featuredExpType = "SELECT * FROM " . EXPERIENCE_TYPE . " WHERE  featured = 1 and status='Active' limit " . $j . ", 1";
        $featuredExperiencesType = $this->landing_model->ExecuteQuery($sel_featuredExpType);
        $exp_type_id = $featuredExperiencesType->row()->id;
        if ($exp_type_id != '') {
            $get_featured_all = "select exp.*,exp.experience_title as exp_title,et.id as e_type_id,et.experience_title,ph.product_image , (select IFNULL(count(R.id),0) from " . EXPERIENCE_REVIEW . " as R where R.product_id= exp.experience_id and R.status='Active') as num_reviewers , (select IFNULL(avg(Rw.total_review),0) from " . EXPERIENCE_REVIEW . " as Rw where Rw.product_id= exp.experience_id and Rw.status='Active') as avg_val from " . EXPERIENCE . " as exp left join " . EXPERIENCE_PHOTOS . " as ph on ph.product_id=exp.experience_id inner join " . EXPERIENCE_TYPE . " as et on et.id=exp.type_id LEFT JOIN  " . EXPERIENCE_DATES . " d  on d.experience_id=exp.experience_id  where exp.status='1' and exp.type_id = " . $exp_type_id . " and  d.from_date >'" . date('Y-m-d') . "' and exp.status='1' AND EXISTS
      ( select c.id FROM fc_experience_dates c where c.status='0' and c.experience_id=exp.experience_id
      )  AND EXISTS (select count(td.id) FROM fc_experience_time_sheet td where td.status='1' and td.experience_id=exp.experience_id) group by exp.experience_id order by exp.added_date desc ";
            $Cat_Type[$exp_type_id] = $this->landing_model->ExecuteQuery($get_featured_all);
        }
		
		if ($exp_type_id != '') {
        if ($Cat_Type[$exp_type_id]->num_rows() > 0) {
            ?>
            <section>
                <div class="container">
                    <div class="rowSpace">
                        <div class="rowHead clear">
                            <h3><?php if ($this->lang->line('experiences_in') != '') {
                                    echo stripslashes($this->lang->line('experiences_in'));
                                } else echo "Experiences in"; ?><?php echo " " . $Cat_Type[$exp_type_id]->row()->experience_title; ?></h3>
                            <a href="<?php echo base_url(); ?>explore-experience"
                               class="seeAll"><?php if ($this->lang->line('See_all') != '') {
                                    echo stripslashes($this->lang->line('See_all'));
                                } else echo "See all"; ?> <span class="icon"> </span></a>
                        </div>
                        <div class="owl-carousel owl-theme experience-carousel">
                            <?php foreach ($Cat_Type[$exp_type_id]->result() as $experience) {
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
										
                                            <div class="loc">Nightlife · New York</div>
											
											
                                            <h5><?php
                                                echo ucfirst($experience->exp_title);
                                                ?> </h5>
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
                                                    ?></span> <?php echo $this->session->userdata('currency_type');  ?>
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
        $j++;
    }
}
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
                                <img src="<?php echo base_url(); ?>images/prefooter/<?php echo $pre_data->image; ?>"
                                     class="icon">
                                <div class="right">
                                    <h5><?php echo $pre_data->footer_title; ?></h5>
                                    <p><?php echo $pre_data->description; ?></p>
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
                    nav: true
                },
                480: {
                    items: 2,
                    nav: false
                },
                800: {
                    items: 3,
                    nav: false
                },
                1200: {
                    items: 4,
                    nav: true,
                    loop: false,
                    margin: 16
                }
            }
        });
        $('.banner-carousel').owlCarousel({
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
        });

        $('.homes-carousel').owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 3,
                    nav: false
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
                    nav: true
                },
                480: {
                    items: 2,
                    nav: false
                },
                600: {
                    items: 3,
                    nav: false
                },
                1000: {
                    items: 6,
                    nav: true,
                    loop: false,
                    margin: 16
                }
            }
        });
    });
</script>
