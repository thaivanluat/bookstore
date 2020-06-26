CREATE SEQUENCE S_MAPHIEUKIEM_ID
	MINVALUE 1
	NOMAXVALUE
	INCREMENT BY 1
	START WITH 1
	NOCACHE
	NOORDER
	NOCYCLE;

create table PHIEUKIEMKHO (
    MaPhieuKiem NUMBER(8,0) NOT NULL,
    NguoiTao NUMBER(8,0) NOT NULL,
    NgayKiem date NOT NULL
);

create table CHITIETPHIEUKIEMKHO (
    MaPhieuKiem NUMBER(8,0) NOT NULL,  
    MaSach NUMBER(8,0) NOT NULL,
    TonKho NUMBER(8,0) NOT NULL,
    ThucTe NUMBER(8,0) NOT NULL,
    GiaTriLech NUMBER(12,0) NOT NULL
);

ALTER TABLE PHIEUKIEMKHO
 ADD CONSTRAINT PHIEUKIEMKHO_NGUOIDUNG_FK FOREIGN KEY (NguoiKiem) REFERENCES NGUOIDUNG(MaNguoiDung)
 ADD CONSTRAINT PHIEUKIEMKHO_PK PRIMARY KEY (MaPhieuKiem)
/

ALTER TABLE CHITIETPHIEUKIEMKHO
 ADD CONSTRAINT CHITIETPHIEUKIEMKHO_PK PRIMARY KEY (MaPhieuKiem, MaSach)
 ADD CONSTRAINT CHITIETPHIEUKIEMKHO_PHIEUKIEMKHO_FK FOREIGN KEY (MaPhieuKiem) REFERENCES PHIEUKIEMKHO(MaPhieuKiem)
 ADD CONSTRAINT CHITIETPHIEUKIEMKHO_SACH_FK FOREIGN KEY (MaSach) REFERENCES SACH(MaSach)
/

create or replace trigger TRG_ADD_CHITIETPHIEUKIEM
before insert
on CHITIETPHIEUKIEMKHO
for each row
declare
    price SACH.DonGiaBan%TYPE;
    difference NUMBER(8,0);
    stock SACH.SoLuongTon%TYPE;
begin
    SELECT DONGIABAN,SOLUONGTON INTO price, stock
    FROM SACH
    WHERE MaSach = :new.MaSach;

    :new.TonKho := stock;
    difference := stock - :new.ThucTe;
    :new.GiaTriLech := price*abs(difference);

    UPDATE SACH
    SET SoLuongTon = :new.ThucTe
    where MaSach = :new.MaSach;
end;
/

create or replace trigger trg_delete_PhieuKiemKho
before delete
on PHIEUKIEMKHO
for each row
begin
    delete from CHITIETPHIEUKIEMKHO where MaPhieuKiem = :old.MaPhieuKiem;
end;