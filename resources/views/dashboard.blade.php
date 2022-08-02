@extends('layouts.user', ['activePage' => 'dashboard', 'menuParent' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.23/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://www.jqueryscript.net/demo/inline-week-day-picker/src/jquery-weekdays.css">



<style>
    th {text-align:center}
table.dataTable thead th {
    position: relative;
    background-image: none !important;
    text-align: center !important;
}
  
table.dataTable thead th.sorting:after,
table.dataTable thead th.sorting_asc:after,
table.dataTable thead th.sorting_desc:after {
    position: absolute !important;
    top: 12px !important;
    right: 8px !important;
    display: block !important;
    font-family: FontAwesome !important;
}
table.dataTable thead th.sorting:after {
    content: "\f0dc" !important;
    color: #ddd !important;
    font-size: 0.8em !important;
    padding-top: 0.12em !important;
}
table.dataTable thead th.sorting_asc:after {
    content: "\f0de" !important;
}
table.dataTable thead th.sorting_desc:after {
    content: "\f0dd" !important;
}
p{
    padding: 0;
    margin: 0;
}

td {
    padding: 0 20px;
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

    						/* Center the loader */
                            .loader {
			position: absolute;
			left: 50%;
			top: 50%;
			z-index: 1;
			width: 120px;
			height: 120px;
			margin: -76px 0 0 -76px;
			border: 16px solid #f3f3f3;
			border-radius: 50%;
			border-top: 16px solid #3498db;
			-webkit-animation: spin 2s linear infinite;
			animation: spin 2s linear infinite;
			display: none;
			}

			@-webkit-keyframes spin {
			0% { -webkit-transform: rotate(0deg); }
			100% { -webkit-transform: rotate(360deg); }
			}

			@keyframes spin {
			0% { transform: rotate(0deg); }
			100% { transform: rotate(360deg); }
			}

			/* Add animation to "page content" */
			.animate-bottom {
			position: relative;
			-webkit-animation-name: animatebottom;
			-webkit-animation-duration: 1s;
			animation-name: animatebottom;
			animation-duration: 1s
			}

			@-webkit-keyframes animatebottom {
			from { bottom:-100px; opacity:0 } 
			to { bottom:0px; opacity:1 }
			}

			@keyframes animatebottom { 
			from{ bottom:-100px; opacity:0 } 
			to{ bottom:0; opacity:1 }
			}

            .swal2-popup{
    width:60vmax !important;
}
        .refresh{
            transition: transform .7s ease-in-out;
        }
        .refresh:hover{
            transform: rotate(360deg);
    transition: all 0.3s ease-in-out 0s;
            opacity: 0.7;
        }

        .progress2 {
  border-radius: 30px;
  background-color: #fff;
}

.progress-bar2 {
  height: 18px;
  border-radius: 30px;
  transition: 0.4s linear;
  transition-property: width, background-color;
}

.progress-moved .progress-bar2 {
  background-color: #f3c623;
  animation: progress 5s infinite;
}

@keyframes progress {
  0% {
    width: 0%;
    background: #f9bcca;
  }

  100% {
    width: 100%;
    background: #f3c623;
    box-shadow: 0 0 40px #f3c623;
  }
}

.icon {
  color: #f3c623;
  animation: icon 5s infinite;
  background-color: transparent;
  padding-right: 400px;
  padding-bottom: 20px;
}

@keyframes icon {
  0% {
    opacity: 0.2;
    text-shadow: 0 0 0 #f3c623;
  }

  100% {
    opacity: 1;
    text-shadow: 0 0 10px #f3c623;
  }
}

.loader2 {
  --p: 0;
  animation: p 5s steps(100) infinite;
  counter-reset: p var(--p);
  font-size: 2.1em;
  position: absolute;
  bottom: 45px;
  left: 325px;
  color: #f3c623;
}

.remove-animation {
  animation: none !important;
}
</style>
<div id="overlay">
    <div style="width: 80%; height: 80%; background: #ccc; left: 15%; top: 10%; position: relative; border-radius: 20px;">
        <div class="row justify-content-center">
            <h1 id="popupHeading" style="margin-top: 20px; text-decoration: underline;">HUB NAME</h1>
        </div>
        <div class="row justify-content-center">
            <div class="loader" id="overlayLoader"></div>

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
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab" style="color: #000">@include('alldevices')</div>
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
                <div class="col-7">

                    <span style="font-size: 28px; font-weight: bold;">Intellihubs | </span>
                    <button type="button" class="btn btn-info btn-sm" style="border-radius: 20px;"><span class="material-symbols-outlined">add_circle</span></button>
                    <button type="button" onclick="liveInit();" class="btn btn-success btn-sm" style="border-radius: 20px;"><span class="material-symbols-outlined">change_circle</span></button>
                    <div class="search-container">
                        <form action="/search" method="get">
                            <input class="search" id="searchleft" type="search" name="q" placeholder="Search">
                            <label class="button searchbutton btn btn-warning btn-sm"  style="border-radius: 20px; height: 100%;" for="searchleft"><span style="font-size: 26px;" class="material-symbols-outlined">pageview</span></label>
                        </form>
                    </div>
                </div>
                <div class="col-2"></div>
                <div class="col-3 justify-content-center">
                    <p style="font-size: 20px"><b>Auto Refresh Timer</b></p>
                    <select id="timerSelect" style="width: 100%" onchange="changeTimer(this)">
                        <option value="5">5 Minutes</option>
                        <option value="15">15 Minutes</option>
                        <option value="30">30 Minutes</option>
                        <option value="45">45 Minutes</option>
                        <option value="1">1 Hour</option>
                        <option value="2">2 Hours</option>
                        <option value="3">3 Hours</option>

                    </select>
                    <p style="font-size: 10px"><b>Next Update In: </b><span id="timerHolder"></span></p>

                </div>
        </div>
            <div class="row">
                <div class="col-md-3">
                <span class="material-symbols-outlined ">wifi</span>
                <span>Intellihub Status</span>
                </div>
                <div class="col-md-5 kustify-content-center">
                <p id="statusText" style="width:100%; text-align: center;">Intellihub Status</p>
                </div>


            </div>

            <div id="topProgDiv1" class="progress2 progress-moved remove-animation">
                <div id="topProgDiv2" class="progress-bar2 remove-animation"></div>
                <div id="topProgDiv3" class="loader2 remove-animation" style="--n: 1; --f: 0;"></div>
            </div>
        <hr>
        <div class="row" id="allHubsDiv">

            @foreach ($hubs as $key => $hub)
            <div data-live="Loading" data-hubser="{{$key}}" class="col-md-2" style="background: {{$hub['statusH']}}; border-radius: 10px; box-shadow: 5px 10px #888888; padding: 20px; margin: 5px; cursor: pointer; opacity: {{$hub['active'] == 'false' ? '0.7' : '1'}};" onclick="hubDetails(event, '{{$hub['name']}}', '{{$key}}', this);">
                <div class="loader"></div>
                <div class="row">
                    <div class="col-10">
                        <p style="font-size: 16px"><b>{{$hub['name']}}</b></p>
                    </div>
                    <div class="col-1">
            
                        <a onclick='this.offsetParent.offsetParent.getElementsByTagName("div")[0].style.display = "block"; getHubInitDetails(this.offsetParent.offsetParent.getAttribute("data-hubser"), this.offsetParent.offsetParent.getElementsByTagName("div")[0], this.offsetParent.offsetParent);' class="refresh" id="refreshButton" style="z-index: 2000;"><span class="material-symbols-outlined refresh">refresh</span></a>                    
                    </div>
                </div>
                <p style="font-size: 8px"><b>Connecting..</b></p>
                <hr>
                
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.23/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://www.jqueryscript.net/demo/inline-week-day-picker/src/jquery-weekdays.js"></script>

<script>

var setTimer = 60*5;
$( document ).ready(function() {
    $( "#allHubsDiv" ).sortable({ helper: 'clone' });
    $(".toggle-btn").click(function(){
        $("#myCollapsible").collapse('toggle');
    });
        liveInit();
        display = document.querySelector('#timerHolder');
        startTimer(setTimer, display);

});
var timerInterval = 0;
function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    timerInterval = setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            liveInit();
            timer = duration;
        }
    }, 1000);
}
function changeTimer(context){
    switch(context.value){
        case "15":
        case "30":
        case "45":
        case "5":
            setTimer = 60*context.value;
            break;
        case "1":
        case "2":
        case "3":
            setTimer = 60*(context.value*60);
            break;
    }
    clearInterval(timerInterval);
    display = document.querySelector('#timerHolder');
        startTimer(setTimer, display);

}
function deleteDevice(hub, device){
    var postObj = {
        'hub': hub,
        'device': device
    };
    Swal.fire({
        title: 'Are You Sure?',
        html: 'You can not undo this operation.',
        icon: 'warning',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: 'Confirm',
        denyButtonText: `Deny`,
        showLoaderOnConfirm: true,
        preConfirm: (login) => {
            return fetch(`/hub/device/delete`,{
                method: 'POST', // or 'PUT'
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(postObj),

            })
            .then(response => {
                if (!response.ok) {
                    Swal.fire('Server Error!', 'Please Contact Support.', 'error')
                }
                return response.json()
            })
            .catch(error => {
                Swal.showValidationMessage(
                `Request failed: ${error}`
                )
            })
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        console.log(result);

        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            if(result.value.live)
                Swal.fire('Deleted!', '', 'success')
            else
                Swal.fire('Unable To Delete!', 'No Response From The Hub.', 'error')

        }
    })
}
function viewSchedule(hub, device){

    document.getElementById("overlayLoader").style.display = "block";

    $.ajax({
        url: '/hub/schedule/get',
        type: 'post',
        data: {
            hub: hub,
            device: device,


        },
        success: feedback => {

            const promise = new Promise((resolve, reject) => {
                console.log(feedback);

                
                var dayDrop = '<div id="weekdays"> </div><script>$("#weekdays").weekdays();</script>';


                var timeBuild = feedback.weekly.hour+":"+feedback.weekly.mins;
                var timeToAct = '<input type="time" id="appt" name="appt" value="'+timeBuild+'">';
                var duration = '<input type="time" id="dur" name="dur" value="'+feedback.weekly.duration+':00">';



                var dateHTML = dayDrop+timeToAct+duration;

                var html = "";

                if(feedback.state == "0"){
                    html += "<b>NO SCHEDULES SET</b><br>";
                }

                var weeklyTable = "<table style='text-align: center;'>";
                weeklyTable += "<thead>";
                weeklyTable += "<th>Days";
                weeklyTable += "</th>";
                weeklyTable += "<th>Time (24H)";
                weeklyTable += "</th>";
                weeklyTable += "<th>Duration (Minutes)";
                weeklyTable += "</th>";

                weeklyTable += "</thead>";
                weeklyTable += "<tbody>";
                weeklyTable += "<tr>";

                weeklyTable += "<td>";
                weeklyTable += dayDrop;

                weeklyTable += "</td>";
                weeklyTable += "<td>";
                weeklyTable += timeToAct;

                weeklyTable += "</td>";
                weeklyTable += "<td>";
                weeklyTable += duration;

                weeklyTable += "</td>";

                weeklyTable += "</tr>";
                weeklyTable += "</tbody>";

                weeklyTable += "</table>";



                html += '<input type="button" class="btn btn-primary btn-lg btn-block" value="Weekly" onclick="$(\'#myCollapsible\').collapse(\'toggle\');"><div id="myCollapsible" class="collapse hide">'+weeklyTable+'</div><input type="button" class="btn btn-primary btn-lg btn-block" value="Monthly" onclick="$(\'#myCollapsible1\').collapse(\'toggle\');"><div id="myCollapsible1" class="collapse hide"><p>No Schedules</p></div><input type="button" class="btn btn-primary btn-lg btn-block" value="Bi Annually" onclick="$(\'#myCollapsible2\').collapse(\'toggle\');"><div id="myCollapsible2" class="collapse hide"><p>No Schedules</p></div><input type="button" class="btn btn-primary btn-lg btn-block" value="Annually" onclick="$(\'#myCollapsible3\').collapse(\'toggle\');"><div id="myCollapsible3" class="collapse hide"><p>No Schedules</p></div>';

                document.getElementById("overlayLoader").style.display = "none";
                Swal.fire({
                    title: 'ProEM Self Test Schedule',
                    html: html,
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    denyButtonText: `Don't save`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        Swal.fire('Saved!', '', 'success')
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                })

            });


            //                        

        }
    });
}
function liveInit(){
    var filter = 'LIVE';
    var list = document.getElementById("allHubsDiv");
    var divs = list.getElementsByTagName("div");
    for (var i = 0; i < divs.length; i++) {
        var a = divs[i].getElementsByTagName("p")[1];

        if (a) {
            divs[i].getElementsByTagName("div")[0].style.display = "block";
            getHubInitDetails(divs[i].getAttribute('data-hubser'), divs[i].getElementsByTagName("div")[0], divs[i]);

        }
    }
}
var input = document.getElementById("searchleft");
input.addEventListener("input", myFunction);

