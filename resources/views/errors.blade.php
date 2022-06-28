@extends('layouts.user', ['activePage' => 'errors', 'menuParent' => 'errors', 'titlePage' => __('Errors')])

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
            <h2>Current Errors</h2>
        </div>
        <div class="row">
            

        </div>

    </div>

</div>
@endsection

@push('js')

@endpush