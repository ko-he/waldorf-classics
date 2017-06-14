<?php
session_start();
require 'class/Schedule.class.php';
require 'function.php';

if(empty($_SESSION['id'])){
    header('location: auth/login.php');
}

$schedule = new Schedule();

$next_match = $schedule->getNextMatch();
$next_practice = $schedule->getNextPractice();
$schedules = $schedule->getSchedules();
 ?>
<?php require '_include/header.php'; ?>
                <h1>Woldorf Classics</h1>
                <p class="menu"><img src="images/menu.png" alt=""></p>
                <nav>
                    <ul>
                        <li><a href="mypage.php"><img src="images/mypage.png" alt=""></a></li>
                        <li><a href="apps/logout.php"><img src="images/logout.png" alt=""></a></li>
                    </ul>
                </nav>
            </header>
            <div class="content">
                <div class="top">
                    <div class="next-match">
                        <p class="label">次の試合</p>
                        <?php if(!empty($next_match)): ?>
                            <p class="match-name"><?php echo h($next_match['description']); ?></p>
                            <p class="place"><?php echo h($next_match['place']); ?></p>
                            <p class="date-time"><span class="date"><?php echo h(dateformat($next_match['sc_date'])); ?></span><span class="time"><?php echo h(substr($next_match['start_time'], 0, 5)); ?></span>~</p>
                        <?php else: ?>
                            <p class="no-sc">未定</p>
                        <?php endif; ?>
                    </div>
                    <div class="next-plactis">
                        <p class="label">次の練習</p>
                        <?php if(!empty($next_practice)): ?>
                            <p class="place"><?php echo h($next_practice['place']); ?></p>
                            <p class="date-time"><span class="date"><?php echo h(dateformat($next_practice['sc_date'])); ?></span><span class="time"><?php echo h(substr($next_practice['start_time'], 0, 5)); ?></span>~<span class="time"><?php echo h(substr($next_practice['finish_time'], 0, 5)); ?></span></p>
                        <?php else: ?>
                            <p class="no-sc">未定</p>
                        <?php endif; ?>
                    </div>
                </div>
                <h2 id="schedule">Schedule</h2>
                <ul class="schedules">
                    <?php foreach($schedules as $value): ?>
                        <?php if($value['sc_type'] == 1): ?>
                            <li class="schedule practise" data-sc-id="<?php echo h($value['id']); ?>">
                                <p class="date"><?php echo h(dateformat($value['sc_date'])); ?></p>
                                <p class="time">時間：<span><?php echo h($value['start_time']); ?></span>~<span ><?php echo h($value['finish_time']); ?></span></p>
                                <p class="place">場所：<?php echo h($value['place']); ?></p>
                                <p class="label">練習</p>
                            </li>
                        <?php else: ?>
                            <li class="schedule match" data-sc-id="<?php echo h($value['id']); ?>">
                                <p class="date"><?php echo h(dateformat($value['sc_date'])); ?></p>
                                <p class="time">時間：<span><?php echo h($value['start_time']); ?></span>~</p>
                                <p class="place">場所：<?php echo h($value['place']); ?></p>
                                <p class="label">試合</p>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
                <div class="popup-wrap">
                    <div class="popup">
                        <div class="ajax-box">

                        </div>
                        <span class="close">✖</span>
                    </div>
                </div>
            </div>
<?php require '_include/footer.php'; ?>