function myFunction(e) {
  var filter = e.target.value.toUpperCase();

  var list = document.getElementById("allHubsDiv");
  var divs = list.getElementsByTagName("div");
  for (var i = 0; i < divs.length; i++) {
    var a = divs[i].getElementsByTagName("p")[0];

    if (a) {
      if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
        divs[i].style.display = "";

      } else {
        divs[i].style.display = "none";
      }
    }
  }

}
function getHubInitDetails(ser, loadContext, mainContext){
    
    document.getElementById("topProgDiv1").classList.remove("remove-animation");
    document.getElementById("topProgDiv2").classList.remove("remove-animation");
    document.getElementById("topProgDiv3").classList.remove("remove-animation");
    document.getElementById("statusText").innerHTML = ser+": Contacting Intellihub";
    $.ajax({
    url: '/hub/init',
    type: 'post',
    data: {
        hubSer: ser,

    },
    success: feedback => {

        const promise = new Promise((resolve, reject) => {
            console.log(feedback);
            if(feedback.status == "Online"){
                mainContext.getElementsByTagName("p")[1].innerHTML = '<b>Live Data</b>';
                document.getElementById("statusText").innerHTML = ser+": Connected To Intellihub";

            }else{
                mainContext.getElementsByTagName("p")[1].innerHTML = '<b>Last Online Data - No Response From Hub</b>';
                document.getElementById("statusText").innerHTML = ser+": Failed To Connect To Intellihub";

            }
            mainContext.style.background = feedback.statusH;
            mainContext.getElementsByTagName("p")[2].innerHTML = 'Total Devices: '+feedback.total;
            mainContext.getElementsByTagName("p")[3].innerHTML = 'Devices Offline: '+feedback.off;
            mainContext.getElementsByTagName("p")[4].innerHTML = 'Devices Online: '+feedback.on;
            mainContext.getElementsByTagName("p")[5].innerHTML = 'Percent Offline: '+feedback.percentOff;
            mainContext.setAttribute('data-live', feedback.api_response);

            loadContext.style.display = "none";
            document.getElementById("topProgDiv1").classList.add("remove-animation");
            document.getElementById("topProgDiv2").classList.add("remove-animation");
            document.getElementById("topProgDiv3").classList.add("remove-animation");


        });


        //                        

    }
});
}
$('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
         .scroller.measure();
   });  
