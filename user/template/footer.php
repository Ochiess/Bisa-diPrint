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

<script src="./../layout/vendor/jquery/jquery.min.js"></script>
<script src="./assets/scripts/main.js"></script>
<script src="./assets/sweetalert2/sweetalert2.min.js"></script>
<script src="./../assets/izitoast/js/iziToast.min.js"></script>
<script src="./../layout/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="./../layout/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();

    });
    var user_id = '<?= $id ?>';
    countPesanan();
    function countPesanan() {
        $.ajax({
            url     : 'controller.php',
            method  : "POST",
            data    : {
                req: 'countPesanan',
                id: user_id
            },
            success : function(data) {
                if (data <= 0) $('#countPesanan').attr('hidden', '').text(data);
                else $('#countPesanan').removeAttr('hidden').text(data);
            }
        });
    }
</script>
</body>
</html>