@extends('layouts.user', ['activePage' => 'dashboard', 'menuParent' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<style>
p{
    padding: 0;
    margin: 0;
}

#overlay {
  text-align:center;
  vertical-align: middle;
  
  justify-content: center;
  align-items: center;
  position: fixed; /* Sit on top of the page content */

  display: none;
  width: 100%; /* Full width (cover the whole page) */
  height: 100%; /* Full height (cover the whole page) */
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0,0,0,0.6); /* Black background with opacity */
  z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
}

.search-container {
	position: relative;
	display: inline-block;
	margin: 4px 2px;
	height: 50px;
	width: 50px;
	vertical-align: bottom;
}

.mglass {
	display: inline-block;
	pointer-events: none;
	-webkit-transform: rotate(-45deg);
	-moz-transform: rotate(-45deg);
	-o-transform: rotate(-45deg);
	-ms-transform: rotate(-45deg);
}

.searchbutton {
	position: absolute;
	font-size: 22px;
	width: 100%;
	margin: 0;
	padding: 0;
}

.search:focus + .searchbutton {
	transition-duration: 0.4s;
	-moz-transition-duration: 0.4s;
	-webkit-transition-duration: 0.4s;
	-o-transition-duration: 0.4s;
	background-color: white;
	color: black;
}

.search {
	position: absolute;
	left: 70px; /* Button width-1px (Not 50px/100% because that will sometimes show a 1px line between the search box and button) */
	background-color: grey;
    border-radius: 10px;
	outline: none;
	border: none;
	padding: 0;
	width: 0;
	height: 100%;
	z-index: 10;
	transition-duration: 0.4s;
	-moz-transition-duration: 0.4s;
	-webkit-transition-duration: 0.4s;
	-o-transition-duration: 0.4s;
}

.search:focus {
	width: 363px; /* Bar width+1px */
	padding: 0 16px 0 0;
}

.expandright {
	left: auto;
	right: 49px; /* Button width-1px */
}

.expandright:focus {
	padding: 0 0 0 16px;
}
</style>
<div id="overlay">
    <div style="width: 80%; height: 80%; background: #ccc; left: 15%; top: 10%; position: relative; border-radius: 20px;">
        <div class="row justify-content-center">
            <h1 id="popupHeading" style="margin-top: 20px; text-decoration: underline;">HUB NAME</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-11">
                <ul class="nav nav-tabs" id="myTab" role="tablist" style="background: #717073">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Overview</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Battery Short</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Battery Open</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="offline-tab" data-bs-toggle="tab" data-bs-target="#offline" type="button" role="tab" aria-controls="offline" aria-selected="false">Devices Offline</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="battery-tab" data-bs-toggle="tab" data-bs-target="#battery" type="button" role="tab" aria-controls="battery" aria-selected="false">Devices on Battery</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent" style="background: #eee; height: 90%;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab" style="color: #000">TEST1</div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">@include('batshort')</div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">@include('batteryopen')</div>
                    <div class="tab-pane fade" id="offline" role="tabpanel" aria-labelledby="offline-tab">@include('devicesoffline')</div>
                    <div class="tab-pane fade" id="battery" role="tabpanel" aria-labelledby="battery-tab">@include('devonbat')</div>

                </div>
            </div>
        </div>
      <div style="position: fixed; top: 10%; right:8%; width:15px;">
        <button id="homeButton" type="button" class="btn btn-danger btn-circle" style="border-radius: 50px;" onclick="off();"><span class="material-symbols-outlined">cancel</span></button>
      </div>
    </div>
</div>
<div class="main-panel">

    <div class="content-wrapper">
        <div class="row">
            <span>
                <span style="font-size: 28px; font-weight: bold;">All Hubs | </span>
                <button type="button" class="btn btn-info btn-sm" style="border-radius: 20px;"><span class="material-symbols-outlined">add_circle</span></button>
                <button type="button" class="btn btn-success btn-sm" style="border-radius: 20px;"><span class="material-symbols-outlined">change_circle</span></button>
                <div class="search-container">
                    <form action="/search" method="get">
                        <input class="search" id="searchleft" type="search" name="q" placeholder="Search">
                        <label class="button searchbutton btn btn-warning btn-sm"  style="border-radius: 20px; height: 100%;" for="searchleft"><span style="font-size: 26px;" class="material-symbols-outlined">pageview</span></label>
                    </form>
                </div>
            </span>
        </div>
        <hr>
        <div class="row" id="allHubsDiv">

            @foreach ($hubs as $key => $hub)
            <div class="col-md-2" style="background: {{$hub['statusH']}}; border-radius: 10px; box-shadow: 5px 10px #888888; padding: 20px; margin: 5px; cursor: pointer;" onclick="hubDetails('{{$hub['name']}}', '{{$key}}');">
                <h4>{{$hub['name']}}</h4>
                <p style="font-size: 13px">Total Devices: {{$hub['total']}}</p>
                <p style="font-size: 13px">Devices Offline: {{isset($hub['off']) ? $hub['off'] : 0}}</p>
                <p style="font-size: 13px">Devices Online: {{isset($hub['on']) ? $hub['on'] : 0}}</p>

                <p style="font-size: 13px">Percent Offline: {{$hub['percentOff']}}</p>
            </div> 
            @endforeach

        </div>

    </div>

</div>
@endsection

@push('js')
<script src="{{ asset('js1') }}/vendors/js/vendor.bundle.base.js"></script>
<script src="{{ asset('js1') }}/vendors/js/vendor.bundle.addons.js"></script>
<script src="{{ asset('js1') }}/off-canvas.js"></script>
<script src="{{ asset('js1') }}/hoverable-collapse.js"></script>
<script src="{{ asset('js1') }}/misc.js"></script>
<script src="{{ asset('js1') }}/settings.js"></script>
<script src="{{ asset('js1') }}/todolist.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js1') }}/sweet.js"></script>
<script src="{{ asset('js1') }}/main.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script>
$( document ).ready(function() {
        $('#offlineTable').DataTable();
        $('#batshortTable').DataTable();
        $('#devonbatTable').DataTable();
        $('#batopenTable').DataTable();


});
var input = document.getElementById("searchleft");
input.addEventListener("input", myFunction);

function myFunction(e) {
  var filter = e.target.value.toUpperCase();

  var list = document.getElementById("allHubsDiv");
  var divs = list.getElementsByTagName("div");
  for (var i = 0; i < divs.length; i++) {
    var a = divs[i].getElementsByTagName("h4")[0];

    if (a) {
      if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
        divs[i].style.display = "";
      } else {
        divs[i].style.display = "none";
      }
    }
  }

}
function hubDetails(name, ser) {
  document.getElementById("popupHeading").innerHTML = name

  $('#offlineTable').DataTable().destroy();
  document.getElementById("loader").style.display = "block";


$.ajax({
    url: '/hub/get',
    type: 'post',
    data: {
        hubSer: ser
    },
    success: feedback => {

        const promise = new Promise((resolve, reject) => {
            console.log(feedback);
            if ($('#offlineTableBody').html(feedback.offDev)) {
                $('#offlineTable').DataTable();
                resolve();
                document.getElementById("overlay").style.display = "block";
                document.getElementById("loader").style.display = "none";

            }
        });


        //                        

    }
});

}

function deleteEmp(){

}

function off() {

  document.getElementById("overlay").style.display = "none";



}
</script>
@endpush