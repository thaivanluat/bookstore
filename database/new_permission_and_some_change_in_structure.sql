-- Bỏ bảng chi tiết tác giả
DROP TABLE CHITIETTACGIA;

ALTER TABLE DAUSACH 
ADD MaTacGia NUMBER(8,0) NOT NULL;

ALTER TABLE DAUSACH
 ADD CONSTRAINT DAUSACH_TACGIA_FK FOREIGN KEY (MaTacGia) REFERENCES TACGIA(MaTacGia)
/


-- Tạo bảng phân quyền
CREATE TABLE QUYENHAN (
	MaQuyenHan NUMBER(8,0) NOT NULL,
	TenQuyenHan NVARCHAR2(50) NOT NULL
);

CREATE TABLE PHANQUYENNGUOIDUNG (
    MaQuyenHan  NUMBER(8,0) NOT NULL,
    MaNguoiDung NUMBER(8,0) NOT NULL
);

ALTER TABLE QUYENHAN 
    ADD CONSTRAINT QUYENHAN_PK PRIMARY KEY (MaQuyenHan)

ALTER TABLE PHANQUYENNGUOIDUNG
 ADD CONSTRAINT PHANQUYENNGUOIDUNG_PK PRIMARY KEY (MaQuyenHan, MaNguoiDung)
 ADD CONSTRAINT PHANQUYEN_NGUOIDUNG_FK FOREIGN KEY (MaNguoiDung) REFERENCES NGUOIDUNG(MaNguoiDung)
 ADD CONSTRAINT PHANQUYEN_QUYENHAN_FK FOREIGN KEY (MaQuyenHan) REFERENCES QUYENHAN(MaQuyenHan)
/


-- Thêm người tạo cho hóa đơn 

ALTER TABLE HOADON 
ADD NguoiTao NUMBER(8,0) NOT NULL;

