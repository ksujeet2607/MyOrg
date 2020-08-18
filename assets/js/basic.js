/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    $('.required').on("focus click",function () {
        $(this).css("border", "1px solid #cfc6c6");
        var id = $(this).attr("id");
        $("#err" + id).text("");
    });
    $('.form-control').on("focus click",function () {
        var id = $(this).attr("id");
        $("#err" + id).text("");
    });
   
});
$(".error").on("click",function(){
    alert(this);
    $(this).css("display","none");
});
$(".errmsg").on("click",function(){
    alert(this);
    $(this).css("display","none");
});
function checkrequired(x) {
    var rq = $(x).find(".required");
    var $formId = x;
    var $error = $("<span class='error'></span>");
    $('.errmsg', $formId).removeClass('error');
    var left = 0;
    var top = 0;
    $('span.error').remove();
    var count = 0;
    var curname = '';
    var ischeck = false
    $.each(rq, function () {
        var id = $(this).attr("id");
        console.log(id);
        var $parentTag = $("#err" + id);
        if ($(this).val() == '') {
//            $parentTag.append($error.clone().text('Mandatory Field').attr("style", "display:block;"));
              $(this).css("border-bottom","1px solid red");
            if (this.nodeName == "SELECT") {
                if ($(this).val() == '0' || $(this).val() == '') {
//                   $parentTag.append($error.clone().text('Mandatory Field').attr("style", "display:block;"));
                $(this).css("border-bottom","1px solid red");
                }
            }
            count++;
        } else if ($(this).attr("type") === 'radio') {
            if ($("input[name='" + this.name + "']:checked").length === 0) {
                var vll = $("input[name='" + this.name + "']").attr("id");
                $("label[for ='" + vll + "'] ").css("border", "1px solid #f44336");
            }
        } else {
            if (curname !== this.name) {
                //alert(curname+" "+ischeck);
                if (ischeck === false) {
                    var vll = $("input[name='" + curname + "']").attr("id");
                    $("label[for ='" + vll + "'] ").css("border", "1px solid #f44336");
                }
                ischeck = false;
            }
            var cls = this.className.split(" ");

            if ($.inArray("password", cls) != -1) {
                if (this.value.length < 5) {
                    alertify.sujeet("<p>Password must be atleat 5 characters long.</p>");
                    count++;
                }
            }

//                if($.inArray("uniqeuserid", cls) != -1) { 
//                     if(x==='create_user'){
//                         var data = 'tbl=admlogin';
//                     }
//                     var checkpage = 'ajax/checkuserid.php?'+data;
//                     var response = $.ajax({
//                            type: "POST",
//                            url: checkpage,
//                            data: {val: this.value}, 
//                        });
//                    //console.log(response);
//                    var pp = this.value;
//                    response.done(pp,function(data){   
//                        if(data=="true"){
//                            alert(pp+" can not be assiged again.");
//                            $(".uniqeuserid").val("");
//                            count++;
//                        } 
//                    });
//                    
//                     
//                }

        }
    });
    //alert(count);

    if (count < 1) {
        return true;
    }
    return false;
}

