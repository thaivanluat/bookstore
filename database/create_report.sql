create table BAOCAOTON (
    MaSach NUMBER(8,0) NOT NULL,
    NgayNhap DATE NOT NULL, 
    TonDau NUMBER(8,0) NOT NULL,
    TonCuoi NUMBER(8,0) NOT NULL,
    PhatSinh NUMBER(12,0) NOT NULL
);

create table BAOCAOCONGNO (
    MaKhachHang NUMBER(8,0) NOT NULL,
    NgayNhap DATE NOT NULL, 
    NoDau NUMBER(12,0) NOT NULL,
    NoCuoi NUMBER(12,0) NOT NULL,
    PhatSinh NUMBER(12,0) NOT NULL
);

ALTER TABLE BAOCAOTON
 ADD CONSTRAINT BAOCAOTON_SACH_FK FOREIGN KEY (MaSach) REFERENCES SACH(MaSach)
/

ALTER TABLE BAOCAOCONGNO
 ADD CONSTRAINT BAOCAOCONGNO_KHACHHANG_FK FOREIGN KEY (MaKhachHang) REFERENCES KHACHHANG(MaKhachHang)
/


create or replace trigger add_baocaoton
before insert
on BAOCAOTON
for each row
declare
tondau sach.soluongton%type;
begin
    select soluongton into tondau
    from sach
    where masach = :new.masach;
    
    :new.tondau := tondau;
    :new.toncuoi := :new.tondau + :new.phatsinh;
end;

create or replace trigger add_baocaocongno
before insert
on BAOCAOCONGNO
for each row
declare
debt khachhang.tongno%type;
begin
    select tongno into debt
    from khachhang
    where makhachhang = :new.makhachhang;
    
    :new.nodau := debt;
    :new.nocuoi := :new.nodau + :new.phatsinh;
end;

