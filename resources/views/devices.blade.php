@extends('layouts.user', ['activePage' => 'devices', 'menuParent' => 'devices', 'titlePage' => __('Devices')])

@section('content')
<div class="main-panel">

                <div class="content-wrapper">



                    <div class="row">
                        <div class="col-12">

                            <div class="card">
                                <div class="card-body">

                                    <!-- Nav pills -->
                                    <ul class="nav nav-pills">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="pill" href="#home">All</a>
                                        </li>
                                        <li class="nav-item" id="noNameTab">
                                            <a class="nav-link" data-toggle="pill" href="#menu1">No Name </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="pill" href="#menu2"></a>
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content pt-5">

                                        <!-- All devices-->
                                        <div class="tab-pane container-fluid px-0 active" id="home">

                                            <div class="row">
                                                <div class="col-md-12">

                                                    <div class="table-responsive">
                                                        <table class="table table-hover table-striped" id="devices_table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Serial</th>
                                                                    <th>Name</th>
                                                                    <th>Type</th>
                                                                    <th>Hub Serial</th>
                                                                    <th>Hub Name</th>
                                                                    <th>Date Registered</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="devices_body"></tbody>
                                                        </table>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!--Devices with no name-->
                                        <div class="tab-pane container-fluid px-0 fade" id="menu1">

                                            <div class="row">
                                                <div class="col-md-12">

                                                    <div class="table-responsive">
                                                        <table class="table table-hover table-striped" id="no_name_table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Serial</th>
                                                                    <th>Name</th>
                                                                    <th>Type</th>
                                                                    <th>Hub Serial</th>
                                                                    <th>Hub Name</th>
                                                                    <th>Date Registered</th>
                                                                    <th>Last Online</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="no_name_body"></tbody>
                                                        </table>
                                                    </div>

                                                </div>

                                            </div>


                                        </div>


                                        <div class="tab-pane container-fluid px-0 fade" id="menu2">...</div>
                                    </div>

                                </div>
                            </div>


                        </div>
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
        $(document).ready(() => {

            const url = "{{ route('devices.get') }}";


            //Get all the devices 
            function getAllDevices() {
                loading();
                $('#devices_table').DataTable().destroy();

                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        getAllDevices: 'please'
                    },
                    success: feedback => {

                        const promise = new Promise((resolve, reject) => {
                            if ($('#devices_body').html(feedback)) {
                                $('#devices_table').DataTable();
                                resolve();
                            }
                        });

                        promise.then(() => {
                            finishLoading();
                        });

                        //                        

                    }
                });


            }

            getAllDevices();


            //get all the devices with no names
            function getNonameDevices() {

                loading();

                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        getNonameDevices: 'please'
                    },
                    success: feedback => {

                        const promise = new Promise((resolve, reject) => {
                            if ($('#no_name_body').html(feedback)) {
                                $('#no_name_table').DataTable();
                                resolve();
                            }
                        });

                        promise.then(() => {
                            finishLoading();
                        });

                    }
                });

            }

            //call the noname when the noname tab has been clicked 
            $('#noNameTab').click(() => {
                getNonameDevices();
            });




        });

    </script>
@endpush