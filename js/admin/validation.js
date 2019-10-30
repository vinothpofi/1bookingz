function checkBoxValidationAdmin(e, t) 

{
    if(($('#total_value_count').val() == $('td input[type="checkbox"]').filter(':checked').length))
    {
        
        alert('Can\'t Select All Values...Should be One Value Present');
        return false;
    }else{

        for (var a = 0, i = "on", s = $("#display_form input"), o = 0; o < s.length; o++) "checkbox" == s[o].type && s[o].checked && (a = 1, "on" != s[o].value && (i = s[o].value));

    return 0 == a ? (alert("Please Select the CheckBox"), !1) : "on" == i ? (alert("No records found "), !1) : void confirm_global_status(e, t)
    }


    

}



function checkBoxWithSelectValidationAdmin(e, t) {

    var a = $("#mail_contents").val();

    if ("" == a) return alert("Please select the mail template"), !1;

    for (var i = 0, s = "on", o = $("#display_form input"), n = 0; n < o.length; n++) "checkbox" == o[n].type && o[n].checked && (i = 1, "on" != o[n].value && (s = o[n].value));

    return 0 == i ? (alert("Please Select the CheckBox"), !1) : "on" == s ? (alert("No records found "), !1) : void confirm_global_status(e, t)

}



function SelectValidationAdmin(e, t) {

    var a = $("#mail_contents").val();

    return "" == a ? (alert("Please select the mail template"), !1) : void confirm_global_status(e, t)

}



function confirm_global_status(e, t) {

    $.confirm({

        title: "Confirmation",

        message: "Whether you want to continue this action?",

        buttons: {

            Yes: {

                "class": "yes",

                action: function() {

                    bulk_logs_action(e, t)

                }

            },

            No: {

                "class": "no",

                action: function() {

                    return !1

                }

            }

        }

    })

}



function bulk_logs_action(e, t) {

    var a = prompt("For Security Purpose, Please Enter Email Id");

    return "" == a ? (alert("Please Enter The Email ID"), !1) : null == a ? !1 : a != t ? (alert("Please Enter The Correct Email ID"), !1) : ($("#statusMode").val(e), $("#SubAdminEmail").val(t), $("#display_form").submit(), void 0)

}



function confirm_status(e) {

    $.confirm({

        title: "Confirmation",

        message: "You are about to change the status of this record ! Continue?",

        buttons: {

            Yes: {

                "class": "yes",

                action: function() {

                    window.location = BaseURL + e

                   

                }

            },

            No: {

                "class": "no",

                action: function() {

                    return !1

                }

            }

        }

    })

}



function confirm_mode(e) {

    $.confirm({

        title: "Confirmation",

        message: "You are about to change the display mode of this record ! Continue?",

        buttons: {

            Yes: {

                "class": "yes",

                action: function() {

                    window.location = BaseURL + e

                }

            },

            No: {

                "class": "no",

                action: function() {

                    return !1

                }

            }

        }

    })

}



function confirm_delete(e) {

    $.confirm({

        title: "Delete Confirmation",

        message: "You are about to delete this record. <br />It cannot be restored at a later time! Continue?",

        buttons: {

            Yes: {

                "class": "yes",

                action: function() {

                    window.location = BaseURL + e

                }

            },

            No: {

                "class": "no",

                action: function() {

                    return !1

                }

            }

        }

    })

}



function checkBoxCategory() {

    for (var e = 0, t = "on", a = $("#display_form input"), i = 0; i < a.length; i++) "checkbox" == a[i].type && a[i].checked && (e = 1, t = a[i].value);

    return 0 == e ? (alert("Please Select the CheckBox"), !1) : e > 1 ? (alert("Please Select only one CheckBox at a time"), !1) : "on" == t ? (alert("No records found "), !1) : void confirm_category_checkbox(t)

}



function confirm_category_checkbox(e) {

    $.confirm({

        title: "Confirmation",

        message: "Whether you want to continue this action?",

        buttons: {

            Yes: {

                "class": "yes",

                action: function() {

                    $("#checkboxID").val(e), $("#display_form").submit()

                }

            },

            No: {

                "class": "no",

                action: function() {

                    return !1

                }

            }

        }

    })

}



function changeSellerStatus(e, t) {

    val = $("#seller_status_" + e).val(), "" != val && "" != e && $.ajax({

        type: "POST",

        url: "admin/seller/change_seller_request",

        data: {

            id: e,

            status: val,

            user_id: t

        },

        dataType: "json",

        success: function(e) {

            alert(e)

        }

    })

}



function disableGiftCards(e, t) {

    $.confirm({

        title: "Confirmation",

        message: "You are about to change the mode of giftcards ! Continue?",

        buttons: {

            Yes: {

                "class": "yes",

                action: function() {

                    var a = prompt("For Security Purpose, Please Enter Email Id");

                    return "" == a ? (alert("Please Enter The Email ID"), !1) : null == a ? !1 : a != t ? (alert("Please Enter The Correct Email ID"), !1) : void(window.location = BaseURL + e)

                }

            },

            No: {

                "class": "no",

                action: function() {

                    return !1

                }

            }

        }

    })

}



function editPictureProducts(e, t) {

    var a = "img_" + e,

        i = window.location.pathname,

        s = i.substring(i.lastIndexOf("/") + 1);

    $.ajax({

        type: "POST",

        url: BaseURL + "admin/product/editPictureProducts",

        data: {

            id: a,

            cpage: s,

            position: e,

            imgId: t

        },

        dataType: "json",

        success: function(t) {

            return "No" == t ? (alert("You can't delete all the images"), !1) : void $("#img_" + e).remove()

        }

    })

}



function editPictureProductsUser(e, t) {

    var a = "img_" + e,

        i = window.location.pathname,

        s = i.substring(i.lastIndexOf("/") + 1);

    $.ajax({

        type: "POST",

        url: BaseURL + "site/product/editPictureProducts",

        data: {

            id: a,

            cpage: s,

            position: e,

            imgId: t

        },

        dataType: "json",

        success: function(t) {

            return "No" == t ? (alert("You can't delete all the images"), !1) : void $("#img_" + e).remove()

        }

    })

}



