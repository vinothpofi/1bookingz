<?php

    $this->load->view('site/includes/header');

?>
<style type="text/css">
.cmsPage table {border:1px solid #ccc;background-color: transparent;}    
.cmsPage table th {font-weight: 600;}
.cmsPage table th, .cmsPage table td {border:1px solid #ccc;padding: 7px;line-height: 1;}    
.cmsPage ul li {list-style: disc;}
.cmsPage ul, .cmsPage ol {padding-left: 20px;}
.cmsPage ol li {list-style: decimal;}
</style>
    <section class="displayCms cmsPage">

        <div class="container">

            <div class="row">

                <div class="col-lg-12 cms-hr">
                     
                    <h2 class="text-center text-capitalize"><?php echo $pageDetails->row()->page_name; ?></h2>

                    <hr>

                </div>

                <div class="col-lg-12">

                    <p class="text-justify"><?php if ($pageDetails->num_rows() > 0) {

                            echo preg_replace('/\s+/', ' ', trim(stripcslashes($pageDetails->row()->description)));

                        } ?></p>

                </div>

            </div>

        </div>

    </section>

<?php

    $this->load->view('site/includes/footer');

?>