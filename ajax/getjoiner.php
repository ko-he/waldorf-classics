<?php
session_start();
// 定義関数の読み込み
require '../function.php';

require '../class/Joiner.class.php';
$joiner = new Joiner();

$joiners = $joiner->getJoiner($_POST['scId']);
$un_joiners = $joiner->getUnJoiner($_POST['scId']);
?>
<p class="date">06/11</p>
<p class="label">参加できるメンバー</p>
<ul class="join">
    <?php foreach($joiners as $value): ?>
        <?php if($_SESSION['id'] == $value['user_id']) $join_flug = true; ?>
        <li><img src="<?php echo h($img_url); ?>" alt=""><span class="name"><?php echo h($value['name']); ?></span></li>
    <?php endforeach; ?>
</ul>
<p class="label">参加でないメンバー</p>
<ul class="unjoin">
    <?php foreach($un_joiners as $value): ?>
        <li><img src="<?php echo h($img_url); ?>" alt=""><span class="name"><?php echo h($value['name']); ?></span></li>
    <?php endforeach; ?>
</ul>
<?php if($joine_flug): ?>
    <p class="wide-btn"><a href="">欠席にする</a></p>
<?php else: ?>
    <p class="wide-btn"><a href="">参加にする</a></p>
<?php endif; ?>
