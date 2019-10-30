<?php

    $this->load->view('site/includes/header');

    if ($this->config->item('s3_bucket_name') != '' && $this->config->item('s3_access_key') != '' && $this->config->item('s3_secret_key') != '') $aws = 'Yes'; else $aws = 'No';

?>

<!-- script for cropping image -->

<script src="<?php echo base_url(); ?>js/jquery2.2.0.min.js"></script>

<script src="<?php echo base_url(); ?>js/jquery.cropit.js"></script>

<style>

    .cropit-preview {

        background-color: #f8f8f8;

        background-size: cover;

        border: 5px solid #ccc;

        border-radius: 3px;

        margin-top: 7px;

        width: 300px;

        height: 250px;

    }



    .cropit-preview-image-container {

        cursor: move;

    }



    .cropit-preview-background {

        opacity: .2;

        cursor: auto;

    }



    .image-size-label {

        margin-top: 10px;

    }



    input, .export {

        /* Use relative position to prevent from being covered by image background */

        position: relative;

        z-index: 10;

        display: block;

    }



    button {

        margin-top: 10px;

    }

</style>

<div class="manage_items">

    <?php

        $this->load->view('site/experience/experience_head_side');

    ?>

    <div class="centeredBlock">

        <div class="content">

            <h3><?php if ($this->lang->line('exp_add_photos') != '') {

                    echo stripslashes($this->lang->line('exp_add_photos'));

                } else echo "Add photos for your experience"; ?></h3>

            <p><?php if ($this->lang->line('exp_choose_photos_showcase') != '') {

                    echo stripslashes($this->lang->line('exp_choose_photos_showcase'));

                } else echo "Choose photos that showcase the location and what guests will be doing. photos must be 360 px x 580 px."; ?></p>



            <div class="error-display" id="errordisplay" style="text-align: center; display: none;">

                <p class="text center text-danger" id="danger">asasasasassa</p>

                <p class="text center text-success" id="success"></p>

            </div>



            <?php

                echo form_open_multipart('#', array('id' => 'imageform'));

            ?>

            <input type="hidden" id="id" name="id" value="<?php echo $listDetail->row()->id; ?>"/>

            <div class="image-editor" id="image_editor">

                <div class="cropit-preview marginBottom3" id="cropit-preview"></div>

                <?php $addphotoattr = array('name' => 'photos', 'id' => 'photos', 'class' => 'submitBtn1 marginBottom3 cropit-image-input');

                    echo form_upload($addphotoattr);

                ?>

                <div class="image-size-label">

                   <?php if ($this->lang->line('resize_image') != '') {
							echo stripslashes($this->lang->line('resize_image'));
					} else echo "Resize image"; ?>		

                </div>
				

                <input type="range" class="cropit-image-zoom-input">

                <input type="hidden" name="image-data" id="image-data" class="hidden-image-data"/>
				
				  <?php if ($this->lang->line('rotate_one') != '') {
							$clockWi= stripslashes($this->lang->line('rotate_one'));
					} else $clockWi= "Rotate counterclockwise"; ?>	
					
					<?php if ($this->lang->line('rotate_two') != '') {
							$rotate_two= stripslashes($this->lang->line('rotate_two'));
					} else $rotate_two= "Rotate clockwise"; ?>	

                <?php

                    $ccw = array('name' => '', 'class' => 'rotate-ccw submitBtn1', 'id' => '');

                    echo form_button('', $clockWi, $ccw);

                ?>

                <?php

                    $cw = array('name' => '', 'class' => 'rotate-cw submitBtn1', 'id' => '');

                    echo form_button('', $rotate_two, $cw);

                ?>

                <div class="marginTop1">
				
				
				<?php if ($this->lang->line('upload') != '') {
							$upload= stripslashes($this->lang->line('upload'));
					} else $upload= "Upload"; ?>	

                <?php

                    $imgsubmt = array('name' => '', 'value' => $upload, 'class' => 'submitBtn1', 'id' => '');

                    echo form_submit($imgsubmt);

                ?>

                </div>

                <?php echo form_close(); ?>

            </div>

        </div>



        <!--div to show uploaded images-->

        <div class="row marginTop1">

            <input type="hidden" name="image_count" id="image_count" value="<?php echo $imgDetail->num_rows(); ?>"/>

            <?php if (!empty($imgDetail)) {

                foreach ($imgDetail->result() as $img) { ?>

                    <div class="col-md-4 col-sm-4">

                        <div class="ListedImages">

						
						
							
						
                            <img src="<?php echo base_url() . 'images/experience/' . $img->product_image; ?>">

                            <a href="javascript:void(0)"

                               onClick="javascript:DeleteExperienceImage(<?php echo $img->id; ?>,<?php echo $listDetail->row()->id; ?>);"

                               title="<?php if ($this->lang->line('Delete this image') != '') {

                                   echo stripslashes($this->lang->line('Delete this image'));

                               } else echo "Delete this image"; ?>"><?php if ($this->lang->line('Delete') != '') {
							echo stripslashes($this->lang->line('Delete'));
							} else echo "Delete"; ?></a>

                        </div>

                    </div>

                    <?php

                }

            } ?></div>

        <div class="divider"></div>

        <div id="onclk-text" class="row">

            <?php if ($listDetail->row()->video_url == '') { ?>

                <p><?php if ($this->lang->line('Want to add Video URL') != '') {

                        echo stripslashes($this->lang->line('Want to add Video URL'));

                    } else echo "Want to add Video URL"; ?>?&nbsp;<a href="#"

                                                                     onclick="show_block_cate()"><?php if ($this->lang->line('You can add') != '') {

                            echo stripslashes($this->lang->line('You can add'));

                        } else echo "You can add"; ?>.</a></p>

            <?php } ?>

        </div>

        <div class="row" <?php if ($listDetail->row()->video_url == '') { ?> style="display: none;" <?php } ?>

             id="VideoUrlInput">

            <div class="form-group">

                <p><?php if ($this->lang->line('Video URL') != '') {

                        echo stripslashes($this->lang->line('Video URL'));

                    } else echo "Video URL"; ?></p>

                <?= form_input('video_url', $listDetail->row()->video_url, array('id' => 'video_url_id', 'placeholder' => ($this->lang->line('video_url') != '') ? stripslashes($this->lang->line('video_url')) : "Enter video link", 'onchange' => "experienceDetailview(this," . $listDetail->row()->id . ",'video_url')", 'maxlength' => 60)); ?>

                <p class="text-danger" id="VideoError"></p>

            </div>

        </div>

        <div class="clear text-right">

            <button class="submitBtn1" id="next-btn"><?php if ($this->lang->line('Save_and_Continue') != '') {

                    echo stripslashes($this->lang->line('Save_and_Continue'));

                } else echo "Save & Continue"; ?></button>

        </div>

    </div>

    <div class="rightBlock">

        <h2><?php if ($this->lang->line('exp_photo_video_url') != '') {

                echo stripslashes($this->lang->line('exp_photo_video_url'));

            } else echo "Make your canvas"; ?></h2>

        <p><?php if ($this->lang->line('Photos_always_attract') != '') {

                echo stripslashes($this->lang->line('Photos_always_attract'));

            } else echo "Photos always attract the eyes since one picture is worth a thousand words. Add pictures and videos to speak about your experience. Do highlight the features of your experience."; ?></p> 
        <p><?php if ($this->lang->line('When_both_the_videos') != '') {

                echo stripslashes($this->lang->line('When_both_the_videos'));

            } else echo "When both the videos and photos are added, the page will first display the video added to grab more attention of users."; ?></p>
    <!--  <p><?php if ($this->lang->line('exp_gives_better') != '') {

                echo stripslashes($this->lang->line('exp_gives_better'));

            } else echo "“A picture is worth a thousand words”. Use the images to speak about your experience louder than words. You can add the pictures as well as video clips of your Experience. Explorers love photos that highlight the features of your Experience."; ?></p> -->

    </div>

