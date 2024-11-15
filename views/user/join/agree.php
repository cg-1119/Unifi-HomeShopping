<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Document</title>
</head>

<body>
<div class="container">
    <div method-="GET" action="input.php">
        <div class="mt-5 d-flex flex-column justify-content-center">
            <div class="border-box">
                <input type="checkbox" id="check_all" hidden>
                <label for="check_all" class="label-box">
                    <i class="bi bi-check-circle" style="font-size: 1.5rem"></i>
                    <span>전체 동의하기</span>
                </label>
                <ul class="list-group">
                    <li class="list-group">
                        <label for="termsService" class="label-box">
                            <i class="bi bi-check-circle" style="font-size: 1.5rem"></i>
                            <span>홈쇼핑 이용약관</span>
                        </label>
                    </li>
                    <li class="list-group">
                        <label for="termsPrivacy" class="label-box">
                            <i class="bi bi-check-circle" style="font-size: 1.5rem"></i>
                            <span>개인정보 수집동의</span>
                        </label>
                    </li>
                </ul>
            </div>
            <div class="box">
                <div style="padding:24px; width: 100%; flex-direction: column;">
                    <input class="form-control" type="submit" value="다음으로">
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

    <?php
    include "../../home/footer.php";
    ?>
</body>

</html>