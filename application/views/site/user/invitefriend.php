<?php$this->load->view('site/includes/header');$this->load->view('site/includes/top_navigation_links');$currency_result = $this->session->userdata('currency_result'); if ($this->lang->line('valid_email') != '') {                            $valid_email = stripslashes($this->lang->line('valid_email'));                        } else{ $valid_email = "enter valid email id's!";} ?>    <section>        <div class="container-fluid inviteBg dbInviteBg"             style="background-image: url('<?php echo base_url(); ?>images/invite_friend.png');"></div>        <div class="container inviteFrnds">            <div class="heading">                <h2>				                    <?php if ($this->lang->line('send_a_friend') != '') {                        echo stripslashes($this->lang->line('send_a_friend'));                    } else echo "Send a friend Homestay credit, you will get"; ?> <?= $guest_invite; ?> <?= ($guest_promotion_type == "percentage") ? "%" : "$"; ?> <?php if ($this->lang->line('when_they_travel') != '') {  echo stripslashes($this->lang->line('when_they_travel'));   } else echo "when they travel"; ?>.																				                    <?php                    /*if ($this->lang->line('send_home_stay_credit') != '') {                        stripslashes($this->lang->line('send_home_stay_credit'));                    } else {                        "Send a friend Homestay credit, you will get " . $guest_invite . ($guest_promotion_type == "percentage") ? "%" : "$" . "  when they travel and " . $host_invite . ($host_promotion_type == "percentage") ? "%" : "$" . " when they host";                    }*/ ?></h2>                <h5><?php                    if ($this->lang->line('Youvegot') != '') {                        echo stripslashes($this->lang->line('You have got'));                    } else echo "You have got"; ?> $                   <?php                     if($this->session->userdata('currency_result') != 'USD'){                    echo changeCurrency('USD',$this->session->userdata('currency_type'),$Details->row()->referalAmount).' '.$this->session->userdata('currency_type');                    }               else               {                 echo ' '.$Details->row()->referalAmount;                }                    ?>                    <?php if ($this->lang->line('in travel credit to spend!') != '') {                        echo stripslashes($this->lang->line('in travel credit to spend!'));                    } else echo "in travel credit to spend!"; ?></h5>            </div>            <div class="row">                  <p class="text-danger" id="err_email" style="text-align: center;">                        <?php                        echo $this->session->flashdata('sErrMSG');                        //echo $this->session->flashdata('sErrMSG');                        ?></p>                <div class="col-md-6">                  <?php  $guest_invite_status_query = 'SELECT * FROM ' . COMMISSION . " where commission_type ='Guest Invite' "; $guest_invite_status = $this->cms_model->ExecuteQuery($guest_invite_status_query); if($guest_invite_status->row()->status == 'Active') {?>                    <div class="searchTable clear">                        <?php                        echo form_open('site/cms/invite_add_form', array('class' => 'clear'));                        if ($this->lang->line('Add friend email address') != '') {                            $inputPlaceholder = stripslashes($this->lang->line('Add friend email address'));                        } else $inputPlaceholder = "Add friend email address";                        if ($this->lang->line('Send') != '') {                            $btnPlaceholder = stripslashes($this->lang->line('Send'));                        } else $btnPlaceholder = "Send";                        echo form_hidden('sender_id', $this->session->userdata('fc_session_user_id'));                        echo form_input('invite_email', '', array('id' =>'invite_email','placeholder' => $inputPlaceholder, 'required' => 'required'));                        echo form_submit('send', $btnPlaceholder, array('id' =>'submit_id' ,'class' => 'submit'));                        ?>                        <p class="reduceFont"><?php if ($this->lang->line('Separate multiple emails with commas') != '') {                                echo stripslashes($this->lang->line('Separate multiple emails with commas'));                            } else echo "Separate multiple emails with commas"; ?></p>                        <?php echo form_close(); ?>                    </div><?php}else{?><div class="searchTable clear">    <h4>Sorry Now Invite Friend Option Is Not Available</h4></div><?php    }?>                </div>                <div class="col-md-6">                    <div class="searchTable clear">                        <?php                        $url = $this->config->item('facebook_share');                        $url = urlencode($url);                        $facebook_share = 'http://www.facebook.com/sharer.php?u=' . $url;                        ?>                        <form class="clear">                            <input type="text" name="" readonly                                   value="<?php echo $facebook_share; ?>"                                   placeholder="">                            <input type="button"                                   onclick="javascript:window.location.href='<?php echo $facebook_share; ?>';"                                   value="<?php if ($this->lang->line('Share') != '') {                                    echo stripslashes($this->lang->line('Share'));                                } else echo "Share"; ?>" class="submit">                            <p class="reduceFont"><?php if ($this->lang->line('Share') != '') {                                    echo stripslashes($this->lang->line('Share'));                                } else echo "Share"; ?> <a                                        href="https://twitter.com/share?url=<?php echo base_url(); ?>&text=I%20love%20this"><i                                            class="fa fa-twitter" aria-hidden="true"></i></a></p>                        </form>                    </div>                </div>            </div>        </div>    </section><?php$this->load->view('site/includes/footer');?><script type="text/javascript">     $('#submit_id').click(function(){     var email=$('#invite_email').val();          var email = email.split(',')     var valid = true;     var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;     for(var i = 0; i < email.length;i++)     {         if(email[i] === '' || !reg.test(email[i].replace(/\s/g, "")))         {             valid = false;         }     }   if (valid == false)        {            $('#err_email').html('Enter Valid Email Id');             setTimeout(function () {                    document.getElementById("err_email").innerHTML = "";                }, 2000);              return false;        }        else        {            $('#err_email').html('');            return true;            }           });    </script>