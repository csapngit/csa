var formUser = function () {
  var dropdown = function () {
    var branch = document.getElementById("userBranch").value;

    $("#branch").select2({
      placeholder: "Cabang",
      allowClear: true,
      ajax: {
        url: "/api/admin/get/list/branch",
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
                text: item.text,
                id: item.id
              }
            })
          };
        },
        cache: true
      }
    });
    $("#userrole").select2({
      placeholder: "User Role",
      allowClear: true,
      ajax: {
        url: "/api/admin/get/list/user-role",
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
                text: item.text,
                id: item.id
              }
            })
          };
        },
        cache: true
      }
    });
    console.log('branch:'+branch);
    // $("#branch").val('3');
    // $("#branch").trigger("change");

    var studentSelect = $('#branch');
    var option = new Option('HT - CENGKARENG', branch, true, true);
    studentSelect.append(option).trigger('change');

    // manually trigger the `select2:select` event
    studentSelect.trigger({
        type: 'select2:select',
        params: {
            data: data
        }
    });
  }

  var avatar = function () {
    avatar = new KTImageInput('kt_user_add_avatar');
  }

  var validasi = function () {
    FormValidation.formValidation(
      document.getElementById('myForm'),
      {
        fields: {
          username: {
            validators: {
              notEmpty: {
                message: 'Username is required'
              }
            }
          },
          name: {
            validators: {
              notEmpty: {
                message: 'Fullname is required'
              }
            }
          },
          password: {
            validators: {
              notEmpty: {
                message: 'Password is required'
              }
            }
          },
          area: {
            validators: {
              notEmpty: {
                message: 'Please Select Area'
              }
            }
          },
          branch: {
            validators: {
              notEmpty: {
                message: 'Please Select Branch'
              }
            }
          },
          userrole: {
            validators: {
              notEmpty: {
                message: 'Please Select User Role'
              }
            }
          },
          email: {
            validators: {
              notEmpty: {
                message: 'Email is required'
              },
              emailAddress: {
                message: 'The value is not a valid email address'
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
      dropdown();
      avatar();
      validasi();
    }
  };
}();

jQuery(document).ready(function () {
  formUser.init();
});
