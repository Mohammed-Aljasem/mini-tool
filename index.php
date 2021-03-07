<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <title>Form </title>
</head>

<body>
  <style>
    /* style to hide up down arrows input type number */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* style for clicked btn  */
    .focus-btn:focus {
      background-color: cadetblue;
    }
  </style>
  <!-- form register user for offer  -->

  <div class="container-sm margin-top-lg mt-5 d-flex   flex-column align-items-center  justify-content-center bd-content ps-lg-3 ">
    <div class="row align-items-center border justify-content-center p-4 ">
      <h4>Enter you information</h4>
      <br>

      <div id="message"></div>
      <form action="" method="POST">
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label" required>Name</label>
          <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="Jon Doe" required>
        </div>
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Mobile number</label>
          <input type="number" name="mobile" class="form-control" id="exampleFormControlInput1" placeholder="077xxxxxxxx" required>
        </div>
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Email</label>
          <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" required>
        </div>
        <button id="submit" type="button" name="submit" onclick="submitForm();" class="btn btn-primary mb-2 focus-btn">submit</button>
      </form>
    </div>
    <!-- pop massage -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Register offer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close2"></button>

          </div>
          <div class="modal-header" style="border: none;">

            <div class="" role="alert" id="successMsg"></div>
          </div>
          <div class="modal-body d-grid gap-2 col-12 mx-auto" id="modal-body">

          </div>
          <div class="modal-header col-12" style="border: none;">

            <button type="button" class="btn btn-primary col-12" onclick="SelectTimeOffers()" data-dismiss="modal" id="confirm-btn">Confirm offer</button>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>

          </div>
        </div>
      </div>
    </div>


  </div>

  <script type="text/javascript">
    //this function save user information in database
    function submitForm() {
      //get values of inputs
      var name = $('input[name=name]').val();
      var mobile = $('input[name=mobile]').val();
      var email = $('input[name=email]').val();

      //validation inputs if empty
      if (name != '' && mobile != '' && email != '') {
        var formData = {
          name: name,
          mobile: mobile,
          email: email
        };


        $.ajax({

          url: "http://localhost/form/apis/api-add-user.php",
          type: 'POST',
          data: formData,

          success: function(response) {

            var res = JSON.parse(JSON.stringify(response))

            sessionStorage.setItem("user_id", res.user_id);

            if (res.success == true) {
              //give the user message for the state of register 
              $('#message').html('<span style="color: green">Form submitted successfully</span>');
              setTimeout(function() {

                $("#exampleModalCenter").attr({

                  "style": "display:block;"

                });
                $("#exampleModalCenter").addClass("show");
              }, 1000);


              //send ok to function for fetch offers after complete the register information
              getOffers("ok");


              //handle error register 
            } else
              $('#message').html('<span style="color: red">Form not submitted. Some error in running the database query.</span>');
          }
        });

        //for sure all fields are entered 
      } else {
        $('#message').html('<span style="color: red">Please fill all the fields</span>');
        return false
      }
    }


    // this function gets all offers is available
    function getOffers(offer) {
      //validation if ok or not for continue 
      if (offer == "ok") {

        $('#successMsg').html('<span style="color: green; margin:0.5rem">success register your can now add you offer</span>');
        $.ajax({
          url: "http://localhost/form/apis/api-offers.php",
          type: 'POST',
          data: "offers",

          success: function(response) {
            var res = JSON.parse(JSON.stringify(response))

            //components of offers 
            function component(res) {
              return `<div class="col d-flex justify-content-center">
              <button type="button"  onclick="saveOfferID(${res.offer_id})" id="offer${res.offer_id}" class="btn btn-primary col-12">${res.offer_name}</button>
              </div>`;
            }

            //map data fetched of database 
            document.getElementById("modal-body").innerHTML =
              `<div class="row align-items-center" >${res.map(component).join('')}</div>`


          }

        });


        //handle error fetch offers from database 
      } else {

        $('#successMsg').html('<span style="color: red; margin:0.5rem">Error get data of server</span>');
      }
    }

    //function select offer from user 
    function saveOfferID(x) {
      //change style of btn after it's clicked 
      $(`#offer${x}`).addClass("focus-btn");

      //save number of offer are selected to use after 
      offer = sessionStorage.setItem("offer_id", x)

    }



    // this function for select the user offer and add on database
    function SelectTimeOffers() {

      //message tell user about the state of offer and will show after a little of time after save offer  
      setTimeout(function() {
        $('#successMsg').html('<span style="color: green; margin:0.5rem">offer added successfully. Can you tell us how mush you are interested </span>');
      }, 400)

      //set time to show data 
      setTimeout(function() {

        //fetch type of interested for save 
        $.ajax({
          url: "http://localhost/form//apis/api-interested.php",
          type: 'POST',
          data: "interested",

          //after send data and get success from api
          success: function(response) {

            // remove btn confirm offer after select  
            $("#confirm-btn").remove();
            var res = JSON.parse(JSON.stringify(response))

            //change style of popup to suits the data 
            $(".modal-dialog").attr({

              "style": "max-width: 600px;"
            });
            //map data of interested after fetch of api
            function component(res) {
              return `<div class="col d-flex justify-content-center">
              <button type="button" id="finish" onclick="saveOffer(${res.inters_id})" id="offers" class="btn btn-primary finish col-12">${res.inters_time}</button>
              </div>`;
            }
            document.getElementById("modal-body").innerHTML =
              `<div class="row align-items-center" >${res.map(component).join('')}</div>`

          }

        });
      }, 750);
    }


    // this function for save information the offer 
    function saveOffer(x) {
      //remove old message and update with new style message 
      setTimeout(function() {}, 650)
      $("#successMsg").remove();

      // get data saved in session storage to use for complete register data of offer 
      user_id = sessionStorage.getItem("user_id");
      offer_id = sessionStorage.getItem("offer_id");
      inters_id = x;

      // define variables to be ready for sent to the api
      var offerData = {
        user: user_id,
        offer: offer_id,
        inters: inters_id,
      };

      //send data for to save on database
      $.ajax({
        url: "http://localhost/form/apis/api-add-offer.php",
        type: 'POST',
        data: offerData,

        success: function(response) {

          var res = JSON.parse(response)
          //message success the register information 
          document.getElementById("modal-body").innerHTML = `<span class="alert alert-success col-11" role="alert ">
            your are finished. You will receive you offer on email
            </span>`;

          //function send information of user about his offer on his email 
          sendOffer("send")


        }
      });


    }

    //this function send information of user about his offer on his email 

    function sendOffer(x) {
      if (x == "send") {

        //get id of user are saved in session to send the api
        user_id = sessionStorage.getItem("user_id");
        var user = {
          id: user_id

        };

        //clear all data saved for the user and after send email and complete the register 
        setTimeout(function() {
          sessionStorage.clear()

        }, 2000)

        $.ajax({
          url: "http://localhost/form/apis/api-get-information.php",
          type: 'POST',
          data: user,

        })
      }
    }

    // attributes pops to change it to close popups
    $('#close').click(function() {

      $("#exampleModalCenter").attr({
        "style": "",
        "data-bs-target": ""
      });
      $("#exampleModalCenter").addClass("");
    });
    $('#close2').click(function() {

      $("#exampleModalCenter").attr({
        "style": "",
        "data-bs-target": ""
      });
      $("#exampleModalCenter").addClass("");
    });
  </script>
</body>

</html>