<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="{{ asset('template/assets/dist/img/user2-160x160.jpg') }}"
            class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
        <a href="#" class="d-block" data-toggle="modal" data-target="#modalAdmin">
            {{ auth()->user()->username }}
        </a>
    </div>
</div>