</div>
		<?php 
				if ($this->lang->line('an_image') != '') {
					$an_image= stripslashes($this->lang->line('an_image'));
				} else {
					$an_image= "Please choose an image";
				} 
				echo form_input(['type'=>'hidden' ,
								 'id'=>'an_image',
								 'value'=>$an_image]);	
				
				
				if ($this->lang->line('upload_atleast_one') != '') {
					$upload_at= stripslashes($this->lang->line('upload_atleast_one'));
				} else {
					$upload_at= "Please Upload At least One Image";
				} 
				echo form_input(['type'=>'hidden' ,
								 'id'=>'upload_at',
								 'value'=>$upload_at]);	
								 
								 
				if ($this->lang->line('use_an_image') != '') {
					$use_an= stripslashes($this->lang->line('use_an_image'));
				} else {
					$use_an= "Please use an image thats must be";
				} 
				echo form_input(['type'=>'hidden' ,
								 'id'=>'use_an',
								 'value'=>$use_an]);	
								 
					
				if ($this->lang->line('one_photo_should') != '') {
					$one_photo= stripslashes($this->lang->line('one_photo_should'));
				} else {
					$one_photo= "Photos are mandatory. So, At least One Photo Should be there";
				} 
				echo form_input(['type'=>'hidden' ,
								 'id'=>'one_photo',
								 'value'=>$one_photo]);	

					
					
			?>


