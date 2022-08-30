<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>to join</title>
</head>

<body>
    <script>
        if ('<?= $data['type'] ?>' == 'leave') {
            if ('<?= $data['state'] ?>' == 'app') {
                location.href = '/my/leave/step2';
            } else {
                if ('<?= $data['snsType'] ?>' == 'apple') {
                    location.href = '/my/leave/step2';
                } else {
                    opener.document.location.href = '/my/leave/step2';
                    self.close();
                }
            }
        } else {
            if ('<?= $data['state'] ?>' == 'app') {
                location.href = '/';
            } else {
                if ('<?= $data['snsType'] ?>' == 'apple') {
                    location.href = '/';
                } else {
                    opener.document.location.href = '/';
                    self.close();
                }
            }
        }
        // self.close();
    </script>
</body>

</html>