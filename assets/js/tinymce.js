import tinymce from 'tinymce'
import "tinymce/themes/silver/theme";
import "tinymce/plugins/autolink";
import "tinymce/plugins/advlist";
import "tinymce/plugins/lists";
import "tinymce/plugins/link";
import "tinymce/plugins/image";
import "tinymce/plugins/charmap";
import "tinymce/plugins/preview";
import "tinymce/plugins/anchor";
import "tinymce/plugins/textcolor";
import "tinymce/plugins/searchreplace";
import "tinymce/plugins/visualblocks";
import "tinymce/plugins/code";
import "tinymce/plugins/fullscreen";
import "tinymce/plugins/insertdatetime";
import "tinymce/plugins/media";
import "tinymce/plugins/table";
import "tinymce/plugins/paste";
import "tinymce/plugins/help";
import "tinymce/plugins/wordcount";

require("../../node_modules/tinymce/skins/ui/oxide/skin.min.css");
require("../../node_modules/tinymce/skins/ui/oxide/content.min.css");

tinymce.init({
    selector: 'textarea',
    height: 300,
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste help wordcount'
    ],
    toolbar: 'undo redo searchreplace preview | formatselect | link | media | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
    content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        '//www.tiny.cloud/css/codepen.min.css'
    ],
    link_assume_external_targets: true,
    default_link_target: "_blank"
});