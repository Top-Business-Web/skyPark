<script>
    var table;
    table = $('.firstTable').DataTable({
        responsive: true,
        paging: false
    });
    var amountCash = $("#amount"),
        total = $('#totalPrice');
    localStorage.setItem('prevent', '0')

    function checkDay(e) {
        // Create date from input value
        var inputDate = new Date(e.target.value);
        // Get today's date
        var Today = new Date();
        // call setHours to take the time out of the comparison
        if (inputDate.setHours(0, 0, 0, 0) === Today.setHours(0, 0, 0, 0)) {
            localStorage.setItem('prevent', '0')
            $('#duration').removeAttr('disabled');
            $('#choices_times').removeAttr('disabled');
            $('#firstNext').removeAttr('disabled');
            $('#dayError').text("")
            $('#start').val('')
            $('#timeDiv').hide(500);
            checkTime()
        } else if (inputDate.setHours(0, 0, 0, 0) > Today.setHours(0, 0, 0, 0)) {
            localStorage.setItem('prevent', '0')
            $('#dayError').text("")
            $('#duration').removeAttr('disabled');
            $('#choices_times').removeAttr('disabled');
            $('#firstNext').removeAttr('disabled');
            $('#duration').val("")
            $('#choices_times').empty()
            $('#start').val($('#first_shift_start').val())
            // $('#timeDiv').show(500);
        } else {
            $('#dayError').text("The Day Can't Be Past !")
            localStorage.setItem('prevent', '1')
            $('#duration').val("")
            $('#duration').attr('disabled', 'disabled')
            $('#choices_times').attr('disabled', 'disabled')
            $('#firstNext').attr('disabled', 'disabled');
            $('#choices_times').empty()
        }
    }

    function checkTime() {
        var myDuration = $('#duration').val(),
            time = $('#start').val(),
            myDate = $('#date').val();
        if (time.length === 0) {
            var now = new Date(Date.now());
            time = now.getHours();
        }
        $('#startError').text('')
        $('#durationError').text('')
        if (localStorage.getItem('prevent') !== '1' && myDuration.length > 0) {
            $.ajax({
                type: 'GET',
                url: "{{route('getShifts')}}",
                data: {
                    'duration': myDuration,
                    'time': time,
                    'visit_date': myDate,
                    'id': 81,
                },
                success: function (data) {
                    if (data.status === 200) {
                        $('#choices_times').empty()
                        if (data.times.length !== 0) {
                            $.each(data.times, function (key, value) {
                                if (data.starts[key] == data.selected_start && data.ends[key] == data.selected_end)
                                    $("#choices_times").append(`<option selected data-starts = ${data.starts[key]} data-ends = ${data.ends[key]}  value= ${data.shift_id[key]}> ${value} </option>`);
                                else
                                    $("#choices_times").append(`<option data-starts = ${data.starts[key]} data-ends = ${data.ends[key]}  value= ${data.shift_id[key]}> ${value} </option>`);
                            });
                        } else
                            toastr.error("Can't Enter To The Next Day !");
                    }
                }
            });
        }
    }

    var count = 1000;

    function appendRow(type_id, type, price) {
        if (localStorage.getItem('available') > table.rows().count()) {
            var row = table.row.add([
                `<span data-type_id="${type_id}" id="visitor_type[]">${type}</span>`,
                `<span data-price="${price}" id="visitor_price[]">${price}</span>`,
                '<input type="text" class="form-control" placeholder="Name" name="visitor_name[]">',
                '<input type="date" class="form-control" name="visitor_birthday[]" id="visitor_birthday[]">',
                `<div class="choose">
                   <div class="genderOption">
                     <input type="radio" class="btn-check" name="gender${count}" id="option1${count}" value="male">
                     <label class=" mb-0 btn btn-outline" for="option1${count}"><span><i class="fas fa-male"></i></span></label>
                   </div>
                   <div class="genderOption" style="display: none">
                     <input type="radio" class="btn-check" name="gender${count}" id="option1${count}" value="" checked>
                     <label class=" mb-0 btn btn-outline" for="option1${count}"></label>
                   </div>
                 <div class="genderOption">
                    <input type="radio" class="btn-check" name="gender${count}" id="option2${count}" value="female">
                    <label class=" mb-0 btn btn-outline" for="option2${count}"><span><i class="fas fa-female"></i> </span></label>
                 </div>
                 </div>`,
                `<span class="controlIcons">
                     <span class="icon Delete" data-model_id="${type_id}"> <i
                      class="far fa-trash-alt"></i> </span>
                </span>`
            ]).draw().node();
            count++;
            $(row).addClass(type);
            getCount(type, type_id)
        } else {
            toastr.error("The park is full")
        }
    }


    function getCount(className, type_id) {
        $('.visitorType' + type_id).find('.count').text(table.rows('[class*=' + className + ']').count());
        $('.visitorType' + type_id).find('.inputCount').val(table.rows('[class*=' + className + ']').count());
    }


    $(document).on('click', '.visitorTypeDiv', function () {
        var type = $(this).find('.visitor').text();
        var visitor_type_id = $(this).find('#visitor_type_id').val();
        appendRow(visitor_type_id, type, $(this).find('input').val())
    });
    $('.firstTable').on('click', 'tbody tr .Delete', function () {
        table.row($(this).parent().parent()).remove().draw();
        getCount($(this).parent().parent().parent().attr('class').replace('odd ', '').replace('even ', '').replace(' odd', '').replace(' even', ''), $(this).attr("data-model_id"))
    });

    // Check Capacity And Get Price Of Visitor Models
    $(document).on('click', '#firstNext', function () {
        var phone       = $('#phone').val(),
            client_name = $('#client_name').val(),
            email       = $('#email').val();
        if (client_name.length === 0 || phone.length === 0 || email.length === 0) {
            if (client_name.length === 0)
                $('#client_nameError').text('Client Name Is Required')
            if (phone.length === 0)
                $('#phoneError').text('Phone Is Required')
            if (email.length === 0)
                $('#emailError').text('Email Is Required')
            $("button[title='visitors']").removeClass('js-active');
            $("#visitorsTab").removeClass('js-active');
            $("button[title='ticket']").addClass('js-active');
            $("#ticketTab").addClass('js-active');
        }
    });


    $(document).on('click', '#secondPrev', function () {
        $('#client_nameError').text('')
        $('#phoneError').text('')
        $('#emailError').text('')
    });


    ////////////////////////////////////////////
    // choice Js
    ////////////////////////////////////////////
    if (document.getElementById('choices-shift')) {
        var element = document.getElementById('choices-shift');
        const options = new Choices(element, {
            searchEnabled: false
        });
    }
    // if (document.getElementById('choices_times')) {
    //     var element = document.getElementById('choices_times');
    //     const options = new Choices(element, {
    //         searchEnabled: false
    //     });
    // }
    if (document.getElementById('choices-category')) {
        var element = document.getElementById('choices-category');
        const options = new Choices(element, {
            searchEnabled: false
        });
    }
    if (document.getElementById('choices-discount')) {
        var element = document.getElementById('choices-discount');
        const options = new Choices(element, {
            searchEnabled: false
        });
    }


    // Show categories
    var categories = JSON.parse('<?php echo json_encode($categories) ?>');
    $(document).on('change', '#choices-category', function () {
        var id = $(this).val();
        var category = categories.filter(oneObject => oneObject.id == id)
        if (category.length > 0) {
            var products = category[0].products

            $('#choices-product').html('<option value="" disabled>Choose The Product</option>')

            $.each(products, function (index) {
                $('#choices-product').append('<option value="' + products[index].id + '" data-price="' + products[index].price + '"> ' + products[index].title + '</option>')
            })
        }
    })

    var myNewTable = $('#myNewTable');
    var myTable;
    myTable = myNewTable.DataTable({
        responsive: true,
    });
    myTable.clear();
    $('#addBtn').click(function () {
        var product_select = $('#choices-product'),
            product = product_select.find(":selected").text(),
            product_id = product_select.find(":selected").val(),
            price = product_select.find(":selected").attr('data-price'),
            category_id = $('#choices-category').find(":selected").val();
        if (myTable.rows('[class*=productrow' + product_id + ']').count() === 0) {
            if (product_id === '') {
                toastr.error("Please Choose The Product ");
            } else {
                var row = myTable.row.add([
                    `<span id="spanProductId" data-product_id="${product_id}">${product}</span>`,
                    `<span class="price" id="price${product_id}">${price}</span>`,
                    `<div class="countInput">
                        <button type="button" class=" sub" id="subBtn">-</button>
                        <input type="number"  disabled id="qtyVal${product_id}" class="qtyVal" value="1" min="1"/>
                        <button type="button" class=" add plusBtn" id="plusBtn">+</button>
                    </div>`,
                    `<span class="productTotalPrice" id="productTotalPrice${product_id}">${price}</span>`,
                    `
                              <span class="controlIcons">
                                <span class="icon Delete" data-bs-toggle="tooltip" title="Delete"> <i
                                    class="far fa-trash-alt"></i> </span>
                              </span>
                `
                ]).draw().node();
                $(row).addClass('productrow' + product_id);
            }
        } else {
            var oldQty = parseInt($('#qtyVal' + product_id).val() || 0)
            $('#qtyVal' + product_id).val(oldQty + 1)
            var qty = $('#qtyVal' + product_id).val();
            $('#productTotalPrice' + product_id).text(price * qty)
        }
    });
    myNewTable.on('click', 'tbody tr .Delete', function () {
        myTable.row($(this).parent().parent()).remove().draw();
    });
    myNewTable.on('click', 'tbody tr .plusBtn', function () {
        var value = $(this).closest('tr').find(".qtyVal").val();
        value++;
        $(this).closest('tr').find(".qtyVal").val(value);
        var price = +$(this).closest('tr').find(".price").text();
        $(this).closest('tr').find(".productTotalPrice").text(value * price);
    });
    myNewTable.on('click', 'tbody tr #subBtn', function () {
        var value = $(this).closest('tr').find(".qtyVal").val();
        if (value != 1) {
            value--;
            $(this).closest('tr').find(".qtyVal").val(value);
            var price = +$(this).closest('tr').find(".price").text();
            $(this).closest('tr').find(".productTotalPrice").text(value * price);
        }
    });
    var totalBeforeDiscount = 0;
    $(document).on('click', '#secondNext', function () {
        if (table.rows().count() != 0) {
            $('.firstInfo').append(`
                        <h6 class="billTitle"> visitors</h6>
                        <div class="items">
                            <div class="itemsHead row visitorItemRows">
                                <span class="col">type</span>
                                <span class="col"> Quantity </span>
                                <span class="col"> price </span>
                            </div>
                        </div>
            `)
            $('.visitorType').each(function () {
                var div = $(this),
                    count = div.find('span.count').text(),
                    price = div.find('input[name*=price]').val() * parseInt(count),
                    visitor = div.find('span.visitor').text();

                if (count != 0) {
                    $('.visitorItemRows').after(
                        `<div class="item row insertRows">
                        <span class="col"> ${visitor}</span>
                        <span class="col"> x${count}</span>
                        <span class="col"> ${price} EGP</span>
                        </div>`)
                    totalBeforeDiscount += price;
                }
            });
        } else {
            toastr.error("at least one model should be exists");
            $("button[title='products']").removeClass('js-active');
            $("#productsTab").removeClass('js-active');
            $("button[title='visitors']").addClass('js-active');
            $("#visitorsTab").addClass('js-active');
        }
    });
    $(document).on('click', '#thirdPrev', function () {
        $('.insertRows').remove();
        $('.firstInfo').html('');
    });
    var Percent = $('#offerType1'),
        Amount = $('#offerType2');
    $(document).on('click', '#thirdNext', function () {
        if (myTable.rows().count() != 0) {
            $('.secondInfo').append(`
                <h6 class="billTitle"> products</h6>
                <div class="items">
                   <div class="itemsHead row productsInfoRows">
                     <span class="col">type</span>
                     <span class="col"> Quantity </span>
                     <span class="col"> price </span>
                </div>
            `)
            $('#myNewTable tr').each(function () {
                var div = $(this),
                    name = div.find('td:first').text(),
                    product_id = div.find('#spanProductId').attr('data-product_id'),
                    total = parseInt(div.find('span.productTotalPrice').text()),
                    qty = div.find('input.qtyVal').val();
                if (qty != undefined) {
                    $('.productsInfoRows').after(
                        `<div class="item row productInsertRows">
                            <input type="hidden" name="product_id[]" value="${product_id}">
                            <input type="hidden" name="proQtyInput[]" value="${qty}">
                            <input type="hidden" name="proTotalInput[]" value="${total}">
                            <span class="col" id="proName">${name} </span>
                        <span class="col" id="proQty"> x${qty} </span>
                        <span class="col" id="proTotal"> ${total} EGP </span>
                    </div>`)
                    totalBeforeDiscount += total;
                }
            });
        }
        if (window.location.href.indexOf("ticket") > -1) {
            totalBeforeDiscount += {{$setting->family_tax}} * totalBeforeDiscount / 100;
            total.text(totalBeforeDiscount);
        } else if (window.location.href.indexOf("reservations") > -1) {
            totalBeforeDiscount += {{$setting->rev_tax}} * totalBeforeDiscount / 100;
            total.text(totalBeforeDiscount);
        }
        $('#totalInfoPrice').text(totalBeforeDiscount + " EGP")
        $('#totalInfoDiscount').text(0 + " EGP")
        $('#totalInfoRevenue').text(totalBeforeDiscount + " EGP")
        $('#revenue').text(totalBeforeDiscount)
        $('#calcDiscount').val('')
        if (window.location.href.indexOf("ticket") > -1) {
            $('.thirdInfo').append(`
                        <h6 class="billTitle"> Totals </h6>
                        <ul>
                            <li><label> total before tax : </label> <strong id="beforeTax">${(totalBeforeDiscount - {{$setting->family_tax}} * totalBeforeDiscount / 100).toFixed(2)} EGP</strong></li>
                            <li><label> Tax : </label> <strong id="family_tax">` + {{$setting->family_tax}} + `%</strong></li>
                            <li><label> total after tax : </label> <strong id="totalInfoPrice">${totalBeforeDiscount} EGP</strong></li>
                            <li><label> Discount : </label> <strong id="totalInfoDiscount">0 EGP</strong></li>
                            <li><label> Revenue : </label> <strong id="totalInfoRevenue">${totalBeforeDiscount} EGP</strong></li>
            `)
        } else if (window.location.href.indexOf("reservations") > -1) {
            $('.thirdInfo').append(`
                        <h6 class="billTitle"> Totals </h6>
                        <ul>
                            <li><label> total before tax : </label> <strong id="beforeTax">${(totalBeforeDiscount - {{$setting->rev_tax}} * totalBeforeDiscount / 100).toFixed(2)} EGP</strong></li>
                            <li><label> Tax : </label> <strong id="rev_tax">` + {{$setting->rev_tax}} + `%</strong></li>
                            <li><label> total after tax : </label> <strong id="totalInfoPrice">${totalBeforeDiscount} EGP</strong></li>
                            <li><label> Discount : </label> <strong id="totalInfoDiscount">0 EGP</strong></li>
                            <li><label> Revenue : </label> <strong id="totalInfoRevenue">${totalBeforeDiscount} EGP</strong></li>
            `)
        }
    });
    var totalPrice = parseInt(total.text());
    Percent.prop("checked", true);
    $('#revenue').text(totalBeforeDiscount)
    $("#calcDiscount").on("keyup change", function (e) {
        if (Percent.is(':checked'))
            checkPercent()
        else if (Amount.is(':checked'))
            checkAmount()
    });
    Percent.change(function () {
        checkPercent()
    });

    function checkPercent() {
        if ($('#calcDiscount').val() > 100 || $('#calcDiscount').val() < 0) {
            toastr.error("enter valid discount percent !");
            $('#calcDiscount').val('');
            $('#totalInfoDiscount').text(0 + " EGP")
            $('#discount').text('0');
            $('#revenue').text(total.text());
        } else {
            $('#discount').text($('#calcDiscount').val() + "%")
            var after = (parseInt(total.text()) - $('#calcDiscount').val() * parseInt(total.text()) / 100).toFixed(2);
            $('#revenue').text(after)
            $('#totalInfoPrice').text(total.text() + " EGP")
            $('#totalInfoRevenue').text(after + " EGP")
            $('#totalInfoDiscount').text($('#calcDiscount').val() + "%")
            calculateChange()
        }
    }

    function checkAmount() {
        if ($('#calcDiscount').val() > parseInt(total.text() || $('#calcDiscount').val() < 0)) {
            toastr.error("discount amount more than total !");
            $('#totalInfoDiscount').text(0 + " EGP")
            $('#calcDiscount').val('');
            $('#discount').text('0');
            $('#revenue').text(total.text());
        } else {
            $('#discount').text($('#calcDiscount').val() || 0)
            var after = (parseInt(total.text()) - $('#calcDiscount').val());
            $('#revenue').text(after)
            $('#totalInfoPrice').text(total.text() + " EGP")
            $('#totalInfoRevenue').text(after + " EGP")
            $('#totalInfoDiscount').text($('#calcDiscount').val() + " EGP")
            calculateChange()
        }
    }

    Amount.change(function () {
        checkAmount()
    });


    function calculateChange() {
        if (amountCash.val() > parseFloat($('#revenue').text())) {
            var change = (parseFloat(amountCash.val()).toFixed(2) - parseFloat($('#revenue').text()).toFixed(2)).toFixed(2);
            $("#change").text(change || 0);
        } else
            $("#change").text('0');

        $('#paid').text(amountCash.val() || 0);
    }

    $(document).on('click', '#lastPrev', function () {
        $('.productInsertRows').remove();
        $('.secondInfo').html('');
        $('.thirdInfo').html('')
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    });


    function DeleteRows() {
        $('.firstTable').DataTable().clear().draw();
        $('.visitorType').each(function () {
            $(this).find('span.count').text('0');
            $(this).find('input.inputCount').val(0);
        });
    }

    $('.inputCount').focusout(function () {
        var type = $(this).parent().parent().find('.visitor').text();
        var number = Math.abs(parseInt($(this).parent().parent().find('.count').text()) - $(this).val());
        // add only if input number more than count --> to prevent multiple insertion
        if ($(this).val() > parseInt($(this).parent().parent().find('.count').text())) {
            var visitor_type_id = $(this).parent().parent().find('#visitor_type_id').val();
            for (var i = 0; i < number; i++) {
                appendRow(visitor_type_id, type, $(this).parent().parent().find('input').val())
            }
        } else if ($(this).val() < parseInt($(this).parent().parent().find('.count').text())) {
            // means the user enter a number less than count so he want to delete not insert
            for (var j = 0; j < number; j++) {
                table.row('tr.' + type.toLowerCase()).remove().draw();
            }
            $(this).parent().parent().find('.count').text($(this).val())
        }
    });
</script>
