<?php
isset($data['snsId']) ? $data['snsId'] : $data['snsId'] = "";
isset($data["multipleLogin"]) ? $data["multipleLogin"] : $data["multipleLogin"] = "";
isset($data["errorMsg"]) ? $data["errorMsg"] : $data["errorMsg"] = "";
?>
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
        if ('<?= $data['type'] ?>' == 'join') {
            if ('<?= $data['state'] ?>' == 'app') {
                location.href = '/join/sns?cacheKey=<?= isset($data['cacheKey']) ? $data['cacheKey'] : '' ?>';
            } else {
                if ('<?= $data['snsType'] ?>' == 'apple') {
                    location.href = '/join/sns?cacheKey=<?= isset($data['cacheKey']) ? $data['cacheKey'] : '' ?>';
                } else {
                    opener.document.location.href = '/join/sns?cacheKey=<?= isset($data['cacheKey']) ? $data['cacheKey'] : '' ?>';
                    self.close();
                }
            }
        } else {
            if ('<?= $data['state'] ?>' == 'app') {
                if ('<?= $data["multipleLogin"] ?>') {
                    alert('<?= $data["errorMsg"] ?>');
                } else {
                    if (navigator.userAgent.indexOf('APP_Highbuff_Android') != -1) {
                        window.interview.send_id('<?= $data['snsId'] ?>')
                    } else if (navigator.userAgent.indexOf('APP_Highbuff_IOS') != -1) {
                        webkit.messageHandlers.send_id.postMessage('<?= $data['snsId'] ?>')
                    }
                }
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