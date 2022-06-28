@extends('layouts.user', ['activePage' => 'dashboard', 'menuParent' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
<style>
p{
    padding: 0;
    margin: 0;
}
</style>
<div class="main-panel">

    <div class="content-wrapper">
        <div class="row">
            <h2>Registered Hubs</h2>
        </div>
        <div class="row">
            @foreach ($hubs as $hub)
            <div class="col-md-2" style="background: {{$hub['statusH']}}; border-radius: 10px; box-shadow: 5px 10px #888888; padding: 20px; margin: 5px;">
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

@endpush