$(document).ready(function () {
    function initialize() {
        var autocomplete = new google.maps.places.Autocomplete(
            (document.getElementById('autocomplete')), {
                types: ['geocode']
            });
        var Url = 'property?city=';
        if (IsExpriencePage == 0) {
            var Url = 'explore-experience?city=';
        }
        if (IsHomePage == 0 || screen.width < 530) {
            autocomplete.addListener('place_changed', function () {
                var address = $('#autocomplete').val();
                window.location = BaseURL + Url + address;
            });
        }
    }

    initialize();
    $("body").click(function (e) {
        if ($(e.target).closest(".searchLocation").length == 1 && $(".searchInput").val() == '') {
            $(".exploreDetail").show();
        }
        else {
            $(".exploreDetail").hide();
        }
    });
    $(document).on("click", ".toggleFooter", function () {
        $("footer").slideToggle(200);
        $(this).toggleClass("closeIcon");
        if (!$(this).hasClass("closeIcon")) {
            $(this).html('<i class="fa fa-globe" aria-hidden="true"></i> Language and Currency');
        }
        else {
            $(this).html('<i class="fa fa-times" aria-hidden="true"></i> Close')
        }
    });
    $(document).on("click", ".inc", function () {
        var guestVal = $(this).prev(".guestVal").val();
        // if(guestVal!=20){
        $(this).prev(".guestVal").val(++guestVal);
        // }
    });
    $(document).on("click", ".dec", function () {
        var guestVal = $(this).next(".guestVal").val();
        if (guestVal != 0) {
            $(this).next(".guestVal").val(--guestVal);
        }
    });
    $(document).on("click", ".toggleMore", function () {
        $(this).prevAll(".more").toggleClass("active");
    });
    $(document).keyup(function (e) {
        if (e.keyCode == 27) { // escape key maps to keycode `27`
            $(".exploreDetail").hide();
        }
    });
    $('.fixedContainer a').click(function () {
        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top - 60
        }, 500);
    });
    $('.goToLoc').click(function () {
        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top
        }, 500);
    });
    $(document).on("click", ".lightboxBanner, .closeLightBox", function () {
        $("#lightBox").toggleClass("active");
    });
    $(".showResult").click(function () {
        $(this).next(".guestInfo").toggle();
        $(this).children(".arrow").toggleClass("active");
    });
    $(document).on("click", ".tRB", function () {
        $(".toggleRequestBook").slideToggle(200);
    });
    $(document).on('hidden.bs.modal', function (event) {
        if ($('.modal:visible').length) {
            $('body').addClass('modal-open');
        }
    });
    $(".signupOpen").click(function () {
        $(".hide_signUp").hide();
        $(".SignupBlock").show();
    });
    $(".showPass").click(function () {
        if ($(".password_l").attr("type") == "password") {
            $(".password_l").prop("type", "text");
            $(this).text("Hide Password");
        }
        else {
            $(".password_l").prop("type", "password");
            $(this).text("Show Password");
        }
    });
    $(document).on("click", ".menuArrow", function () {
        $(".menuArrow .icon").toggleClass("active");
        $(".responsiveMenu").slideToggle(300);
    });
    $(document).on("click", ".toggleMenuD", function () {
        $(this).toggleClass("change");
        var hiddenMenu = $('.leftSlideBlock');
        if (hiddenMenu.hasClass('active')) {
            hiddenMenu.animate({"left": "-100%"}, "100").removeClass('active');
        } else {
            hiddenMenu.addClass("active");
            hiddenMenu.animate({"left": "0px"}, "100");
        }
    });
    $(document).on("click", ".toggleNotes", function () {
        $(".rightBlock").toggle("100");
    });
    $(".allowGuest").change(function () {
        if ($(this).is(':checked')) {
            $(".togglePreapprove").hide();
            $(".allowGuest").not($(this)).prop('checked', false);
            $(this).parent().parent().next(".togglePreapprove").show();
        }
        else {
            $(".togglePreapprove").hide();
        }
    });
});

function CalanderUpdate(evt, catID, chk) {
   // alert('0');
     
    $("#calander_listing").show();
     $('.pric').hide();
    var title = evt.value;
    var msg = $("#saved").val();
    $.ajax({
        type: 'post',
        url: baseURL + 'site/product/saveDetailPage',
        data: {'catID': title, 'title': catID, 'chk': chk},
        complete: function (e) {
            $('#imgmsg_' + catID).hide();
            $('#imgmsg_' + catID).show().text(msg);
        }
    });
}
function CalanderUpdate_some(evt, catID, chk) {
    // alert('1');
     
    $("#calander_listing").show();
     $('.pric').show();
    var title = evt.value;
    var msg = $("#saved").val();
    $.ajax({
        type: 'post',
        url: baseURL + 'site/product/saveDetailPage',
        data: {'catID': title, 'title': catID, 'chk': chk},
        complete: function (e) {
            $('#imgmsg_' + catID).hide();
            $('#imgmsg_' + catID).show().text(msg);
        }
    });
}

function Detaillist(evt, catID, chk) {
    var title = evt.value;
    $.ajax({
        type: 'post',
        url: baseURL + 'site/product/Save_Listing_Details',
        data: {'catID': catID, 'title': title, 'chk': chk},
        complete: function () {
            $('#imgmsg_' + catID).hide();
            $('#imgmsg_' + catID).show().text('Saved');
        }
    });
}

/************/

/*ajax saving for Exp*/
function experienceDetailview(evt, catID, chk) {
    var title = evt.value;
    var pattern = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
    no_ajax = 0;
    if (chk == 'video_url') {
        if (!pattern.test(title)) {
            $("#video_url").val("");
            $("#VideoError").html("Please enter a valid URL.");
            no_ajax = 1;
        } else {
            $("#VideoError").html("");
        }
    }
    if (no_ajax == 0) {
        $.ajax({
            type: 'post',
            url: baseURL + 'site/experience/saveDetailPage',
            data: {'catID': catID, 'title': title, 'chk': chk},
            complete: function () {
                $('#imgmsg_' + catID).hide();
                $('#imgmsg_' + catID).show().text('Saved');
            }
        });
    }
}

/*
*function to save property cancellation policies, listings
*/
function Detailview(evt, catID, chk) {
    var title = evt.value;
    var msg = $("#saved").val();
    $.ajax({
        type: 'post',
        url: baseURL + 'site/product/saveDetailPage',
        data: {'catID': catID, 'title': title, 'chk': chk},
        complete: function (e) {
            $('#imgmsg_' + catID).hide();
            $('#imgmsg_' + catID).show().text(msg);
        }
    });
}

/*Fill map address*/
function fillInAddress() {
    var place = autocomplete.getPlace();
    $('#latitude').val(place.geometry.location.lat());
    $('#longitude').val(place.geometry.location.lng());
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            if (addressType == "route") {
                $('#address').val(val);
            } else if (addressType == "locality") {
                $('#city').val(val);
            } else if (addressType == "administrative_area_level_1") {
                $('#state').val(val);
            } else if (addressType == "country") {
                $('#country').val(val);
            } else if (addressType == "postal_code") {
                $('#post_code').val(val);
            }
        }
    }
}
function boot_success_alert(message){
    $("#model-alert-success").modal();
    $("#alert_message_content_success").text(message);
}
function boot_alert(message){
    $("#model-alert").modal();
    $("#alert_message_content").text(message);
}