function quickSignup() {

    var e = ($.dialog("signin-overlay"), $.dialog("register")),

        t = $("#signin-email").val();

    $.ajax({

        type: "POST",

        url: baseURL + "site/user/quickSignup",

        data: {

            email: t

        },

        dataType: "json",

        success: function(t) {

            return "0" == t.success ? (alert(t.msg), !1) : ($(".quickSignup2 .username").val(t.user_name), $(".quickSignup2 .url b").text(t.user_name), $(".quickSignup2 .email").val(t.email), $(".quickSignup2 .fullname").val(t.full_name), e.open(), void 0)

        }

    })

}



function quickSignup2() {

    var e = $(".quickSignup2 .username").val(),

        t = $(".quickSignup2 .email").val(),

        a = $(".quickSignup2 .user_password").val(),

        i = $(".quickSignup2 .fullname").val();

    $.ajax({

        type: "POST",

        url: baseURL + "site/user/quickSignupUpdate",

        data: {

            username: e,

            email: t,

            password: a,

            fullname: i

        },

        dataType: "json",

        success: function(e) {

            return "0" == e.success ? (alert(e.msg), !1) : void(location.href = baseURL + "send-confirm-mail")

        }

    })

}



function reload_captcha() {

    $.ajax({

        type: "POST",

        url: baseURL + "site/user/reloadCaptcha",

        success: function(e) {

            e = $.trim(e);

            var t = e.split("-");

            $("#captacha").val(t[0] + t[1]), $("#captacha1").html(t[0]), $("#captacha2").html(t[1]), $("#register_captcha").val("")

        }

    })

}



function register_user() {

	

	

    var e = $("#first_name").val(),

        t = $("#last_name").val(),

        a = $("#email").val(),

        i = $("#password").val(),

        s = $("#cnf_password").val();

		r = $("#rep_code").val();

		var atpos = a.indexOf("@");

		var dotpos = a.lastIndexOf(".");

		var fn = e.trim();

		var ln = t.trim();

		var em = a.trim();

		

        invite_ref = $("#invite_reference").val();

		

		var password_msg = $("#pass_msg").val();

		var min_password = $("#min_pass").val();

		var email = $("#email_add").val();

		var first_name = $("#first_name_msg").val();

		var last_name = $("#last_name_msg").val();

		var pass_not_match = $("#pass_not_match").val();

		var valid_captcha = $("#valid_captcha").val();

		var enter_email = $("#enter_mail").val();

		

        //alert(invite_ref);

    if ("" == fn || "First Name" == fn) alert(first_name);

    else if ("" == ln || "Last Name" == ln) alert(last_name);

    else if ("" == em || "Email Address" == em) alert(email);

	else if(atpos<1 || dotpos<atpos+2 || dotpos+2>=em.length)

	{

		//alert("Please enter valid email address!");

		alert(enter_email);

	}

    else if ("" == i) alert(password_msg);

    else if (i.length < 6) alert(min_password);

    else {

		

		

		

        if (i == s) {

            var o = "no";

            return $("#checkbox").is(":checked") && (o = "yes"), $("#captacha").val() != $("#register_captcha").val() ? ($.ajax({

                type: "POST",

                url: baseURL + "site/user/reloadCaptcha",

                success: function(e) {

                    e = $.trim(e);

                    var t = e.split("-");

                    $("#captacha").val(t[0] + t[1]), $("#captacha1").html(t[0]), $("#captacha2").html(t[1])

                }

            }), alert(valid_captcha), $("#register_captcha").val(""), 

			$("#register_captcha").focus(), !1) : ($("#loading_signup").css("display", "block"),

			$("#loading_signup_image").css("display", "block"),

			$.ajax({

                type: "POST",

                url: baseURL + "site/user/registerUser",

                data: {

                    firstname: fn,

                    lastname: ln,

                    email: em,

                    pwd: i,

					rep_code : r,

                    news_signup: o,

                    invite_reference:invite_ref

                },

                dataType: "json",

                success: function(e) {



					if(e.success ==0) {

						if(e.msgs=='Does not Support Rep Code')

						{

							return $("#rep_code_alert").css("display", "block"),$("#emailalert").css("display", "none");

						}

						

						else{

							return $("#emailalert").css("display", "block"),$("#rep_code_alert").css("display", "none"),$("#loading_signup_image").css("display", "none");

						}

												//alert(e.msgs);

               

                                               //alert(e.msg);

                                               //return false;

                                       }

									   else{



                    return $("#loading_signup").css("display", "block"), $("#loading_signup_image").css("display", "none"), "0" == e.success ? (alert(e.msg), !1) : void location.reload()

									   }}

            }), !1)

        }

        alert(pass_not_match)

    }

    return !1

}



function signin() {

	

	var password_msg = $("#pass_msg").val();

	var min_password = $("#min_pass").val();

	var email = $("#email_add").val();

	

	

    var e = $("#signin_email_address").val();

        t = $("#signin_password").val();

		var em = e.trim();

    if ("" == em) alert(email);

    else if ("" == t) alert(password_msg);

    else if (t.length < 6) alert(min_password);

    else {

        var a = "no";

        $("#remember").is(":checked") && (a = "yes"), $.ajax({

            type: "POST",

            url: baseURL + "site/user/login_user",

            data: {

                email: em,

                password: t,

                remember: a

            },

            dataType: "json",

            success: function(e) {

                1 == e.status_code ? "" != e.redirect ? window.location.href = e.redirect : window.location.reload() : alert(e.message)

            }

        })

    }

    return !1

}



function paypaldetail() {

    var e = $("#bank_code").val(),

        t = $("#paypal_email").val(),

        a = $("#bank_name").val(),

        i = $("#bank_no").val(); 

		var bank_name = $("#bank_name").val();

		var bank_number = $("#bank_number").val();

		var bank_code = $("#bank_code").val();

		var email_required = $("#email_required").val();

		

		

    return "" == a ? alert(bank_name) : "" == i ? alert(bank_number) : "" == e ? alert(bank_code) : "" == t ? alert(email_required) : $.ajax({

        type: "POST",

        url: baseURL + "site/user/paypaldetail",

        data: {

            bank_name: a,

            bank_no: i,

            bank_code: e,

            paypalemail: t

        },

        dataType: "json",

        success: function(e) {

            1 == e.status_code ? window.location.reload() : alert(e.message)

        }

    }), !1

}



