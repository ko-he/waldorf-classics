            </div>
        </div>
        <div class="popup-wrap">
            <div class="popup">
                <div class="ajax-box">

                </div>
                <span class="close">✖</span>
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
                $('.sc-edit').on('click', function () {
                    getEditSchedule($(this).attr('data-sc-id'));
                });
                $('.close').on('click', function () {
                    $('.popup-wrap').fadeOut(function () {
                        $('.ajax-box').empty();
                    });
                });
                function getJoiners(scid) {
                    $.ajax({
                        url: 'ajax/getjoiner.php',
                        type: 'post',
                        dataType: 'html',
                        data: {
                            scId: scid
                        },
                        success: function (data) {
                            $(data).appendTo($('.ajax-box'));
                        }
                    });
                }
                function getEditSchedule(scid) {
                    $.ajax({
                        url: 'ajax/geteditschedule.php',
                        type: 'post',
                        dataType: 'html',
                        data: {
                            scId: scid
                        },
                        success: function (data) {
                            $('form').html($(data));
                        }
                    });
                }
                var n = 0;
                $('.menu').on('click', function () {
                    if(n == 0){
                        $('nav').show();
                        $('nav').css({
                            top: $('header').height() + 5
                        });
                        n = 1;
                    }else{
                        $('nav').hide();
                        n = 0;
                    }
                });
            });
        </script>
    </body>
</html>
