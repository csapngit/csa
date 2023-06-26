"use strict";
var Form = function () {
  var initiateComponent = function () {
    var myTable = document.getElementById('myTable');
    var jmlbaris = myTable.rows.length - 1;
    var editmode = document.getElementById('editmode').value;

    for (var i = 1; i <= jmlbaris; i++) {
      var nmbaris = myTable.rows[i];
      nmbaris = nmbaris.id.replace('line-', '');

      var btn = KTUtil.getById("qty-" + i);
      KTUtil.addEvent(btn, "blur", function () {
        hitungTotal();
      });
      $("#invtid-" + nmbaris).select2({
        placeholder: "Sku Code or Description",
        allowClear: true,
        ajax: {
          url: "/api/get/list/inventory",
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
                  text: item.descr,
                  id: item.invtid
                }
              })
            };
          },
          cache: true
        }
      });
    }

    $("#custid").select2({
      placeholder: "Custid or Name",
      allowClear: true,
      ajax: {
        url: "/api/get/list/customer",
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
                text: item.name,
                id: item.custid
              }
            })
          };
        },
        cache: true
      }
    });

    // $("#custid").select2('data', { id: customer, text: "Ranch Market St. Moritz" });
    if (editmode == 1) {
      var customer = document.getElementById('customer').value;
      var customername = document.getElementById('customername').value;
      var text = customer + ' - ' + customername
      var newOption = new Option(text, customer, true, true);
      $('#custid').append(newOption).trigger('change');

      var header = document.getElementById('header').value;
      var url = '/api/rebate/get/potongan-manual/detail/' + header;
      $.ajax({
        url: url,
        type: 'GET',
        success: function (result) {
          for (var detail in result) {
            var inventory = result[detail].invtid;
            var inventoryname = result[detail].descr;
            var text = inventory + ' - ' + inventoryname
            var newOption = new Option(text, inventory, true, true);
            var j = parseInt(detail) + 1;
            $("#invtid-" + j).append(newOption).trigger('change');
          }
        },
        error: function (error) {
          toastr.error("Gagal mengambil detail potongan manual");
        }
      });
    }
  }

  var formatCurency = function () {
    var btn = KTUtil.getById("totaltemp");
    KTUtil.addEvent(btn, "blur", function () {
      var total = btn.value;
      console.log('Total:' + total)

      document.getElementById("totaltemp").value = numeral(total).format('0,0.00');
      document.getElementById("total").value = total;
    });
  }

  var hitungTotal = function () {
    var myTable = document.getElementById('myTable');
    var jmlbaris = myTable.rows.length - 1;
    var total = 0;
    for (var i = 1; i <= jmlbaris; i++) {
      var nmbaris = myTable.rows[i];

      nmbaris = nmbaris.id.replace('line-', '');

      total += numeral(document.getElementById("qty-" + nmbaris).value).value();
    }
    document.getElementById("total").value = total;
    document.getElementById("totaltemp").value = numeral(total).format('0,0.00');
  }

  var addRow = function () {
    var myTable = document.getElementById('myTable');
    var jmlbaris = myTable.rows.length - 1;
    for (var i = 1; i <= jmlbaris; i++) {
      var btn = KTUtil.getById("btnAdd-" + i);
    }

    // var userID = document.getElementById("userID").value;

    KTUtil.addEvent(btn, "click", function () {
      var strBaris = '';

      var baristerakhir = $("#line").find("tr:last").attr('id');

      baristerakhir = baristerakhir.replace('line-', '');
      baristerakhir++;

      strBaris += "<tr id='line-" + baristerakhir + "'>";
      strBaris += "<td><select class='form-control select2' name='arrSKU[]' id='invtid-" + baristerakhir + "'><option label='Label'></option></select></td>";
      strBaris += "<td><input id='qty-" + baristerakhir + "' name='arrAmount[]' class='form-control' placeholder = 'Jml. Potongan' type='text'/></td>";
      strBaris += "<td class='col-sm-2 text-center'>";
      strBaris += "<button type='button' class='btn btn-sm font-weight-bolder btn-light-primary' id='btnAdd-" + baristerakhir + "'><i class='la la-plus'></i>Add</button>";
      strBaris += "<button type='button' class='btn btn-sm font-weight-bolder btn-light-danger' id='btnDelete'><i class='la la-trash-o'></i>Delete</button>";
      strBaris += "</td>";
      strBaris += "</tr>";
      $("#line:last").append(strBaris);

      $("#invtid-" + baristerakhir).select2({
        placeholder: "Sku Code or Description",
        allowClear: true,
        ajax: {
          url: "/api/get/list/inventory",
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
                  text: item.descr,
                  id: item.invtid
                }
              })
            };
          },
          cache: true
        }
      });

      var txt = KTUtil.getById("qty-" + baristerakhir);
      KTUtil.addEvent(txt, "blur", function () {
        hitungTotal();
      });
    });
  }

  var dropPotongan = function () {
    var cmb = KTUtil.getById("jenispotongan");
    setStatus(cmb.value);
    KTUtil.addEvent(cmb, "change", function () {
      setStatus(cmb.value);
    });

    function setStatus(jenis) {
      var myTable = document.getElementById('myTable');
      var jmlbaris = myTable.rows.length - 1;
      var status = true;

      if (jenis === 'TPR') {
        status = false;
      }
      document.getElementById("totaltemp").disabled = !status;
      for (var i = 1; i <= jmlbaris; i++) {
        document.getElementById("btnAdd-" + i).disabled = status;
        document.getElementById("qty-" + i).disabled = status;
        document.getElementById("invtid-" + i).disabled = status;
      }
    }
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
          totaltemp: {
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
      addRow();
      hitungTotal();
      dropPotongan();
      formatCurency();
      validasi();
    }
  };
}();

jQuery(document).ready(function () {
  Form.init();
});
