ALTER TABLE TACGIA
 ADD CONSTRAINT TACGIA_PK PRIMARY KEY (MaTacGia)
/

ALTER TABLE THELOAI
 ADD CONSTRAINT THELOAI_PK PRIMARY KEY (MaTheLoai)
/

ALTER TABLE DAUSACH
 ADD CONSTRAINT DAUSACH_PK PRIMARY KEY (MaDauSach)
 ADD CONSTRAINT DAUSACH_THELOAI_FK FOREIGN KEY (MaTheLoai) REFERENCES THELOAI(MaTheLoai)
/

ALTER TABLE SACH
 ADD CONSTRAINT SACH_PK PRIMARY KEY (MaSach)
 ADD CONSTRAINT SACH_DAUSACH_FK FOREIGN KEY (MaDauSach) REFERENCES DAUSACH(MaDauSach)
/

ALTER TABLE PHIEUNHAPSACH
 ADD CONSTRAINT PHIEUNHAPSACH_PK PRIMARY KEY (MaPhieuNhapSach)
/

ALTER TABLE KHACHHANG
 ADD CONSTRAINT KHACHHANG_PK PRIMARY KEY (MaKhachHang)
/

ALTER TABLE HOADON
 ADD CONSTRAINT HOADON_PK PRIMARY KEY (MaHoaDon)
 ADD CONSTRAINT HOADON_KHACHHANG_FK FOREIGN KEY (MaKhachHang) REFERENCES KHACHHANG(MaKhachHang)
/

ALTER TABLE PHIEUTHU
 ADD CONSTRAINT PHIEUTHU_PK PRIMARY KEY (MaPhieuThu)
 ADD CONSTRAINT PHIEUTHU_KHACHHANG_FK FOREIGN KEY (MaKhachHang) REFERENCES KHACHHANG(MaKhachHang)
/

ALTER TABLE CHITIETHOADON
 ADD CONSTRAINT CHITIETHOADON_PK PRIMARY KEY (MaHoaDon, MaSach)
 ADD CONSTRAINT CHITIETHOADON_HOADON_FK FOREIGN KEY (MaHoaDon) REFERENCES HOADON(MaHoaDon)
 ADD CONSTRAINT CHITIETHOADON_SACH_FK FOREIGN KEY (MaSach) REFERENCES SACH(MaSach)
/

ALTER TABLE CHITIETPHIEUNHAPSACH
 ADD CONSTRAINT CHITIETPHIEUNHAPSACH_PK PRIMARY KEY (MaPhieuNhapSach, MaSach)
 ADD CONSTRAINT CHITIETPHIEUNHAPSACH_PHIEUNHAPSACH_FK FOREIGN KEY (MaPhieuNhapSach) REFERENCES PHIEUNHAPSACH(MaPhieuNhapSach)
 ADD CONSTRAINT CHITIETPHIEUNHAPSACH_SACH_FK FOREIGN KEY (MaSach) REFERENCES SACH(MaSach)
/

ALTER TABLE CHITIETTACGIA 
 ADD CONSTRAINT CHITIETTACGIA_PK PRIMARY KEY (MaTacGia, MaDauSach)
 ADD CONSTRAINT CHITIETTACGIA_TACGIA_FK FOREIGN KEY (MaTacGia) REFERENCES TACGIA(MaTacGia)
 ADD CONSTRAINT CHITIETTACGIA_DAUSACH_FK FOREIGN KEY (MaDauSach) REFERENCES DAUSACH(MaDauSach)
/

--  ThiThi---
--------------------------------------------------------
--------------------------------------------------------
--  Năm xuất bản  >0 (SACH)---
--------------------------------------------------------
  ALTER TABLE SACH 
  ADD CONSTRAINT check_nam_xuat_ban CHECK (NAMXUATBAN > 0);

--------------------------------------------------------
--  Số Lượng Tồn >0 (SACH))---
--------------------------------------------------------
  ALTER TABLE SACH 
  ADD CONSTRAINT check_so_luong_ton_kho CHECK (SOLUONGTON >= 0);
--------------------------------------------------------
--  Đơn giá bán > 0 (SACH)---
--------------------------------------------------------
  ALTER TABLE SACH 
  ADD CONSTRAINT check_don_gia_ban CHECK (DONGIABAN > 0);
--------------------------------------------------------
--  Tổng tiền >= 0 (PHIEUNHAPSACH)---
--------------------------------------------------------
  ALTER TABLE PHIEUNHAPSACH 
  ADD CONSTRAINT check_tong_tien_phieu_nhap_sach CHECK (TONGTIEN >= 0);

  --RBTV SoTienThu > 0
ALTER TABLE PHIEUTHU ADD CONSTRAINT Check_SoTienThu CHECK (SoTienThu > 0);

--RBTV SoLuong > 0 (CHITIETHOADON)
ALTER TABLE CHITIETHOADON ADD CONSTRAINT Check_slg_cthd CHECK (Soluong > 0);

--RBTV DonGia > 0 (CHITIETHOADON)
ALTER TABLE CHITIETHOADON ADD CONSTRAINT Check_dongia_cthd CHECK (DonGia > 0);

ALTER TABLE CHITIETPHIEUNHAPSACH ADD CONSTRAINT CHECK_DonGiaNhap CHECK (DonGiaNhap > 0);
ALTER TABLE HOADON ADD CONSTRAINT CHECK_TongTien CHECK (TongTien >= 0);
ALTER TABLE HOADON ADD CONSTRAINT CHECK_SoTienTra CHECK (SoTienTra > 0);
ALTER TABLE KHACHHANG ADD CONSTRAINT CHECK_TongNo CHECK (TongNo >= 0);
