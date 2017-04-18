var ajaxurl = location.protocol + "//" + location.hostname + (location.port && ":" + location.port) + "/" + "zippcash/store/ajax.php";
var baseUrl = location.protocol + "//" + location.hostname + (location.port && ":" + location.port) + "/" + "zippcash/store/";
$(document).ready(function () {
  var input_count = 1;
  $('#add_input').click(function(){
    input_count++;
    $('#additional_input').append('<br><br><br><div class="col-md-5 col-sm-5 col-xs-5"><input name = "lottery_number[]" type="text" class="form-control" placeholder="Number"></div><div class="col-md-5 col-sm-5 col-xs-5"><input name = "lottery_number_amount[]" type="text" class="form-control" placeholder="Amount"></div>');
  });

  $('#buy_tickets').click(function(){
    $('#success').html('');
    $('#success').hide();
    $('#error').hide();
    $('#processing').show();
    $('#buy_tickets').hide();
    var ticket = [];
    var ticket_numbers = document.getElementsByName('lottery_number[]');
    var ticket_numbers_amount = document.getElementsByName('lottery_number_amount[]');
    var lottery_id = $('#lottery_id').val();
    var login_id = $('#login_id').val();
    if(login_id == null || login_id == ""){
      $('#error').html('<p>Please specify the user.</p>').fadeIn();
      $('#processing').hide();
      $('#buy_tickets').show();
      return false;
    }
    if(lottery_id == null || lottery_id == "" || isNaN(lottery_id)){
      $('#error').html('<p>An error occured. Please try again later.</p>').fadeIn();
      $('#processing').hide();
      $('#buy_tickets').show();
      return false;
    }
    if(ticket_numbers.length != ticket_numbers_amount.length){
      $('#error').html('<p>An error occured. Please try again later.</p>').fadeIn();
      $('#processing').hide();
      $('#buy_tickets').show();
      return false;
    }

    for(var i = 0; i < ticket_numbers_amount.length; i++){
      if(ticket_numbers[i].value != null && ticket_numbers[i].value != "" && !isNaN(ticket_numbers[i].value) && ticket_numbers_amount[i].value != null && ticket_numbers_amount[i].value != "" && !isNaN(ticket_numbers_amount[i].value)){
        var ticketDetails = {
          number: ticket_numbers[i].value,
          amount: ticket_numbers_amount[i].value
        }
        ticket.push(ticketDetails);
      }
    }
    if(ticket.length > 0){
      var data = {
        controller: 'lottery',
        action: 'addTicketDetails',
        login_id: login_id,
        lottery_id: lottery_id,
        tickets: ticket
      }
      $.post(ajaxurl, data, function (response) {
        console.log(response);
        $('#processing').hide();
        var result = JSON.parse(response);
        if (result.success == true) {
          $('#error').html('').hide();
          $('#success').html('<p>The ticket has been purchased successfully. <a href = "index.php?options=ticket_details&ticket_id='+result.data.ticket_id+'">Click Here</a> to view ticket details.</p>').fadeIn();
          $('#processing').hide();
          $('#buy_tickets').show();
          $('#additional_input').html('');
          for(var i = 0; i < ticket_numbers_amount.length; i++){
            ticket_numbers[i].value = '';
            ticket_numbers_amount[i].value = '';
          }
          $('#login_id').val('');
          $('input#login_id').focus();
        } else {
          $('#error').html(result.data).fadeIn();
          $('#error').show();
          $('#processing').hide();
          $('#buy_tickets').show();
        }
      });
    }else {
      $('#error').html('<p>Please enter the number and amount you want to play for.</p>').fadeIn();
      $('#processing').hide();
      $('#buy_tickets').show();
      return false;
    }
  });
  if($('#login_id').length){
    $('input#login_id').focus();
    // $('input#credit_amount').focus();
  }
  var cnt = 10;

  TabbedNotification = function (options) {
    var message = "<div id='ntf" + cnt + "' class='text alert-" + options.type + "' style='display:none'><h2><i class='fa fa-bell'></i> " + options.title + "</h2><div class='close'><a href='javascript:;' class='notification_close'><i class='fa fa-close'></i></a></div><p>" + options.text + "</p></div>";

    if (document.getElementById('custom_notifications') == null) {
      alert('doesnt exists');
    } else {
      $('#custom_notifications ul.notifications').append("<li><a id='ntlink" + cnt + "' class='alert-" + options.type + "' href='#ntf" + cnt + "'><i class='fa fa-bell animated shake'></i></a></li>");
      $('#custom_notifications #notif-group').append(message);
      cnt++;
      CustomTabs(options);
    }
  }

  CustomTabs = function (options) {
    $('.tabbed_notifications > div').hide();
    $('.tabbed_notifications > div:first-of-type').show();
    $('#custom_notifications').removeClass('dsp_none');
    $('.notifications a').click(function (e) {
      e.preventDefault();
      var $this = $(this),
      tabbed_notifications = '#' + $this.parents('.notifications').data('tabbed_notifications'),
      others = $this.closest('li').siblings().children('a'),
      target = $this.attr('href');
      others.removeClass('active');
      $this.addClass('active');
      $(tabbed_notifications).children('div').hide();
      $(target).show();
    });
  }

  CustomTabs();

  var tabid = idname = '';
  $(document).on('click', '.notification_close', function (e) {
    idname = $(this).parent().parent().attr("id");
    tabid = idname.substr(-2);
    $('#ntf' + tabid).remove();
    $('#ntlink' + tabid).parent().remove();
    $('.notifications a').first().addClass('active');
    $('#notif-group div').first().css('display','block');
  });

  $('#sign_in').click(function (event) {
    event.preventDefault();
    $('#processing').show();
    $('#sign_in').hide();
    var login_id = $('#login_id').val();
    var password = $('#password').val();
    var data = {
      controller: 'user',
      action: 'authenticate_user',
      login_id: login_id,
      password: password,
      submit: 'submit'
    };
    $.post(ajaxurl, data, function (response) {
      $('#processing').hide();
      $('#sign_in').show();
      var result = JSON.parse(response);
      if (result.success == true) {
        window.location = baseUrl + 'index.php?options=dashboard';
      } else {
        $('#error').html(result.data).fadeIn();
        $('#error').show();
      }
    });

    return false;
  });

  $('#recharge_wallet').click(function (event) {
    event.preventDefault();
    $('#recharge_wallet').attr('disabled', true);
    $('#recharge_wallet').hide();
    $('#recharge_wallet_success').hide();
    $('#recharge_wallet_error').hide();
    $('#processing').show();
    var login_id = $('#login_id').val();
    var credit_amount = $('#credit_amount').val();
    var data = {
      controller: 'user',
      action: 'rechargeWallet',
      login_id: login_id,
      credit_amount: credit_amount
    };
    console.log(data);
    $.post(ajaxurl, data, function (response) {
      console.log(response);
      var result = JSON.parse(response);
      if (result.success == true) {
        $('#login_id').val('');
        $('#credit_amount').val('');
        $('#recharge_wallet').attr('disabled', true);
        $('#recharge_wallet').show();
        $('#recharge_wallet_success').html(result.data).fadeIn();
        $('#recharge_wallet_error').hide();
        $('#processing').hide();

        $('#user_detail_processing').show();
        var newData = {
          controller: 'user',
          action: 'getUserDetailsByLoginId',
          login_id: login_id
        }
        $.post(ajaxurl, newData, function (detailResponse) {
          $('#user_detail_processing').hide();
          var detailResult = JSON.parse(detailResponse);
          console.log(detailResult);
          if (detailResult.success == true) {
            $('#error').html('');
            $('#error').hide();
            if($('#add_credit').length){
              $('#add_credit').removeAttr('disabled');
            }
            if($('#withdraw_credit').length){
              $('#withdraw_credit').removeAttr('disabled');
            }
            if($('#recharge_wallet').length){
              $('#recharge_wallet').removeAttr('disabled');
            }
            $('#ajax_response').html(detailResult.data);
          } else {
            if($('#add_credit').length){
              $('#add_credit').attr('disabled', true);
            }
            if($('#withdraw_credit').length){
              $('#withdraw_credit').attr('disabled', true);
            }
            if($('#recharge_wallet').length){
              $('#recharge_wallet').attr('disabled', true);
            }
            $('#ajax_response').html('');
            $('#error').html(detailResult.data).fadeIn();
            $('#error').show();
          }
        });
      } else {
        $('#recharge_wallet_success').hide();
        $('#recharge_wallet').removeAttr('disabled');
        $('#recharge_wallet').show();
        $('#processing').hide();
        $('#recharge_wallet_error').html(result.data).fadeIn();
        $('#recharge_wallet_error').show();
      }
    });

    return false;
  });

  $('#withdraw_credit').click(function (event) {
    event.preventDefault();
    $('#withdraw_credit').attr('disabled', true);
    $('#withdraw_credit').hide();
    $('#withdraw_credit_success').hide();
    $('#withdraw_credit_error').hide();
    $('#processing').show();
    var login_id = $('#login_id').val();
    var debit_amount = $('#debit_amount').val();
    var data = {
      controller: 'user',
      action: 'withdrawCredit',
      login_id: login_id,
      debit_amount: debit_amount
    };
    $.post(ajaxurl, data, function (response) {
      console.log(response);
      var result = JSON.parse(response);
      if (result.success == true) {
        $('#login_id').val('');
        $('#debit_amount').val('');
        $('#withdraw_credit').attr('disabled', true);
        $('#withdraw_credit').show();
        $('#withdraw_credit_success').html(result.data).fadeIn();
        $('#withdraw_credit_error').hide();
        $('#processing').hide();

        $('#user_detail_processing').show();
        var newData = {
          controller: 'user',
          action: 'getUserDetailsByLoginId',
          login_id: login_id
        }
        $.post(ajaxurl, newData, function (detailResponse) {
          $('#user_detail_processing').hide();
          var detailResult = JSON.parse(detailResponse);
          console.log(detailResult);
          if (detailResult.success == true) {
            $('#error').html('');
            $('#error').hide();
            if($('#add_credit').length){
              $('#add_credit').removeAttr('disabled');
            }
            if($('#withdraw_credit').length){
              $('#withdraw_credit').removeAttr('disabled');
            }
            $('#ajax_response').html(detailResult.data);
          } else {
            if($('#add_credit').length){
              $('#add_credit').attr('disabled', true);
            }
            if($('#withdraw_credit').length){
              $('#withdraw_credit').attr('disabled', true);
            }
            $('#ajax_response').html('');
            $('#error').html(detailResult.data).fadeIn();
            $('#error').show();
          }
        });
      } else {
        $('#withdraw_credit_success').hide();
        $('#withdraw_credit').removeAttr('disabled');
        $('#withdraw_credit').show();
        $('#processing').hide();
        $('#withdraw_credit_error').html(result.data).fadeIn();
        $('#withdraw_credit_error').show();
      }
    });

    return false;
  });

  $('#add_user').click(function (event) {
    event.preventDefault();
    $('#add_user').hide();
    $('#processing').show();
    $('#error').hide();
    $('#success').hide();
    var user_type = 'individual';
    var first_name = $('#first_name').val();
    var last_name = $('#last_name').val();
    var email = $('#email').val();
    var phone = $('#phone').val();
    var address = $('#address').val();
    var address_2 = $('#address_2').val();
    var city = $('#city').val();
    var state = $('#state').val();
    var country = $('#country').val();
    var postal_code = $('#postal_code').val();
    var landmark = $('#landmark').val();


    var data = {
      controller: 'user',
      action: 'addUser',
      user_type: user_type,
      email: email,
      phone: phone,
      address: address,
      address_2: address_2,
      city: city,
      state: state,
      country: country,
      postal_code: postal_code,
      landmark: landmark,
      submit: 'submit'
    };
    if(user_type == 'store'){
      data.store_name = store_name
    }else{
      data.first_name = first_name;
      data.last_name = last_name;
    }
    $.post(ajaxurl, data, function (response) {
      console.log(response);
      var result = JSON.parse(response);
      $('#processing').hide();
      if (result.success == true) {
        $('#add_user_form').hide();
        $('#success').html('The user has been registered successfully. Please note down the id: <strong>'+result.login_id+'</strong>').fadeIn();
        // $('#success').show();

        $('#user_detail_processing').show();
        var newData = {
          controller: 'user',
          action: 'getUserDetailsByLoginId',
          login_id: result.login_id
        }
        $.post(ajaxurl, newData, function (detailResponse) {
          $('#user_detail_processing').hide();
          var detailResult = JSON.parse(detailResponse);
          console.log(detailResult);
          if (detailResult.success == true) {
            $('#error').html('');
            $('#error').hide();
            $('#ajax_response').html(detailResult.data);
            $('#ajax_response').append('<form method = "post" style = "text-align:center;" action = "index.php?options=add_credit"><input type = "hidden" name = "login_id" value = "'+result.login_id+'"><input type = "submit" class="btn btn-success btn-sm" value = "Add Credit Now"></form>');
          } else {
            $('#ajax_response').html('');
            $('#error').html(detailResult.data).fadeIn();
            $('#error').show();
          }
        });
      } else {
        $('#email_error').html('');
        $('#email_error').hide();
        $('#phone_error').html('');
        $('#phone_error').hide();
        $('#error').html(result.data).fadeIn();
        $('#error').show();
        $('#add_user').show();
      }
    });

    return false;
  });

  $('#login_id').focus(function(){
    if($('#add_credit').length){
      $('#add_credit').attr('disabled', true);
    }
    if($('#withdraw_credit').length){
      $('#withdraw_credit').attr('disabled', true);
    }
    if($('#recharge_wallet').length){
      $('#recharge_wallet').attr('disabled', true);
    }
  });

  $('#login_id').blur(function(){
    $('#user_detail_processing').show();
    var login_id = $("#login_id").val();
    if(login_id.length < 5){
      return false;
    }
    var data = {
      controller: 'user',
      action: 'getUserDetailsByLoginId',
      login_id: login_id
    }

    $.post(ajaxurl, data, function (response) {
      $('#user_detail_processing').hide();
      var result = JSON.parse(response);
      if (result.success == true) {
        $('#error').html('');
        $('#error').hide();
        if($('#add_credit').length){
          $('#add_credit').removeAttr('disabled');
        }
        if($('#withdraw_credit').length){
          $('#withdraw_credit').removeAttr('disabled');
        }
        if($('#recharge_wallet').length){
          $('#recharge_wallet').removeAttr('disabled');
        }
        $('#ajax_response').html(result.data);
      } else {
        if($('#add_credit').length){
          $('#add_credit').attr('disabled', true);
        }
        if($('#withdraw_credit').length){
          $('#withdraw_credit').attr('disabled', true);
        }
        if($('#recharge_wallet').length){
          $('#recharge_wallet').attr('disabled', true);
        }
        $('#ajax_response').html('');
        $('#error').html(result.data).fadeIn();
        $('#error').show();
      }
    });

  })

  $('#email').blur(function(){
    $('#user_detail_processing').show();
    var email = $("#email").val();
    var data = {
      controller: 'user',
      action: 'isEmailRegistered',
      email: email
    }

    $.post(ajaxurl, data, function (response) {
      console.log(response);
      $('#user_detail_processing').hide();
      var result = JSON.parse(response);
      if (result.success == true) {
        $('#email_error').html('');
        $('#email_error').hide();
      } else {
        $('#error').html('');
        $('#error').hide();
        $('#email_error').html(result.data).fadeIn();
        $('#email_error').show();
      }
    });
  })

  $('#phone').blur(function(){
    $('#user_detail_processing').show();
    var phone = $("#phone").val();
    var data = {
      controller: 'user',
      action: 'isPhoneRegistered',
      phone: phone
    }

    $.post(ajaxurl, data, function (response) {
      console.log(response);
      $('#user_detail_processing').hide();
      var result = JSON.parse(response);
      if (result.success == true) {
        $('#phone_error').html('');
        $('#phone_error').hide();
      } else {
        $('#error').html('');
        $('#error').hide();
        $('#phone_error').html(result.data).fadeIn();
        $('#phone_error').show();
      }
    });
  })

  $('#recharge_wallet_button').click(function(event){
    window.location = baseUrl + 'index.php?options=recharge_wallet';
    return true;
  });

  $('#withdraw_credit_button').click(function(event){
    window.location = baseUrl + 'index.php?options=withdraw_credit';
    return true;
  });

  $('#add_new_user_button').click(function(event){
    window.location = baseUrl + 'index.php?options=add_new_user';
    return true;
  });

  $('#add_new_store_button').click(function(event){
    window.location = baseUrl + 'index.php?options=add_new_store';
    return true;
  });

  var asInitVals = new Array();

  if($('.input.tableflat').length){
    $('input.tableflat').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });
  }

  if($('#transaction_table').length){
    var oTable = $('#transaction_table').dataTable({
        "oLanguage": {
            "sSearch": "Search all columns:"
        },
        'iDisplayLength': 12,
        "sPaginationType": "full_numbers",
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": baseUrl + "template/js/datatables/tools/swf/copy_csv_xls_pdf.swf"
        }
    });
  }

  if($('#user_table').length){
    var oTable = $('#user_table').dataTable({
        "oLanguage": {
            "sSearch": "Search all columns:"
        },
        "aoColumnDefs": [
            {
                'bSortable': false,
                'aTargets': [4]
            } //disables sorting for column one
        ],
        'iDisplayLength': 12,
        "sPaginationType": "full_numbers",
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": baseUrl + "template/js/datatables/tools/swf/copy_csv_xls_pdf.swf"
        }
    });
  }


});
