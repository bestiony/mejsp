// $(document).ready((function(){function t(t,e=".result"){let r=$(t+" button[type=submit]");$(t).ajaxForm({url:$(this).attr("action"),dataType:"json",type:"POST",beforeSend:function(){$(r).attr("disabled",""),$(r).append('<div class="spinner-border spinner-border-sm submit-spinner mr-1" role="status"></div>')},success:function(r){$(e).empty(),1==r.status?(toastr.success(r.message,(function(){1==r.reload&&setTimeout((function(){location.reload()}),2800),1==r.redirect&&setTimeout((function(){$(t).trigger("reset"),window.location.href=r.to}),2800)})),"reset"==r.form&&$(t).trigger("reset")):"notfound"==r.status?toastr.warning(r.message,(function(){setTimeout((function(){location.reload()}),2800)})):"forbidden"==r.status?toastr.warning("هذه العملية غير مصرح بها , لا تقم بتكرار ذلك للحفاظ علي عدم فقدان النظام",(function(){setTimeout((function(){location.reload()}),2800)})):"alert"==r.status?(toastr.warning(r.message),setTimeout((function(){location.reload()}),2800)):toastr.error("يوجد خطأ ما في تحديث ذلك البيانات")},error:function(t,r){if(document.body.scrollTop=0,document.documentElement.scrollTop=0,"error"==r){let r="";$.each(t.responseJSON.errors,(function(t,e){r+=`<div class='alert alert-danger py-2'>${e}</div>`})),$(e).html(r)}console.clear()},complete:function(data){$(r).removeAttr("disabled"),$(".spinner-border").remove(),console.log(data),data.responseJSON.redirect_to_success_page ? window.location.pathname=`u/researches/${data.responseJSON.order_id}/confirm_received` : window.location.pathname="u/researches"}})}$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}),function(t){let e=$(t+" button[type=submit]");$(t).ajaxForm({url:$(this).attr("action"),type:"POST",beforeSend:function(){$(e).attr("disabled",""),$(e).append('<div class="spinner-border spinner-border-sm submit-spinner mr-1" role="status"></div>')},complete:function(t){$(".result").html(t.responseText),$(".spinner-border").remove(),$(e).removeAttr("disabled")},resetForm:!0})}("#form-add-media-library"),t(".form",".result"),t(".ajax",".result"),t("#form-add-article",".result"),t("#form-edit-article",".result"),t("#form-add-catrgory"),t("#form-add-catrgory")}));

$(document).ready(function () {
    function t(t, e = ".result") {
        let r = $(t + " button[type=submit]");
        $(t).ajaxForm({
            url: $(this).attr("action"),
            dataType: "json",
            type: "POST",
            beforeSend: function () {
                $(r).attr("disabled", ""),
                    $(r).append(
                        '<div class="spinner-border spinner-border-sm submit-spinner mr-1" role="status"></div>'
                    );
            },
            success: function (r) {
                $(e).empty(),
                    r.status == true
                        ? (toastr.success(r.message, function () {
                            1 == r.reload &&
                                setTimeout(function () {
                                    location.reload();
                                }, 2800),
                                1 == r.redirect &&
                                setTimeout(function () {
                                    $(t).trigger("reset"),
                                        (window.location.href = r.to);
                                }, 2800);
                        }),
                            "reset" == r.form && $(t).trigger("reset"))
                        : "notfound" == r.status
                            ? toastr.warning(r.message, function () {
                                setTimeout(function () {
                                    location.reload();
                                }, 2800);
                            })
                            : "forbidden" == r.status
                                ? toastr.warning(
                                    "هذه العملية غير مصرح بها , لا تقم بتكرار ذلك للحفاظ علي عدم فقدان النظام",
                                    function () {
                                        setTimeout(function () {
                                            location.reload();
                                        }, 2800);
                                    }
                                )
                                : "same_study" == r.status
                                    ?   (
                                        // toastr.warning("هذا العنوان مستعمل من قبل، استعمل عنوان دراسة جديد"),
                                        $("#title-error").removeClass("d-none").text('لا يمكن تقديم هذا الطلب، تم تقديم نفس الدراسة مسبقاً'),

                                        (document.body.scrollTop = 0),
                                        (document.documentElement.scrollTop = 0)
                                    )
                                : "alert" == r.status
                                    ? (toastr.warning(r.message),
                                        setTimeout(function () {
                                            location.reload();
                                        }, 2800))

                                    : toastr.error("يوجد خطأ ما في تحديث ذلك البيانات");
            },
            error: function (t, r) {
                if (
                    ((document.body.scrollTop = 0),
                        (document.documentElement.scrollTop = 0),
                        "error" == r)
                ) {
                    let r = "";
                    $.each(t.responseJSON.errors, function (t, e) {
                        r += `<div class='alert alert-danger py-2'>${e}</div>`;
                    }),
                        $(e).html(r);
                }
                console.clear();
            },
            complete: function (data) {
                $(r).removeAttr("disabled"),
                    $(".spinner-border").remove(),
                    console.log(data),
                    data.responseJSON.redirect_to_success_page
                        ? (window.location.pathname = `u/researches/${data.responseJSON.order_id}/confirm_received`)
                        : /*(window.location.pathname = "u/researches")*/
                        (console.log("sth is up"));
            },
        });
    }
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    }),
        (function (t) {
            let e = $(t + " button[type=submit]");
            $(t).ajaxForm({
                url: $(this).attr("action"),
                type: "POST",
                beforeSend: function () {
                    $(e).attr("disabled", ""),
                        $(e).append(
                            '<div class="spinner-border spinner-border-sm submit-spinner mr-1" role="status"></div>'
                        );
                },
                complete: function (t) {
                    $(".result").html(t.responseText),
                        $(".spinner-border").remove(),
                        $(e).removeAttr("disabled");
                },
                resetForm: !0,
            });
        })("#form-add-media-library"),
        t(".form", ".result"),
        t(".ajax", ".result"),
        t("#form-add-article", ".result"),
        t("#form-edit-article", ".result"),
        t("#form-add-catrgory"),
        t("#form-add-catrgory");
});
