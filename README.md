# Unifi Home Shopping
2024 창원대학교 정보통신공학과 DB 프로그래밍 텀프로젝트

유비쿼티 네트웍스의 제품을 소개하는 한글 쇼핑몰을 모의로 제작한 프로젝트입니다. 
현재 공식 Unifi 상품 페이지에는 한글 지원이 없기 때문에, 한글 사용자들에게 친숙한 인터페이스를 제공하는 가상의 홈쇼핑 웹 애플리케이션을 구현했습니다.
사용자는 상품을 검색하고, 장바구니에 담고, 결제를 진행할 수 있으며, 관리자 페이지를 통해 상품과 주문을 관리할 수 있습니다.

사용한 기술 스택은 다음과 같습니다.
- 프론트엔드: HTML, CSS(Bootstrap), JavaScript
- 벡엔드: PHP 8.1, MySQL 9.0

## 목차

- [주요 기능](#주요-기능)<br>
- [프로젝트 구조](#프로젝트-구조)<br>
- [사용 방법](#사용-방법)
- [Copyright](#Copyright)


## 주요 기능
### 사용자 기능
- 회원가입 및 로그인
- 상품 검색 및 카테고리별 조회
- 상품 상세 페이지 및 리뷰 작성
- 장바구니 추가 및 수정
- 주문 및 결제
### 관리자 기능
- 상품 등록, 수정, 삭제
- 주문 관리 (주문 내역 조회 및 상태 변경)
- 사용자 관리

## 프로젝트 구조
```
project-root/
├── config/        # 데이터베이스 설정 및 환경 설정
├── controllers/   # 로직 및 요청 처리
├── models/        # 데이터 모델
├── public/        # CSS 및 JS 파일
├── uploads/       # 업로드 저장
├── views/         # 사용자 인터페이스
│   ├── admin/     # 관리자 페이지
│   ├── main/      # 홈, 헤더, 푸터, copyright 페이지
│   ├── order/     # 주문 페이지
│   ├── products/  # 상품 관련 페이지
│   └── user/      # 사용자 관련 페이지
│       ├── cart/  # 장바구니 페이지
│       ├── find/  # 회원 정보 찾기 관련 페이지
│       └── join/  # 회원가입 페이지
│
└── README.md      # 프로젝트 설명 파일
```
### 구조 상세 설명
이 프로젝트의 디자인 패턴은 MVC 패턴을 사용하였습니다. (설명: https://developer.mozilla.org/ko/docs/Glossary/MVC)<br>
예시를 들어 설명해보겠습니다.
#### 1. 모델 설정
먼저 명세에 맞는 테이블을 생성합니다.
```sql
-- config/table.sql

CREATE TABLE users
(
    uid       INT AUTO_INCREMENT PRIMARY KEY,
    id        VARCHAR(30)  NOT NULL UNIQUE,
    pw        VARCHAR(255) NOT NULL,
    name      VARCHAR(10)  NOT NULL,
    email     VARCHAR(50)  NOT NULL UNIQUE,
    phone     VARCHAR(20)  NOT NULL UNIQUE,
    address   TEXT,
    activate_status ENUM('deactivate', 'activate') DEFAULT 'activate',
    is_admin  BOOLEAN DEFAULT 0
);
```
모델에서 필요한 기능을 구현
```php
// models/User.php

// 사용자 등록
public function setUser($id, $pw, $name, $email, $phone, $address)
{
    $pdo = $this->db->connect();
    try {
        $stmt = $pdo->prepare("INSERT INTO users (id, pw, name, email, phone, address) VALUES (:id, :pw, :name, :email, :phone, :address)");
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':pw', $pw, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("User Model setUser Exception: " . $e->getMessage());
        return false;
    }
}
```
#### 2. 뷰에서 컨트롤러에 요청
뷰에서 데이터를 입력받아 컨트롤러에 로직 처리 요청
```php
// views/user/join/verify.php
<form method="POST" action="/controllers/UserController.php" class="needs-validation" novalidate>
    <!-- Submit Button -->
    <input type="hidden" name="action" value="register">
    <button class="btn btn-secondary" type="submit">회원가입</button>
</form>
```
#### 3. 컨트롤러 설정
컨트롤러에서 요청을 받아 처리
```php
// controllers/UserController.php

public function register()
{
    $id = $_POST['id'] ?? null;
    $pw = $_POST['pw'] ?? null;
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $address = $_POST['address'] ?? null;
    
    if ($this->userModel->setUser($id, $hashed_pw, $name, $email, $phone, $address)) {
        echo "<script>alert('회원가입이 완료되었습니다!'); location.href = '/views/user/login.php';</script>";
    } else {
        echo "<script>alert('회원가입에 실패했습니다. 다시 시도해주세요.'); history.back();</script>";
    }
}

// 요청 처리
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controller = new UserController();

    switch ($_POST['action']) {
        case 'register': $controller->register(); break;
    }
}
```

## 사용 방법
### 1. XAMPP 세팅
학교에서 사용하는 APMSETUP은 지원중단된 프로그램입니다.
구 버전의 PHP를 제공하기 때문에 8.1 이상 버전을 지원하는 최신 XAMPP를 사용해야 합니다.
환경 세팅이 쉬워 추천합니다.

### 2. 프로젝트 클론 및 설정
```
git clone https://github.com/cg-1119/Unifi-HomeShopping.git
```

### 3. 데이터베이스 설정
MySQL에서 데이터베이스를 생성하고 config/database.php에서 연결 정보를 설정합니다.
```sql
CREATE DATABASE database_name;
USE database_name;
SOURCE config/table.sql;
```
Database 클래스 안의 필드값에 사용자 환경에 맞게 설정
```php
// config/Database.php
class Database {
    private $host = "localhost";
    private $port = 3306;
    private $user = "user_name";
    private $password = "user_password";
    private $dbname = "database_name";
}
```

## Copyright

이 프로젝트의 상품들은 모두 유비쿼터 네트웍스의 상품들로 저작권 또한 유비쿼터 네트웍스에 있습니다.<br>
또한 메인페이지의 이미지 또한 외부 리소스를 사용하였습니다.<br>
- page1.mp4 (출처: https://www.pexels.com/@pressmaster/)
- page2.jpg, page3.jpg (출처: https://kr.freepik.com/author/pikisuperstar)

더 자세한 내용은 views/main/copyright.php에서 확인하실 수 있습니다.