function RentalEnquiry() {

    var e = $("#datefrom1").val(),

        t = $("#expiredate1").val(),

        a = $("#Enquiry").val(),

        i = $("#caltophone:checked").val(),

        s = $("#enquiry_timezone").val(),

        o = $("#NoofGuest").val(),

        n = $("#prd_id").val(),

        r = $("#ownerid").val();

    if ("" != $("#datefrom").val() && "" != $("#expiredate").val()) var l = ($("#expiredate").datepicker("getDate") - $("#datefrom").datepicker("getDate")) / 1e3 / 60 / 60 / 24;

    return "" == e ? (alert("Please select checkin date"), !1) : "" == t ? (alert("Please select checkout date"), !1) : ($("#validationErraaaa").show(), void $.ajax({

        type: "POST",

        url: baseURL + "site/user/rentalEnquiry",

        data: {

            checkin: e,

            checkout: t,

            numofdates: l,

            Enquiry: a,

            caltophone: i,

            enquiry_timezone: s,

            NoofGuest: o,

            prd_id: n,

            renter_id: r

        },

        dataType: "json",

        success: function(e) {

            return 1 != e.status_code ? (alert(e.message), !1) : void(window.location.href = baseURL + "rental/" + n)

        }

    }))

}



function RentalEnquiryBooting() {

    $("#validationErraaaa").show();

    var e = $("#datefrom1").val(),

        t = $("#expiredate1").val(),

        a = $("#Enquiry").val(),

        i = $("#caltophone:checked").val(),

        s = $("#enquiry_timezone").val(),

        o = $("#NoofGuest").val(),

        n = $("#prd_id").val(),

        r = $("#renter_id").val();

    return $.ajax({

        type: "POST",

        url: baseURL + "site/user/rentalEnquiry",

        data: {

            checkin: e,

            checkout: t,

            Enquiry: a,

            caltophone: i,

            enquiry_timezone: s,

            NoofGuest: o,

            prd_id: n,

            renter_id: r

        },

        dataType: "json",

        success: function(e) {

            1 == e.status_code ? window.location.href = baseURL + "rental/" + n : alert(e.message)

        }

    }), !1

}



function forgot_password() {

    $("#load-img-forgot").css("display", "block");

    var e = $("#forgot_email").val();

	var EMAIL = $("#Email_required").val();

    return "" == e && (alert(EMAIL), $("#load-img-forgot").css("display", "none")), $.ajax({

        type: "POST",

        url: baseURL + "site/user/forgot_password_user",

        data: {

            email: e

        },

        dataType: "json",

        success: function(e) {

            1 == e.status_code ? (window.location.reload(), $("#load-img-forgot").css("display", "none")) : (alert(e.message), $("#load-img-forgot").css("display", "none"))

        }

    }), !1

}



function hideErrDiv(e) {

    $("#" + e).hide("slow")

}



function resendConfirmation(e) {

    "" != e && ($(".confirm-email").html("<span>Sending...</span>"), $.ajax({

        type: "POST",

        url: baseURL + "site/user/resend_confirm_mail",

        data: {

            mail: e

        },

        dataType: "json",

        success: function(e) {

            return "0" == e.success ? (alert(e.msg), !1) : void $(".confirm-email").html('<font color="green">Confirmation Mail Sent Successfully</font>')

        }

    }))

}



function profileUpdate() {

    $("#save_account").disable();

    var e = $(".setting_fullname").val(),

        t = $(".setting_website").val(),

        a = $(".setting_location").val(),

        i = $(".setting_twitter").val(),

        s = $(".setting_facebook").val(),

        o = $(".setting_google").val(),

        n = $(".birthday_year").val(),

        r = $(".birthday_month").val(),

        l = $(".birthday_day").val(),

        c = $(".setting_bio").val(),

        d = $(".setting_email").val(),

        u = $(".setting_age").val(),

        m = $(".setting_gender:checked").val();

    return $.ajax({

        type: "POST",

        url: baseURL + "site/user_settings/update_profile",

        data: {

            full_name: e,

            web_url: t,

            location: a,

            twitter: i,

            facebook: s,

            google: o,

            b_year: n,

            b_month: r,

            b_day: l,

            about: c,

            email: d,

            age: u,

            gender: m

        },

        dataType: "json",

        success: function(e) {

            return "0" == e.success ? (alert(e.msg), $("#save_account").removeAttr("disabled"), !1) : void(window.location.href = baseURL + "settings")

        }

    }), !1

}



function updateUserPhoto() {

    return $("#save_profile_image").disable(), "" == $(".uploadavatar").val() ? (alert("Choose a image to upload"), $("#save_profile_image").removeAttr("disabled"), !1) : ($("#profile_settings_form").removeAttr("onSubmit"), void $("#profile_settings_form").submit())

}



function deleteUserPhoto() {

    $("#delete_profile_image").disable();

    var e = window.confirm("Are you sure?");

    return e ? void $.ajax({

        type: "POST",

        url: baseURL + "site/user_settings/delete_user_photo",

        dataType: "json",

        success: function(e) {

            return "0" == e.success ? (alert(e.msg), $("#delete_profile_image").removeAttr("disabled"), !1) : void(window.location.href = baseURL + "settings")

        }

    }) : ($("#delete_profile_image").removeAttr("disabled"), !1)

}



function deactivateUser() {

    $("#close_account").disable();

    var e = window.confirm("Are you sure?");

    e ? $.ajax({

        url: baseURL + "site/user_settings/delete_user_account",

        success: function(e) {

            window.location.href = baseURL

        }

    }) : $("#close_account").removeAttr("disabled")

}



function delete_gift(e, t) {

    $.ajax({

        type: "POST",

        url: baseURL + "site/cart/ajaxDelete",

        data: {

            curval: e,

            cart: "gift"

        },

        success: function(e) {

            var a = e.split("|");

            $("#gift_cards_amount").val(a[0]), $("#item_total").html(a[0]), $("#total_item").html(a[0]), $("#Shop_id_count").html(a[1]), $("#Shop_MiniId_count").html(a[1] + " items"), $("#giftId_" + t).hide(), $("#GiftMindivId_" + t).hide(), 0 == a[0] && ($("#GiftCartTable").hide(), 0 == a[1] && $("#EmptyCart").show())

        }

    })

}



