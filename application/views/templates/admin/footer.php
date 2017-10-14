<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////// core file ///////////////////////////////
///////////////////////////////// go-cms /////////////////////////////////

    /**
     *  This is a core go-cms file.  Do not edit if you plan to
     *  ever update your go-cms version.  Changes would be lost.
     */

//////////////////////////////// core file ///////////////////////////////
///////////////////////////////// go-cms /////////////////////////////////
?>

<?php if($this->session->has_userdata('logged_in')) : ?>
    <br /><br />
    <div id="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9 copyright">
                    <p>&copy; <?php echo date('Y') . " " . $this->config->item('go_company_name'); ?> | All Rights Reserved</p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    var menuActiveClass = "<?= $this->session->userdata('menu_active_class'); ?>"; // gets set in GO_CONTROLLER/go_load_page()

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

    $(window).on('resize', function() {
        positionFooter();
    });

    function positionFooter() {
        var docHeight = $(window).height();
        var footerHeight = $('#footer').height();
        var footerTop = $('#footer').position().top + footerHeight;
        if(footerTop < docHeight) $('#footer').css('margin-top', -24 + (docHeight - footerTop) + 'px');
    } 
</script>

<script language="javascript" type="text/javascript" src="<?php echo base_url();?>/assets/admin/js/tinymce/tinymce.min.js"></script>
<script>
// Start TinyMCE
    tinyMCE.init({
    theme : "modern",
    mode: "exact",
    elements : "Content",
    branding: false,
    width:"100%",
    height:"250px",
    //menubar : false, // code edit icon
    /* theme of the editor */     
    skin: "lightgray",

    /* display statusbar */
    statubar: true,

    /* plugin */
    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor"
    ],

    /* toolbar */
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",

    /* style */
    style_formats: [
        {title: "Headers", items: [
            {title: "Header 1", format: "h1"},
            {title: "Header 2", format: "h2"},
            {title: "Header 3", format: "h3"},
            {title: "Header 4", format: "h4"},
            {title: "Header 5", format: "h5"},
            {title: "Header 6", format: "h6"}
        ]},
        {title: "Inline", items: [
            {title: "Bold", icon: "bold", format: "bold"},
            {title: "Italic", icon: "italic", format: "italic"},
            {title: "Underline", icon: "underline", format: "underline"},
            {title: "Strikethrough", icon: "strikethrough", format: "strikethrough"},
            {title: "Superscript", icon: "superscript", format: "superscript"},
            {title: "Subscript", icon: "subscript", format: "subscript"},
            {title: "Code", icon: "code", format: "code"}
        ]},
        {title: "Blocks", items: [
            {title: "Paragraph", format: "p"},
            {title: "Blockquote", format: "blockquote"},
            {title: "Div", format: "div"},
            {title: "Pre", format: "pre"}
        ]},
        {title: "Alignment", items: [
            {title: "Left", icon: "alignleft", format: "alignleft"},
            {title: "Center", icon: "aligncenter", format: "aligncenter"},
            {title: "Right", icon: "alignright", format: "alignright"},
            {title: "Justify", icon: "alignjustify", format: "alignjustify"}
        ]}
    ]
    });
</script>

<?php 
// echo "<pre>";
// var_dump($this->session->userdata);