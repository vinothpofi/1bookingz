<?php
$this->load->view('site/includes/header');
$this->load->view('site/includes/top_navigation_links');
$currency_result = $this->session->userdata('currency_result');
?>
<style>
    .multiselect.dropdown-toggle{min-width: 86px; height: 48px; padding:15px 5px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: 17ch;}
    .open .multiselect.dropdown-toggle {border-bottom: 0px solid #787878 !important;background: transparent !important;box-shadow: none !important;}
    ul.multiselect-container>li a {padding: 5px;}
    ul.multiselect-container>li:last-child a {border-bottom: 0px solid;}
    ul.multiselect-container>li a:hover {background-color: #f5f5f5;border-bottom: 1px solid transparent;}
    .multiselect.dropdown-toggle:active, .multiselect.dropdown-toggle:focus, .multiselect.dropdown-toggle:hover {border-bottom: 0px solid #787878 !important;background: transparent !important;box-shadow: none !important;color: #008489;}
    .multiselect.dropdown-toggle:focus {}
    #booking_number_filter{float: right;}
    /*#booking_number_filter .pull-left { float: none !important; }*/
    .submitBtn1.pull-left{float: right !important;}
    .user_updated{
        margin-left: auto;
        margin-right: auto;
        width: 50%;
        border-radius: 30px;
    }
    .font16{
        font-size: 16px;
    }
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="<?php echo base_url(); ?>js/multipleSelect/bootstrap-multiselect.js"></script>
<section>
    <div class="container">
        <div class="loggedIn clear">
            <div class="width20">
                        <?php 
                            $this->load->view('site/includes/message_sidebar');
                         ?>   
            </div>
            <div class="width80">
                 <form name="booking_number_filter" method="post" id="booking_number_filter" action="<?php echo base_url().$page_name;?>">
                        <?php
                        //print_r($bookingNo_all);
                        //print_r($selected_booking_nos);
                        ?>

                        <div class="pull-left col-lg-3">
                        <select class="form-control" name="booking_no[]"  id="search_booking_no" multiple >
                            <?php
                            if(!empty($bookingNo_all)){
                                foreach ($bookingNo_all as $b_n){
                                    ?>
                                    <option value="<?php echo $b_n->bookingNo; ?>" <?php echo in_array($b_n->bookingNo,$selected_booking_nos) ? "selected" : "" ; ?>><?php echo $b_n->bookingNo; ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                        </div>

                        <button type="submit" name="submit" value="Search" class="submitBtn1 submit pull-left" ><?php if ($this->lang->line('submit') != '') {
                                    echo stripslashes($this->lang->line('submit'));
                                } else echo "Submit"; ?></button>

                    </form>
                    <div class="table-responsive">
                <table class="table table-striped leftAlign msgListing">
                    <tr>
                        <th width="5%"><?php if ($this->lang->line('S.no') != '') {
                                echo stripslashes($this->lang->line('S.no'));
                            } else echo "S.no"; ?></th>
                        <th width="10%"><?php if ($this->lang->line('conv_with') != '') {
                                echo stripslashes($this->lang->line('conv_with'));
                            } else echo "conversation with"; ?></th>
                        <!--<th width="30%"><?php if ($this->lang->line('Date') != '') {
                                echo stripslashes($this->lang->line('Date'));
                            } else echo "Date"; ?></th>-->
                        <th width="50%"><?php if ($this->lang->line('Subject') != '') {
                                echo stripslashes($this->lang->line('Subject'));
                            } else echo "Subject"; ?></th>
                        <th width="25%"><?php if ($this->lang->line('Action') != '') {
                                echo stripslashes($this->lang->line('Action'));
                            } else echo "Action"; ?></th>
                    </tr>
                    <?php
                    $i = 1;
                    if (!empty($med_messages)) {
                        foreach ($med_messages as $med_message) {
                             $user_details=$this->db->select('firstname,lastname,image')->where('id',$med_message->senderId)->get(USERS);
                                    $senderDetails=$user_details->row();
                            ?>
                            <tr>
                            <td><?php echo $i;
                                $i++; ?></td>
                            <td>
                                <?php
                                $imageSrc = 'profile.png';
                                if ($senderDetails->image != "" && file_exists('./images/users/' . $senderDetails->image)) {
                                    $imageSrc = $senderDetails->image;
                                }
                                echo img('images/users/' . $imageSrc, TRUE, array('class' => 'user_updated','style'=>'width:50%;'));
                                ?>
                                <div><?php echo ($med_message->senderId!=$this->session->fc_session_user_id)?ucfirst($senderDetails->firstname . ' ' . $senderDetails->lastname):'Me'; ?></div>
                                        <div class="date"><small><i><?php echo date('d-m-Y', strtotime($med_message->dateAdded)); ?></i></small></div>
                            </td>
                            <!--<td>
                                <div><?php /*echo ucfirst($med_message->firstname . ' ' . $med_message->lastname); */ ?></div>
                                <div class="date"><?php echo date('d-m-Y', strtotime($med_message->dateAdded)); ?></div>
                            </td>-->
                            <td><?php echo ucfirst($med_message->subject); ?><?php echo ($med_message->msg_unread_count > 0) ? ' (' . $med_message->msg_unread_count . ')' : '';
                                if (($med_message->status == 'Pending') && ($med_message->user_id == $luser_id)) {
                                    echo '<p class="text-danger">There is a booking request for you</p>';
                                } ?></td>
                            <td class="font16">
                                <!-- =============================== -->
                                <a href="<?php echo base_url(); ?>experience_conversation/<?php echo $med_message->bookingNo; ?>/<?php echo $med_message->id; ?>">
                                    <i class="fa fa-eye" aria-hidden="true"></i> </a>
                                <!-- =============================== --> 
                                <?php if ($med_message->msg_star_status == 'No') { ?>
                                        <a href="<?php echo base_url(); ?>experience-change-star-status/<?php echo $med_message->bookingNo; ?>/<?php echo $med_message->id; ?>/0" title="Not Starred"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                <!-- =============================== -->
                                        <?php }else if($med_message->msg_star_status == 'Yes'){ ?>
                                            <a href="<?php echo base_url(); ?>experience-change-star-status/<?php echo $med_message->bookingNo; ?>/<?php echo $med_message->id; ?>/1" title="Starred"><i class="fa fa-star" aria-hidden="true"></i></a>
                                <!-- =============================== -->

                                <?php } //if ($med_message->msg_read == 'Yes') { ?>
                                    <a href="site/experience/delete_conversation_details_msg/<?php echo $med_message->id; ?>" title="Archive">
                                        <i class="fa fa-archive" aria-hidden="true"></i> </a>
                                <?php //} ?>
                                <!-- =============================== -->
                            </td>
                            </tr><?php
                        }
                    } else { ?>
                        <tr>
                            <td colspan="5"><p
                                        class="text-danger text-center"><?php if ($this->lang->line('NoMessage') != '') {
                                        echo stripslashes($this->lang->line('NoMessage'));
                                    } else echo "There is no message(s) in inbox"; ?></p></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            </div>
        </div>
    </div>
</section><div class="myPagination" id="page_numbers">    <?php    echo $paginationLink;    ?></div>
<?php
$this->load->view('site/includes/footer');
?>
<script type="text/javascript">

    $(document).ready(function() {
        $('#search_booking_no').multiselect();
    });

</script>