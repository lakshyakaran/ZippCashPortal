var ajaxurl = location.protocol + "//" + location.hostname + (location.port && ":" + location.port) + "/" + "zippcash/admin/ajax.php";
var baseUrl = location.protocol + "//" + location.hostname + (location.port && ":" + location.port) + "/" + "zippcash/admin/";
$(document).ready(function () {
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
        var email = $('#email').val();
        var password = $('#password').val();
        var data = {
            controller: 'user',
            action: 'authenticate_user',
            email: email,
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

    $('.ticket_user_details').click(function(event){
      event.preventDefault();
      $('#user_ticket_container .modal-body').html('');
      var user_id = $(this).attr('id');
      var lottery_id = $('#lottery_id').val();
      if(lottery_id == undefined){
        lottery_id = $(this).attr('lottery_id');
      }

      var data = {
          controller: 'lottery',
          action: 'getUserTicketsByLottery',
          user_id: user_id,
          lottery_id: lottery_id,
          submit: 'submit'
      };
      $.post(ajaxurl, data, function (response) {
          var result = JSON.parse(response);
          if (result.success == true) {
            $('#user_ticket_container .modal-body').html(result.data);
          } else {
            $('#user_ticket_container .modal-body').html(result.data);
          }
          return true;
      });
    });

    $('#preview_result').click(function(event){
      event.preventDefault();
      $('#preview_result_response').html('');
      var lottery_id = $('#lottery_id').val();
      var lottery_number_1 = $('#lottery_number_1').val();
      var lottery_number_2 = $('#lottery_number_2').val();
      var lottery_number_3 = $('#lottery_number_3').val();

      var data = {
          controller: 'lottery',
          action: 'previewLotteryResult',
          lottery_number_1: lottery_number_1,
          lottery_number_2: lottery_number_2,
          lottery_number_3: lottery_number_3,
          lottery_id: lottery_id,
          submit: 'submit'
      };
      $.post(ajaxurl, data, function (response) {
        console.log(response);
          var result = JSON.parse(response);
          if (result.success == true) {
            $('#preview_error_response').html('');
            $('#preview_result_response').html(result.data);
            $('#generate_result_button_container').show();
          } else {
            $('#preview_error_response').html(result.data);
            $('#generate_result_button_container').hide();
          }
          return true;
      });
    });

    $('#generate_result_button').click(function(event){
      event.preventDefault();
      var lottery_id = $('#lottery_id').val();
      var lottery_number_1 = $('#lottery_number_1').val();
      var lottery_number_2 = $('#lottery_number_2').val();
      var lottery_number_3 = $('#lottery_number_3').val();

      var data = {
          controller: 'lottery',
          action: 'generateLotteryResult',
          lottery_number_1: lottery_number_1,
          lottery_number_2: lottery_number_2,
          lottery_number_3: lottery_number_3,
          lottery_id: lottery_id,
          submit: 'submit'
      };
      $.post(ajaxurl, data, function (response) {
        console.log(response);
          var result = JSON.parse(response);
          if (result.success == true) {
            $('#preview_error_response').html('');
            window.location = baseUrl + 'index.php?options=lottery/'+lottery_id;
          } else {
            $('#preview_error_response').html(result.data);
            $('#generate_result_button_container').hide();
          }
          return true;
      });
    });

    $('#make_payment_button').click(function(event){
      window.location = baseUrl + 'index.php?options=make_payment';
      return true;
    });

    $('.make_user_payment').click(function(event){
      event.preventDefault();
      var user_id = $(this).attr('id');
      var total_amount = $(this).attr('total_amount');
      var name = $(this).attr('user_name');

      $('#make_payment_form #form_user_id').val(user_id);
      $('#make_payment_form #form_name').val(name);
      $('#make_payment_form #form_amount_to_pay').val(total_amount);
      return true;
    });

    $('#pay_now').click(function(event){
      event.preventDefault();
      var user_id = $('#make_payment_form #form_user_id').val();
      var name = $('#make_payment_form #form_name').val();
      var amount_to_pay = $('#make_payment_form #form_amount_to_pay').val();
      var cheque_id = $('#make_payment_form #form_cheque_id').val();

      var data = {
          controller: 'lottery',
          action: 'makePayment',
          user_id: user_id,
          amount_to_pay: amount_to_pay,
          cheque_id: cheque_id,
          submit: 'submit'
      };
      $.post(ajaxurl, data, function (response) {
        console.log(response);
          var result = JSON.parse(response);
          if (result.success == true) {
            $('#payment_error_response').html('');
            new TabbedNotification({
              title: 'Payment Successful',
              text: 'The payment of $'+amount_to_pay+' for '+name+' with UserID: '+user_id+' has been successful',
              type: 'success',
              sound: true
            });
          } else {
            $('#payment_error_response').html(result.data);
          }
          return true;
      });
    });

    var asInitVals = new Array();

    if($('.input.tableflat').length){
      $('input.tableflat').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
      });
    }

    if($('#lottery_table').length){
      var oTable = $('#lottery_table').dataTable({
          "oLanguage": {
              "sSearch": "Search all columns:"
          },
          "aoColumnDefs": [
              {
                  'bSortable': false,
                  'aTargets': [4, 5]
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

    if($('#lottery_user_table').length){
      var oTable = $('#lottery_user_table').dataTable({
          "oLanguage": {
              "sSearch": "Search all columns:"
          },
          "aoColumnDefs": [
              {
                  'bSortable': false,
                  'aTargets': [5]
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
