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
                        <select class="form-control" name="booking_no[]"  id="search_booking_no" multiple style="display: none;">
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

<script>
    // variable_names
// functionNames
// CONSTANT_VARIABLE_NAMES
// $_my_jquery_selected_element

if(typeof String.prototype.trim !== 'function') {
    
    String.prototype.trim = function()
    {
        return this.replace(/^\s+|\s+$/g, '');
    }
}

var checkbox_select = function(params)
{
    // Error handling first
    // ----------------------------------------------------------------------------------------------------
    
    var error = false;

    // If the selector is not given
    if(!params.selector) {                                              console.error("selector needs to be defined"); error = true; }

    // If the selector is not a string
    if(typeof params.selector != "string") {                            console.error("selector needs to be a string"); error = true; }

    // If the element is not a form
    if(!$(params.selector).is("form")) {                                console.error("Element needs to be a form"); error = true; }

    // If the element doesn't contain a select
    if($(params.selector).find("select").length < 1) {                  console.error("Element needs to have a select in it"); error = true; }

    // If the element doesn't contain option elements
    if($(params.selector).find("option").length < 1) {                  console.error("Select element needs to have an option in it"); error = true; }

    // If the select element doesn't have a name attribute
    if($(params.selector).find('select').attr('name') == undefined) {   console.error("Select element needs to have a name attribute"); error = true; }

    // If there was an error at all, dont continue in the code.
    if(error)
        return false;

    // ----------------------------------------------------------------------------------------------------

    var that            = this,
        $_native_form   = $(params.selector),
        $_native_select = $_native_form.find('select'),
        
        // Variables
        selector                = params.selector,
        select_name             = $_native_select.attr('name').charAt(0).toUpperCase() + $_native_select.attr('name').substr(1),
        selected_translation    = params.selected_translation   ? params.selected_translation   : "selected",
        all_translation         = params.all_translation        ? params.all_translation        : "All " + select_name + "s",
        not_found_text          = params.not_found              ? params.not_found              : "No " + select_name + "s found.",
        currently_selected      = [],
        
        // Create the elements needed for the checkbox select
        $_parent_div    = $("<div />")      .addClass("checkbox_select"),
        $_select_anchor = $("<a />")        .addClass("checkbox_select_anchor")     .text( select_name ),
        $_search        = $("<input />")    .addClass("checkbox_select_search"),
        $_submit        = $("<input />")    .addClass("checkbox_select_submit")     .val("Apply") .attr('type','submit') .data("selected", ""),
        $_dropdown_div  = $("<div />")      .addClass("checkbox_select_dropdown"),
        $_not_found     = $("<span />")     .addClass("not_found hide")             .text(not_found_text),
        $_ul            = $("<ul />"),

        updateCurrentlySelected = function()
        {
            var selected = [];

            $_ul.find("input:checked").each(
                                                        
                function()
                {
                    selected.push($(this).val());
                }
            );

            currently_selected = selected;

            if(selected.length == 0)
            {
                    $_select_anchor.text( select_name )
            }
            else if(selected.length == 1)
            {
                $_select_anchor.text( selected[0] + " " + selected_translation );
            }
            else if(selected.length ==  $_ul.find("input[type=checkbox]").length)
            {
                $_select_anchor.text( all_translation );
            }
            else
            {
                $_select_anchor.text( selected.length + " " + selected_translation );
            }
        },

        // Template for the li, will be used in a loop.
        createItem  = function(name, value, count)
        {
            var uID             = 'checkbox_select_' + select_name + "_" + name.replace(" ", "_"),
                $_li            = $("<li />"),
                $_checkbox      = $("<input />").attr(
                                        {
                                            'name'  : name,
                                            'id'    : uID,
                                            'type'  : "checkbox",
                                            'value' : value
                                        }
                                    )
                                    .click(

                                        function()
                                        {
                                            updateCurrentlySelected();
                                        }
                                    ),

                $_label         = $("<label />").attr('for', uID),
                $_name_span     = $("<span />").text(name).prependTo($_label),
                $_count_span    = $("<span />").text(count).appendTo($_label);
                        
            return $_li.append( $_checkbox.after( $_label ) );
        },
        
        apply = function()
        {
            $_dropdown_div.toggleClass("show");
            $_parent_div.toggleClass("expanded");
                
            if(!$_parent_div.hasClass("expanded"))
            {  
                // Only do the Apply event if its different
                if(currently_selected != $_submit.data("selected"))
                {
                    $_submit.data("selected" , currently_selected);

                    that.onApply(
                        { 
                            selected : $_submit.data("selected")
                        }
                    );
                }       
            }                   
        };
    
    // Event of this instance
    that.onApply = typeof params.onApply == "function" ? 
                
                    params.onApply :
                
                    function(e) 
                    {
                        //e.selected is accessible
                    };

    that.update = function() 
    {
        $_ul.empty();
        $_native_select.find("option").each(

            function(i)
            {
                $_ul.append( createItem( $(this).text(), $(this).val(), $(this).data("count") ) );
            }
        );

        updateCurrentlySelected();
    }

    that.check = function(checkbox_name, checked) 
    {
        //$_ul.find("input[type=checkbox][name=" + trim(checkbox_name) + "]").attr('checked', checked ? checked : false);

        $_ul.find("input[type=checkbox]").each(function()
        {
            // If this elements name is equal to the one sent in the function
            if($(this).attr('name') == checkbox_name)
            {
                // Apply the checked state to this checkbox
                $(this).attr('checked', checked ? checked : false);
                
                // Break out of each loop
                return false;
            }
        });
        
        updateCurrentlySelected();

    }

    // Build mark up before pushing into page
    $_dropdown_div  .prepend($_search);
    $_dropdown_div  .append($_ul);
    $_dropdown_div  .append($_not_found);
    $_dropdown_div  .append($_submit);
    $_dropdown_div  .appendTo($_parent_div);
    $_select_anchor .prependTo($_parent_div);

    // Iterate through option elements
    that.update();

    // Events 

    // Actual dropdown action
    $_select_anchor.click( 

        function()
        {
            apply();
        }
    );
             
    // Filters the checkboxes by search on keyup
    $_search.keyup(

        function()
        {
            var search = $(this).val().toLowerCase().trim();

            if( search.length == 1 )
            {
                $_ul.find("label").each(

                    function()
                    {
                        if($(this).text().toLowerCase().charAt(0) == search.charAt(0))
                        {
                            if($(this).parent().hasClass("hide"))
                                $(this).parent().removeClass("hide");

                            if(!$_not_found.hasClass("hide"))
                                $_not_found.addClass("hide");
                        }
                        else
                        {
                            if(!$(this).parent().hasClass("hide"))
                                $(this).parent().addClass("hide");

                            if($_not_found.hasClass("hide"))
                                $_not_found.removeClass("hide");
                        }
                    }
                );
            }
            else
            {
                // If it doesn't contain 
                if($_ul.text().toLowerCase().indexOf(search) == -1)
                {
                    if($_not_found.hasClass("hide"))
                        $_not_found.removeClass("hide");
                }
                else
                {
                    if(!$_not_found.hasClass("hide"))
                        $_not_found.addClass("hide");
                }
                    
                $_ul.find("label").each(

                    function()
                    {
                        if($(this).text().toLowerCase().indexOf(search) > -1)
                        {
                            if($(this).parent().hasClass("hide"))
                                $(this).parent().removeClass("hide");
                        }
                        else
                        {
                            if(!$(this).parent().hasClass("hide"))
                                $(this).parent().addClass("hide");
                        }
                    }
                );
            }
        }
    );

    $_submit.click(
                
        function(e)
        {
            e.preventDefault();

            apply();
        }
    );

    // Delete the original form submit
    $(params.selector).find('input[type=submit]').remove();

    // Put finalized markup into page.
    $_native_select.after($_parent_div);

    // Hide the original element
    $_native_select.hide();
};
</script>









