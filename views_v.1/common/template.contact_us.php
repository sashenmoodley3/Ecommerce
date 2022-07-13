
  <!-- Main Container -->
  <section class="main-container col1-layout">
    <div class="main container">
      <div class="row">
        <section class="col-main col-sm-12">
          
          <div id="contact" class="page-content page-contact">
          <div class="page-title">
            <h2><?=$this->lang->line("Contact Us")?></h2>
          </div>
            <div class="row">
                <b> <?php    echo $this->session->flashdata('mess'); 
                    ?> </b>
              <div class="col-xs-6 col-sm-6" id="contact_form_map">
                  <?php
                    echo $getPageDescri['pg_descri'];
                  ?>
              </div>
              <div class="col-xs-6 col-sm-6" id="contact_form_map">
                 <h3 class="page-subheading">Enquiry</h3>
                   
                    <?php echo form_open(base_url() . 'enquiry'); ?>
                    
                    <label for="name"><?=$this->lang->line("Name")?><span class="required">*</span></label>                   
                    <!--                    <div class='error_msg text-warning'></div>-->
                   
                    <input id="name" type="text" required class="form-control"
                           name="name" >

                    <label for="email"><?=$this->lang->line("Email")?><span class="required">*</span></label>
                    
                    <input id="email" type="email" name="email" value="" required
                           class="form-control">
                           
                    <label for="phone"><?=$this->lang->line("Phone")?></label>
                    
                    <input id="phone" type="number" name="phone" value=""
                           class="form-control">
                           
                           
                   <label for="phone"><?=$this->lang->line("Message")?><span class="required">*</span></label>
                   <textarea name="message" required class="form-control"> </textarea>
                    
                   <hr>
                    
                    <button type="submit" class="button"><i class="fa fa-lock"></i>&nbsp; <span><?=$this->lang->line("Send")?></span></button><label class="inline" for="rememberme">
                       
                    <?php echo form_close(); ?>
               
              </div>
              
            </div>
          </div>
        </section>
      </div>
    </div>
  </section>