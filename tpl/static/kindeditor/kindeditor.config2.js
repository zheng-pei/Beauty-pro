/* File Created: 四月 21, 2012 */

KindEditor.ready(function (K) {
    var editor1 = K.create('#content', {
        items: [
        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 
        'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'code', 'pagebreak',
        'link', 'unlink'
        ],
        themeType: "simple",
        uploadJson: '/kindeditor/php/upload_json.php',
        fileManagerJson: '/kindeditor/php/file_manager_json.php',
        allowFileManager: true
        // urlType: "domain"//”relative”、”absolute”、”domain”。
    });

});