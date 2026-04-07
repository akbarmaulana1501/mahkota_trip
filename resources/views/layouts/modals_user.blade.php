<div class="modal fade" id="modalAdmin" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Akun Admin</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form action="{{ route('admin.updatePassword') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body text-center">

                    <img src="{{ asset('template/assets/dist/img/user2-160x160.jpg') }}"
                        class="img-circle mb-3" width="100">

                    <h5>{{ auth()->user()->username }}</h5>
                    <p class="text-muted">{{ auth()->user()->email }}</p>

                    <hr>

                    <!-- Password Lama -->
                    <div class="form-group text-left">
                        <label>Password Lama</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>

                    <!-- Password Baru -->
                    <div class="form-group text-left">
                        <label>Password Baru</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="form-group text-left">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Password
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>