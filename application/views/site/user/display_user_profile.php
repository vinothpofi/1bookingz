<?php$this->load->view('site/includes/header');$not_specified = "Not Specified ";if ($this->lang->line('not_specified') != '') {    $not_specified = stripslashes($this->lang->line('not_specified'));}?>    <section>        <div class="container">            <div class="row userProfile">                <div class="col-md-3">                    <div class="profile_I">                        <?php                        $ImageSrc = 'profile.png';                        if ($user_Details->row()->image != "" && file_exists('./images/users/' . $user_Details->row()->image)) {                            $ImageSrc = $user_Details->row()->image;                        }                        echo img(base_url() . 'images/users/' . $ImageSrc, TRUE, array('class' => 'opacity'));                        echo img(base_url() . 'images/users/' . $ImageSrc, TRUE, array('class' => 'dp'));                        ?>                    </div>                    <div class="panel panel-default aboutMe" style="display:none;">                        <div class="panel-heading"><?php if ($this->lang->line('AboutMe') != '') {                                echo stripslashes($this->lang->line('AboutMe'));                            } else echo "About Me "; ?></div>                        <div class="panel-body">                                                       <h6><?php if ($this->lang->line('Address') != '') {                                    echo stripslashes($this->lang->line('Address'));                                } else echo "Address  "; ?></h6>                            <p><?php if ($user_Details->row()->address != '') {                                    echo ucfirst($user_Details->row()->address);                                } else {                                    echo $not_specified;                                } ?></p>							<h6><?php if ($this->lang->line('TimeZone') != '') {                                    echo stripslashes($this->lang->line('TimeZone'));                                } else echo "Time Zone  "; ?></h6>								<p></p>                            <h6><?php if ($this->lang->line('Language') != '') {                                    echo stripslashes($this->lang->line('Language'));                                } else echo "Languages  "; ?></h6>                            <p><?php                                $languages_known = explode(',', $user_Details->row()->languages_known);                                $languages_known_text = '';                                foreach ($languages->result() as $language) {                                    if (in_array($language->language_code, $languages_known)) {                                        $languages_known_text .= $language->language_name . ',';                                    }                                }                                echo ucfirst(substr($languages_known_text, 0, -1));                                if ($languages_known_text == '') {                                    if ($this->lang->line('none_selected') != '') {                                        echo stripslashes($this->lang->line('none_selected'));                                    } else echo "None Selected";                                } ?></p>                        </div>                    </div>                    <div class="panel panel-default verification">                        <div class="panel-heading"><?php if ($this->lang->line('Verifications') != '') {                                echo stripslashes($this->lang->line('Verifications'));                            } else echo "Verifications"; ?></div>                        <div class="panel-body">                            <div class="tableRow">                                <div class="left">                                    <div><?php if ($this->lang->line('signup_emailaddrs') != '') {                                            echo stripslashes($this->lang->line('signup_emailaddrs'));                                        } else echo "Email Address"; ?></div>                                </div>                                <div class="right">                                    <img src="<?php echo base_url(); ?>images/<?php echo ($user_Details->row()->id_verified == 'Yes') ? 'verifiedIcon.png' : 'unverified150x50.png'; ?>"                                         width="25">                                </div>                            </div>                            <div class="tableRow">                                <div class="left">                                    <div><?php if ($this->lang->line('PhoneNumber') != '') {                                            echo stripslashes($this->lang->line('PhoneNumber'));                                        } else echo "Phone Number "; ?></div>                                </div>                                <div class="right">                                    <img src="<?php echo base_url(); ?>images/<?php echo ($user_Details->row()->ph_verified == 'Yes') ? 'verifiedIcon.png' : 'unverified150x50.png'; ?>"                                         width="25">                                </div>                            </div>                        </div>                    </div>                </div>                <div class="col-md-9">								                    <h2><?php echo ucfirst($user_Details->row()->firstname . ' ' . $user_Details->row()->lastname); ?></h2>                    <h5 class="marginBottom3"><?php echo ucfirst($user_Details->row()->email); ?>                        <?php                        if($ReviewDetails->num_rows()>0) {                            echo $ReviewDetails->num_rows()."&nbsp;";                            if ($this->lang->line('joined_in') != '') {                                echo stripslashes($this->lang->line('joined_in'));                            } else echo "Joined in  ";                            echo "&nbsp;";                            echo date('M Y', strtotime($user_Details->row()->created));                        }                        ?>                    </h5>										<h2 class="marginSpace"><?php if ($this->lang->line('Address') != '') {                                echo stripslashes($this->lang->line('Address'));                            } else echo "Address  "; ?></h2>					<p><?php if ($user_Details->row()->address != '') {                                    echo ucfirst($user_Details->row()->address);                                } else {                                    echo $not_specified;                                } ?></p>													<h2 class="marginSpace"><?php if ($this->lang->line('TimeZone') != '') {                                echo stripslashes($this->lang->line('TimeZone'));                            } else echo "TimeZone  "; ?></h2>					<p><?php if ($user_Details->row()->timezone != '') {                                    echo ucfirst($user_Details->row()->timezone);                                } else {                                    echo $not_specified;                                } ?></p>													<h2 class="marginSpace"><?php if ($this->lang->line('Language') != '') {                                echo stripslashes($this->lang->line('Language'));                            } else echo "Languages  "; ?></h2>					<p><?php                                $languages_known = explode(',', $user_Details->row()->languages_known);                                $languages_known_text = '';                                foreach ($languages->result() as $language) {                                    if (in_array($language->language_code, $languages_known)) {                                        $languages_known_text .= $language->language_name . ',';                                    }                                }                                echo ucfirst(substr($languages_known_text, 0, -1));                                if ($languages_known_text == '') {                                    if ($this->lang->line('none_selected') != '') {                                        echo stripslashes($this->lang->line('none_selected'));                                    } else echo "None Selected";                                } ?></p>							                    <p><?php echo nl2br($user_Details->row()->description); ?></p>                                       <div class="userFeatures">                        <a href="#" class="reRef">                            <span><?php echo $ReviewDetails->num_rows(); ?></span> <?php if ($this->lang->line('reviews') != '') {                                echo stripslashes($this->lang->line('reviews'));                            } else echo "Reviews  "; ?>                        </a>                    </div>				                <?php //} ?>								<?php if($user_Details->row()->group == "Seller"){ ?>								<h2 class="marginSpace"><?php if ($this->lang->line('Business_details') != '') {                                echo stripslashes($this->lang->line('Business_details'));                            } else echo "Business Details"; ?></h2>											<?php $userbusinessname = ""; if (!empty($userDetails)) $userbusinessname = $userDetails->row()->business_name;?>						<h4><?= $userbusinessname; ?></h4>								<?php $enterBusinessdesc = ""; if (!empty($userDetails)) $enterBusinessdesc = $userDetails->row()->description;?>						<h5><?= $enterBusinessdesc; ?></h5>													<?php $userlicno = ""; if (!empty($userDetails)) $userlicno = $userDetails->row()->license_number;?>						<h5><?php if ($this->lang->line('signup_license_number') != '') {                                        echo stripslashes($this->lang->line('signup_license_number'));                                    } else echo "License Number"; ?> : <?= $userlicno; ?></h5>								<?php $userbusinessaddr = ""; if (!empty($userDetails)) $userbusinessaddr = $userDetails->row()->business_address; ?>				<h5><?= $userbusinessaddr; ?></h5>																	                    <div class="myListings">                        <h2><?php if ($this->lang->line('Listing') != '') {                                echo stripslashes($this->lang->line('Listing'));                            } else echo "Listings  "; ?> <?php if ($rentalDetail->num_rows() > 0) { ?>(<?php echo $rentalDetail->num_rows(); ?>)<?php } ?></h2>                        <ul class="res_Scroll clear">                            <?php if ($rentalDetail->num_rows() > 0) {                                foreach ($rentalDetail->result() as $rentals) { ?>                                    <li>                                        <a href="<?php echo base_url(); ?>rental/<?php echo $rentals->seourl; ?>"><img                                                    src="<?php echo ($rentals->product_image != "" && file_exists("./images/rental/" . $rentals->product_image)) ? base_url() . "images/rental/" . $rentals->product_image : base_url() . 'images/rental/dummyProductImage.jpg'; ?>"><span                                                    class="title"><?php echo $rentals->product_title; ?></span></a>                                    </li>                                <?php }                            } else {                                ?>                                <li>                                    <a href="#"><?php if ($this->lang->line('no_listing_found') != '') {                                echo stripslashes($this->lang->line('no_listing_found'));                            } else echo "No Listings Found  "; ?>!</a>                                </li>                                <?php                            } ?>                        </ul>                        <?php if($rental_counts->num_rows() > 8){?>                        <a class="submitBtn1" target="_blank" href="<?php echo base_url(); ?>explore_listing/<?php echo $rentalDetail->row()->user_id; ?>"><?php if ($this->lang->line('see_all') != '') {                                echo stripslashes($this->lang->line('see_all'));                            } else echo "See All"; ?></a>                        <?php }?>                    </div>				<?php } ?>									<?php if($user_Details->row()->group == "User"){ ?>	                    <h2 class="marginSpace"><?php if ($this->lang->line('Wish_list') != '') {                            echo stripslashes($this->lang->line('Wish_list'));                        } else echo "Wishlist "; ?> <?php if ($Properties_WishList->num_rows() > 0) { ?>(<?php echo $Properties_WishList->num_rows(); ?>)<?php } ?></h2>                    <div class="row">                        <?php                        if ($Properties_WishList->num_rows() > 0) {                            foreach ($Properties_WishList->result() as $wlist) {                                $link = $this->db->select('seourl')->where('id', $wlist->id)->get(PRODUCT);                                foreach ($properties_wishlist_image[$wlist->id]->result() as $product_image) {                                    ?>                                    <div class="col-md-4 col-sm-3">                                        <div class="wishlist_list">                                            <a href="<?php echo base_url(); ?>rental/<?php echo $link->row()->seourl; ?>">                                                <img src="<?php echo ($product_image->product_image != "" && file_exists('./images/rental/' . $product_image->product_image)) ? base_url() . 'images/rental/' . $product_image->product_image : base_url() . 'images/empty-wishlist.jpg'; ?>">                                                <div class="title">                                                    <div><?php echo ucfirst($wlist->product_title); ?></div>                                                    <span><?php if ($this->lang->line('Viewlisting') != '') {                            echo stripslashes($this->lang->line('Viewlisting'));                        } else echo "View Listing "; ?></span></div>																										                                            </a>                                        </div>                                    </div>                                    <?php                                }                            }                        } else {                            ?>                            <div class="col-md-12"><p class="text-Green"><?php if ($this->lang->line('no_wishlist_found') != '') {                            echo stripslashes($this->lang->line('no_wishlist_found'));                        } else echo "No wishlists found "; ?>!</p></div>							                            <?php                        }                        ?>                    </div>				<?php } ?>									<?php if($user_Details->row()->group == "Seller"){ ?>	                    <h2 class="marginSpace"><?php if ($this->lang->line('reviews') != '') {                            echo stripslashes($this->lang->line('reviews'));                        } else echo "Reviews  "; ?> <?php if ($ReviewDetails->num_rows() > 0) { ?> (<?php echo $ReviewDetails->num_rows(); ?>) <?php } ?></h2>                    <?php                     if ($ReviewDetails->num_rows() > 0) {                        foreach ($ReviewDetails->result_array() as $review) {                            $link = $this->db->select('seourl')->where('id', $review['product_id'])->get(PRODUCT);                            $reviewuser = $this->db->select('image,firstname')->where(array('id' => $review['reviewer_id']))->get(USERS);                            ?>                            <div class="customTabView">                                <div class="reviewList">                                    <div class="reviewItems clear">                                        <div class="top">                                            <div class="left">                                                <img src="<?php echo base_url(); ?>images/users/<?php echo ($reviewuser->row()->image != "" && file_exists('./images/users/' . $reviewuser->row()->image)) ? $reviewuser->row()->image : 'profile.png'; ?>">                                            </div>                                            <div class="right">                                                <div class="h7"><a                                                            href="<?php echo base_url(); ?>users/show/<?php echo $review['reviewer_id']; ?>"><?php echo ucfirst($reviewuser->row()->firstname); ?></a>                                                </div>                                                <p><?php echo date('d F Y', strtotime($review['dateAdded'])); ?></p>                                            </div>                                        </div>                                        <p><?php echo nl2br($review['review']); ?></p>                                        <div>                                            <span class="badge"><?php if($review['review_type'] == '0'){echo "Rental";}else{echo "Host";} ?></span>                                        </div>                                        <a href="<?= base_url(); ?>rental/<?= $link->row()->seourl; ?>" class="home"><i                                                    class="fa fa-home"                                                    aria-hidden="true"></i> <?php echo $review['product_title']; ?>                                        </a>                                    </div>                                </div>                            </div>                            <?php                        }                    } else {                        ?>                        <p class="text-Green"><?php if ($this->lang->line('no_reviews_found') != '') {                            echo stripslashes($this->lang->line('no_reviews_found'));                        } else echo "No reviews found"; ?>!</p>				<?php } } ?>											                    <?php /* if ($experienceExistCount > 0) { ?>                    <div class="myListings">                        <h2>						                            <?php if ($this->lang->line('experiences') != '') {                            echo stripslashes($this->lang->line('experiences'));                        } else echo "Experiences"; ?> <?php if ($expDetail->num_rows() > 0) { ?>(<?php echo $expDetail->num_rows(); ?>)<?php } ?></h2>                        <ul class="res_Scroll clear">                            <?php if ($expDetail->num_rows() > 0) {                                foreach ($expDetail->result() as $rentals) { ?>                                    <li>                                        <a href="<?php echo base_url(); ?>view_experience/<?php echo $rentals->experience_id; ?>"><img                                                    src="<?php echo ($rentals->product_image != "" && file_exists("./images/experience/" . $rentals->product_image)) ? base_url() . "images/experience/" . $rentals->product_image : base_url() . 'images/experience/dummyProductImage.jpg'; ?>"><span                                                    class="title"><?php echo $rentals->experience_title; ?></span></a>                                    </li>                                <?php }                            } else {                                ?>                                <li>                                    <a href="#"><?php if ($this->lang->line('no_exps_found') != '') {                            echo stripslashes($this->lang->line('no_exps_found'));                        } else echo "No Experiences Found "; ?>!</a>																											                                </li>                                <?php                            } ?>                        </ul>                         <?php if($exp_counts->num_rows() > 8){?>                        <a class="submitBtn1" target="_blank" href="<?php echo base_url(); ?>explore-experience/<?php echo $rentalDetail->row()->user_id; ?>"><?php if ($this->lang->line('see_all') != '') {                                echo stripslashes($this->lang->line('see_all'));                            } else echo "See All"; ?></a>                        <?php }?>                    </div>                <?php } */ ?>								                <?php  /* if ($this->data['experienceExistCount'] > 0) { ?>                    <h2 class="marginSpace"><?php if ($this->lang->line('Wish_list') != '') {                            echo stripslashes($this->lang->line('Wish_list'));                        } else echo "Wishlist "; ?> <?php if ($Experiences_WishList->num_rows() > 0) { ?>(<?php echo $Experiences_WishList->num_rows(); ?>)<?php } ?></h2>                    <div class="row">                        <?php                        if ($Experiences_WishList->num_rows() > 0) {                            foreach ($Experiences_WishList->result() as $wlist) {                                foreach ($experiences_wishlist_image[$wlist->experience_id]->result() as $exp_image) {                                    ?>                                    <div class="col-md-4 col-sm-6">                                        <div class="wishlist_list">                                            <a href="<?php echo base_url(); ?>view_experience/<?php echo $wlist->experience_id; ?>">                                                <img src="<?php echo ($exp_image->product_image != "" && file_exists('./images/experience/' . $exp_image->product_image)) ? base_url() . 'images/experience/' . $exp_image->product_image : base_url() . 'images/empty-wishlist.jpg'; ?>">                                                <div class="title">                                                    <div><?php echo ucfirst($wlist->experience_title); ?></div>                                                    <span><?php if ($this->lang->line('Viewlisting') != '') {                            echo stripslashes($this->lang->line('Viewlisting'));                        } else echo "View Listing "; ?></span></div>                                            </a>                                        </div>                                    </div>                                    <?php                                }                            }                        } else {                            ?>                            <div class="col-md-12"><p class="text-Green"><?php if ($this->lang->line('no_exp_wish_found') != '') { echo stripslashes($this->lang->line('no_exp_wish_found'));                        } else echo "No Experience wishlists found"; ?>!</p></div>							                            <?php                        }                        ?>                    </div>                <?php } */ ?>			                <?php /* <h2 class="marginSpace"><?php if ($this->lang->line('reviews') != '') {                            echo stripslashes($this->lang->line('reviews'));                        } else echo "Reviews  "; ?> <?php if ($Exp_ReviewDetails->num_rows() > 0) { ?> (<?php echo $Exp_ReviewDetails->num_rows(); ?>) <?php } ?></h2>                    <?php if ($Exp_ReviewDetails->num_rows() > 0) {                        foreach ($Exp_ReviewDetails->result_array() as $review) {                            $reviewuser = $this->db->select('image,firstname')->where(array('id' => $review['reviewer_id']))->get(USERS);                            ?>                            <div class="customTabView">                                <div class="reviewList">                                    <div class="reviewItems clear">                                        <div class="top">                                            <div class="left">                                                <img src="<?php echo base_url(); ?>images/users/<?php echo ($reviewuser->row()->image != "" && file_exists('./images/users/' . $reviewuser->row()->image)) ? $reviewuser->row()->image : 'profile.png'; ?>">                                            </div>                                            <div class="right">                                                <div class="h7"><a                                                            href="<?php echo base_url(); ?>users/show/<?php echo $review['reviewer_id']; ?>"><?php echo ucfirst($reviewuser->row()->firstname); ?></a>                                                </div>                                                <p><?php echo date('d F Y', strtotime($review['dateAdded'])); ?></p>                                            </div>                                        </div>                                        <p><?php echo nl2br($review['review']); ?></p>                                        <div>                                            <span class="badge"><?php if($review['review_type'] == '0'){echo "Experience";}else{echo "Host";} ?>                                            </span>                                        </div>                                        <a href="<?= base_url(); ?>view_experience/<?= $review['product_id']; ?>"                                           class="home"><i                                                    class="fa fa-home"                                                    aria-hidden="true"></i> <?php echo $review['experience_title']; ?>                                        </a>                                    </div>                                </div>                            </div>                            <?php                        }                    } else {                        ?>                        <p class="text-Green"><?php if ($this->lang->line('no_exp_reviews_found') != '') { echo stripslashes($this->lang->line('no_exp_reviews_found'));                        } else echo "No Experience reviews found"; ?>!</p>                        <?php                    } */                    ?>                </div>            </div>        </div>    </section><?php$this->load->view('site/includes/footer');?>