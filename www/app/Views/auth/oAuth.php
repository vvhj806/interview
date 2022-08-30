<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>test</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <!--s sns_loginUl-->
    <ul class="sns_loginUl">
        <li>
            <a href="javascript:;" data-sns="highbuff" class="btn-sns sns_hibuff">
                <img src="<?= $data['url']['menu'] ?>/static/www/img/sub/sns_google.png">
            </a>
        </li>
    </ul>
    <!--e sns_loginUl-->
    <script>
        const snsUrl = {
            'highbuff': {
                'link': () => {
                    window.open('https://localinterviewr.highbuff.com/rest/authorize?client_id=29352915982374239857&redirect_uri=https://localinterviewr.highbuff.com/sns/highbuff/web/call&response_type=code&state=CIwNZNlR4XbisJF39I8yWnWX9wX4WFoz', '_blank', 'width=480,height=640');
                }
            }
        }

        $('.btn-sns').on("click", function() {
            const snsName = $(this).data("sns");
            snsUrl[snsName].link();
        })
    </script>
</body>

</html>