@include("layouts.master")

<!doctype html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>글 쓰기</title>

    <style>
        .realContentDiv {
            width: 100%;
            height: 85%;
            display: flex;
            flex-direction: column;
        }

        .contentBoxDiv {
            width: 100%;
            height: 95%;
            margin-top: 3%;
        }

        .txtContent {
            width: 100%;
            height: 100%;
        }

        .titleBoxDiv {
            width: 100%;
            height: 40px;
        }

        .txtTitle {
            width: 100%;
            height: 100%;
            line-height: 40px;
        }

    </style>
</head>
<body>
    <div class="mainDiv">
        @yield("nav")
        <div class="contentDiv">
            <div class="subContentDiv">
                <div class="categoryDiv">
                    My Story > 글쓰기
                </div>
                <div class="realContentDiv">
                    <div class="titleBoxDiv">
                        <input name="txtTitle" class="txtTitle" type="text" placeholder="제목을 입력해주세요">
                    </div>
                    <div class="contentBoxDiv">
                        <textarea name="txtContent" class="txtContent" id="" cols="30" rows="10" placeholder="내용을 입력해주세요"></textarea>
                    </div>
                </div>
                <hr>
                <div class="contentFootDiv">
                    <div class="buttonDiv">
                        <button>글쓰기</button>
                        <button>취소</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>