@empty($user)
    <div id="modal-master" class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan.
                </div>
                <a href="{{ url('/user') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-striped mb-0">
                    <tr>
                        <th class="text-right col-4">User ID :</th>
                        <td class="col-8">{{ $user->user_id }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Level ID :</th>
                        <td>{{ $user->level_id }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Username :</th>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Nama Lengkap :</th>
                        <td>{{ $user->nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Password :</th>
                        <td>*****</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endempty