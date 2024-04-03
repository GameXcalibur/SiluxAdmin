@extends('layouts.user', ['activePage' => 'heat_dashboard', 'menuParent' => 'heat_dashboard', 'titlePage' => __('Heat Dashboard')])

@section('content')

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.23/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://www.jqueryscript.net/demo/inline-week-day-picker/src/jquery-weekdays.css">

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-7">
                <span style="font-size: 28px; font-weight: bold;">Heat Dashboard</span>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table id="datatables" class="table table-striped table-no-bordered table-hover" style="display:none">
                <thead class="text-primary">

                    <th>
                        {{ __('Name') }}
                    </th>
                    <th>
                        {{ __('HUB') }}
                    </th>
                    <th>
                        {{ __('Last Temperature') }}
                    </th>
                    <th>
                        {{ __('Last Update') }}
                    </th>

                </thead>
                <tbody>
                    <tr>
                        <td>
                        Heat Sensor - 1
                        </td>
                        <td>
                        HUB6565 - MNS
                        </td>
                        <td>
                        20*
                        </td>
                        <td>
                        2024-02-08 11:30
                        </td>

                    </tr>
                    <tr>
                        <td>
                        Heat Sensor - 2
                        </td>
                        <td>
                        HUB6565 - MNS
                        </td>
                        <td>
                        19*
                        </td>
                        <td>
                        2024-02-08 11:30
                        </td>

                    </tr>
                    <tr>
                        <td>
                        Heat Sensor - 3
                        </td>
                        <td>
                        HUB6565 - MNS
                        </td>
                        <td>
                        22*
                        </td>
                        <td>
                        2024-02-08 11:30
                        </td>

                    </tr>
                </tbody>
                </table>
            </div>
        </div>
        <div class='row justify-content-center'>
            <canvas id="myChart" style="width:100%;max-width:80%"></canvas> 
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
<script
src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script> 

<script>
    //disabled toilet 
//office bathroom
    $(document).ready(function() {
        $('#datatables').fadeIn(1100);
        $('#datatables').DataTable();

    });

    const xValues = ['09 FEB 2024 - 10:05','09 FEB 2024 - 10:10','09 FEB 2024 - 10:15','09 FEB 2024 - 10:20','09 FEB 2024 - 10:25','09 FEB 2024 - 10:30','09 FEB 2024 - 10:35','09 FEB 2024 - 10:40','09 FEB 2024 - 10:45','09 FEB 2024 - 10:50','09 FEB 2024 - 10:55','09 FEB 2024 - 11:00','09 FEB 2024 - 11:05','09 FEB 2024 - 11:10','09 FEB 2024 - 11:15','09 FEB 2024 - 11:15','09 FEB 2024 - 11:20','09 FEB 2024 - 11:25','09 FEB 2024 - 11:30','09 FEB 2024 - 11:35', '09 FEB 2024 - 11:40','09 FEB 2024 - 11:45','09 FEB 2024 - 11:50','09 FEB 2024 - 11:55','09 FEB 2024 - 12:00','09 FEB 2024 - 12:05','09 FEB 2024 - 12:10','09 FEB 2024 - 12:15','09 FEB 2024 - 12:20','09 FEB 2024 - 12:25','09 FEB 2024 - 12:30','09 FEB 2024 - 12:35','09 FEB 2024 - 12:40','09 FEB 2024 - 12:45','09 FEB 2024 - 12:50','09 FEB 2024 - 12:55','09 FEB 2024 - 13:00','09 FEB 2024 - 13:05','09 FEB 2024 - 13:10','09 FEB 2024 - 13:15'];

new Chart("myChart", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{
        label: 'Heat Sensor - 1',
      data: [20,21,20,22,20,21,22,23,25,26,28,30,30,30,30,30,30,30,30,30,28,30,30,30,30,30,30,30,30,30,28,30,30,30,30,30,30,30,30,30],
      borderColor: "red",
      fill: false
    },{
        label: 'Heat Sensor - 2',
      data: [24,23,22,21,24,23,21,22,24,23,21,22,23,23,22,21,22,21,22,21,24,23,22,21,24,23,21,22,24,23,21,22,23,23,22,21,22,21,22,21],
      borderColor: "green",
      fill: false
    },{
        label: 'Heat Sensor - 3',
      data: [19,21,24,22,21,22,21,22,21,22,21,22,21,22,21,22,21,22,21,22,21,22,21,22,22,22,21,22,22,21,21,21,21,22,22,22,22,22,22,21],
      borderColor: "blue",
      fill: false
    }]
  },
  options: {
    legend: {display: true}
  }
});
</script>
@endpush