function form_submit(data, byajax, target) {
    var datastring = $("#" + data).serialize();
    var rq = $("#" + data + " .required");
    var scount = 0;
    datastring = datastring + "&req=ajax";
    var count = 0;
    $.each(rq, function () {
        if ($(this).val() == '') {
            var id = $(this).attr("id");
            $("#err" + id).text("Mandatory Field");
            $(this).css("border", "1px solid #cfc6c6");
            if (this.nodeName == "SELECT") {
                if ($(this).val() == '0' || $(this).val() == '') {
                    $(this).css("border", "1px solid #cfc6c6");
                }
            }
            count++;
        }
        if (this.attributes[0].nodeValue === 'email' && $(this).val() !== '') {
            var c = $.trim($("#cemailid").val());
            var o = $.trim($(this).val());
            if ("" + c !== "" + o) {
                alertify.sujeet("<p>Email address miss match!.</p><p>Please confirm your email address.</p>");
                $(this).css("border", "1px solid #cfc6c6");
                $("#err" + $(this).attr("id")).text("Mandatory Field");
                $(this).val("");
                $("#cemailid").val("");
                $("#err" + $("#cemailid").attr("id")).text("Mandatory Field");
                count++;
            }

        }
//            if($(this).attr('name')==='contact' && $(this).val()!==''){
//                //console.log($(this).val().length);
//                    if($(this).val().length !== 10){   
//                        alertify.sujeet("<p>Invalid mobile number</p><p>Please enter 10 digit mobile number.</p>");
//                        $(this).css("border","1px solid #cfc6c6");
//                        $("#err"+$(this).attr("id")).text("Mandatory Field");
//                        $(this).val("");
//                        count++;
//                    }
//                      
//            }
    });

    //alert(count);
    if (count > 0) {
        return false;
    } else {

        if (byajax) {
            requestAjax(datastring, data, target);
        } else {

            return true;


        }
    }
    return false;
}
function requestAjax(datastring, form, page) {
    $.ajax({
        type: "POST",
        url: page,
        data: datastring,
        success: function (data) {
            if (data == "true") {
                alertify.sujeet("<p>Thank You! We have received your request.We'll get back to you soon.</p>");
                $("#" + form).trigger("reset");
            } else {
                alertify.sujeet("Error: Please Try Again Later!!!");
            }
        },
        error: function () {
            alertify.sujeet("Error: Please Try Again Later");
        }
    });
}


function isvalidtextarea(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 32 || (charCode > 47 && charCode < 58) || charCode == 44 || charCode == 95 || charCode == 64 || charCode == 46)
        return true;
    else
        return false;
}

function useridvalid(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if ((charCode < 97 || charCode > 122) && (charCode < 65 || charCode > 90)) {
        return false;
    }
    return true;
}



function isNumberKey(evt){
var charCode = (evt.which) ? evt.which : event.keyCode;
if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
return true;

}

function validemail(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 32 || (charCode > 47 && charCode < 58) || charCode == 44 || charCode == 95 || charCode == 64 || charCode == 46)
        return true;
    else
        return false;
}

function isAlphaKey(e) {
    try {
        if (window.event) {
            var charCode = window.event.keyCode;
        } else if (e) {
            var charCode = e.which;
        } else {
            return true;
        }
        if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 44 || charCode == 188 || charCode == 32)
            return true;
        else
            return false;
    } catch (err) {
        alert(err.Description);
    }
}

function isAlphaOnly(e) {
//            var str = t.value;
//            alert(str.charAt(0).toUpperCase());
    //str.charAt(0).toUpperCase();
    try {
        if (window.event) {
            var charCode = window.event.keyCode;
        } else if (e) {
            var charCode = e.which;
        } else {
            return true;
        }
        if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 32)
            return true;
        else
            return false;
    } catch (err) {
        alert(err.Description);
    }
}
function isAlphanumaricOnly(e) {
//            var str = t.value;
//            alert(str.charAt(0).toUpperCase());
    //str.charAt(0).toUpperCase();
    try {
        if (window.event) {
            var charCode = window.event.keyCode;
        } else if (e) {
            var charCode = e.which;
        } else {
            return true;
        }
        if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 32 || (charCode > 47 && charCode < 58))
            return true;
        else
            return false;
    } catch (err) {
        alert(err.Description);
    }
}

function js_delete(type, x, cl) {
    var xx = confirm("are you sure to delete?");
    if (xx)
    {
        $.ajax({
            type: 'POST',
            url: "ajax/delete.php?typ=" + type,
            data: {"id": x},
            success: function (data12) {
                if (cl && typeof (cl) === "function") {
                    cl(1, 30);
                }
            }});
    } else {
        return false;
    }
}