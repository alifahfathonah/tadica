$(document).ready(function() {
    var currentActive = null;

    function changeContent(filePath) {
        $.ajax({
            url: filePath,
            cache: false,
            success: function(html) {
                $("#content-wrapper").html(html);
            }
        });
    }

    function changeActive(elem) {
        if (currentActive != null) {
            currentActive.removeClass("active");
        }
        currentActive = elem;
        currentActive.addClass("active");
    }

    $("#dashboard").click(function() {
        changeContent("contents/dashboard.html");
        changeActive($("#dashboard"));
    });

    $("#soal-materi").click(function() {
        changeContent("contents/soal-materi.html");
        changeActive($("#soal-materi"));
    });

    $("#kelas").click(function() {
        changeContent("contents/kelas.html");
        changeActive($("#kelas"));
    });

    $("#post").click(function() {
        changeContent("contents/post.html");
        changeActive($("#post"));
    });

    $("#public-chat").click(function() {
        changeContent("contents/public-chat.html");
        changeActive($("#public-chat"));
    });

    $("#informasi").click(function() {
        changeContent("contents/informasi.html");
        changeActive($("#informasi"));
    });

    $("#transaksi").click(function() {
        changeContent("contents/transaksi.html");
        changeActive($("#transaksi"));
    });

    $("#dashboard").trigger("click");
});