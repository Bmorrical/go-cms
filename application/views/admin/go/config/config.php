<?php
    //////////////////////////////// core file ///////////////////////////////
    ///////////////////////////////// go-cms /////////////////////////////////

        /**
         *  This is a core go-cms file.  Do not edit if you plan to
         *  ever update your go-cms version.  Changes would be lost.
         */

    //////////////////////////////// core file ///////////////////////////////
    ///////////////////////////////// go-cms /////////////////////////////////
?>
<div class="container-fluid">
    <div class="row">
        <?php include_once(APPPATH . 'views/admin/helpers/sidebar.php'); ?>
        <div class="col-md-9 main-content-top-pad">
            <div class="row">
                <div class="col-md-3">
                    <h1>Configuration</h1>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <!-- <button name="save" class="btn btn-primary actions" type="submit" form="form1">Save</button> 
                        <a href="<?php echo base_url(); ?>admin/dashboard"><button type="button" class="btn btn-primary actions">Cancel</button></a>-->
                    </div>
                </div>
            </div>
            <form id="form1" class="" method="post" action="<?php echo base_url() . 'admin/'; ?>">
                <?php // include_once(APPPATH . 'views/admin/go/users/form.php'); ?>
            </form>
            <?php if(isset($updateVersion)): ?>
              <div class="col-md-12">

                <div class="alert alert-info update-message">
                  
                    GO CMS update <strong>version <?php echo $updateVersion ?></strong> is now available
                  
                    <a onclick="go_updator(<?php echo $updateVersion ?>)" class="btn btn-success">Update Now</a>

                </div>

              </div>
            <?php endif ?>
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                  <label>Current Version</label>
                </div>
                <div class="col-md-6">
                  <span id="current-version-number"><?php echo $currentVersion->meta_value ?></span>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>