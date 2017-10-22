var ajaxurl = location.protocol + "//" + location.hostname + (location.port && ":" + location.port) + "/" + "zippcash/agent/ajax.php";
var baseUrl = location.protocol + "//" + location.hostname + (location.port && ":" + location.port) + "/" + "zippcash/agent/";
$(document).ready(function () {
  if($('#login_id').length){
    console.log("Focus");
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
    var login_id = $('#login_id').val();
    var password = $('#password').val();
    var data = {
      controller: 'user',
      action: 'authenticate_user',
      agent_phone: login_id,
      password: password,
      submit: 'submit'
    };
    $.post(ajaxurl, data, function (response) {
      console.log(response);
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

  $('#add_credit').click(function (event) {
    event.preventDefault();
    $('#add_credit').attr('disabled', true);
    $('#add_credit').hide();
    $('#add_credit_success').hide();
    $('#add_credit_error').hide();
    $('#processing').show();
    var login_id = $('#login_id').val();
    var credit_amount = $('#credit_amount').val();
    var data = {
      controller: 'user',
      action: 'addCredit',
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
        $('#add_credit').attr('disabled', true);
        $('#add_credit').show();
        $('#add_credit_success').html(result.data).fadeIn();
        $('#add_credit_error').hide();
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
        $('#add_credit_success').hide();
        $('#add_credit').removeAttr('disabled');
        $('#add_credit').show();
        $('#processing').hide();
        $('#add_credit_error').html(result.data).fadeIn();
        $('#add_credit_error').show();
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
    var user_type = $('#user_type').val();
    if(user_type == 'store'){
      var store_name = $('#store_name').val();
    }else{
      var first_name = $('#first_name').val();
      var last_name = $('#last_name').val();
    }
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
            $('#ajax_response').append('<form method = "post" style = "text-align:center;" action = "index.php?options=add_credit"><input type = "hidden" name = "login_id" value = "'+result.login_id+'"></form>');
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
  });

  $('#login_id').blur(function(){
    $('#user_detail_processing').show();
    var login_id = $("#login_id").val();
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
        $('#ajax_response').html(result.data);
      } else {
        if($('#add_credit').length){
          $('#add_credit').attr('disabled', true);
        }
        if($('#withdraw_credit').length){
          $('#withdraw_credit').attr('disabled', true);
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

  $('#add_credit_button').click(function(event){
    window.location = baseUrl + 'index.php?options=add_credit';
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
                'aTargets': [4, 6, 7]
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

  if($('#store_table').length){
    var oTable = $('#store_table').dataTable({
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