function delete_subscribe(e, t) {

    $.ajax({

        type: "POST",

        url: baseURL + "site/cart/ajaxDelete",

        data: {

            curval: e,

            cart: "subscribe"

        },

        success: function(e) {

            var a = e.split("|");

            $("#subcrib_amount").val(a[0]), $("#subcrib_ship_amount").val(a[1]), $("#subcribt_tax_amount").val(a[2]), $("#subcrib_total_amount").val(a[3]), $("#SubCartAmt").html(a[0]), $("#SubCartSAmt").html(a[1]), $("#SubCartTAmt").html(a[2]), $("#SubCartGAmt").html(a[3]), $("#Shop_id_count").html(a[4]), $("#Shop_MiniId_count").html(a[4] + " items"), $("#SubscribId_" + t).hide(), $("#SubcribtMinidivId_" + t).hide(), 0 == a[0] && ($("#SubscribeCartTable").hide(), 0 == a[4] && $("#EmptyCart").show())

        }

    })

}



function ajaxEditproductAttribute(e, t, a) {

    $("#loadingImg_" + a).html('<span class="loading"><img src="images/indicator.gif" alt="Loading..."></span>'), $.ajax({

        type: "POST",

        url: baseURL + "admin/product/ajaxProductAttributeUpdate",

        data: {

            attname: e,

            attval: t,

            attId: a

        },

        success: function(e) {

            $("#loadingImg_" + a).html("")

        }

    })

}



function ajaxCartAttributeChange(e, t) {

    $("#loadingImg_" + t).html('<span class="loading"><img src="images/indicator.gif" alt="Loading..."></span>'), $("#AttrErr").html(""), $.ajax({

        type: "POST",

        url: baseURL + "site/product/ajaxProductDetailAttributeUpdate",

        data: {

            prdId: t,

            attId: e

        },

        success: function(e) {

            var a = e.split("|");

            $("#attribute_values").val(a[0]), $("#price").val(a[1]), $("#SalePrice").html(a[1]), $("#loadingImg_" + t).html("")

        }

    })

}



function ajaxCartAttributeChangePopup(e, t) {

    $("#loadingImg1_" + t).html('<span class="loading"><img src="images/indicator.gif" alt="Loading..."></span>'), $.ajax({

        type: "POST",

        url: baseURL + "site/product/ajaxProductDetailAttributeUpdate",

        data: {

            prdId: t,

            attId: e

        },

        success: function(a) {

            var i = a.split("|");

            $("#attribute_values").val(i[0]), $("#attr_name_id").val(e), $("#price").val(i[1]), $("#SalePrice").html(i[1]), $("#loadingImg1_" + t).html("")

        }

    })

}



function delete_cart(e, t) {

    $.ajax({

        type: "POST",

        url: baseURL + "site/cart/ajaxDelete",

        data: {

            curval: e,

            cart: "cart"

        },

        success: function(e) {

            var a = e.split("|");

            $("#cart_amount").val(a[0]), $("#cart_ship_amount").val(a[1]), $("#cart_tax_amount").val(a[2]), $("#cart_total_amount").val(a[3]), $("#CartAmt").html(a[0]), $("#CartSAmt").html(a[1]), $("#CartTAmt").html(a[2]), $("#CartGAmt").html(a[3]), $("#Shop_id_count").html(a[4]), $("#Shop_MiniId_count").html(a[4] + " items"), $("#cartdivId_" + t).hide(), $("#cartMindivId_" + t).hide(), 0 == a[0] && ($("#CartTable").hide(), 0 == a[4] && $("#EmptyCart").show())

        }

    })

}



function update_cart(e, t) {

    var a = $("#quantity" + t).val(),

        i = $("#quantity" + t).data("mqty");

    return a - a != 0 || "" == a || "0" == a ? (alert("Invalid quantity"), !1) : (a > i && ($("#quantity" + t).val(i), a = i, alert("Maximum stock available for this product is " + i)), void $.ajax({

        type: "POST",

        url: baseURL + "site/cart/ajaxUpdate",

        data: {

            updval: e,

            qty: a

        },

        success: function(e) {

            var a = e.split("|");

            $("#cart_amount").val(a[1]), $("#cart_ship_amount").val(a[2]), $("#cart_tax_amount").val(a[3]), $("#cart_total_amount").val(a[4]), $("#IndTotalVal" + t).html(a[0]), $("#CartAmt").html(a[1]), $("#CartAmtDup").html(a[1]), $("#CartSAmt").html(a[2]), $("#CartTAmt").html(a[3]), $("#CartGAmt").html(a[4]), $("#Shop_id_count").html(a[5]), $("#Shop_MiniId_count").html(a[5] + " items")

        }

    }))

}



function CartChangeAddress(e) {

    var t = $("#cart_amount").val(),

        a = $("#discount_Amt").val();

    $.ajax({

        type: "POST",

        url: baseURL + "site/cart/ajaxChangeAddress",

        data: {

            add_id: e,

            amt: t,

            disamt: a

        },

        success: function(t) {

            if ("0" == t) return !1;

            var a = t.split("|");

            $("#cart_ship_amount").val(a[0]), $("#cart_tax_amount").val(a[1]), $("#cart_tax_Value").val(a[2]), $("#cart_total_amount").val(a[3]), $("#CartSAmt").html(a[0]), $("#CartTAmt").html(a[1]), $("#carTamt").html(a[2]), $("#CartGAmt").html(a[3]), $("#Ship_address_val").val(e), $("#Chg_Add_Val").html(a[4])

        }

    })

}



function SubscribeChangeAddress(e) {

    var t = $("#subcrib_amount").val();

    $.ajax({

        type: "POST",

        url: baseURL + "site/cart/ajaxSubscribeAddress",

        data: {

            add_id: e,

            amt: t

        },

        success: function(t) {

            if ("0" == t) return !1;

            var a = t.split("|");

            $("#subcrib_ship_amount").val(a[0]), $("#subcrib_tax_amount").val(a[1]), $("#subcrib_total_amount").val(a[3]), $("#SubCartSAmt").html(a[0]), $("#SubCartTAmt").html(a[1]), $("#SubTamt").html(a[2]), $("#SubCartGAmt").html(a[3]), $("#SubShip_address_val").val(e), $("#SubChg_Add_Val").html(a[4])

        }

    })

}



