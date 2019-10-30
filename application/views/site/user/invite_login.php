<?php
$this->load->view('site/includes/header');
//$this->load->view('site/includes/top_navigation_links');
$currency_result = $this->session->userdata('currency_result');
?>
<section>
	<div class="container-fluid inviteBg"
		 style="background-image: url('<?php echo base_url(); ?>images/invite_login.jpg');">
		<div class="col-md-4"></div>
		<div class="col-md-4 text-center" style="margin-top:100px;">
			<img class="img img-circle" src="<?php if ($user_image != '') {
				echo base_url(); ?>images/users/<?php echo $user_image;
			} else echo base_url()."images/users/profile.png"; ?>" alt="" height="80px"><br><br>
			<button class="submitBtn" data-toggle="modal" data-target="#signUp">Sign up to claim your credit</button>
		</div>
		<div class="col-md-4"></div>
		<div class="clearfix"></div>
	</div>
	<div class="container inviteFrnds">
		<div class="heading">
			<h2><?php if ($this->lang->line('How_it_Works') != '') {
					echo stripslashes($this->lang->line('How_it_Works'));
				} else echo "How it Works"; ?></h2>
			<h5><?php
				if ($this->lang->line('Rent unique, local accommodations on any budget, anywhere in the world') != '') {
					echo stripslashes($this->lang->line('Rent unique, local accommodations on any budget, anywhere in the world'));
				} else echo "Rent unique, local accommodations on any budget, anywhere in the world";
				?></h5>
		</div>
		<div class="row text-center">
			<div class="col-md-4">
				<h4><?php if ($this->lang->line('Explore') != '') {
						echo stripslashes($this->lang->line('Explore'));
					} else echo "Explore"; ?></h4>
				<p><?php if ($this->lang->line('Find_the_perfect_place') != '') {
						echo stripslashes($this->lang->line('Find_the_perfect_place'));
					} else echo "Find the perfect place"; ?></p>
			</div>
			<div class="col-md-4">
				<h4><?php if ($this->lang->line('footer_contact') != '') {
						echo stripslashes($this->lang->line('footer_contact'));
					} else echo "Contact"; ?></h4>
				<p><?php if ($this->lang->line('Message hosts') != '') {
						echo stripslashes($this->lang->line('Message hosts'));
					} else echo "Message hosts"; ?></p>
			</div>
			<div class="col-md-4">
				<h4><?php if ($this->lang->line('Book') != '') {
						echo stripslashes($this->lang->line('Book'));
					} else echo "Book"; ?></h4>
				<p><?php if ($this->lang->line('View_your_itinerary') != '') {
						echo stripslashes($this->lang->line('View_your_itinerary'));
					} else echo "View your itinerary"; ?></p>
			</div>
		</div>
	</div>
</section>
<?php
$this->load->view('site/includes/footer');
?>
