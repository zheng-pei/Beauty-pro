KindEditor.ready(function (K) {
    var editormp3 = K.editor({
        themeType: "simple",
        allowFileManager: true

    });
    var _mp3_i = 0; 
    K('button.addmp3').click(function (e) {
        editormp3.loadPlugin('mp3', function () {
            editormp3.plugin.imageDialog({
                mp3Url: $(e.target).parent().prevAll("input[type=text]").val(),
                clickFn: function (url, title, width, height, border, align) {
                    _mp3_i++;
                    var $input = $(e.target).parent().prevAll("input[type=hidden]")
                    var $mp3 = $(e.target).parent().prevAll("div.mp3");
                    var $flag = $mp3.find("a.audio");
                    var $filename = url.match(/[^\/]*$/)[0];
                    if ($filename.lastIndexOf('.') > -1) {
                        $filename = $filename.substring(0, $filename.lastIndexOf('.'))
                    }
                    $input.val(url)
                    if ($flag.length > 0) {
                        $flag.mb_miniPlayer_changeFile({ mp3: url }, $filename);
                        $flag.mb_miniPlayer_play();
                    }
                    else {
                        while ($("#m" + _mp3_i).length > 0) {
                            _mp3_i++;
                        }
                        var _tmp = '<a id="m{1}" class="audio {skin:\'blue\'}" href="{0}">{2}</a> ';
                        $mp3.html(_tmp.format(url, _mp3_i, $filename));
                        $mp3.find("a.audio").mb_miniPlayer();
                        var $id = $mp3.find("a.audio").attr("id");
                        setTimeout(function () {
                            $("#" + $id).mb_miniPlayer_play();
                        }, 1000);
                    }
                    editormp3.hideDialog();
                    $(e.target).text("重新选择");
                }
            });
        });
    });
  
});