function shipping_Subcribe_address_delete() {

    var e = $("#SubShip_address_val").val();

    $.ajax({

        type: "POST",

        url: baseURL + "site/cart/ajaxDeleteAddress",

        data: {

            del_ID: e

        },

        success: function(e) {

            return 0 != e ? ($("#Ship_Sub_err").html("Default address don`t be deleted."), setTimeout("hideErrDiv('Ship_Sub_err')", 3e3), !1) : void location.reload()

        }

    })

}



function shipping_cart_address_delete() {

    var e = $("#Ship_address_val").val();

    $.ajax({

        type: "POST",

        url: baseURL + "site/cart/ajaxDeleteAddress",

        data: {

            del_ID: e

        },

        success: function(e) {

            return 0 != e ? ($("#Ship_err").html("Default address don`t be deleted."), setTimeout("hideErrDiv('Ship_err')", 3e3), !1) : void location.reload()

        }

    })

}



function view_inquiry(e) {

    $.ajax({

        type: "POST",

        url: baseURL + "site/user_settings/view_inquiry_details",

        data: {

            inqID: e

        },

        dataType: "html",

        success: function(e) {

            $("#inquiry_popup").html(e)

        }

    }), $("#inquiry_popup").show(), $($(".inquiry_link").colorbox({

        width: "600px",

        height: "600px",

        inline: !0,

        href: "#inquiry_popup"

    })).trigger("click")

}



function ajax_add_cart(e) {

    $("#QtyErr").html("");

    var t = $(".add_to_cart").attr("require_login");

    if (t) return void require_login();

    var a = $("#quantity").val(),

        i = $("#quantity").data("mqty");

    if ("0" == a || "" == a) return alert("Invalid quantity"), !1;

    if (a > i) return $("#QtyErr").html("Maximum Purchase Quantity at a time is " + i), $("#quantity").val(i), !1;

    if (e > 0) {

        $("#AttrErr").html(" ");

        var s = $("#attr_name_id").val();

        if (0 == s) return $("#AttrErr").html("Please Choose the Attribute"), !1

    }

    var o = $("#product_id").val(),

        n = $("#sell_id").val(),

        r = $("#price").val(),

        l = $("#product_shipping_cost").val(),

        c = $("#product_tax_cost").val(),

        d = $("#cateory_id").val(),

        u = $("#attribute_values").val();

    return $.ajax({

        type: "POST",

        url: baseURL + "site/cart/cartadd",

        data: {

            mqty: i,

            quantity: a,

            product_id: o,

            sell_id: n,

            cate_id: d,

            price: r,

            product_shipping_cost: l,

            product_tax_cost: c,

            attribute_values: u

        },

        success: function(e) {

            var t = e.split("|");

            "login" == t[0] ? window.location.href = baseURL + "login" : "Error" == t[0] ? $("#ADDCartErr").html("Maximum Purchase Quantity: " + i + ". Already in your cart: " + t[1] + ".") : ($("#MiniCartViewDisp").html(t[1]), $("#cart_popup").show().delay("2000").fadeOut())

        }

    }), !1

}



function ajax_add_cart_subcribe() {

    var e = $("#subscribe").attr("require_login");

    if (e) return void require_login();

    var t = $("#user_id").val(),

        a = 1,

        i = $("#fancybox_id").val(),

        s = $("#price").val(),

        o = $("#shipping_cost").val(),

        n = $("#tax").val(),

        r = $("#category_id").val(),

        l = $("#name").val(),

        c = $("#seourl").val(),

        d = $("#image").val();

    return $.ajax({

        type: "POST",

        url: baseURL + "site/fancybox/cartsubscribe",

        data: {

            name: l,

            quantity: a,

            user_id: t,

            fancybox_id: i,

            price: s,

            fancy_ship_cost: o,

            category_id: r,

            fancy_tax_cost: n,

            seourl: c,

            image: d

        },

        success: function(e) {

            "login" == e ? window.location.href = baseURL + "login" : ($("#MiniCartViewDisp").html(e), $("#cart_popup").show().delay("3000").fadeOut())

        }

    }), !1

}



function ajax_add_gift_card() {

    var e = $(".create-gift-card").attr("require_login");

    if (e) return void require_login();

    $("#GiftErr").html();

    var t = $("#price_value").val(),

        a = $("#recipient_name").val(),

        i = $("#recipient_mail").val(),

        s = $("#description").val(),

        o = $("#sender_name").val(),

        n = $("#sender_mail").val();

    return "" == t ? ($("#GiftErr").html("Please Select the Price Value"), !1) : "" == a ? ($("#GiftErr").html("Please Enter the Receiver Name"), !1) : "" == i ? ($("#GiftErr").html("Please Enter the Receiver Email"), !1) : validateEmail(i) ? "" == s ? ($("#GiftErr").html("Please  Enter the Description"), !1) : ($.ajax({

        type: "POST",

        url: baseURL + "site/giftcard/insertEditGiftcard",

        data: {

            price_value: t,

            recipient_name: a,

            recipient_mail: i,

            description: s,

            sender_name: o,

            sender_mail: n

        },

        success: function(e) {

            "login" == e ? window.location.href = baseURL + "login" : ($("#MiniCartViewDisp").html(e), $("#cart_popup").show())

        }

    }), !1) : ($("#GiftErr").html("Please Enter Valid Email Address"), !1)

}



function change_user_password() 

{

	

    $("#save_password").disable();

    var e = $("#pass").val(),

        t = $("#confirmpass").val();

		var new_password = $("#new_password").val();

		var min_pass = $("#min_pass").val();

		var confirm_pass = $("#confirm_pass").val();

		var pass_not_match = $("#pass_not_match").val();

		

    return "" == e ? (alert(new_password), $("#save_password").removeAttr("disabled"), $("#pass").focus(), !1) : e.length < 6 ? (alert(min_pass), $("#save_password").removeAttr("disabled"), $("#pass").focus(), !1) : "" == t ? (alert(confirm_pass), $("#save_password").removeAttr("disabled"), $("#confirmpass").focus(), !1) : e != t ? (alert(pass_not_match), $("#save_password").removeAttr("disabled"), $("#confirmpass").focus(), !1) : !0

}



