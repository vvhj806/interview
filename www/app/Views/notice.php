<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> 서비스 점검 </title>
</head>

<body>
    <div id="wrap">
        <div class="server_text">
            <h1>서비스 점검 안내</h1>
            <p></p>
        </div>
        <div class="server_text_ud">
            <p>

                서버 안정화를 위해 서비스 점검을 실시합니다.<br>
                고객 여러분들의 너그러운 양해 부탁드리며, 자세한 사항은 아래 내용을 확인해주시기 바랍니다.<br><br><br>
                ▣ 점검시간과 작업영향<br>
                <b style="color:red">- 6월 7일 12:00 ~ 6월 7일 24:00 </b><br>
                <b>: 서비스 점검</b><br><br>
                점검 상황에 따라 조기 종료 및 연장될 수 있습니다.<br>
                내용 참고하셔서 이용에 불편 없으시길 바랍니다.<br>
                감사합니다.<br>
            <h3>하이버프인터뷰</h3>
            </p>
        </div>

    </div>

    <style>
        * {
            margin: 0 auto;
            padding: 0;
            color: #000;

        }

        body {
            box-sizing: border-box;
            width: 100%;
        }

        #wrap {
            text-align: center;
            text-align: center;
            margin-top: 50px;
            width: 60%;
            overflow: hidden;
        }

        img {
            width: 30%
        }

        .server_text {
            background-color: #5360AE;
            width: 100%;
            text-align: center;
            margin-top: 50px;
        }

        .server_text>h1 {
            color: #fff;
            font-size: 36px;
            padding-top: 30px;
        }

        .server_text>p {
            color: #fff;
            font-size: 24px;
            padding-bottom: 30px;
        }

        .server_text_ud {
            border-bottom: 1px solid #5360AE;
            width: 100%;
        }

        .server_text_ud>p {
            font-size: 20px;
            font-weight: 500;
            padding: 50px 0 50px 0;
        }

        /*    mobile    */
        @media (max-width:1024px) {
            #wrap {
                text-align: center;
                text-align: center;
                margin-top: 50px;
                width: 80%;
                overflow: hidden;
            }

            img {
                width: 40%
            }

            .server_text {
                background-color: #5360AE;
                width: 100%;
                text-align: center;
                padding: 0px;
                margin-top: 50px;
                text-align: center;
            }

            .server_text>h1 {
                color: #fff;
                font-size: 36px;
                padding-top: 30px;
            }

            .server_text>p {
                color: #fff;
                font-size: 24px;
                padding-bottom: 30px;
            }

            .server_text_ud {
                border-bottom: 1px solid #5360AE;
                width: 100%;
                padding: 0px;
            }

            .server_text_ud>p {
                font-size: 18px;
                font-weight: 500;
                padding: 40px 0 40px 0;
            }
        }

        @media (max-width:640px) {
            #wrap {
                width: 90%;

            }

            img {
                width: 40%
            }

            .server_text>h1 {
                font-size: 24px;
                padding-top: 20px;
            }

            .server_text>p {
                font-size: 16px;
                padding-bottom: 20px;
            }

            .server_text_ud {
                border-bottom: 1px solid #5360AE;
                width: 100%;
                padding: 0px;
            }

            .server_text_ud>p {
                font-size: 10px;
                font-weight: 500;
                padding: 30px;
            }
        }
    </style>
</body>

</html>