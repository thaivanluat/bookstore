CREATE SEQUENCE S_MANGUOIDUNG_ID
	MINVALUE 1
	NOMAXVALUE
	INCREMENT BY 1
	START WITH 1
	NOCACHE
	NOORDER
	NOCYCLE;


create table NGUOIDUNG (
    MaNguoiDung NUMBER(8,0) NOT NULL,
    TenDangNhap NVARCHAR2(20) NOT NULL,
    HoTen  NVARCHAR2(20) NOT NULL,
    MatKhau NVARCHAR2(100) NOT NULL,
    DienThoai NVARCHAR2(15) NOT NULL,
    Email NVARCHAR2(30),
    NgaySinh date NOT NULL,
    NgayTao date NOT NULL,
    ChucVu NVARCHAR2(10) NOT NULL
);

ALTER TABLE NGUOIDUNG
    ADD CONSTRAINT NGUOIDUNG_PK PRIMARY KEY (MaNguoiDung)    
/

INSERT INTO NGUOIDUNG
VALUES (S_MANGUOIDUNG_ID.nextval,'admin','Admin','e10adc3949ba59abbe56e057f20f883e','0915222222','a@gmail.com',sysdate,sysdate,'admin');
INSERT INTO NGUOIDUNG
VALUES (S_MANGUOIDUNG_ID.nextval,'giamdoc','Giam doc 1','e10adc3949ba59abbe56e057f20f883e','0915222222','a@gmail.com',sysdate,sysdate,'manager');

INSERT INTO NGUOIDUNG
VALUES (S_MANGUOIDUNG_ID.nextval,'nhanvien','Nhan vien 1','e10adc3949ba59abbe56e057f20f883e','0915222222','a@gmail.com',sysdate,sysdate,'staff');