function shipping_address_cart() {

    var e = $.dialog("newadds-frm");

    $.dialog("editadds-frm"), $("#address_tmpl").remove();

    e.open(), setTimeout(function() {

        e.$obj.find(":text:first").focus()

    }, 10)

}



function checkCode() {

    $("#CouponErr").html(""), $("#CouponErr").show();

    var e = $("#cart_amount").val();

    if (e > 0) {

        var t = $("#is_coupon").val(),

            a = $("#cart_total_amount").val(),

            i = $("#cart_ship_amount").val();

        $("#cart_tax_amount").val();

        "" != t ? $.ajax({

            type: "POST",

            url: baseURL + "site/cart/checkCode",

            data: {

                code: t,

                amount: a,

                shipamount: i

            },

            success: function(e) {

                var s = e.split("|");

                return 1 == e ? ($("#CouponErr").html("Entered code is invalid"), !1) : 2 == e ? ($("#CouponErr").html("Code is already used"), !1) : 3 == e ? ($("#CouponErr").html("Please add more items in the cart and enter the coupon code"), !1) : 4 == e ? ($("#CouponErr").html("Entered Coupon code is not valid for this product"), !1) : 5 == e ? ($("#CouponErr").html("Entered Coupon code is expired"), !1) : 6 == e ? ($("#CouponErr").html("Entered code is Not Valid"), !1) : 7 == e ? ($("#CouponErr").html("Please add more items quantity in the particular category or product, for using this coupon code"), !1) : 8 == e ? ($("#CouponErr").html("Entered Gift code is expired"), !1) : void("Success" == s[0] && $.ajax({

                    type: "POST",

                    url: baseURL + "site/cart/checkCodeSuccess",

                    data: {

                        code: t,

                        amount: a,

                        shipamount: i

                    },

                    success: function(e) {

                        var a = e.split("|");

                        $("#cart_amount").val(a[0]), $("#cart_ship_amount").val(a[1]), $("#cart_tax_amount").val(a[2]), $("#cart_total_amount").val(a[3]), $("#discount_Amt").val(a[4]), $("#CartAmt").html(a[0]), $("#CartSAmt").html(a[1]), $("#CartTAmt").html(a[2]), $("#CartGAmt").html(a[3]), $("#disAmtVal").html(a[4]), $("#disAmtValDiv").show(), $("#CouponCode").val(t), $("#Coupon_id").val(s[1]), $("#couponType").val(s[2]);

                        for (var i = 6, o = 0; o < a[5]; o++) $("#IndTotalVal" + o).html(a[i]), i++

                    }

                }))

            }

        }) : $("#CouponErr").html("Enter Valid Code")

    } else $("#CouponErr").html("Please add items in cart and enter the coupon code");

    setTimeout("hideErrDiv('CouponErr')", 3e3)

}



function paypal() {

    $("#PaypalPay").show(), $("#CreditCardPay").hide(), $("#otherPay").hide(), $("#dep1").attr("class", "depth1 current"), $("#dep2").attr("class", "depth2"), $("#dep1 a").attr("class", "current"), $("#dep2 a").attr("class", "")

}



function creditcard() {

    $("#CreditCardPay").show(), $("#PaypalPay").hide(), $("#otherPay").hide(), $("#dep1").attr("class", "depth1"), $("#dep2").attr("class", "depth2 current"), $("#dep1 a").attr("class", ""), $("#dep2 a").attr("class", "current")

}



function othermethods() {

    $("#otherPay").show(), $("#PaypalPay").hide(), $("#CreditCardPay").hide(), $("#dep1").attr("class", "depth1"), $("#dep2").attr("class", "depth2"), $("#dep3").attr("class", "depth3 current"), $("#dep1 a").attr("class", ""), $("#dep2 a").attr("class", ""), $("#dep3 a").attr("class", "current")

}



function loadListValues(e) {

    var t = $(e).val(),

        a = $(e).parent().next().find("select");

    "" == t ? a.html('<option value="">--Select--</option>') : (a.hide(), $(e).parent().next().append('<span class="loading">Loading...</span>'), $.ajax({

        type: "POST",

        url: BaseURL + "admin/product/loadListValues",

        data: {

            lid: t

        },

        dataType: "json",

        success: function(e) {

            a.next().remove(), a.html(e.listCnt).show()

        }

    }))

}



function loadStateListValues(e) {

    var t = $(e).val();

    $(e).val();

    "" == t || $.ajax({

        type: "POST",

        url: BaseURL + "admin/product/loadStateListValues",

        data: {

            lid: t

        },

        dataType: "json",

        success: function(e) {

            $("#listStateCnt").hide(), $("#listStateCnt").html(e.listCountryCnt).show()

        }

    })

}



function loadCountryListValues(e) {

    var t = $(e).val();

    $(e).val();

    "" == t || $.ajax({

        type: "POST",

        url: BaseURL + "admin/product/loadCountryListValues",

        data: {

            lid: t

        },

        dataType: "json",

        success: function(e) {

            $("#listCountryCnt").hide(), $("#listCountryCnt").html(e.listCountryCnt).show()

        }

    })

}



function loadListValuesUser(e) {

    var t = $(e).val(),

        a = $(e).parent().next().find("select");

    "" == t ? a.html('<option value="">--Select--</option>') : (a.hide(), $(e).parent().next().append('<span class="loading">Loading...</span>'), $.ajax({

        type: "POST",

        url: BaseURL + "site/product/loadListValues",

        data: {

            lid: t

        },

        dataType: "json",

        success: function(e) {

            a.next().remove(), a.html(e.listCnt).show()

        }

    }))

}



