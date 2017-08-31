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
<style>
    .fa-check-circle {
        color: #a6e22e;
    }
    .fa-spinner {
        color: #297db9;
    }
    .config-row {
        height: 30px;
    }
    .btn {
        width: 150px;
        padding-top: 5px;
        padding-bottom: 5px;
    }
</style>
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
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-6 config-row">
                            go-cms <span id="current-version-number"></span> 
                        </div>
                        <div class="col-md-6">
                            <div id="update-block"></div>
                        </div>
                    </div>
                    <div class="row even">
                        <div class="col-md-6">
                            CodeIgniter v <?= CI_VERSION; ?> 
                        </div>
                        <div class="col-md-6">
                            <a href="https://www.codeigniter.com/userguide3/installation/upgrading.html" target="_blank"><button class="btn btn-success btn-xs">Check For Update</button></a>
                        </div>
                    </div>  
                </div>
            </div>          
        </div>
    </div>
</div>

<script>
    var base_url = '<?= base_url(); ?>';
    var current_version = "<?= $currentVersion->Tag; ?>";
    var latest_version;

    $(window).on("load", function() {

        $("#current-version-number").html("&nbsp;&nbsp;v " + current_version);

        var waiting = new $.Deferred();

        // Get current go-cms version from api

            $.getJSON('https://api.go-cms.org/request/get-version', function(data) {
                if(parseFloat(data[0].Tag) > parseFloat(current_version)) {
                    latest_version = data[0].Tag;
                    waiting.resolve();
                } else {
                    $("#update-block").append(
                        $("<div>", {id: "update-block-success", html: "<i class='fa fa-check-circle'></i> &nbsp;Up to date"})
                    )
                }
            });   
             

        // If new version is available 

            $.when(waiting).done(function() {
                // If new version is available     
                $("#update-block").append(
                    $("<button>", {value: "Submit", id: "update-btn", class: "btn btn-success btn-xs", text: "Update Now"}).on("click", function() {
                        $(this).remove();
                        $("#update-block").append(
                            $("<div>", {id: "update-block-success", html: "<i class='fa fa-spinner fa-spin fa-fw'></i> &nbsp;Working..."})
                        )

                        $.getJSON('https://api.go-cms.org/request/get-build?tag=' + latest_version, function(data) {
                            $.ajax({
                                url         : base_url + 'admin/ajax_go_update',
                                type        : 'POST',
                                dataType    : 'JSON',
                                data        : {
                                    latest_version: latest_version,
                                    files: data
                                },
                                success     : function(d) {     
                                    $("#current-version-number").html("&nbsp;&nbsp;v " + latest_version);
                                    $("#update-block-success").html("<i class='fa fa-check-circle'></i> &nbsp;Up to date");
                                }
                            });                         
                        });
                    })
                )
            })
    });

</script>