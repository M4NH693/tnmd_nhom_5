-- =====================================================
-- SEED DATA: Dữ liệu mẫu cho BookStore
-- Chạy file này SAU KHI đã chạy bookstore.sql
-- =====================================================

USE bookstore;

-- Tạo tài khoản Admin (mật khẩu: admin123)
INSERT INTO users (email, password_hash, full_name, phone, role, is_active) VALUES
('admin@bookstore.vn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', '0901234567', 'admin', 1);

-- Tạo tài khoản khách hàng mẫu (mật khẩu: password)
INSERT INTO users (email, password_hash, full_name, phone, role, is_active) VALUES
('nguyenvana@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nguyễn Văn A', '0912345678', 'customer', 1),
('tranthib@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Trần Thị B', '0923456789', 'customer', 1),
('levanc@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Lê Văn C', '0934567890', 'customer', 1);

-- Danh mục sách
INSERT INTO categories (category_name, slug, description, is_active) VALUES
('Văn học', 'van-hoc', 'Sách văn học Việt Nam và thế giới', 1),
('Kinh tế', 'kinh-te', 'Sách kinh tế, kinh doanh, tài chính', 1),
('Khoa học', 'khoa-hoc', 'Sách khoa học tự nhiên và xã hội', 1),
('Kỹ năng sống', 'ky-nang-song', 'Sách phát triển bản thân, kỹ năng', 1),
('Thiếu nhi', 'thieu-nhi', 'Sách dành cho thiếu nhi, truyện tranh', 1),
('Ngoại ngữ', 'ngoai-ngu', 'Sách học ngoại ngữ, từ điển', 1),
('Công nghệ', 'cong-nghe', 'Sách công nghệ thông tin, lập trình', 1),
('Lịch sử', 'lich-su', 'Sách lịch sử Việt Nam và thế giới', 1);

-- Nhà xuất bản
INSERT INTO publishers (publisher_name, address, phone, email) VALUES
('NXB Trẻ', 'TP. Hồ Chí Minh', '028-39316289', 'info@nxbtre.com.vn'),
('NXB Kim Đồng', 'Hà Nội', '024-39434730', 'info@nxbkimdong.com.vn'),
('NXB Tổng hợp TP.HCM', 'TP. Hồ Chí Minh', '028-38256804', 'info@nxbhcm.com.vn'),
('NXB Thế Giới', 'Hà Nội', '024-38253841', 'info@thegioipublishers.vn'),
('NXB Lao Động', 'Hà Nội', '024-38515380', 'info@nxblaodong.com.vn');

-- Tác giả
INSERT INTO authors (author_name, bio) VALUES
('Dale Carnegie', 'Tác giả người Mỹ, nổi tiếng với các sách về kỹ năng giao tiếp'),
('Paulo Coelho', 'Nhà văn Brazil, tác giả của Nhà Giả Kim'),
('Nguyễn Nhật Ánh', 'Nhà văn Việt Nam nổi tiếng với các tác phẩm dành cho thiếu nhi'),
('Yuval Noah Harari', 'Giáo sư sử học tại Đại học Hebrew'),
('Robert C. Martin', 'Kỹ sư phần mềm, tác giả của Clean Code'),
('Napoleon Hill', 'Tác giả người Mỹ, chuyên về thành công cá nhân'),
('Tô Hoài', 'Nhà văn Việt Nam, tác giả Dế Mèn Phiêu Lưu Ký'),
('Daniel Kahneman', 'Nhà tâm lý học, Nobel Kinh tế 2002');

-- Sách
INSERT INTO books (title, slug, isbn, publisher_id, category_id, publication_year, pages, language, price, stock_quantity, description, is_active, avg_rating, total_sold) VALUES
('Đắc Nhân Tâm', 'dac-nhan-tam', '978-604-1-12345', 1, 4, 2020, 320, 'Tiếng Việt', 89000, 150, 'Đắc nhân tâm là cuốn sách nổi tiếng nhất, bán chạy nhất của Dale Carnegie. Được xuất bản lần đầu vào năm 1936, đến nay sách đã được dịch ra hầu hết các thứ tiếng trên thế giới.', 1, 4.8, 2500),
('Nhà Giả Kim', 'nha-gia-kim', '978-604-1-12346', 4, 1, 2019, 228, 'Tiếng Việt', 75000, 200, 'Tiểu thuyết Nhà giả kim của Paulo Coelho như một câu chuyện cổ tích giản dị, nhân ái, giàu chất thơ, thấm đẫm những minh triết huyền bí.', 1, 4.6, 1800),
('Sapiens: Lược sử loài người', 'sapiens-luoc-su-loai-nguoi', '978-604-1-12347', 4, 3, 2021, 560, 'Tiếng Việt', 199000, 80, 'Sapiens is a book by Yuval Noah Harari, published in 2011. It surveys the entire length of human history, from the evolution of Homo sapiens.', 1, 4.7, 950),
('Clean Code', 'clean-code', '978-604-1-12348', 3, 7, 2018, 464, 'Tiếng Việt', 299000, 60, 'Cuốn sách hướng dẫn viết code sạch, rõ ràng và dễ bảo trì. Một cuốn sách kinh điển cho lập trình viên.', 1, 4.9, 700),
('Tôi Tài Giỏi, Bạn Cũng Thế', 'toi-tai-gioi-ban-cung-the', '978-604-1-12349', 1, 4, 2020, 276, 'Tiếng Việt', 110000, 120, 'Cuốn sách giúp bạn khám phá tiềm năng bản thân và phát triển kỹ năng.', 1, 4.3, 1500),
('Dế Mèn Phiêu Lưu Ký', 'de-men-phieu-luu-ky', '978-604-1-12350', 2, 5, 2019, 180, 'Tiếng Việt', 45000, 300, 'Tác phẩm kinh điển của nhà văn Tô Hoài dành cho thiếu nhi.', 1, 4.5, 3000),
('Tư Duy Nhanh & Chậm', 'tu-duy-nhanh-cham', '978-604-1-12351', 4, 3, 2021, 624, 'Tiếng Việt', 159000, 90, 'Cuốn sách kinh điển về tâm lý học hành vi của Daniel Kahneman.', 1, 4.7, 800),
('Think and Grow Rich', 'think-and-grow-rich', '978-604-1-12352', 3, 4, 2020, 320, 'Tiếng Việt', 95000, 100, 'Nghĩ giàu làm giàu - cuốn sách kinh điển của Napoleon Hill.', 1, 4.4, 1200),
('Cho Tôi Xin Một Vé Đi Tuổi Thơ', 'cho-toi-xin-mot-ve-di-tuoi-tho', '978-604-1-12353', 1, 1, 2018, 216, 'Tiếng Việt', 68000, 180, 'Tác phẩm nổi tiếng của Nguyễn Nhật Ánh, đưa bạn trở về tuổi thơ.', 1, 4.6, 2200),
('Mắt Biếc', 'mat-biec', '978-604-1-12354', 1, 1, 2019, 280, 'Tiếng Việt', 78000, 160, 'Câu chuyện tình yêu trong sáng của Nguyễn Nhật Ánh.', 1, 4.8, 2800),
('Homo Deus', 'homo-deus', '978-604-1-12355', 4, 3, 2022, 480, 'Tiếng Việt', 189000, 70, 'Lược sử tương lai - tiếp nối Sapiens của Yuval Noah Harari.', 1, 4.5, 500),
('English Grammar In Use', 'english-grammar-in-use', '978-604-1-12356', 5, 6, 2021, 380, 'Song ngữ', 185000, 100, 'Sách ngữ pháp tiếng Anh kinh điển, phù hợp cho người tự học.', 1, 4.6, 900);