function hubDetails(event, name, ser, context) {
    console.log(event);
    if(event.target.className == "material-symbols-outlined refresh")
        return;
  document.getElementById("popupHeading").innerHTML = name;

  var live = context.getAttribute('data-live');

  $('#offlineTable').DataTable().destroy();
  $('#devonbatTable').DataTable().destroy();
  $('#batopenTable').DataTable().destroy();
  $('#batshortTable').DataTable().destroy();
  $('#allDevTable').DataTable().destroy();


  document.getElementById("loader").style.display = "block";


$.ajax({
    url: '/hub/get',
    type: 'post',
    data: {
        hubSer: ser,
        live: live

    },
    success: feedback => {

        const promise = new Promise((resolve, reject) => {
            console.log(feedback);
            if ($('#offlineTableBody').html(feedback.offDev)) {
                $('#offlineTable').DataTable();
            }
            if ($('#devonbatTableBody').html(feedback.onBattDev)) {
                $('#devonbatTable').DataTable();
            }
            if ($('#batopenTableBody').html(feedback.battOpen)) {
                $('#batopenTable').DataTable();
            }
            if ($('#batshortTableBody').html(feedback.battShort)) {
                $('#batshortTable').DataTable();
            }


            if ($('#allDevTableBody').html(feedback.allDevices)) {
                setTimeout(function() {
                    var allDevTable = $('#allDevTable').DataTable({
                    scrollY: '50vh',
                    scrollCollapse: true,
                    "paging": false,
                });
                }, 200);



                
            }
            resolve();
            document.getElementById("overlay").style.display = "block";
            document.getElementById("loader").style.display = "none";
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