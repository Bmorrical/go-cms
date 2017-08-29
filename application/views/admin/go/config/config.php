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
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>Current Version</label>
                </div>
                <div class="col-md-4">
                    <span id="current-version-number"></span>
                </div>
                <div class="col-md-4">
                    <div id="update-block"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var current_version = "<?= $currentVersion->Tag; ?>";

    $(window).on("load", function() {
        $("#current-version-number").text(current_version);
        $("#update-block").hide().append(
            $("<a>", {id: "update-btn", class: "btn btn-success", text: "Update Now"}).on("click", function() {
                $.ajax({
                    url         : "https://api.go-cms.org/request/get-build",
                    type        : 'GET',
                    success     : function(d) { 
                        console.log('d',d); 
                    }
                }) 
            })
        )
        $.ajax({
            url         : "https://api.go-cms.org/request/get-version",
            type        : 'GET',
            dataType: 'jsonp',
            success     : function(d) { 
                alert('success' + d); 
                // if(d > current_version) {
                //     $("#update-block").show();
                // }
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
             }            
        })            
    });
</script>