-- Liên kết sách - tác giả
INSERT INTO book_authors (book_id, author_id) VALUES
(1, 1), (2, 2), (3, 4), (4, 5), (5, 1), (6, 7), (7, 8), (8, 6), (9, 3), (10, 3), (11, 4), (12, 5);

-- Đánh giá mẫu
INSERT INTO reviews (book_id, user_id, rating, comment) VALUES
(1, 2, 5, 'Sách rất hay, đã thay đổi cách tôi giao tiếp!'),
(1, 3, 5, 'Cuốn sách kinh điển, ai cũng nên đọc.'),
(2, 2, 4, 'Câu chuyện truyền cảm hứng, rất đáng đọc.'),
(2, 4, 5, 'Tuyệt vời! Đọc đi đọc lại nhiều lần.'),
(6, 3, 5, 'Tuổi thơ của bao thế hệ, sách quá hay.'),
(10, 2, 5, 'Mắt Biếc hay lắm, cảm động vô cùng.'),
(4, 4, 5, 'Must-read cho mọi lập trình viên!');

-- Đơn hàng mẫu
INSERT INTO orders (order_code, user_id, receiver_name, receiver_phone, shipping_address, subtotal, shipping_fee, total_amount, payment_method, payment_status, order_status, ordered_at) VALUES
('ORD-20260301-001', 2, 'Nguyễn Văn A', '0912345678', '123 Nguyễn Huệ, Q.1, TP.HCM', 164000, 30000, 194000, 'cod', 'paid', 'delivered', '2026-01-15 10:30:00'),
('ORD-20260302-001', 3, 'Trần Thị B', '0923456789', '456 Trần Hưng Đạo, Q.5, TP.HCM', 299000, 30000, 329000, 'bank_transfer', 'paid', 'delivered', '2026-01-20 14:00:00'),
('ORD-20260303-001', 4, 'Lê Văn C', '0934567890', '789 Lê Lợi, Q.1, TP.HCM', 388000, 30000, 418000, 'cod', 'paid', 'delivered', '2026-02-05 09:15:00'),
('ORD-20260304-001', 2, 'Nguyễn Văn A', '0912345678', '123 Nguyễn Huệ, Q.1, TP.HCM', 75000, 30000, 105000, 'e_wallet', 'paid', 'delivered', '2026-02-14 16:45:00'),
('ORD-20260305-001', 3, 'Trần Thị B', '0923456789', '456 Trần Hưng Đạo, Q.5, TP.HCM', 247000, 30000, 277000, 'cod', 'paid', 'delivered', '2026-03-01 11:20:00'),
('ORD-20260306-001', 4, 'Lê Văn C', '0934567890', '789 Lê Lợi, Q.1, TP.HCM', 159000, 30000, 189000, 'credit_card', 'unpaid', 'pending', '2026-03-15 08:30:00'),
('ORD-20260307-001', 2, 'Nguyễn Văn A', '0912345678', '123 Nguyễn Huệ, Q.1, TP.HCM', 185000, 30000, 215000, 'cod', 'unpaid', 'confirmed', '2026-03-16 10:00:00');

-- Order items cho các đơn hàng
INSERT INTO order_items (order_id, book_id, quantity, unit_price, total_price) VALUES
(1, 1, 1, 89000, 89000), (1, 2, 1, 75000, 75000),
(2, 4, 1, 299000, 299000),
(3, 3, 1, 199000, 199000), (3, 7, 1, 159000, 159000), (3, 6, 1, 45000, 45000),
(4, 2, 1, 75000, 75000),
(5, 1, 1, 89000, 89000), (5, 7, 1, 159000, 159000),
(6, 7, 1, 159000, 159000),
(7, 12, 1, 185000, 185000);