<!--script to crop image-->

<script type="text/javascript">

    /*show UTubeVideo Add Link*/

    function show_block_cate() {

        $("#onclk-text").css("display", "none");

        $("#VideoUrlInput").css("display", "block");

    }

    /*Next Button*/

    $(document).ready(function () {
		
		

        $('#next-btn').click(function (e) {
			
			var upload_at=$("#upload_at").val();
            var video_url = $("#video_url_id").val();

            image_count = $('#image_count').val();

            if (image_count == '0') {

                $('#danger').html(upload_at);
				 document.getElementById("errordisplay").style.display = "block";

            } else if (video_url != '' && image_count == '0') {
                $('#danger').html(upload_at);
				 document.getElementById("errordisplay").style.display = "block";

            } else {
                $('.loading').show();
                window.location.href = '<?php echo base_url() . "what_we_do/" . $id; ?>';

            }

        });

    });

    /*Crop it Plugin*/
 <?php if ($this->lang->line('image_h1920_w1080') != '') {
                    $use_an2= stripslashes($this->lang->line('image_h1920_w1080'));
                } else {
                    $use_an2= "576px in width and 928px in height.";
                }  ?>
    $(function () {
		
		var use_an=$("#use_an").val();

        $('.image-editor').cropit({

            exportZoom: 1.60,

            imageBackground: false,

            allowDragNDrop: true,

            imageBackgroundBorderWidth: 20,

            width: 360,

            height: 580,

            onImageError: function (e) {

               
                if (e.code === 1) {

                    $('.cropit-image-input').val("");

                    document.getElementById("errordisplay").style.display = "block";

                    $('#danger').html(use_an + " 576px in width and 928px in height.");

                    setTimeout(function () {

                        document.getElementById("danger").innerHTML = "";

                        document.getElementById("errordisplay").style.display = "none";

                    }, 3000);

                }

            }

        });

        /*rotating image*/

        $('.rotate-cw').click(function () {

            $('.image-editor').cropit('rotateCW');

        });

        $('.rotate-ccw').click(function () {

            $('.image-editor').cropit('rotateCCW');

        });

        /*getting cropped image details and uploading */

        $('form').submit(function () {
			$('.loading').show();
			var an_image=$("#an_image").val();

            if (document.getElementById("photos").files.length == 0) {

                $('.loading').hide();

                document.getElementById("errordisplay").style.display = "block";

                $('#danger').html(an_image);

                setTimeout(function () {

                    document.getElementById("errordisplay").style.display = "none";

                }, 2000);

                return false;

            }

            else {

                var imageData = $('.image-editor').cropit('export');

                $('.hidden-image-data').val(imageData);

                var formValue = $(this).serialize();



                $.ajax({

                    type: "POST",

                    url: "<?php echo base_url(); ?>site/experience/<?php echo ($aws == 'Yes') ? "ajaxImageUpload_aws" : "ajaxImageUpload"; ?>",

                    data: formValue,

                    success: function (msg) {

                        document.getElementById("errordisplay").style.display = "block";

                        $("#errordisplay").html(msg);

                        setTimeout(function () {

                            document.getElementById("errordisplay").style.display = "none";

                            location.reload();

                        }, 2000);

                    }

                })

                return false;

            }

        });

    });

    /*Delete the Image*/

    function DeleteExperienceImage(prdID, imgID) {
		$('.loading').show();
		var one_photo=$("#one_photo").val();

        imagecount = $('#image_count').val();

        if (imagecount == 1) {
            $('.loading').hide();
            $('#danger').html(one_photo);

            return false;

        } else {

            $('#danger').html('');

            $.ajax({

                type: 'post',

                url: '<?= base_url(); ?>site/experience/deleteProductImage',

                data: {prdID: prdID},

                dataType: 'json',

                success: function (json) {

                    window.location.reload();

                }

            });

        }

    }

</script>

