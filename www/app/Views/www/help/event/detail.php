<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>이벤트</title>
</head>

<body>
    <div>
        <a href='javascript:window.history.back();'>뒤로가기</a>
        <?= $data['eventList']['bd_title'] ?>
    </div>
    <div>본문</div>
    <div>
        <?= $data['eventList']['bd_content'] ?>
    </div>
</body>

</html>