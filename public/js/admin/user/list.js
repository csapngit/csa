var UserList = function() {
  var pesan = function () {
    var status = document.getElementById("status").value;
    var pesan = document.getElementById("pesan").value;
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "0",
      "extendedTimeOut": "0",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut",
      "tapToDismiss": false
    };

    if (status !== '') {
      // $.notify(pesan, status);
      switch (status) {
        case 'success':
          toastr.success(pesan);
          break
        case 'info':
          toastr.info(pesan);
          break
      }

    }
  };
    var grid = function() {
        var datatable = $('#kt_datatable').KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/api/admin/get/list/user',
                        method: 'GET'
                    }
                },
                pageSize: 10
            },

            layout: {
                scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                footer: false // display/hide footer
            },

            sortable: true,

            pagination: true,

            search: {
                input: $('#kt_datatable_search_query'),
                key: 'generalSearch'
            },

            columns: [{
                field: 'ID',
                title: '#',
                sortable: false,
                width: 20,
                type: 'number',
                selector: {
                    class: ''
                },
                textAlign: 'center',
            }, {
                field: 'name',
                title: 'Nama',
                template: function(data) {
                    output = '<div class="d-flex align-items-center">\
                        <div class="symbol symbol-40 symbol-sm flex-shrink-0">\
                        </div>\
                        <div class="ml-4">\
                        <div class="text-dark-75 font-weight-bolder font-size-lg mb-0">' + data.name + '</div>\
                        <a href="#" class="text-muted font-weight-bold text-hover-primary">' + data.role_name + '</a>\
                        </div>\
                        </div>';

                    return output;
                }
            }, {
                field: 'username',
                title: 'Username'
            }, {
                field: 'email',
                title: 'Email'
            }, {
                field: 'area_name',
                title: 'Area'
            }, {
                field: 'status',
                title: 'Status',
                template: function(data) {

                    var status = {
                        0: {'title': 'Tidak Aktif', 'class': ' label-light-danger'},
                        1: {'title': 'Aktif', 'class': ' label-light-primary'}
                    };

                    return '<span class="label label-lg font-weight-bold ' + status[data.status].class + ' label-inline">' + status[data.status].title + '</span>';
                }
            }, {
                field: 'Actions',
                title: 'Actions',
                sortable: false,
                width: 125,
                autoHide: false,
                overflow: 'visible',
                textAlign: 'center',
                template: function(raw) {
                    return '\
                <a href="/admin/user/' + raw.id + '/edit" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">\
                    <span class="svg-icon svg-icon-md">\
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                <rect x="0" y="0" width="24" height="24"/>\
                                <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero"\ transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>\
                                <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>\
                            </g>\
                        </svg>\
                    </span>\
                </a>\
                <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Delete">\
                    <span class="svg-icon svg-icon-md">\
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                <rect x="0" y="0" width="24" height="24"/>\
                                <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>\
                                <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>\
                            </g>\
                        </svg>\
                    </span>\
                </a>\
            ';
                },
            }],

        });

        $('#kt_datatable_search_siteid').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'OrganizationCode');
        });

        $('#kt_datatable_search_type').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Type');
        });

        $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
    };

    return {
        init: function() {
            grid();
            pesan();
        }
    };
}();

jQuery(document).ready(function() {
    UserList.init();
});
