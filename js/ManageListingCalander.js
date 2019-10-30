/**
 *
 * @Author : Sathyaseelan
 * Description: Allow us to book and reset scheduled dates.
 *
 * */
var selectedDate = [];
var selectedDate1 = [];
var LocalBookedDates = [];
BookedDates.forEach(function (value) {
    LocalBookedDates.push(value.toLocaleDateString());
});
datepicker.onSelect = function (checked) {
    var selected = this.toLocaleDateString();
    var selected_date = this;
    selectedDate.indexOf(selected) === -1 ? selectedDate.push(selected) : selectedDate.splice($.inArray(selected, selectedDate), 1);
    selectedDate1.indexOf(selected_date) === -1 ? selectedDate1.push(selected_date) : selectedDate1.splice($.inArray(selected_date, selectedDate1), 1);
    if (selectedDate.length == 2) {
        var d1 = new Date(selectedDate[0]);
        var d2 = new Date(selectedDate[1]);
        var t1 = d1.getTime();
        var t2 = d2.getTime();
        if (t1 > t2) {
            var temp = selectedDate[0];
            selectedDate[0] = selectedDate[1];
            selectedDate[1] = temp;
        }
        var dates = getDates(new Date(selectedDate[0]), new Date(selectedDate[1]));
    } else {
        var dates = [];
    }
    var found = 0;
    for (var i = 0; i < dates.length; i++) {
        if (LocalBookedDates.indexOf(dates[i]) > -1) {
            found++;
        }
    }
    if (found > 0) {
        boot_alert('In selected dates , booked date also there. Not allowed to Edit');
        return false;
    } else {
        if (selectedDate.length == 2) {
            $("#StartDate").val(formatDate(selectedDate1[0]));
            $("#EndDate").val(formatDate(selectedDate1[1]));
            $('#DateMaker').modal('show');
        }
    }
};
var getDates = function (startDate, endDate) {
    var dates = [],
        currentDate = startDate,
        addDays = function (days) {
            var date = new Date(this.valueOf());
            date.setDate(date.getDate() + days);
            return date;
        };
    while (currentDate <= endDate) {
        dates.push(currentDate.toLocaleDateString());
        currentDate = addDays.call(currentDate, 1);
    }
    return dates;
};

/*DateFormat*/
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;
    return [year, month, day].join('-');
}

/*Saving date or remove dates from schedule dates */
function SaveAvailableDate() {
    var StartDate = $("#StartDate").val();
    var ProductId = $("#ProductId").val();
    var EndDate = $("#EndDate").val();
    var NewPrice = $("#Price").val();
    var NewStatus = $("#status").val();
    if (NewPrice != "" && isNaN(NewPrice)) {
        $("#priceError").html("Please Enter Valid Price!");
    } else {
        $("#priceError").html("");
        $.post(base_url + "site/product/saveNewDates",
            {
                StartDate: StartDate,
                EndDate: EndDate,
                Price: NewPrice,
                ProductId: ProductId,
                AlreadyFound: AlreadyFound,
                Status: NewStatus
            },
            function (data, status) {
                window.location.reload();
            });
    }
}

/*reset dates from schedule dates */
function ResetChoosedDates() {
    var StartDate = $("#StartDate").val();
    var ProductId = $("#ProductId").val();
    var EndDate = $("#EndDate").val();
    $("#priceError").html("");
    $.post(base_url + "site/product/ResetGivenDates",
        {
            StartDate: StartDate,
            EndDate: EndDate,
            ProductId: ProductId,
            AlreadyFound: AlreadyFound
        },
        function (data, status) {
            window.location.reload();
        });
}
