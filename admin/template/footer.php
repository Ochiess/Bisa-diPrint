<!--footer-->
<footer>
    <div class="app-wrapper-footer">
        <div class="app-footer">
            <div class="app-footer__inner">
                <div class="app-footer-left">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; diPrint Allright Reserved</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


</div>
</div>

<!-- MODAL GANTI PASSWORD -->
<div class="modal fade modal-update-akun" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Akun Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body px-5">
                    <div class="form-group">
                        <lable class="form-lable">Nama Tampilan</lable>
                        <input class="form-control" type="text" required="" placeholder="Nama Tampilan..." name="nama" value="<?= $adm['nama'] ?>" required="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <lable class="form-lable">Username</lable>
                        <input class="form-control" type="text" required="" placeholder="Username..." name="username" value="<?= $adm['username'] ?>" required="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <lable class="form-lable">Password</lable>
                        <input class="form-control" placeholder="Password..." name="password" type="text" autocomplete="off">
                        <span class="text-info">Info: Masukkan password baru jika ingin mengganti password lama!</span>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-success" name="update_akun">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="./../layout/vendor/jquery/jquery.min.js"></script>
<script src="./assets/scripts/main.js"></script>
<script src="./../user/assets/sweetalert2/sweetalert2.min.js"></script>
<script src="./../assets/izitoast/js/iziToast.min.js"></script>
<script src="./../layout/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="./../layout/vendor/datatables/dataTables.bootstrap4.min.js"></script>
</body>

</html>

<script>
    $(document).ready(function($) {
        $('#dataTable').DataTable();

        <?php if ($success_update == true) { ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Diproses',
                text: 'Data telah telah diperbarui'
            }).then(function() {
                window.location.href = location.href;
            });
        <?php } ?>
    });
</script>