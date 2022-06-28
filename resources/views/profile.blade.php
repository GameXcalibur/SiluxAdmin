@extends('layouts.user', ['activePage' => 'profile', 'menuParent' => 'profile', 'titlePage' => __('Profile')])

@section('content')
<div class="main-panel">

                <div class="content-wrapper">

                    <div class="row">

                        <div class="col-md-4">

                            <!--   My Details-->
                            <div class="card" id="details">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h4>Profile</h4>
                                        <i class="material-icons" id="edit_btn">edit</i>
                                    </div>

                                    <hr>

                                    <ul class="list-group mt-5">
                                        <li class="list-group-item list-group-flush d-flex justify-content-between">
                                            <span class="item_identifier">Username</span>
                                            <span>{{ Auth::user()->username }}</span>
                                        </li>

                                        <li class="list-group-item list-group-flush d-flex justify-content-between">
                                            <span class="item_identifier">Email</span>
                                            <span>{{ Auth::user()->email }}</span>
                                        </li>

                                    </ul>

                                </div>
                            </div>


                            <!-- Edit cards -->
                            <div id="edit">

                                <!--Edit My Profile-->
                                <div class="card">

                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h4>Edit Profile</h4>
                                            <i class="material-icons" id="edit_close">close</i>
                                        </div>
                                        <hr>

                                        <form id="editProfile">

                                            <div class="form-group">
                                                <label for="">Username</label>
                                                <input type="text" id="username" value="{{ Auth::user()->username }}" class="form-control" required>
                                            </div>


                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="email" id="email" value="{{ Auth::user()->email }}" class="form-control" required>
                                            </div>


                                            <div class="form-group">
                                                <button class="btn btn-primary btn-block">Update Details </button>
                                            </div>

                                        </form>

                                    </div>

                                </div>

                                <!--Edit My Password-->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h4>Edit Password</h4>
                                        </div>
                                        <hr>


                                        <form id="editPassword">

                                            <div class="form-group">
                                                <label for="">New Password</label>
                                                <input type="password" id="password" class="form-control" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Verify Password</label>
                                                <input type="password" id="verify" class="form-control" required>
                                            </div>

                                            <div class="form-group">
                                                <button class="btn btn-primary btn-block">Update Password </button>
                                            </div>

                                        </form>

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

            const url = "ajax/profile_ajax.php";
            const id = "1";
            const email = "EMAIL";
            const name = "NAME";

            //hide the damn thing when the page loads 
            $('#edit').slideUp();


            //show the edit part
            $('#edit_btn').on('click', function() {

                $('#edit').slideDown();
                $('#details').slideUp();

            });

            //and do the opposite 
            $('#edit_close').on('click', function() {

                $('#edit').slideUp();
                $('#details').slideDown();

            });


            //update my profile 
            $('#editProfile').submit(e => {

                e.preventDefault();

                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        editProfile: 'please',
                        name: $('#name').val(),
                        surname: $('#surname').val(),
                        email: $('#email').val(),
                        cell: $('#cell').val(),
                        id: id,
                        oldEmail: email
                    },
                    success: feedback => {
                        if (feedback == 'success') {
                            sweetSuccess('Details Updated');

                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            sweetError(feedback);
                        }

                        console.log(feedback);
                    }
                });

            });


            //update my password 
            $('#editPassword').submit(e => {

                e.preventDefault();

                if ($('#password').val() != $('#verify').val()) {
                    sweetError('Passwords do not match');
                } else {

                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                            editPassword: 'please',
                            password: $('#password').val(),
                            email: email,
                            name: name,
                            id: id
                        },
                        success: feedback => {
                            if (feedback == 'success') {
                                sweetSuccess('Password Updated');

                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            } else {
                                sweetError(feedback);
                            }
                        }
                    });


                }

            });


        });

    </script>
@endpush