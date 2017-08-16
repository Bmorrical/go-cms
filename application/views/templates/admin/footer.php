<script>
    var showfooter = 0;
    var menuActiveClass = "<?= $this->session->userdata('menu_active_class'); ?>"; // gets set in GO_CONTROLLER/go_load_page()

    $(window).on('load', function(){
        $('#toggle-btn').click(function(){
            if ($(window).width() <= 980) {
                var li_element = $('.top_menu_ul li') ;
                for(var i = ( li_element.length - 1 ) ; i >= 0 ;  i-- ){
                    $('.top_menu_ul').append(li_element[i]);
                }
            }
            $('.top_menu_ul').slideToggle('fast');
        });
        $('#side-toggle').click(function(){
            $('.side_menu_ul').slideToggle('fast');
        });

        positionFooter();
        $('li[class^="menu-"] .active').removeClass('active');
        if(menuActiveClass != "") $('.menu-' + menuActiveClass).addClass('active');
    });

    $(window).on('resize', function() {
        positionFooter();
    });

    function positionFooter() {
        if(showfooter == 1) {
            var docHeight = $(window).height();
            var footerHeight = $('#footer').height();
            var footerTop = $('#footer').position().top + footerHeight;
            if(footerTop < docHeight) $('#footer').css('margin-top', -24 + (docHeight - footerTop) + 'px');
        }       
    }
  function go_updator(updateVersion){

    $.ajax({

      url:'<?php echo base_url("Update/updator") ?>',
      method: 'POST',
      beforeSend: function(){
        $(".update-message").removeClass("alert-info");
        $(".update-message").addClass("alert-danger");
        $(".update-message").html('<h1>Updating <i class="fa fa-spinner fa-spin" aria-hidden="true"></i></h1><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <strong>Caution:</strong> Do not Close the browser or this Tab until updation is completed');

      },
      data: 'updateVersion='+updateVersion, 
      success:function(response){
        $(".update-message").removeClass("alert-danger");
        $(".update-message").addClass("alert-success");
        $(".update-message").html('GO CMS is updated to Version '+updateVersion);
        $("#current-version-number").html(updateVersion);
      }

    });

  }  
</script>

<?php 
    if($this->session->has_userdata('logged_in')) { ?>
    <script>showfooter = 1;</script>
    <br /><br />
        <div id="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-9 copyright">
                        <p>&copy; <?php echo date('Y') . " " . $this->config->item('company_name'); ?> | All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
        
<?php } 

// echo "<pre>";
// var_dump($this->session->userdata);

?>