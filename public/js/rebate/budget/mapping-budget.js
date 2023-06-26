"use strict";
var Form = function () {
  var initiateComponent = function () {
    $("#nopengajuan").select2({
      placeholder: "Nomor Pengajuan",
      allowClear: true,
      ajax: {
        url: "/api/rebate/get/list-manual",
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            q: params.term, // search term
            page: params.page
          };
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (item) {
              return {
                text: item.nomor,
                id: item.id
              }
            })
          };
        },
        cache: true
      }
    });
    $('#nopengajuan').on("select2:select", function (e) {
      KTApp.block('#kt_blockui_card');
      var value = $(e.currentTarget).find("option:selected").val();
      const urlHeader = '/api/rebate/get/header/' + value;
      const urlDetail = '/api/rebate/get/detail/' + value;
      var jenis = '';
      $.ajax({
        url: urlHeader,
        type: 'GET',
        success: function (hasil) {
          var x = numeral(hasil.total).format('0,0')
          jenis = hasil.jenispotongan
          document.getElementById("nokwitansi").value = hasil.nomorkwitansi;
          document.getElementById("custid").value = hasil.custid + ' -' + hasil.name;
          document.getElementById("jenispotongan").value = hasil.jenispotongan;
          document.getElementById("catatan").value = hasil.catatan;
          document.getElementById("total").value = x;
          $("#myTable").find("tbody tr").remove();
          if (jenis === 'TPR') {
            $.ajax({
              url: urlDetail,
              type: 'GET',
              success: function (result) {
                for (var i = 0; i <= result.length - 1; i++) {
                  var strBaris = '';
                  strBaris += "<tr id='line-" + i + "'>";
                  strBaris += "<td><input id='sku-" + i + "' value='" + result[i].invtid + " - " + result[i].descr + "' type='text' class='form-control text-center' disabled/></td>";
                  strBaris += "<td><input id='qty-" + i + "' value='" + numeral(result[i].amount).format('0,0') + "' type='text' class='form-control text-center' disabled/></td>";
                  strBaris += "<td>";
                  strBaris += "<div class='input-group'>";
                  strBaris += "<input type='text' class='form-control' placeholder='ICG' id='txt-icg-" + i + "' aria-describedby='basic-addon2' readonly/>";
                  strBaris += "<div class='input-group-append'><button class='btn btn-secondary' type='button' id='btn-modal-" + i + "' onclick='showModal(this.id)'><i class='la la-folder-open icon-lg'></i></button></div>";
                  strBaris == "</div>";
                  strBaris += "</td>";
                  strBaris += "</tr>";
                  $("#line:last").append(strBaris);
                }
              }
            });
          }
          KTApp.unblock('#kt_blockui_card');
        },
        error: function (error) {
          console.log('error');
        }
      });
    });
  }

  var validasi = function () {
    FormValidation.formValidation(
      document.getElementById('myForm'),
      {
        fields: {
          custid: {
            validators: {
              notEmpty: {
                message: 'Customer tidak boleh dikosongkan'
              }
            }
          },
          nokwitansi: {
            validators: {
              notEmpty: {
                message: 'No. Kwitansi tidak boleh dikosongkan'
              }
            }
          },
          total: {
            validators: {
              notEmpty: {
                message: 'Total potongan tidak boleh 0.'
              }
            }
          }
        },

        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap: new FormValidation.plugins.Bootstrap(),
          submitButton: new FormValidation.plugins.SubmitButton(),
          defaultSubmit: new FormValidation.plugins.DefaultSubmit()
        }
      }
    );
  }
  return {
    init: function () {
      initiateComponent();
      validasi();
    }
  };
}();

function btnICG(e) {
  var id = e.replace('btn-icg-', '');

  $.ajax({
    url: '/api/rebate/get/icg-detail/' + id,
    type: 'GET',
    success: function (result) {
      var txt = document.getElementById("btnTemp").value;
      document.getElementById("txt-icg-" + txt).value = result.IMCode + ' - ' + result.Descr;
      $('#frmICG').modal('hide');
    }
  });

}

function showModal(e) {
  var id = e.replace('btn-modal-', '');
  $('#frmICG').modal('show');
  document.getElementById("btnTemp").value = id;
}

jQuery(document).ready(function () {
  Form.init();
  btnICG();
  showModal();
});
