<?php
$this->load->view('site/includes/header');
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
        width: 600px;
        height: 400px;
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
    $this->load->view('site/includes/listing_head_side');
    ?>
    <div class="centeredBlock">
        <div class="content">
            <?php if ($this->session->flashdata('sErrMSG')) { ?>
                <div class="alert alert-success alert-dismissable">
                    <?php echo $this->session->flashdata('sErrMSG') ?>
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                </div>
            <?php } ?>
            <h3><?php if ($this->lang->line('AddPhotos') != '') {
                    echo stripslashes($this->lang->line('AddPhotos'));
                } else echo "Add photos!"; ?>
            </h3>
            <p>
                <?php if ($this->lang->line('Orthree') != '') {
                    echo stripslashes($this->lang->line('Orthree'));
                } else echo "Guests love photos that highlight the features of your space."; ?>
            </p>
			<p class="text center text-danger"><?php if ($this->lang->line('image_h400_w600') != '') {
                    echo stripslashes($this->lang->line('image_h400_w600'));
                } else echo "Please  use an image that's at least 1300px in width and 650px in height."; ?></p>
            <div class="error-display" id="errordisplay" style="text-align: center; display: none;">
                <p class="text center text-danger" id="danger"></p>
                <p class="text center text-success" id="success"></p>
            </div>
            <?php
            echo form_open_multipart('#', array('id' => 'formUpload'));
            ?>
            <input type="hidden" id="id" name="id" value="<?php echo $listDetail->row()->id; ?>"/>
            <div class="image-editor" id="image_editor">
                <div class="cropit-preview marginBottom3" id="cropit-preview"></div>
                <?php $addphotoattr = array(
                    'name' => 'photos',
                    'id' => 'photos',
                    'class' => 'submitBtn1 marginBottom3 cropit-image-input'
                );
                echo form_upload($addphotoattr);
                ?>
                <div class="image-size-label">
                    
					
				<?php if ($this->lang->line('resize_img') != '') {
                    echo stripslashes($this->lang->line('resize_img'));
                } else echo "Resize image"; ?>
					
                </div>
                <input type="range" class="cropit-image-zoom-input">
                <input type="hidden" name="image-data" id="image-data" class="hidden-image-data"/>
				<?php if ($this->lang->line('rotate_one') != '') {
                    $rot_one= stripslashes($this->lang->line('rotate_one'));
                } else $rot_one= "Rotate counterclockwise"; ?>
				
				<?php if ($this->lang->line('rotate_two') != '') {
                    $rot_two= stripslashes($this->lang->line('rotate_two'));
                } else $rot_two= "Rotate clockwise"; ?>
				
				
                <?php
                $ccw = array(
                    'name' => '',
                    'class' => 'rotate-ccw submitBtn1',
                    'id' => ''
                );
                echo form_button('', "$rot_one", $ccw);
                ?>
                <?php
                $cw = array(
                    'name' => '',
                    'class' => 'rotate-cw submitBtn1',
                    'id' => ''
                );
                echo form_button('', "$rot_two", $cw);
                ?>
				
				
				<?php if ($this->lang->line('upload') != '') {
                    $upload= stripslashes($this->lang->line('upload'));
                } else $upload= "Upload"; ?>
                <div class="text-right marginTop1">
                    <?php
                    $imgsubmt = array(
                        'name' => '',
                        'value' => "$upload",
                        'class' => 'submitBtn1',
                        'id' => ''
                    );
                    echo form_submit($imgsubmt);
                    ?>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
        <!--div to show uploaded images-->
        <?php if (!empty($imgDetail)) {
            foreach ($imgDetail->result() as $img) { ?>
                <div class="photoDesc clear marginTop1">
                    <div class="left">
                        <img src="<?php echo base_url() . 'images/rental/' . $img->product_image; ?>">
                    </div>
                    <div class="right">
					
                        <textarea placeholder="<?php if ($this->lang->line('enter_description') != '') {
                    echo stripslashes($this->lang->line('enter_description'));
                } else echo "Enter Description"; ?>" onblur="SavePhotoCaption('<?php echo $img->id; ?>',this.value);"><?php echo $img->caption; ?></textarea>
                    </div>
                    <a href="javascript:void(0)" class="del_flx"
                       title="<?php if ($this->lang->line('Delete this image') != '') {
                           echo stripslashes($this->lang->line('Delete this image'));
                      } else echo "Delete this image"; ?>"
                       onClick="javascript:SiteDeleteProductImage(<?php echo $img->id; ?>,<?php echo $listDetail->row()->id; ?>);"><i
                                class="fa fa-trash-o"></i></a>
                </div>
                <?php
            }
        } ?>
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
                <?= form_input('video_url', $listDetail->row()->video_url, array('id' => 'video_url_id', 'placeholder' => ($this->lang->line('video_url') != '') ? stripslashes($this->lang->line('video_url')) : "Enter video link", 'onchange' => "checkurl_valid(this," . $listDetail->row()->id . ",'video_url')", 'onpaste' => "checkurl_valid(this," . $listDetail->row()->id . ",'video_url')", 'maxlength' => 60)); ?>
                <p id="video_error" class="text-danger"></p>
            </div>
        </div>
        <div class="clear text-right">
            <a class="submitBtn1" onclick="inloader();" style="cursor: pointer;">
                <?php if ($this->lang->line('Next') != '') {
                    echo stripslashes($this->lang->line('Next'));
                } else echo "Next"; ?>
            </a>
        </div>
    </div>
    <div class="rightBlock">
        <h2><i class="fa fa-lightbulb-o" aria-hidden="true"></i>
            <?php if ($this->lang->line('Video URL') != '') {
                echo stripslashes($this->lang->line('Video URL'));
            } else echo "Video URL"; ?>
        </h2>
        <p>
            <?php if ($this->lang->line('photos1_add_photos') != '') {
                echo stripslashes($this->lang->line('photos1_add_photos'));
            } else echo "Add photos of your property which will tempt the guests to book your rentals."; ?>
        </p> 
        <p>
            <?php if ($this->lang->line('photos2_you_can_also') != '') {
                echo stripslashes($this->lang->line('photos2_you_can_also'));
            } else echo "You can also add videos about your property. Add the YouTube link of your videos which are supported."; ?>
        </p> 

      <!--   <p>
            <?php if ($this->lang->line('It will only be shared with guests after a reservation is confirmed') != '') {
                echo stripslashes($this->lang->line('It will only be shared with guests after a reservation is confirmed'));
            } else echo "It will only be shared with guests after a reservation is confirmed"; ?>
        </p> -->
    </div>
