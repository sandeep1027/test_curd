<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" id="csrf-token" content="{{ Session::token() }}" />
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Enter address
                </div>
                <form action="/action_page.php">
                 <div class="form-group">
                  <input type="text" class="form-control" id="address">
                 </div>
                 <ul  style="list-style: none;">
                     <li>Full Address: <span id="location-snap"></span></li>
                     <li>Latitude: <span id="lat-span"></span></li>
                     <li>Longitude: <span id="lon-span"></span></li>
                 </ul>
                 <p id="success_msg" style="color:green;display:none">Save successfully</p>
                <button type="submit" class="btn btn-default" id="save">Save</button>
                </form>
            </div>
        </div>
    </body>
    <script>
        function initMap() {
            var input = document.getElementById('address');
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                document.getElementById('location-snap').innerHTML = place.formatted_address;
                document.getElementById('lat-span').innerHTML = place.geometry.location.lat();
                document.getElementById('lon-span').innerHTML = place.geometry.location.lng();
            });
        }
        $("#save").on("click", function(e){

            e.preventDefault();
            var address = $("#address").val();
            if (address == "") {
                alert("Address cannot be left empty.");
                return;
            }
            var long = $("#lon-span").text();
            var lat = $("#lat-span").text();
            $("#save").attr("disabled", true);
            $.ajax({
              type : 'POST',
              url: '/saveaddress',
              headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
              },
              data : {address: address, long: long , lat: lat},
              success: function(resp) {
                  $("#success_msg").show();
                  setTimeout(function() {
                    $("#success_msg").hide();
                }, 2000);

                  $("#save").attr("disabled", false);
                  $("#location-snap").text('');
                  $("#lon-span").text('');
                  $("#lat-span").text('');
                  $("#address").val("");
              },
              error: function(req, status, err) {
                console.log( 'something went wrong', status, err );
                $("#save").attr("disabled", true);
              }
            });
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmK2c5snow5tdHYhQhEbIDQrAY0acULoY&libraries=places&callback=initMap"
        async defer></script>
</html>
