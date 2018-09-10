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

    $("#belajar").click(function() {
        changeContent("contents/materi.html", false, null);
        changeActive($("#belajar"));
    });

    $("#ujian").click(function() {
        changeContent("contents/ujian.html", false, null);
        changeActive($("#ujian"));
    });
    
    $("#public-chat").click(function() {
        changeContent("contents/public-chat.html", false, null);
        changeActive($("#public-chat"));
    });

    $("#pengaturan-akun").click(function() {
        changeContent("contents/pengaturan.html", false, null);
        changeActive($("#pengaturan-akun"));
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
            data: {id: actionValue},
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