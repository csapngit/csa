var Form = function () {
  var latlong = function () {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
          };
          console.log('latitude:' + pos.lat + ', ' + pos.lng);
          document.getElementById('actual_latitude').value = pos.lat;
          document.getElementById('actual_longitude').value = pos.lng;
        },
      );
    } else {
      console.log('error baca latlong');
    }
  }

  function getLatLong() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
          };
          console.log('latitude:' + pos.lat + ', ' + pos.lng);
          return pos.lat + ', ' + pos.lng;

        },
      );
    } else {
      console.log('error baca latlong');
    }
  }

  var map = function () {
    var map;
    var store_latitude = document.getElementById("store_latitude").value;
    var store_longitude = document.getElementById("store_longitude").value;
    var storeName = document.getElementById("toko").value;

    const iconBase =
      "https://developers.google.com/maps/documentation/javascript/examples/full/images/";


    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
          };
          if (document.getElementById('myMap')) {
            map = new GMaps({
              div: '#myMap',
              lat: pos.lat,
              lng: pos.lng
            });
            map.addMarker({
              lat: pos.lat,
              lng: pos.lng,
              title: 'You',
              icon: iconBase + "info-i_maps.png",
              details: {
                database_id: 42,
                author: 'HPNeo'
              }
            });
            map.addMarker({
              lat: store_latitude,
              lng: store_longitude,
              title: storeName,
              details: {
                database_id: 42,
                author: 'HPNeo'
              }
            });
          }
        },
      );
    } else {
      console.log('error baca latlong');
    }


  }
  var gps = function () {
    let timeoutID;
    timeoutID = setInterval(latlong, 5000);

    function latlong() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          (position) => {
            const pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude,
            };
            console.log('latitude:' + pos.lat + ', ' + pos.lng);
            var latlng = pos.lat + ', ' + pos.lng;
            document.getElementById('actual_latitude').value = pos.lat;
            document.getElementById('actual_longitude').value = pos.lng;
            document.getElementById('Latlong').value = latlng;
          },
        );
      } else {
        console.log('error baca latlong');
      }
    }
  };

  var validasi = function () {
    FormValidation.formValidation(
      document.getElementById('myForm'),
      {
        fields: {
          storePicture: {
            validators: {
              notEmpty: {
                message: 'Foto Toko tidak boleh dikosongkan.'
              }
            }
          },
          invoicePicture: {
            validators: {
              notEmpty: {
                message: 'Foto Invoice tidak boleh dikosongkan.'
              }
            }
          },
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
      latlong();
      map();
      gps();
      validasi();
    }
  };
}();

jQuery(document).ready(function () {
  Form.init();
});