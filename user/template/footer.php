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

<link href="./../assets/css/chat.css" rel="stylesheet">

<div class="chat-content">
    <div class="card card-bordered">
        <div class="card-header">
            <h4 class="card-title"><strong>Chat</strong></h4> <a class="btn btn-xs btn-secondary" href="#" data-abc="true">Let's Chat App</a>
        </div>
        <div class="ps-container ps-theme-default ps-active-y" id="chat-content" style="overflow-y: scroll !important; height:400px !important;">
            <div class="media media-chat"> <img class="avatar" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="...">
                <div class="media-body">
                    <p>Hi</p>
                    <p>How are you ...???</p>
                    <p>What are you doing tomorrow?<br> Can we come up a bar?</p>
                    <p class="meta"><time datetime="2018">23:58</time></p>
                </div>
            </div>
            <div class="media media-meta-day">Today</div>
            <div class="media media-chat media-chat-reverse">
                <div class="media-body">
                    <p>Hiii, I'm good.</p>
                    <p>How are you doing?</p>
                    <p>Long time no see! Tomorrow office. will be free on sunday.</p>
                    <p class="meta"><time datetime="2018">00:06</time></p>
                </div>
            </div>
            <div class="media media-chat"> <img class="avatar" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="...">
                <div class="media-body">
                    <p>Okay</p>
                    <p>We will go on sunday? </p>
                    <p class="meta"><time datetime="2018">00:07</time></p>
                </div>
            </div>
            <div class="media media-chat media-chat-reverse">
                <div class="media-body">
                    <p>That's awesome!</p>
                    <p>I will meet you Sandon Square sharp at 10 AM</p>
                    <p>Is that okay?</p>
                    <p class="meta"><time datetime="2018">00:09</time></p>
                </div>
            </div>
            <div class="media media-chat"> <img class="avatar" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="...">
                <div class="media-body">
                    <p>Okay i will meet you on Sandon Square </p>
                    <p class="meta"><time datetime="2018">00:10</time></p>
                </div>
            </div>
            <div class="media media-chat media-chat-reverse">
                <div class="media-body">
                    <p>Do you have pictures of Matley Marriage?</p>
                    <p class="meta"><time datetime="2018">00:10</time></p>
                </div>
            </div>
            <div class="media media-chat"> <img class="avatar" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="...">
                <div class="media-body">
                    <p>Sorry I don't have. i changed my phone.</p>
                    <p class="meta"><time datetime="2018">00:12</time></p>
                </div>
            </div>
            <div class="media media-chat media-chat-reverse">
                <div class="media-body">
                    <p>Okay then see you on sunday!!</p>
                    <p class="meta"><time datetime="2018">00:12</time></p>
                </div>
            </div>
            <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
            </div>
            <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px;">
                <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px;"></div>
            </div>
        </div>
        <div class="publisher bt-1 border-light"> 
            <?php if ($photo) { ?>
                <img class="avatar avatar-xs" src="../user/img/<?php echo $photo ?>" alt="">
            <?php } else { ?>
                <img class="avatar avatar-xs" src="../user/img/default.png" alt="">
            <?php } ?>
            <input class="publisher-input" type="text" placeholder="Silahkan tulis pesan..."> 
            <a class="publisher-btn text-info" href="#" data-abc="true"><i class="fa fa-paper-plane"></i></a> </div>
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