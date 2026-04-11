# Tài Liệu Đặc Tả Yêu Cầu Phần Mềm (SRS)
## Hệ Thống Web Bán Sách Trực Tuyến — **Book4u**

**Phiên bản**: 2.2  
**Nhóm**: 5  
**Ngày cập nhật**: 11/04/2026

---

## Mục Lục

1. [Giới Thiệu](#1-giới-thiệu)
2. [Mô Tả Tổng Quan Hệ Thống](#2-mô-tả-tổng-quan-hệ-thống)
3. [Yêu Cầu Chức Năng](#3-yêu-cầu-chức-năng)
4. [Yêu Cầu Phi Chức Năng](#4-yêu-cầu-phi-chức-năng)
5. [Thiết Kế Cơ Sở Dữ Liệu](#5-thiết-kế-cơ-sở-dữ-liệu)
6. [Kiến Trúc Hệ Thống](#6-kiến-trúc-hệ-thống)
7. [Giao Diện Người Dùng](#7-giao-diện-người-dùng)
8. [Ràng Buộc & Giả Định](#8-ràng-buộc--giả-định)

---

## 1. Giới Thiệu

### 1.1 Mục Đích

Tài liệu này mô tả đầy đủ các yêu cầu chức năng và phi chức năng của hệ thống website bán sách trực tuyến **Book4u**. Đây là tài liệu tham chiếu chính thức cho nhóm phát triển, kiểm thử, và các bên liên quan trong suốt vòng đời dự án.

### 1.2 Phạm Vi

Hệ thống Book4u là một nền tảng thương mại điện tử chuyên biệt cho sách, cung cấp:
- **Giao diện khách hàng**: duyệt, tìm kiếm, mua sách, quản lý đơn hàng và đánh giá.
- **Giao diện quản trị (Admin Panel)**: quản lý sách, danh mục, đơn hàng, người dùng và thống kê doanh thu.

### 1.3 Đối Tượng Sử Dụng Tài Liệu

| Đối tượng             | Mục đích sử dụng                              |
|-----------------------|-----------------------------------------------|
| Nhóm phát triển       | Triển khai đúng theo đặc tả                   |
| Kiểm thử viên         | Xây dựng test case dựa trên yêu cầu           |
| Giảng viên hướng dẫn  | Đánh giá phạm vi và chất lượng dự án          |

### 1.4 Định Nghĩa & Viết Tắt

| Ký hiệu    | Ý nghĩa                                    |
|------------|---------------------------------------------|
| SRS        | Software Requirements Specification        |
| MVC        | Model – View – Controller                  |
| CRUD       | Create – Read – Update – Delete            |
| COD        | Cash On Delivery (thanh toán khi nhận hàng) |
| NXB        | Nhà Xuất Bản                               |
| Admin      | Người quản trị hệ thống                    |
| Customer   | Khách hàng / người dùng cuối               |
| ISBN       | International Standard Book Number         |

---

## 2. Mô Tả Tổng Quan Hệ Thống

### 2.1 Tổng Quan Sản Phẩm

Book4u là website thương mại điện tử bán sách xây dựng theo mô hình **MVC tùy chỉnh** (PHP thuần). Hệ thống phục vụ hai nhóm người dùng chính: **khách hàng** (customer) và **quản trị viên** (admin).

### 2.2 Các Nhóm Người Dùng

#### 2.2.1 Khách Vãng Lai (Guest)
- Duyệt trang chủ, danh sách sách, chi tiết sách.
- Tìm kiếm sách theo từ khóa.
- Lọc sách theo danh mục.
- **Không thể** thêm vào giỏ hàng hay đặt hàng.

#### 2.2.2 Khách Hàng Đã Đăng Ký (Customer)
- Tất cả quyền của Guest.
- Thêm sách vào giỏ hàng, đặt hàng.
- Theo dõi lịch sử và trạng thái đơn hàng.
- **Hủy đơn hàng** khi đang ở trạng thái "Chờ xác nhận".
- **Cập nhật địa chỉ giao hàng** khi đang ở trạng thái "Chờ xác nhận".
- Viết đánh giá sách (chỉ khi đã mua và nhận hàng).
- Quản lý thông tin hồ sơ cá nhân (avatar, mật khẩu).

#### 2.2.3 Quản Trị Viên (Admin)
- Toàn quyền quản lý sách, danh mục, đơn hàng, người dùng.
- Xem thống kê doanh thu theo tháng (biểu đồ Chart.js).
- Tải lên ảnh bìa và ảnh xem trước sách.
- Quản lý trạng thái đơn hàng (tự động cập nhật thanh toán).

### 2.3 Môi Trường Hoạt Động

| Thành phần       | Công nghệ / Phiên bản         |
|------------------|-------------------------------|
| Ngôn ngữ backend | PHP 8.3                       |
| Cơ sở dữ liệu    | MySQL 8.4                     |
| Web server       | Apache (Laragon)              |
| Thư viện PHP     | PHPMailer (Gửi email)         |
| Frontend         | HTML5, CSS3, JavaScript (ES6+)|
| Thư viện JS      | Chart.js, Font Awesome 6      |
| Phông chữ        | Google Fonts (Inter, Outfit)  |

---

## 3. Yêu Cầu Chức Năng

### 3.1 Module Xác Thực (Authentication)

#### FR-AUTH-01: Đăng Ký Tài Khoản
- **Mô tả**: Người dùng đăng ký với email, họ tên và mật khẩu.
- **Đầu vào**: `full_name`, `email`, `password`, `confirm_password`, `agree_terms`.
- **Xử lý**:
  - Kiểm tra email không trùng lặp.
  - Mật khẩu >= 6 ký tự, xác nhận khớp nhau.
  - Lưu mật khẩu dưới dạng **bcrypt hash**.
  - **Bắt buộc đồng ý Điều khoản sử dụng** trước khi đăng ký.
- **Đầu ra**: Tài khoản `role = 'customer'`, tự động đăng nhập và chuyển về trang chủ.
- **Hỗ trợ AJAX**: Phản hồi JSON khi gửi từ form JavaScript.

#### FR-AUTH-02: Đăng Nhập
- **Mô tả**: Đăng nhập bằng email và mật khẩu.
- **Xử lý**:
  - Xác thực mật khẩu với `password_verify()`.
  - Kiểm tra `is_active = 1` (tài khoản không bị khóa).
  - **Bắt buộc đồng ý Điều khoản sử dụng**.
  - Lưu `user_id`, `user_name`, `user_role`, `user_avatar` vào `$_SESSION`.
- **Hỗ trợ AJAX**: Phản hồi JSON với redirect URL.

#### FR-AUTH-03: Đăng Xuất
- **Mô tả**: Hủy session và chuyển về trang đăng nhập.

#### FR-AUTH-04: Quên Mật Khẩu
- **Mô tả**: Yêu cầu khôi phục tài khoản khi quên mật khẩu thông qua email cá nhân.
- **Đầu vào**: `email`.
- **Xử lý**:
  - Kiểm tra email có hợp lệ và tồn tại trong hệ thống hay không.
  - Tạo ngẫu nhiên một mã OTP gồm 6 chữ số.
  - Lưu mã OTP vào `reset_token` và thiết lập `reset_expires_at` (15 phút) trong CSDL.
  - Sử dụng thư viện **PHPMailer** để gửi email chứa mã OTP đến người dùng.

#### FR-AUTH-05: Xác Thực OTP & Đặt Lại Mật Khẩu
- **Mô tả**: Sử dụng mã OTP để xác thực và thiết lập mật khẩu mới.
- **Xử lý**:
  - **Bước 1 (Xác thực OTP)**: Nhập mã OTP 6 chữ số. Kiểm tra khớp với `reset_token` và chưa quá hạn `reset_expires_at` trong CSDL. Nếu đúng, đánh dấu xác thực thành công trong session.
  - **Bước 2 (Đặt lại mật khẩu)**: Nhập `new_password`, `confirm_password` (tối thiểu 6 ký tự). Cần có session xác thực OTP trước đó. Hash mật khẩu bằng bcrypt và hệ thống xóa mã OTP cũ trong DB (SET NULL). Chuyển về trang đăng nhập.

---

### 3.2 Module Trang Chủ & Duyệt Sách

#### FR-HOME-01: Trang Chủ
- **Nội dung hiển thị**:
  - **Hero Section**: Tiêu đề, nút "Khám phá ngay", nút "Đăng ký" (ẩn khi đã đăng nhập), ảnh bìa 4 sách nổi bật.
  - **Danh mục**: Grid hiển thị tất cả danh mục kèm hình minh họa và số lượng sách.
  - **Sách bán chạy**: Tối đa 8 sách, sắp xếp `total_sold DESC`.
  - **Sách mới**: Tối đa 8 sách, sắp xếp `created_at DESC`.
  - **Sách kỹ năng sống**: Hiển thị riêng nếu danh mục tồn tại.
  - **Dịch vụ nổi bật**: Giao hàng nhanh, sách chính hãng, đổi trả 30 ngày, hỗ trợ 24/7.

#### FR-HOME-02: Danh Sách Sách
- **Chức năng lọc**: Theo danh mục, khoảng giá.
- **Sắp xếp**: Bán chạy, mới nhất, giá tăng/giảm, đánh giá cao.
- **Phân trang**: 12 sách/trang.

#### FR-HOME-03: Chi Tiết Sách
- Ảnh bìa chính + gallery ảnh xem trước (thumbnail slider).
- Tên sách, tác giả, đánh giá sao, số lượng đã bán.
- Giá bán, trạng thái tồn kho (còn hàng / hết hàng).
- Thông tin: NXB, năm XB, số trang, ngôn ngữ, ISBN, kích thước.
- Bộ chọn số lượng + nút "Thêm vào giỏ".
- Phần đánh giá + sách liên quan cùng danh mục.

#### FR-HOME-04: Tìm Kiếm Sách
- Ô tìm kiếm trên navbar với **gợi ý real-time (AJAX)** — tối đa 5 kết quả.
- Hiển thị **lịch sử tìm kiếm nhanh** bên dưới input.
- Trang kết quả tìm kiếm với phân trang.

#### FR-HOME-05: Điều Khoản Sử Dụng
- Trang `/terms` hiển thị nội dung điều khoản với các anchor link cho từng mục.

---

### 3.3 Module Giỏ Hàng (Cart)

#### FR-CART-01: Thêm Vào Giỏ Hàng
- **Điều kiện**: Đã đăng nhập, số lượng không vượt `stock_quantity`.
- **Xử lý**: Nếu sách đã có trong giỏ → cộng thêm số lượng. Lưu vào `cart_items`.

#### FR-CART-02: Xem Giỏ Hàng
- Danh sách sách, số lượng, đơn giá, thành tiền, tổng cộng.
- Cập nhật số lượng, xóa sản phẩm, nút "Tiếp tục mua" và "Đặt hàng".

#### FR-CART-03: Cập Nhật / Xóa Sản Phẩm
- Thay đổi số lượng hoặc xóa line item.

---

### 3.4 Module Đặt Hàng & Thanh Toán

#### FR-ORDER-01: Thanh Toán (Checkout)
- **Đầu vào**: Họ tên người nhận, SĐT, địa chỉ giao hàng, ghi chú, phương thức thanh toán (COD / chuyển khoản / ví điện tử / thẻ tín dụng).
- **Xử lý**:
  - Phí vận chuyển: miễn nếu `subtotal >= 300.000₫`, ngược lại **30.000₫**.
  - Tạo `order_code` dạng `ORD-YYYYMMDD-XXX`.
  - Lưu vào `orders` + `order_items`, xóa giỏ hàng.

#### FR-ORDER-02: Lịch Sử Đơn Hàng
- Hiển thị tất cả đơn hàng kèm: mã đơn, ngày đặt, sản phẩm, tổng tiền, trạng thái.
- Mỗi đơn hàng hiển thị danh sách sách kèm ảnh, số lượng, giá.

#### FR-ORDER-03: Hủy Đơn Hàng (Customer)
- **Điều kiện**: Đơn hàng ở trạng thái `pending` (Chờ xác nhận) VÀ thuộc về user đang đăng nhập.
- **Xử lý**: Cập nhật `order_status = 'cancelled'`, ghi nhận `cancelled_at`.
- **Giao diện**: Nút "Hủy đơn" với xác nhận (confirm dialog) trước khi thực hiện.

#### FR-ORDER-04: Cập Nhật Địa Chỉ Giao Hàng (Customer)
- **Điều kiện**: Đơn hàng ở trạng thái `pending` VÀ thuộc về user đang đăng nhập.
- **Đầu vào**: Tên người nhận, số điện thoại, địa chỉ giao hàng.
- **Giao diện**: Form inline có thể ẩn/hiện, pre-fill dữ liệu hiện tại.

#### FR-ORDER-05: Tracking Trạng Thái Đơn Hàng
- **Các trạng thái**:
  1. `pending` — Chờ xác nhận
  2. `confirmed` — Đã xác nhận
  3. `shipping` — Đang giao hàng
  4. `delivered` — Đã giao hàng
  5. `cancelled` — Đã hủy
  6. `returned` — Đã trả hàng

#### FR-ORDER-06: Tự Động Cập Nhật Trạng Thái Thanh Toán
- Khi `order_status` → `delivered`: `payment_status` tự động chuyển thành `paid` (Đã thanh toán).
- Khi `order_status` → `returned`: `payment_status` tự động chuyển thành `refunded` (Hoàn tiền).

---

### 3.5 Module Đánh Giá Sách (Reviews)

#### FR-REVIEW-01: Viết Đánh Giá
- **Điều kiện**: Đã đăng nhập + đã mua sách (đơn `delivered`) + chưa đánh giá trước đó.
- **Đầu vào**: Số sao (1–5), nội dung bình luận.
- **Xử lý**: Lưu vào `reviews`. Trigger MySQL tự động tính lại `avg_rating`.

#### FR-REVIEW-02: Hiển Thị Đánh Giá
- Trang chi tiết sách hiển thị: avatar, tên, số sao, ngày, nội dung bình luận.

---

### 3.6 Module Tài Khoản Người Dùng

#### FR-ACCOUNT-01: Dashboard Cá Nhân
- Xem thông tin hồ sơ: họ tên, email, SĐT.

#### FR-ACCOUNT-02: Cập Nhật Avatar
- Upload ảnh đại diện: JPG, PNG, WebP, GIF — tối đa 5MB.
- Tên file: `avatar_{userId}_{timestamp}.ext`.

#### FR-ACCOUNT-03: Đổi Mật Khẩu
- Xác thực mật khẩu hiện tại → nhập mật khẩu mới >= 6 ký tự + xác nhận.

---

### 3.7 Module Quản Trị — Sách (Admin Books)

#### FR-ADMIN-BOOK-01: Danh Sách Sách
- Hiển thị phân trang (15 sách/trang) kèm: tên, danh mục, giá, tồn kho, trạng thái, hành động.

#### FR-ADMIN-BOOK-02: Thêm Sách
- **Đầu vào**: Tên sách, ISBN, danh mục, năm XB, số trang, ngôn ngữ, giá, tồn kho, mô tả, tác giả (phân cách dấu phẩy), ảnh bìa, ảnh xem trước (nhiều file).
- **Xử lý**: Tự động tạo `slug`, liên kết tác giả qua `book_authors`.

#### FR-ADMIN-BOOK-03: Sửa Sách
- Chỉnh sửa thông tin, thêm ảnh xem trước, cập nhật tác giả.

#### FR-ADMIN-BOOK-04: Ẩn Sách
- Đánh dấu `is_active = 0` (soft delete).

---

### 3.8 Module Quản Trị — Danh Mục (Admin Categories)

#### FR-ADMIN-CAT-01: Quản Lý Danh Mục
- CRUD đầy đủ: tên, mô tả, hình ảnh minh họa (upload).
- Hiển thị kèm số lượng sách thuộc danh mục.

---

### 3.9 Module Quản Trị — Đơn Hàng (Admin Orders)

#### FR-ADMIN-ORDER-01: Danh Sách Đơn Hàng
- Hiển thị tất cả đơn + lọc theo trạng thái.
- Thông tin: mã đơn, khách hàng, email, tổng tiền, trạng thái thanh toán, trạng thái đơn, ngày.

#### FR-ADMIN-ORDER-02: Chi Tiết Đơn Hàng
- Thông tin đầy đủ: sản phẩm, thông tin giao hàng, thông tin khách hàng.

#### FR-ADMIN-ORDER-03: Cập Nhật Trạng Thái
- Admin thay đổi `order_status`.
- Khi giao thành công (`delivered`): kiểm tra tồn kho đủ không → trigger MySQL trừ stock + cộng `total_sold`.
- **Tự động cập nhật `payment_status`**: `delivered` → `paid`, `returned` → `refunded`.

---

### 3.10 Module Quản Trị — Người Dùng (Admin Users)

#### FR-ADMIN-USER-01: Danh Sách Người Dùng
- Hiển thị: email, họ tên, vai trò, trạng thái, ngày tạo.

#### FR-ADMIN-USER-02: Khóa / Mở Khóa Tài Khoản
- Toggle `is_active` giữa 0 và 1.

#### FR-ADMIN-USER-03: Xóa Người Dùng
- Ràng buộc: không thể xóa nếu có đơn hàng (FK `RESTRICT`).

---

### 3.11 Module Quản Trị — Dashboard & Thống Kê

#### FR-ADMIN-DASH-01: Dashboard Tổng Quan
- 4 chỉ số KPI: tổng sách, tổng users, tổng đơn, tổng doanh thu (từ đơn `delivered`).
- 5 đơn hàng gần nhất + top 5 sách bán chạy.

#### FR-ADMIN-DASH-02: Biểu Đồ Doanh Thu
- Biểu đồ đường (Chart.js) — doanh thu 12 tháng gần nhất.
- API: `/admin/revenue-data` trả JSON.

---

## 4. Yêu Cầu Phi Chức Năng

### 4.1 Hiệu Năng

| Tiêu chí                          | Mục tiêu                      |
|------------------------------------|-------------------------------|
| Thời gian tải trang chủ           | < 3 giây (localhost)          |
| Thời gian phản hồi AJAX tìm kiếm | < 500ms                       |
| Xử lý đồng thời                   | Tối thiểu 50 users            |

### 4.2 Bảo Mật

- **Mật khẩu**: Hash bằng `password_hash()` — bcrypt.
- **SQL Injection**: PDO Prepared Statements cho mọi truy vấn.
- **XSS**: `htmlspecialchars()` khi hiển thị dữ liệu người dùng.
- **Phân quyền**: Kiểm tra `$_SESSION['user_role'] === 'admin'` trước mọi tác vụ admin.
- **Upload File**: Giới hạn định dạng (JPG, PNG, WebP, GIF) và kích thước (<= 5MB).
- **Kiểm tra sở hữu đơn hàng**: Verify `user_id` trước khi cho phép hủy đơn / cập nhật địa chỉ.

### 4.3 Khả Dụng

- Responsive desktop & tablet (>= 768px).
- Flash message thông báo thành công / thất bại.
- Breadcrumb navigation.
- Trang 404 tùy chỉnh.
- Confirm dialog trước các hành động nguy hiểm (hủy đơn, xóa...).

### 4.4 Khả Năng Bảo Trì

- Kiến trúc MVC rõ ràng, tách biệt logic và giao diện.
- JavaScript modular hóa: `cart.js`, `search.js`, `auth.js`, `payment.js`, `product.js`, `alerts.js`, `animations.js`, `ui.js`.
- CSS tổ chức theo vai trò: `style.css`, `components.css`, `pages.css`, `admin.css`.

### 4.5 Tương Thích

- Trình duyệt: Chrome, Firefox, Edge (phiên bản mới nhất).
- Môi trường: Laragon — PHP 8.3, MySQL 8.4.

---

## 5. Thiết Kế Cơ Sở Dữ Liệu

### 5.1 Sơ Đồ Quan Hệ (ERD)

```
users ──< cart_items >── books
users ──< orders >──< order_items >── books
users ──< reviews >── books
books >── book_authors >── authors
books >── book_images
books ──> categories
books ──> publishers
orders ──< order_status_history
users ──< addresses
users ──< wishlists >── books
```

### 5.2 Mô Tả Các Bảng Chính

#### Bảng `users` — Người Dùng

| Cột             | Kiểu dữ liệu             | Mô tả                         |
|-----------------|--------------------------|--------------------------------|
| `user_id`          | INT UNSIGNED PK AI       | Khóa chính                    |
| `email`            | VARCHAR(255) UNIQUE      | Email đăng nhập               |
| `password_hash`    | VARCHAR(255)             | Mật khẩu hash (bcrypt)        |
| `full_name`        | NVARCHAR(150)            | Họ và tên                     |
| `phone`            | VARCHAR(20)              | Số điện thoại                 |
| `avatar_url`       | VARCHAR(500)             | Đường dẫn ảnh đại diện        |
| `role`             | ENUM('customer','admin') | Vai trò                       |
| `is_active`        | TINYINT(1)               | 1 = hoạt động, 0 = bị khóa   |
| `reset_token`      | VARCHAR(64)              | Mã OTP quên mật khẩu          |
| `reset_expires_at` | DATETIME                 | Hạn sử dụng OTP               |
| `created_at`       | DATETIME                 | Thời điểm tạo                |

#### Bảng `books` — Sách

| Cột                | Kiểu dữ liệu        | Mô tả                           |
|--------------------|---------------------|----------------------------------|
| `book_id`          | INT UNSIGNED PK AI  | Khóa chính                      |
| `title`            | NVARCHAR(300)       | Tên sách                        |
| `slug`             | VARCHAR(350) UNIQUE | URL thân thiện                  |
| `isbn`             | VARCHAR(20) UNIQUE  | Mã ISBN                         |
| `publisher_id`     | INT UNSIGNED FK     | Nhà xuất bản                    |
| `category_id`      | INT UNSIGNED FK     | Danh mục                        |
| `publication_year` | SMALLINT            | Năm xuất bản                    |
| `pages`            | SMALLINT            | Số trang                        |
| `language`         | VARCHAR(50)         | Ngôn ngữ (mặc định: Tiếng Việt) |
| `price`            | DECIMAL(12,2)       | Giá bán (VND)                   |
| `stock_quantity`   | INT UNSIGNED        | Tồn kho                        |
| `description`      | TEXT                | Mô tả sách                     |
| `cover_image`      | VARCHAR(500)        | Đường dẫn ảnh bìa              |
| `is_active`        | TINYINT(1)          | Hiển thị / ẩn                   |
| `avg_rating`       | DECIMAL(2,1)        | Đánh giá TB (0–5)              |
| `total_sold`       | INT UNSIGNED        | Tổng đã bán                    |

#### Bảng `orders` — Đơn Hàng

| Cột                | Kiểu dữ liệu | Mô tả                                                            |
|--------------------|--------------|-------------------------------------------------------------------|
| `order_id`         | INT PK AI    | Khóa chính                                                       |
| `order_code`       | VARCHAR(30)  | Mã đơn (VD: ORD-20260405-001)                                   |
| `user_id`          | INT FK       | Khách đặt hàng                                                   |
| `receiver_name`    | NVARCHAR(150)| Tên người nhận                                                   |
| `receiver_phone`   | VARCHAR(20)  | SĐT người nhận                                                   |
| `shipping_address` | NVARCHAR(500)| Địa chỉ giao hàng                                                |
| `subtotal`         | DECIMAL(14,2)| Tổng tiền hàng                                                   |
| `shipping_fee`     | DECIMAL(12,2)| Phí vận chuyển                                                   |
| `total_amount`     | DECIMAL(14,2)| Tổng thanh toán                                                  |
| `payment_method`   | ENUM         | cod / bank_transfer / e_wallet / credit_card                     |
| `payment_status`   | ENUM         | unpaid / paid / refunded                                         |
| `order_status`     | ENUM         | pending / confirmed / shipping / delivered / cancelled / returned |
| `note`             | NVARCHAR(500)| Ghi chú                                                          |
| `ordered_at`       | DATETIME     | Ngày đặt hàng                                                   |
| `confirmed_at`     | DATETIME     | Ngày xác nhận                                                    |
| `shipped_at`       | DATETIME     | Ngày giao                                                        |
| `delivered_at`     | DATETIME     | Ngày nhận                                                        |
| `cancelled_at`     | DATETIME     | Ngày hủy                                                         |

#### Các Bảng Phụ

| Bảng                   | Mô tả                                            |
|------------------------|---------------------------------------------------|
| `categories`           | Danh mục sách (hỗ trợ parent_id đa cấp)          |
| `authors`              | Tác giả (tên, tiểu sử, avatar)                   |
| `book_authors`         | Liên kết N-N sách ↔ tác giả                      |
| `book_images`          | Ảnh xem trước sách (sort_order)                   |
| `publishers`           | Nhà xuất bản                                      |
| `reviews`              | Đánh giá (UNIQUE user_id + book_id, rating 1–5)  |
| `cart_items`           | Giỏ hàng (UNIQUE user_id + book_id)              |
| `order_items`          | Chi tiết đơn hàng (book_id, quantity, unit_price) |
| `order_status_history` | Lịch sử thay đổi trạng thái đơn                  |
| `addresses`            | Địa chỉ giao hàng (nhiều địa chỉ/user)           |
| `wishlists`            | Sách yêu thích (CSDL có, UI chưa triển khai)     |

### 5.3 Database Views & Triggers

#### View `vw_book_details`
Tổng hợp thông tin sách kèm tên danh mục, nhà xuất bản, và danh sách tác giả (GROUP_CONCAT).

#### View `vw_monthly_revenue`
Doanh thu, số đơn giao thành công, số đơn hủy theo tháng/năm cho dashboard admin.

#### Trigger `trg_orders_after_update_status`
Khi đơn → `delivered`: tự động **trừ** `stock_quantity`, **cộng** `total_sold` cho từng sách.

#### Trigger `trg_reviews_after_insert/update/delete`
Tự động tính lại `avg_rating` của sách khi reviews thay đổi.

---

## 6. Kiến Trúc Hệ Thống

### 6.1 Mô Hình MVC

```
HTTP Request
    │
    ▼
public/index.php (Entry Point + Route Definitions)
    │
    ▼
Router.php (Phân tích URL → Controller::Action)
    │
    ▼
Controller (Business Logic)
    │          │
    ▼          ▼
 Model        View
(PDO+MySQL) (HTML Output + Layout)
```

### 6.2 Cấu Trúc Thư Mục

```
tnmd_nhom_5/
├── public/                          # Document root (Apache)
│   ├── index.php                    # Entry point + route definitions
│   ├── .htaccess                    # URL rewrite
│   ├── css/
│   │   ├── style.css                # CSS chung & design tokens
│   │   ├── components.css           # Components tái sử dụng
│   │   ├── pages.css                # CSS riêng từng trang
│   │   └── admin.css                # CSS Admin Panel
│   ├── js/
│   │   ├── main.js                  # Entry point JS
│   │   └── modules/                 # 8 modules JS tách biệt
│   │       ├── alerts.js            # Flash messages
│   │       ├── animations.js        # Micro-animations
│   │       ├── auth.js              # Login/Register AJAX
│   │       ├── cart.js              # Giỏ hàng
│   │       ├── payment.js           # Thanh toán
│   │       ├── product.js           # Chi tiết sách
│   │       ├── search.js            # Tìm kiếm AJAX
│   │       └── ui.js                # UI interactions
│   └── images/
│       ├── books/                   # Ảnh bìa & xem trước
│       ├── categories/              # Ảnh minh họa danh mục
│       └── avatars/                 # Ảnh đại diện
│
├── app/
│   ├── config/database.php          # Cấu hình MySQL
│   ├── core/
│   │   ├── PHPMailer/               # Thư viện PHPMailer
│   │   ├── Mailer.php               # Class hỗ trợ gửi email
│   │   ├── Router.php               # Định tuyến URL (regex)
│   │   ├── Controller.php           # Base Controller
│   │   ├── Model.php                # Base Model (PDO)
│   │   └── Database.php             # Singleton DB connection
│   ├── controllers/                 # 7 controllers
│   │   ├── HomeController.php       # Trang chủ, điều khoản
│   │   ├── BookController.php       # Sách, tìm kiếm, đánh giá
│   │   ├── CartController.php       # Giỏ hàng
│   │   ├── OrderController.php      # Đặt hàng, lịch sử, hủy đơn
│   │   ├── AuthController.php       # Đăng ký, đăng nhập
│   │   ├── AccountController.php    # Hồ sơ, avatar, mật khẩu
│   │   └── AdminController.php      # Toàn bộ admin CRUD
│   ├── models/                      # 5 models
│   │   ├── Book.php, Category.php, Cart.php, Order.php, User.php
│   └── views/
│       ├── layouts/main.php         # Layout khách hàng
│       ├── home/index.php           # Trang chủ
│       ├── books/{index,detail,search}.php
│       ├── cart/index.php
│       ├── orders/{checkout,history}.php
│       ├── auth/{login,register}.php
│       ├── account/dashboard.php
│       ├── partials/book_card.php
│       ├── errors/404.php
│       └── admin/                   # Admin panel views
│           ├── layouts/main.php
│           ├── dashboard.php
│           ├── books/{index,form}.php
│           ├── categories/{index,form}.php
│           ├── orders/{index,detail}.php
│           └── users/index.php
│
└── database/
    ├── bookstore.sql                # Schema DDL
    └── seed_data.sql                # Dữ liệu mẫu
```

### 6.3 Luồng Xử Lý Request

```
1. Người dùng gửi HTTP request
2. Apache .htaccess rewrite → public/index.php
3. Router.php phân tích URL → xác định Controller::Action
4. Controller được khởi tạo, gọi Model(s) nếu cần
5. Model thực thi truy vấn PDO với MySQL
6. Controller truyền dữ liệu vào View
7. Layout bao bọc View → render HTML hoàn chỉnh
8. Response trả về trình duyệt
```

---

## 7. Giao Diện Người Dùng

### 7.1 Bản Đồ Trang (Sitemap)

#### Giao diện Khách Hàng

| Trang                    | URL                               | Mô tả                           |
|--------------------------|-----------------------------------|----------------------------------|
| Trang chủ                | `/`                               | Hero, danh mục, sách nổi bật    |
| Danh sách sách           | `/books`                          | Grid sách + bộ lọc + sắp xếp   |
| Chi tiết sách            | `/book/{id}`                      | Thông tin + đánh giá            |
| Tìm kiếm                 | `/search?q=...`                   | Kết quả tìm kiếm               |
| Danh mục                 | `/category/{id}`                  | Sách theo danh mục             |
| Giỏ hàng                 | `/cart`                           | Xem & chỉnh sửa giỏ           |
| Thanh toán                | `/checkout`                       | Form đặt hàng                  |
| Lịch sử đơn hàng         | `/orders`                         | Đơn hàng + hủy/cập nhật       |
| Hủy đơn hàng             | `/orders/cancel/{id}`             | POST — hủy đơn pending         |
| Cập nhật địa chỉ          | `/orders/update-address/{id}`     | POST — sửa địa chỉ pending    |
| Đăng nhập                | `/login`                          | Form đăng nhập                 |
| Đăng ký                  | `/register`                       | Form đăng ký                   |
| Quên mật khẩu            | `/forgot-password`                | Yêu cầu khôi phục mật khẩu     |
| Xác thực OTP             | `/verify-otp`                     | Nhập mã xác thực OTP từ email |
| Đặt lại mật khẩu         | `/reset-password`                 | Form đặt lại mật khẩu mới      |
| Hồ sơ cá nhân            | `/account`                        | Dashboard người dùng           |
| Cập nhật avatar          | `/account/avatar`                 | POST — upload ảnh đại diện    |
| Đổi mật khẩu             | `/account/password`               | POST — đổi mật khẩu           |
| Điều khoản               | `/terms`                          | Trang điều khoản sử dụng      |

#### Giao diện Quản Trị (Admin)

| Trang                    | URL                                | Mô tả                            |
|--------------------------|------------------------------------|-----------------------------------|
| Dashboard                | `/admin`                           | KPI + biểu đồ doanh thu         |
| API Doanh thu            | `/admin/revenue-data`              | JSON data cho Chart.js           |
| Quản lý sách             | `/admin/books`                     | Danh sách + phân trang           |
| Thêm sách                | `/admin/books/add`                 | Form thêm sách mới              |
| Sửa sách                 | `/admin/books/edit/{id}`           | Form chỉnh sửa                  |
| Ẩn sách                  | `/admin/books/delete/{id}`         | Soft delete                      |
| Quản lý danh mục         | `/admin/categories`                | CRUD danh mục                    |
| Thêm danh mục            | `/admin/categories/add`            | Form thêm danh mục              |
| Sửa danh mục             | `/admin/categories/edit/{id}`      | Form sửa danh mục               |
| Xóa danh mục             | `/admin/categories/delete/{id}`    | Xóa danh mục                    |
| Quản lý đơn hàng         | `/admin/orders`                    | Danh sách + lọc trạng thái      |
| Chi tiết đơn hàng        | `/admin/orders/detail/{id}`        | Xem + cập nhật trạng thái       |
| Cập nhật trạng thái      | `/admin/orders/update-status/{id}` | POST — đổi trạng thái           |
| Quản lý người dùng       | `/admin/users`                     | Danh sách users                  |
| Khóa/Mở người dùng      | `/admin/users/toggle/{id}`         | Toggle is_active                 |
| Xóa người dùng           | `/admin/users/delete/{id}`         | Xóa user                        |

### 7.2 Nguyên Tắc Thiết Kế UI

- **Color Scheme**: Tông xanh đậm (`--primary`), nền sáng, hỗ trợ dark mode.
- **Typography**: Inter/Outfit (Google Fonts); phân cấp rõ ràng h1–h4.
- **Components**: Card sách hover effect, badge HOT/NEW, micro-animations 0.2–0.3s.
- **Responsive**: Desktop-first, hỗ trợ từ 768px trở lên.
- **Icon**: Font Awesome 6.

---

## 8. Ràng Buộc & Giả Định

### 8.1 Ràng Buộc Kỹ Thuật

- Chạy trên LAMP stack cục bộ (Laragon) — chưa deploy production.
- Không tích hợp cổng thanh toán thực tế — chỉ mang tính chọn lựa UI.
- Không gửi email xác nhận đơn hàng tự động.
- Bảng `wishlists`, `addresses` đã thiết kế CSDL nhưng chưa triển khai UI.
- Danh mục chỉ hỗ trợ 1 cấp (parent_id tồn tại, chưa xử lý đa cấp).

### 8.2 Giả Định

- Mỗi người dùng chỉ có một vai trò: `customer` hoặc `admin`.
- Tài khoản Admin được cấp trực tiếp qua CSDL.
- Phí vận chuyển mặc định: **30.000₫**; miễn phí cho đơn từ **300.000₫**.
- Thị trường Việt Nam (tiền tệ VND, ngôn ngữ tiếng Việt).

### 8.3 Phụ Thuộc Hệ Thống

| Phụ thuộc      | Phiên bản | Ghi chú                         |
|----------------|-----------|----------------------------------|
| PHP            | >= 8.3    | Bắt buộc                        |
| MySQL          | >= 8.0    | Bắt buộc                        |
| Apache         | Bất kỳ    | Cần `mod_rewrite`               |
| Chart.js       | CDN       | Biểu đồ doanh thu admin         |
| Font Awesome 6 | CDN       | Icons toàn bộ hệ thống          |
| Google Fonts   | CDN       | Typography (Inter, Outfit)      |

---

*Tài liệu SRS phiên bản 2.2 — Nhóm 5 — Ngày 11/04/2026*