function changeListValues(e, t) {

    var a = $(e).val(),

        i = $(e).parent().next().find("select");

    "" == a ? i.html('<option value="">--Select--</option>') : (i.hide(), $(e).parent().next().append('<span class="loading">Loading...</span>'), $.ajax({

        type: "POST",

        url: BaseURL + "admin/product/loadListValues",

        data: {

            lid: a,

            lvID: t

        },

        dataType: "json",

        success: function(e) {

            i.next().remove(), i.html(e.listCnt).show()

        },

        complete: function() {

            i.next().remove(), i.show()

        }

    }))

}



function changeListValuesUser(e, t) {

    var a = $(e).val(),

        i = $(e).parent().next().find("select");

    "" == a ? i.html('<option value="">--Select--</option>') : (i.hide(), $(e).parent().next().append('<span class="loading">Loading...</span>'), $.ajax({

        type: "POST",

        url: BaseURL + "site/product/loadListValues",

        data: {

            lid: a,

            lvID: t

        },

        dataType: "json",

        success: function(e) {

            i.next().remove(), i.html(e.listCnt).show()

        },

        complete: function() {

            i.next().remove(), i.show()

        }

    }))

}



function confirm_status_dashboard(e) {

    $.confirm({

        title: "Confirmation",

        message: "You are about to change the status of this record ! Continue?",

        buttons: {

            Yes: {

                "class": "yes",

                action: function() {

                    window.location = BaseURL + "admin/dashboard/admin_dashboard"

                }

            },

            No: {

                "class": "no",

                action: function() {

                    return !1

                }

            }

        }

    })

}



function validateEmail(e) {

    var t = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

    return t.test(e) ? !0 : !1

}



function changeShipStatus(e, t, a) {

    $(".status_loading_" + t).prev().hide(), $(".status_loading_" + t).show(), $.ajax({

        type: "post",

        url: baseURL + "site/user/change_order_status",

        data: {

            value: e,

            dealCode: t,

            seller: a

        },

        dataType: "json",

        success: function(e) {

            1 == e.status_code

        },

        fail: function(e) {

            alert(e)

        },

        complete: function() {

            $(".status_loading_" + t).hide(), $(".status_loading_" + t).prev().show()

        }

    })

}



function changeCatPos(e, t) {

    var a = $(e).prev().val();

    return a - a != 0 ? void alert("Invalid position") : ($(e).hide(), $(e).next().show(), $.ajax({

        type: "post",

        url: baseURL + "admin/category/changePosition",

        data: {

            catID: t,

            pos: a

        },

        complete: function() {

            $(e).next().hide(), $(e).show().text("Done").delay(800).text("Update")

        }

    }), void 0)

}



function changeProductPos(e, t) {

    var a = $(e).prev().val();

    return a - a != 0 ? void alert("Invalid position") : ($(e).hide(), $(e).next().show(), $.ajax({

        type: "post",

        url: baseURL + "admin/product/changePosition",

        data: {

            catID: t,

            pos: a

        },

        complete: function() {

            $(e).next().hide(), $(e).show().text("Done").delay(800).text("Update")

        }

    }), void 0)

}



function approveCmt(e) {

    if (!$(e).hasClass("approving")) {

        $(e).addClass("approving"), $(e).text("Approving...");

        var t = window.confirm("Are you sure to approve this comment ?\n This action cannot be undone.");

        if (t) {

            var a = $(e).data("cid"),

                i = $(e).data("tid"),

                s = $(e).data("uid");

            $.ajax({

                type: "post",

                url: baseURL + "site/product/approve_comment",

                data: {

                    cid: a,

                    tid: i,

                    uid: s

                },

                dataType: "json",

                success: function(t) {

                    "1" == t.status_code ? $(e).parent().remove() : ($(e).removeClass("approving"), $(e).text("Approve"))

                }

            })

        } else $(e).removeClass("approving"), $(e).text("Approve")

    }

}



function deleteCmt(e) {

    if (!$(e).hasClass("deleting")) {

        $(e).addClass("deleting"), $(e).text("Deleting...");

        var t = window.confirm("Are you sure to delete this comment ?\n This action cannot be undone.");

        if (t) {

            var a = $(e).data("cid");

            $.ajax({

                type: "post",

                url: baseURL + "site/product/delete_comment",

                data: {

                    cid: a

                },

                dataType: "json",

                success: function(t) {

                    "1" == t.status_code ? $(e).parent().parent().remove() : ($(e).removeClass("deleting"), $(e).text("Delete"))

                }

            })

        } else $(e).removeClass("deleting"), $(e).text("Delete")

    }

}



function post_order_comment(e, t, a, i) {

    if (!$(".order_comment_" + e).hasClass("posting")) {

        $(".order_comment_" + e).addClass("posting");

        var s = $(".order_comment_" + e).parent();

		var login_required = $("#login_required").val();

		var comment_empty = $("#comment_empty").val();

		

        "" == a ? (alert(login_required), $(".order_comment_" + e).removeClass("posting")) : "" == $(".order_comment_" + e).val() ? (alert(comment_empty), $(".order_comment_" + e).removeClass("posting")) : (s.find("img").show(), s.find("input").hide(), $.ajax({

            type: "post",

            url: baseURL + "site/user/post_order_comment",

            data: {

                product_id: e,

                comment_from: t,

                commentor_id: a,

                deal_code: i,

                comment: $(".order_comment_" + e).val()

            },

            complete: function() {

                s.find("img").hide(), s.find("input").show(), window.location.reload()

            }

        }))

    }

}



function post_order_comment_admin(e, t) {

    if (!$(".order_comment_" + e).hasClass("posting")) {

        $(".order_comment_" + e).addClass("posting");

        var a = $(".order_comment_" + e).parent();

        "" == $(".order_comment_" + e).val() ? (alert("Your comment is empty"), $(".order_comment_" + e).removeClass("posting")) : (a.find("img").show(), a.find("input").hide(), $.ajax({

            type: "post",

            url: baseURL + "admin/order/post_order_comment",

            data: {

                product_id: e,

                comment_from: "admin",

                commentor_id: "1",

                deal_code: t,

                comment: $(".order_comment_" + e).val()

            },

            complete: function() {

                a.find("img").hide(), a.find("input").show(), window.location.reload()

            }

        }))

    }

}



