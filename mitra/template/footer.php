        <div class="app-wrapper-footer">
            <div class="app-footer">
                <div class="app-footer__inner">
                    <div class="app-footer-right">
                        <span>Copyright &copy; diPrint Allright Reserved</span>
                    </div>
                </div>
            </div>
        </div>
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
        $('.dataTable').DataTable();
    });

    var agen_id = '<?= $id ?>';
    countPesanan();
    function countPesanan() {
        $.ajax({
            url     : 'controller.php',
            method  : "POST",
            data    : {
                req: 'countPesanan',
                id: agen_id
            },
            success : function(data) {
                if (data.all <= 0) $('.countPesanan').attr('hidden', '').text(data.all);
                else $('.countPesanan').removeAttr('hidden').text(data.all);

                if (data.review <= 0) $('.badgeReview').attr('hidden', '').text(data.review);
                else $('.badgeReview').removeAttr('hidden').text(data.review);

                if (data.proccess <= 0) $('.badgeProccess').attr('hidden', '').text(data.proccess);
                else $('.badgeProccess').removeAttr('hidden').text('.');

                if (data.done <= 0) $('.badgeDone').attr('hidden', '').text(data.done);
                else $('.badgeDone').removeAttr('hidden').text(data.done);

                if (data.panding <= 0) $('.badgePanding').attr('hidden', '').text(data.panding);
                else $('.badgePanding').removeAttr('hidden').text(data.panding);
            }
        });
    }
</script>
</body>
</html>