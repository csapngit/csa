var Partner = function () {
  var datagrid = function () {

    var btn = KTUtil.getById("btn_area");

    KTUtil.addEvent(btn, "click", function () {
      var combo = document.getElementById('area').value
      KTApp.block('#kt_blockui_card');
      $.ajax({
        url: '/api/get/listVoucher/' + combo,
        type: 'GET',
        success: function (result) {

          $("#myTable").find("tbody tr").remove();

          for (var i = 0; i <= result.length - 1; i++) {
            var strBaris = '';
            strBaris += "<tr id='line-" + i + "'>";
            strBaris += "<td><input type='checkbox' name='customer_id["+ result[i].customer_id +"]' class='check_customer_id'/></td>";
            strBaris += "<td>" + result[i].customer_id + "</td>";
            strBaris += "<td>" + result[i].name + "</td>";
            strBaris += "<td>" + result[i].target + "</td>";
            strBaris += "<td>" + result[i].offtakes + "</td>";
            strBaris += "</tr>";
            $("#line:last").append(strBaris);
          }

          KTApp.unblock('#kt_blockui_card');
        },
        error: function (error) {
          console.log('error');
        }
      });
    });
  };

  return {
    // public functions
    init: function () {
      datagrid();
    }
  };
}();

jQuery(document).ready(function () {
  Partner.init();
});