function ChangeFeatured(e, t) {

    $("#feature_" + t).html('<a class="c-loader" href="javascript:void(0);" title="Loading" >Loading</a>');

    var a = e,

        i = "feature_" + t,

        s = window.location.pathname,

        o = s.substring(s.lastIndexOf("/") + 1);

    $.ajax({

        type: "POST",

        url: BaseURL + "admin/product/ChangeFeaturedProducts",

        data: {

            id: i,

            cpage: o,

            imgId: t,

            FtrId: a

        },

        dataType: "json",

        success: function(e) {

            $("#feature_" + t).remove()

        }

    }), "Featured" == a ? $("#feature_" + t).html('<a class="c-featured" href="javascript:ChangeFeatured(\'UnFeatured\',' + t + ')" title="Click To Un-Featured" >Featured</a>').show() : $("#feature_" + t).html('<a class="c-unfeatured" href="javascript:ChangeFeatured(\'Featured\',' + t + ')" title="Click To Featured" >Un-Featured</a>').show()

}



function changeReceivedStatus(e, t) {

    $(e).hide(), $(e).next().show(), $.ajax({

        type: "post",

        url: baseURL + "site/user/change_received_status",

        data: {

            rid: t,

            status: $(e).val()

        },

        complete: function() {

            $(e).show(), $(e).next().hide()

        }

    })

}



function update_refund(e, t) {

    if (!$(e).hasClass("updating")) {

        $(e).addClass("updating").text("Updating..");

        var a = $(e).prev().val();

        return "" == a || a - a != 0 ? (alert("Enter valid amount"), $(e).removeClass("updating").text("Update"), !1) : void $.ajax({

            type: "post",

            url: baseURL + "admin/seller/update_refund",

            data: {

                amt: a,

                uid: t

            },

            complete: function() {

                window.location.reload()

            }

        })

    }

}



function DeleteWishList(e, t) {

    var a = window.confirm("Are you sure delete the wish list?");

    if (!a) return !1;

    var i = "wish_" + e,

        s = window.location.pathname,

        o = s.substring(s.lastIndexOf("/") + 1);

    $.ajax({

        type: "POST",

        url: BaseURL + "site/wishlists/DeleteWishList",

        data: {

            pid: e,

            cpage: o,

            wid: t

        },

        dataType: "json",

        success: function(e) {

            "0" == e.result && ($("#" + i).remove(), alert("Wish list deleted successfully"), window.location.reload()), "1" == e.result && ($("#" + i).remove(), alert("Wish list deleted successfully"), window.location.reload())

        }

    })

}



function ChangePassword() {

	

	var old_password = $("#old_pass").val();

	var new_password = $("#new_pass").val();

	var confirm_password = $("#confirm_pass").val();

	var pass_not = $("#pass_not").val();

	

	

    return $("#old_password_warn").html(""), $("#new_password_warn").html(""), $("#confirm_password_warn").html(""), "" == $("#old_password").val() ? ($("#old_password_warn").html(old_password), $("#old_password").focus(), !1) : "" == $("#new_password").val() ? ($("#new_password_warn").html(new_password), $("#new_password").focus(), !1) : "" == $("#confirm_password").val() ? ($("#confirm_password_warn").html(confirm_password), $("#confirm_password").focus(), !1) : $("#confirm_password").val() != $("#new_password").val() ? ($("#confirm_password_warn").html(pass_not), $("#confirm_password").focus(), !1) : void $("#changePassword1").submit()

}



function SavedNeighborhoods(e, t) {

    var a = e,

        i = t;

    $.ajax({

        type: "POST",

        url: BaseURL + "site/neighborhood/saved_neighborhoods",

        data: {

            neighborhood: a,

            city_name: i

        },

        dataType: "json",

        success: function(e) {

            $("#saveCount").html(e.count), $("#saved_details").html(e.details), alert(e.msg)

        }

    })

}



function DeleteNeighborhoods(e) {

    var t = e;

    $.ajax({

        type: "POST",

        url: BaseURL + "site/neighborhood/delete_neighborhoods",

        data: {

            id: t

        },

        dataType: "json",

        success: function(e) {

            $("#saveCount").html(e.count),

                $("#row_" + t).hide(), alert(e.msg)

        }

    })

}

$(document).ready(function() {

    $(".checkboxCon input:checked").parent().css("background-position", "-114px -260px"), $("#selectallseeker").click(function() {

        $(".caseSeeker").attr("checked", this.checked), this.checked ? ($(this).parent().addClass("checked"), $(".checkboxCon").css("background-position", "-114px -260px")) : ($(this).parent().removeClass("checked"), $(".checkboxCon").css("background-position", "-38px -260px"))

    }), $(".captcha-cls").bind("cut copy paste", function(e) {

        e.preventDefault()

    }), $(".caseSeeker").click(function() {

        $(".caseSeeker").length == $(".caseSeeker:checked").length ? ($("#selectallseeker").attr("checked", "checked"), $("#selectallseeker").parent().addClass("checked")) : ($("#selectallseeker").removeAttr("checked"), $("#selectallseeker").parent().removeClass("checked"))

    }), $(".checkboxCon input").click(function() {

        this.checked ? $(this).parent().css("background-position", "-114px -260px") : $(this).parent().css("background-position", "-38px -260px")

    }), $(".popup-signup-ajax").click(function() {

        $.ajax({

            type: "POST",

            url: baseURL + "googlelogin/index.php",

            data: {},

            success: function(e) {

                $("#popup_container").css("display", "block")

            }

        })

    }), $(".gnb-notification").mouseenter(function() {

        $(this).hasClass("cntLoading") || ($(this).addClass("cntLoading"), $(".feed-notification").show(), $(".feed-notification").find("ul").remove(), $(this).find(".loading").show(), $.ajax({

            type: "post",

            url: baseURL + "site/notify/getlatest",

            dataType: "json",

            success: function(e) {

                1 == e.status_code ? ($(".feed-notification").find(".loading").after(e.content), $(".moreFeed").show()) : 2 == e.status_code && ($(".feed-notification").find(".loading").after(e.content), $(".moreFeed").hide())

            },

            complete: function() {

                $(".gnb-notification").find(".loading").hide(), $(".gnb-notification").removeClass("cntLoading")

            }

        }))

    }).mouseleave(function() {

        $(".feed-notification").hide()

    })

});