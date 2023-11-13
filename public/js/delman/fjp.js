"use strict";
var Form = function () {
    var datagrid = function () {
        var delman = document.getElementById("delman").value;
        // console.log("Delman:" + delman);
        var datatable = $('#kt_datatable').KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/api/v2/logistic/delman/routes/' + delman,
                        method: 'GET'
                    }
                },
                pageSize: 50,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
            },
            layout: {
                scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                footer: false // display/hide footer
            },

            sortable: false,
            pagination: false,
            search: {
                input: $('#kt_datatable_search_query'),
                key: 'generalSearch'
            },

            columns: [
                {
                    field: 'card_name',
                    title: 'Nama Toko',
                }, {
                    field: 'address',
                    title: 'Alamat',
                }, {
                    field: 'Status',
                    title: 'Status',
                    template: function (data) {

                        if (data.Status != 'New') {

                            return '<span class="label label-lg font-weight-bold label-light-success label-inline">' + data.Status + '</span>';
                        } else {
                            return '<a href="/logistic/delman/routes/' + data.id + '"><span class="label label-lg font-weight-bold  label-inline">Visit</span></a>';
                        }
                    }
                }],
        });
    };

		var checkIn = function() {
			var btn = document.getElementById('btnCheckIn');
			var delman = document.getElementById("delman").value;

			btn.addEventListener("click", function() {
					$.ajax({
							url : '/api/v2/logistic/delman/checkin/' + delman,
							type: 'GET',
							success: function(data){
								// console.log(data)
								if(data =="sukses"){
									$.notify("Checkin Sukses");
								}else{
									$.notify("Anda Sudah Checkin", "danger");
								}
								}
					});
			});
		};

		var checkOut = function() {
			var btn = document.getElementById('btnCheckOut');
			var delman = document.getElementById("delman").value;

			btn.addEventListener("click", function() {
					$.ajax({
							url : '/api/v2/logistic/delman/checkout/' + delman,
							type: 'GET',
							success: function(data){
								console.log(data);
								if(data =="sukses"){
									$.notify("Checkout Sukses");
								// }else if(data == "warning"){
								// 	$.notify("Anda Sudah Checkout");
								}else{
									$.notify("Anda belum Checkin");
								}
							}
					});
			});
		}

    return {
        init: function () {
            datagrid();
						checkIn();
						checkOut();
        }
    };
}();

jQuery(document).ready(function () {
    Form.init();
});
