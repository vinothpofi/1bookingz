<?php
$this->load->view('site/includes/header');
$this->load->view('site/includes/top_navigation_links');
$currency_result = $this->session->userdata('currency_result');
?>
    <section>
        <div class="container">
            <div class="loggedIn clear">
                <div class="width20">
                    <ul class="sideBarMenu">
                        <li>
                            <a href="<?php echo base_url(); ?>settings" <?php if ($this->uri->segment(1) == 'settings') { ?> class="active" <?php } ?>><?php if ($this->lang->line('EditProfile') != '') {
                                    echo stripslashes($this->lang->line('EditProfile'));
                                } else echo "Edit Profile"; ?></a></li>
                        <li>
                            <a href="<?php echo base_url(); ?>photo-video" <?php if ($this->uri->segment(1) == 'photo-video') { ?> class="active" <?php } ?>><?php if ($this->lang->line('photos') != '') {
                                    echo stripslashes($this->lang->line('photos'));
                                } else echo "Photos"; ?></a></li>
                        <li>
                            <a href="<?php echo base_url(); ?>verification" <?php if ($this->uri->segment(1) == 'verification') { ?> class="active" <?php } ?>><?php if ($this->lang->line('TrustandVerification') != '') {
                                    echo stripslashes($this->lang->line('TrustandVerification'));
                                } else echo "Trust and Verification"; ?></a></li>
                        <li>
                            <a href="<?php echo base_url(); ?>display-review" <?php if ($this->uri->segment(1) == 'display-review') { ?> class="active" <?php } ?>><?php if ($this->lang->line('Reviews') != '') {
                                    echo stripslashes($this->lang->line('Reviews'));
                                } else echo "Reviews"; ?></a></li>
                      <li>
                            <a href="users/show/<?php echo $userDetails->row()->id; ?>"><?php if ($this->lang->line('ViewProfile') != '') {
                                    echo stripslashes($this->lang->line('ViewProfile'));
                                } else echo "View Profile"; ?></a></li>
                    </ul>
                </div>
                <div class="width80">
                    <div class="tableRow photos marginBottom2">
                        <div class="left">
                            <div class="profile_I">
                                <?php
                                if ($userDetails->row()->image != '' && file_exists('./images/users/' . $userDetails->row()->image)) {
                                    $imgSource = "images/users/" . $userDetails->row()->image;
                                } else {
                                    $imgSource = "images/users/profile.png";
                                }
                                echo img($imgSource, TRUE, array('class' => 'opacity'));
                                echo img($imgSource, TRUE, array('class' => 'dp'));
                                ?>
                            </div>
                        </div>
                        <div class="right">
                            <h5><?php if ($this->lang->line('upload_Photo') != '') {
                                    echo stripslashes($this->lang->line('upload_Photo'));
                                } else echo "Upload Profile Picture"; ?></h5>
                            <p class="note"><?php if ($this->lang->line('Clearfrontal') != '') {
                                    echo stripslashes($this->lang->line('Clearfrontal'));
                                } else echo "Clear frontal face photos are an important way for hosts and guests to learn about each other. It's not much fun to host a landscape! Please upload a photo that clearly shows your face."; ?></p>
								
								
								
								
                            <p class="text-danger"><b><?php if ($this->lang->line('note') != '') {
                                    echo stripslashes($this->lang->line('note'));
                                } else echo "Note"; ?> : </b><?php if ($this->lang->line('img_type_should') != '') {
                                    echo stripslashes($this->lang->line('img_type_should'));
                                } else echo "Image type should"; ?> jpg, jpeg, Png  <?php if ($this->lang->line('img_dimension') != '') {
                                    echo stripslashes($this->lang->line('img_dimension'));
                                } else echo "And Image dimensions should"; ?> 272*272px.</p>
								
								
								
								
                            <?php
                            echo form_open_multipart('photo-video');
                            echo form_upload('upload-file', '', array('class' => 'marginBottom2 fileStyle', 'required' => 'required'));
                            if ($this->lang->line('SaveSetting') != '') {
                                $btnValue = stripslashes($this->lang->line('SaveSetting'));
                            } else $btnValue = "Save Settings";
                            ?>
                            <p class="text-danger"><?php echo $errors; ?></p>
                            <p class="text-success"><?php echo $success; ?></p>
                            <?php
                            echo form_submit('file-upload', $btnValue, array('class' => 'submitBtn1'));
                            echo form_close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->load->view('site/includes/footer');
?>