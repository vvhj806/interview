<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>이벤트</title>
    <style>
        li {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <div>
    <a href='/help'>뒤로가기</a>
        <div>
            <form method="get" action='event'>
                <button name='stat' type='submit' value='ing'>진행중인 이벤트</button>
                <button name='stat' type='submit' value='end'>종료된 이벤트</button>
            </form>
        </div>
    </div>
    <hr>
    <div>
        <ul>
            <?php foreach ($data['eventList'] as $val) : ?>
                <li>
                    <a href='event/<?= $val['idx'] ?>'>
                        이벤트
                        <img src='/writable<?= $val['file_save_name'] ?>'>
                    </a>
                    <div> <?= $val['bd_start_date'] ?> ~ <?= $val['bd_end_date'] ?></div>
                </li>
            <?php endforeach; ?>
        </ul>
        <?= $data['pager']->links('event', 'front_full') ?>
    </div>

</body>

</html>