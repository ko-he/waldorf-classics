            </div>
        </div>
        <div class="bg-wrap"></div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(function () {
                $('.schedule').on('click', function () {
                    $('.popup-wrap').height($('.wrap').height());
                    $('.popup-wrap').fadeIn();
                    getJoiners($(this).attr('data-sc-id'));
                });
                $('.close').on('click', function () {
                    $('.popup-wrap').fadeOut();
                });
                function getJoiners(scid) {
                    $.ajax({
                        url: 'ajax/getjoinerphp',
                        type: 'post',
                        dataType: 'html',
                        data: {
                            scId: scid
                        },
                        success: function (data) {
                            $(data).appendTo($('.ajax.box'));
                        }
                    });

                }
            });
        </script>
    </body>
</html>