</div>
<!--script to crop image-->
<script type="text/javascript">
    $(function () {
        $('.image-editor').cropit({
            exportZoom: 1,
            imageBackground: false,
            allowDragNDrop: true,
            imageBackgroundBorderWidth: 20,
            width: 1300,
            height: 650,
            onImageError: function (e) { 
                if (e.code === 1) 
                {
                    $('.cropit-image-input').val("");
                    document.getElementById("errordisplay").style.display = "block";
                   /* $('#errordisplay').text("Please use an image that's at least " + $('.cropit-preview').outerWidth() + "px in width and " + $('.cropit-preview').outerHeight() + "px in height.");*/                    
					$('.text-danger').css('color','#F00');
                    setTimeout(function () {
                        //document.getElementById("danger").innerHTML = "";
                       // document.getElementById("errordisplay").style.display = "none";
					   $('.text-danger').css('color','#a61d55');
                    }, 5000);
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
            if (document.getElementById("photos").files.length == 0) {
                $('.loading').hide();
                $("#errordisplay").show();
                $('#danger').text("Please choose an image.");
                $("#errordisplay").hide();
                return false;
            }/*else if(document.getElementById("photos").files.height){
                alert(document.getElementById("photos").files.height);
                return false;
            }*/
            else {
                
                var imageData = $('.image-editor').cropit('export');
                $('.hidden-image-data').val(imageData);
                var formValue = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>/photos_uploading ",
                    data: formValue,
                    success: function (msg) {
                        document.getElementById("errordisplay").style.display = "block";
                        $("#errordisplay").html(msg);
                        /*setTimeout(function () {
                            document.getElementById("errordisplay").style.display = "none";
                            location.reload();
                        }, 2000);*/
                        document.getElementById("errordisplay").style.display = "none";
                        location.reload();
                    }
                })
                return false;
            }
        });
    });

    function SavePhotoCaption(id, caption) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '<?php echo base_url()?>site/product/SavePhotoCaption',
            data: {id: id, caption: caption},
            success: function (response) {
            }
        });
    }

    /*show UTubeVideo Add Link*/
    function show_block_cate() {
        $("#onclk-text").hide();
        $("#VideoUrlInput").show();
    }

    /*Youtube validation*/
    function checkurl_valid(data, rentalId, update_field) {
        var url = data.value;
        if (url != '') {
            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
            var match = url.match(regExp);
            if (parseInt(match[2].length) == 11) {
                $("#video_error").html("");
                Detailview(data, rentalId, update_field);
            }
            else {
                $("#video_error").html("Please provide an valid YouTube Video Url!!");
                return false;
            }
        }
        else {
            Detailview(data, rentalId, update_field);
            $("#video_error").html("");
        }
    }

    /*Delete property image*/
    function SiteDeleteProductImage(prdID, imgID) {
        $('.loading').show();
        $.ajax({
            type: 'post',
            url: '<?= base_url(); ?>site/product/deleteProductImage',
            data: {prdID: prdID},
            dataType: 'json',
            success: function (json) {
                window.location.reload();
            }
        });
    }
     function inloader()
    {
         $('.loading').show();

          var listDetailid = '<?= $listDetail->row()->id;?>';
          var base_url = '<?= base_url(); ?>';
        window.location.href=base_url+"amenities_listing/"+listDetailid;
    }
</script>
