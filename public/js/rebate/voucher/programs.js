var Partner = function () {
  var upload = function () {
    // Demo 1
    var btn = KTUtil.getById("btnUpload");
    var userID = document.getElementById("userID").value;

    KTUtil.addEvent(btn, "click", function () {
      KTUtil.btnWait(btn, "spinner spinner-right spinner-white pr-15", "Please wait");
      const url = '/api/dds/generate/partner/' + userID;
      $.ajax({
        url: url,
        type: 'GET',
        success: function (result) {
          KTUtil.btnRelease(btn);
          toastr.success("Sukses mengupload data partner.");
        },
        error: function (error) {
          KTUtil.btnRelease(btn);
          toastr.error("Gagal mengupload data partner!");
        }
      });
    });
  };

  var download = function () {
    var btn = KTUtil.getById("btnDownload");
    var userID = document.getElementById("userID").value;

    KTUtil.addEvent(btn, "click", function () {
      KTUtil.btnWait(btn, "spinner spinner-right spinner-white pr-15", "");
      const url = '/api/dds/download/partner/' + userID;
      $.ajax({
        url: url,
        type: 'GET',
        success: function (result) {
          KTUtil.btnRelease(btn);
          toastr.success("Sukses menyiapkan file.");
          document.getElementById('my_iframe').src = result;
        },
        error: function (error) {
          KTUtil.btnRelease(btn);
          toastr.error("gagal Menyiapkan file.");
        }
      });
    });
  };

  var datagrid = function () {
    var datatable = $('#kt_datatable').KTDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
          read: {
            url: '/api/get/programs',
            method: 'GET'
          }
        },
        pageSize: 10,
        serverPaging: true,
        serverFiltering: true,
        serverSorting: true,
      },

      // layout definition
      layout: {
        scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
        footer: false // display/hide footer
      },

      // column sorting
      sortable: true,

      pagination: true,

      search: {
        input: $('#kt_datatable_search_query'),
        onEnter: true,
        key: 'generalSearch'
      },

      // columns definition
      columns: [{
        field: 'id',
        title: '#',
        sortable: false,
        width: 20,
        type: 'number',
        selector: {
          class: 'kt-checkbox--solid'
        },
        textAlign: 'center'
      }, {
        field: 'area',
        title: 'Area'
      }, {
        field: 'name',
        title: 'Name'
      }, {
        field: 'valid_from2',
        title: 'Valid From',
      }, {
        field: 'valid_until',
        title: 'Valid Until',
        template: function (data) {
          var tanggal = new Date(data.valid_until);
          return tanggal.getDate() + '-' + (tanggal.getMonth() + 1) + '-' + (tanggal.getFullYear());
        }
      }, {
        field: 'Actions',
        title: 'Actions',
        sortable: false,
        width: 125,
        autoHide: false,
        overflow: 'visible',
        textAlign: 'center',
        template: function (raw) {
          return '\
                  <a href="programs/' + raw.id + '/show" class="btn btn-sm btn-clean btn-icon" title="Show Tiers">\
                      <span class="svg-icon svg-icon-md">\
                          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                  <rect x="0" y="0" width="24" height="24"/>\
                                  <path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>\
                                  <path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" fill="#000000" opacity="0.3"/>\
                                  <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>\
                              </g>\
                          </svg>\
                      </span>\
                  </a>\
                  <a href="program-customers/' + raw.id +'" class="btn btn-sm btn-clean btn-icon" title="Show Customers">\
                      <span class="svg-icon svg-icon-md">\
                          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                  <rect x="0" y="0" width="24" height="24"/>\
                                  <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>\
                                  <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>\
                                  <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>\
                              </g>\
                          </svg>\
                      </span>\
                  </a>\
                  <a href="programs/' + raw.id + '/edit" class="btn btn-sm btn-clean btn-icon" title="Edit details">\
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
              ';
        },
      }],

    });

    $('#kt_datatable_search_branch').on('change', function () {
      datatable.search($(this).val().toLowerCase(), 'BranchName');
    });

    $('#kt_datatable_search_area').on('change', function () {
      datatable.search($(this).val().toLowerCase(), 'Area');
    });
    $('#kt_datatable_search_status').on('change', function () {
      datatable.search($(this).val().toLowerCase(), 'Status');
    });

    $('#kt_datatable_search_latlong').on('change', function () {
      datatable.search($(this).val().toLowerCase(), 'Latlong');
    });

    $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
    $('#btnReload').on('click', function () {
      $('#kt_datatable').KTDatatable('reload');
    });

    $('#kt_datatable').on('datatable-on-check', function (e, args) {
      var ids = datatable.checkbox().getSelectedId();
      var count = ids.length;

      $('#kt_datatable_selected_records_2').html(count);
      console.log('jml record:');
      if (count > 0) {
        // $('#kt_datatable_group_action_form_2').collapse('show');

      } else {
        // $('#kt_datatable_group_action_form_2').collapse('hide');
      }
    });
  };

  var eventsCapture = function () {
    //         var chk = document.getElementById("CheckID");
    //         $('#kt_datatable').on('datatable-on-check', function(e, args) {
    // //                var document.getElementById("checkyear").value = args.toString();
    //             $('#CheckID').append(args.toString());
    //             var x = $('#kt_datatable').KTDatatable('getSelectedRecords');
    //             console.log(x.cell);
    // //                    eventsWriter('Checkbox active: ' + args.toString());
    //         }).on('datatable-on-uncheck', function(e, args) {
    //             console.log(args.toString());
    // //                    eventsWriter('Checkbox inactive: ' + args.toString());
    //         });

  };

  return {
    // public functions
    init: function () {
      upload();
      download();
      datagrid();
      eventsCapture();
    }
  };
}();

jQuery(document).ready(function () {
  Partner.init();
});
