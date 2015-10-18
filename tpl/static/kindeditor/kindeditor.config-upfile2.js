 
  KindEditor.ready(function (K) {
      var editor = K.editor({
          themeType: "simple",
          uploadJson: '/kindeditor/php/upload_json.php',
          fileManagerJson: '/kindeditor/php/file_manager_json.php',
          allowFileManager: true
      });
      K('#insertimage').click(function () {
        editor.loadPlugin('smimage', function () {
              editor.plugin.smimageDialog({
                  imageUrl: K('#thumb').val(),
                  clickFn: function (url, title, width, height, border, align) {
                      K('#thumb').val(url);
                      if (K('#Preview')) {
                          K('#Preview').attr('src', url)
                      }
                      editor.hideDialog();
                  }
              });
          });
      });
       
  });