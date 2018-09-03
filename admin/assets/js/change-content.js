$(document).ready(function() {
    var currentActive = null;

    function changeActive(elem) {
        if (currentActive != null) {
            currentActive.removeClass("active");
        }
        currentActive = elem;
        currentActive.addClass("active");
    }

    $("#dashboard").click(function() {
        changeContent("contents/dashboard.html", false, null);
        changeActive($("#dashboard"));
    });

    $("#soal-materi").click(function() {
        changeContent("contents/soal-materi.html", false, null);
        changeActive($("#soal-materi"));
    });

    $("#kelas").click(function() {
        changeContent("contents/kelas.html", false, null);
        changeActive($("#kelas"));
    });

    $("#post").click(function() {
        changeContent("contents/post.html", false, null);
        changeActive($("#post"));
    });

    $("#public-chat").click(function() {
        changeContent("contents/public-chat.html", false, null);
        changeActive($("#public-chat"));
    });

    $("#informasi").click(function() {
        changeContent("contents/informasi.html", false, null);
        changeActive($("#informasi"));
    });

    $("#transaksi").click(function() {
        changeContent("contents/transaksi.html", false, null);
        changeActive($("#transaksi"));
    });

    $("#dashboard").trigger("click");

    // /**Soal Materi */
    // $("#edit").click(function() {
    //     var actionValue = $("#edit").val();
    //     console.log(actionValue);
    //     changeContent("materi/manage-soal-materi.html");
    //     $.post("contents/manage-soal-materi.html", {action: actionValue});
    // });
    
    // $("#hapus").click(function() {
    //     var actionValue = $("#hapus").val();
    //     console.log(actionValue);
    //     changeContent("materi/manage-soal-materi.html");
    //     $.post("contents/manage-soal-materi.html", {action: actionValue});
    // });
});

var changeContent = function(filePath, postPhp, actionValue) {
    if (postPhp) {
        // $.post("contents/manage-soal-materi.html", {action: action});
        $.ajax({
            type: "POST",
            url: filePath,
            cache: false,
            data: {action: actionValue},
            success: function(html) {
                $("#content-wrapper").html(html);
            }
        });
    }
    else {
        $.ajax({
            url: filePath,
            cache: false,
            success: function(html) {
                $("#content-wrapper").html(html);
            }
        });
    }
}