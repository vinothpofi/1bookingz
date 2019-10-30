<?php
$this->load->view('site/includes/header');
//$this->load->view('site/includes/top_navigation_links');
$currency_result = $this->session->userdata('currency_result');
//print_r($_REQUEST);
if($Confirmation =='Success'){
$user_currencycode=$invoicedata->row()->user_currencycode;
$Prd_currencycode=$invoicedata->row()->currencycode;
$unitprice=$invoicedata->row()->unitPerCurrencyUser;
}
$Confirmation = 'Success';
?>

    <script type="text/javascript">
        $(document).ready(function(){
            setTimeout(function(){ $(".svgDiv").addClass("drawn") }, 500);
        });
    </script>
    <section class="countDown">
        <!--<div class="container-fluid inviteBg"
             style="background-image: url('<?php echo base_url(); ?>images/<?php echo ($Confirmation == 'Success') ? 'payment_success' : 'payment_failed'; ?>.jpg');"></div>-->
        <div class="container inviteFrnds">
            <p class="text-center text-info" style="margin-top: 10px;font-size: 14px;"> Page will redirect in <span
                        id="countdowntimer">10 </span> Seconds</p>
            <?php ?>
                <div class="heading">

                    <div class="svgDiv">
                        <svg version="1.1" id="tick" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 37 37" style="enable-background:new 0 0 37 37;" xml:space="preserve">
                            <path class="circ path" style="fill:none;stroke:#78b645;stroke-width:1.3;stroke-linejoin:round;stroke-miterlimit:10;" d="
                            M30.5,6.5L30.5,6.5c6.6,6.6,6.6,17.4,0,24l0,0c-6.6,6.6-17.4,6.6-24,0l0,0c-6.6-6.6-6.6-17.4,0-24l0,0C13.1-0.2,23.9-0.2,30.5,6.5z"
                            />
                            <polyline class="tick path" style="fill:none;stroke:#78b645;stroke-width:1.3;stroke-linejoin:round;stroke-miterlimit:10;stroke-linecap: round;" points="
                            11.6,20 15.9,24.2 26.4,13.8 "/>
                        </svg>
                    </div>

                    <h2><?php if ($this->lang->line('listed_succes') != '') {
                            echo stripslashes($this->lang->line('listed_succes'));
                        } else echo "Listed Successfully"; ?></h2>
                    <h5><?php if ($this->lang->line('Congratulation_host_exp') != '') {
            echo stripslashes($this->lang->line('Congratulation_host_exp'));
        } else { echo "Congratulation your experience has been listed. Please pay further to book"; } ?></h5>
                </div>
               
            <?php
            $this->output->set_header('refresh:10;url=' . base_url() . 'experience/all');
            ?>
        </div>
    </section>
    <script type="text/javascript">
        var timeleft = 10;
        var downloadTimer = setInterval(function () {
            timeleft--;
            document.getElementById("countdowntimer").textContent = timeleft;
            if (timeleft <= 0)
                clearInterval(downloadTimer);
        }, 1000);
    </script>
<?php
$this->load->view('site/includes/footer');
?>