<h2 class="my-5">Akun</h2>
<ul class="list-unstyled" id="user-sidebar">
    <li class="my-4 @if (Route::current()->getName() == 'user.editprofile') active
        position-relative @endif">
        <a href="{{ route('user.editprofile') }}" class="text-gray text-decoration-none fs-5">Edit
            Profile</a>
        @if (Route::current()->getName() == 'user.editprofile')
            <div class="active-border py-1 position-absolute end-0 d-inline"> </div>
        @endif
    </li>
    <li class="my-4 @if (Route::current()->getName() == 'user.resetpassword') active
        position-relative @endif">
        <a href="{{ route('user.resetpassword') }}" class="text-gray text-decoration-none fs-5">Reset
            Password</a>
        @if (Route::current()->getName() == 'user.resetpassword')
            <div class="active-border py-1 position-absolute end-0 d-inline"> </div>
        @endif
    </li>
</ul>