<div class="table-responsive">

                    <table class="table table-striped leftAlign msgListing">
                        <tr>
                            <th width="5%"><?php if ($this->lang->line('S.no') != '') {
                                    echo stripslashes($this->lang->line('S.no'));
                                } else echo "S.no"; ?></th>
                            <th width="10%"><?php if ($this->lang->line('conv_with') != '') {
                                echo stripslashes($this->lang->line('conv_with'));
                            } else echo "Conversation with"; ?></th>
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
                                foreach ($med_messages as $med_message) {/*
                                    print_r($med_message);*/
                                    $user_details=$this->db->select('firstname,lastname,image')->where('id',$med_message->senderId)->get(USERS);
                                    $senderDetails=$user_details->row();
                                    ?>
                                    <tr <?php if ($med_message->msg_read == 'No') { ?> style="color: #a61d55" <?php } ?>>
                                    <td><?php echo $i;
                                            $i++; ?></td>
                                    <td>

                                        <div>
                                        <?php
                                            $imageSrc = 'profile.png';
                                            if ($senderDetails->image != "" && file_exists('./images/users/' . $senderDetails->image)) {
                                                $imageSrc = $senderDetails->image;
                                            }
                                            echo img('images/users/' . $imageSrc, TRUE, array('class' => 'user_updated','style'=>'width:50%;'));
                                        ?>
                                        <div><?php echo ($med_message->senderId!=$this->session->fc_session_user_id)?ucfirst($senderDetails->firstname . ' ' . $senderDetails->lastname):'Me'; ?></div>
                                        <div class="date"><small><i><?php echo date('d-m-Y', strtotime($med_message->dateAdded)); ?></i></small></div>
                                        </div>
                                    </td>
									
									<?php if ($this->lang->line('There is a booking request for you') != '') {
                                    $thereis= stripslashes($this->lang->line('There is a booking request for you'));
                                } else $thereis= "There is a booking request for you"; ?>
									
                                    <td><?php echo ucfirst($med_message->subject); ?><?php echo ($med_message->msg_unread_count > 0) ? ' <div class="badge" title="Unread counts">' . $med_message->msg_unread_count . '</div>' : '';
                                            if (($med_message->status == 'Pending') && ($med_message->user_id == $luser_id)) {
                                                echo "<p class='text-danger'>$thereis</p>";
                                            } ?></td>
                                    <td class="font16">
                                        <!-- =============================== -->
                                       <!--  <a href="<?php //echo base_url(); ?>change-archive-status/<?php //echo $med_message->bookingNo; ?>/<?php //echo $med_message->id; ?>/0" title="Archive"><i class="fa fa-archive" aria-hidden="true"></i></a> -->
                                        <!-- =============================== -->
                                        <a href="<?php echo base_url(); ?>new_conversation/<?php echo $med_message->bookingNo; ?>/<?php echo $med_message->id; ?>" title="View">
                                            <i class="fa fa-eye" aria-hidden="true"></i> </a>
                                        <!-- =============================== -->
                                        <?php if ($med_message->msg_star_status == 'No') { ?>
                                        <a href="<?php echo base_url(); ?>change-star-status/<?php echo $med_message->bookingNo; ?>/<?php echo $med_message->id; ?>/0" title="Not Starred"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                        <!-- =============================== -->
                                        <?php }else if($med_message->msg_star_status == 'Yes'){ ?>
                                            <a href="<?php echo base_url(); ?>change-star-status/<?php echo $med_message->bookingNo; ?>/<?php echo $med_message->id; ?>/1" title="Starred"><i class="fa fa-star" aria-hidden="true"></i></a>
                                        <!-- =============================== -->    
                                        <?php } //if ($med_message->msg_read == 'Yes') { ?>
                                          <a href="site/user_settings/delete_conversation_details_msg/<?php echo $med_message->id; ?>" title="Archive">
                                                <i class="fa fa-archive" aria-hidden="true"></i> </a>
                                        <?php //} ?>
                                        <!-- =============================== -->
                                    </td>
                                    </tr><?php
                                }
                            } else { ?>
                                <tr>
                                    <td colspan="4"><p
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
    </section>

<div class="myPagination" id="page_numbers">
    <?php
    echo $paginationLink;
    ?>
</div>

<?php
    $this->load->view('site/includes/footer');
?>


<script type="text/javascript">

    $(document).ready(function() {
        $('#booking_number_filter').show();
        $('#search_booking_no').multiselect();
    });

</script>