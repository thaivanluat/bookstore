create table BAOCAOTON (
    MaSach NUMBER(8,0) NOT NULL,
    Thang NUMBER(2,0) NOT NULL,
    Nam NUMBER(4,0) NOT NULL,
    TonDau NUMBER(8,0) NOT NULL,
    TonCuoi NUMBER(8,0) NOT NULL,
    PhatSinhNhap NUMBER(12,0) NOT NULL,
    PhatSinhXuat NUMBER(12,0) NOT NULL
);

create table BAOCAOCONGNO (
    MaKhachHang NUMBER(8,0) NOT NULL,
    Thang NUMBER(2,0) NOT NULL,
    Nam NUMBER(4,0) NOT NULL,
    NoDau NUMBER(12,0) NOT NULL,
    NoCuoi NUMBER(12,0) NOT NULL,
    TongTienMua NUMBER(12,0) NOT NULL,
    TongTienTra NUMBER(12,0) NOT NULL
);


ALTER TABLE BAOCAOTON
 ADD CONSTRAINT BAOCAOTON_SACH_FK FOREIGN KEY (MaSach) REFERENCES SACH(MaSach)
 ADD CONSTRAINT BAOCAOTON_PK PRIMARY KEY (MaSach, Thang, Nam)
/

ALTER TABLE BAOCAOCONGNO
 ADD CONSTRAINT BAOCAOCONGNO_KHACHHANG_FK FOREIGN KEY (MaKhachHang) REFERENCES KHACHHANG(MaKhachHang)
 ADD CONSTRAINT BAOCAOCONGNO_PK PRIMARY KEY (MaKhachHang, Thang, Nam)
/

-- Init BAOCAOTON RECORD PER MONTH
create or replace procedure proc_init_opening_stock_of_month 
as 
month_var number;
year_var number;
cursor c1 is select masach, soluongton from sach order by masach;
begin
    year_var :=  EXTRACT(YEAR FROM sysdate);
    month_var :=  EXTRACT(MONTH FROM sysdate);
    for book in c1
    loop
        insert into baocaoton values 
        (book.masach, month_var, year_var, book.soluongton, book.soluongton, 0, 0);
    end loop;
end;

-- WHen new book is created, its stock is 0 and add to monthly stock report
create or replace trigger add_new_book_to_stock_report
after insert
on SACH
for each row
declare
month_var number;
year_var number;
begin
    year_var :=  EXTRACT(YEAR FROM sysdate);
    month_var :=  EXTRACT(MONTH FROM sysdate);
    insert into baocaoton values 
    (:new.masach, month_var, year_var, :new.soluongton, :new.soluongton, 0, 0);
end;

-- Update baocaoton when create hoadon or create phieunhapsach
create or replace procedure update_baocaoton(masach_var sach.masach%type, phatsinh number)
as 
month_var number;
year_var number;
begin
    year_var :=  EXTRACT(YEAR FROM sysdate);
    month_var :=  EXTRACT(MONTH FROM sysdate);
    
    if phatsinh > 0 then
        update baocaoton
        set phatsinhnhap = phatsinhnhap + phatsinh,
        toncuoi = toncuoi + phatsinh
        where masach = masach_var and nam = year_var and thang = month_var;
    else 
        update baocaoton
        set phatsinhxuat = phatsinhxuat + -phatsinh,
        toncuoi = toncuoi + phatsinh
        where masach = masach_var and nam = year_var and thang = month_var;
    end if;
end;

-- Init BAOCAOCONGNO RECORD PER MONTH
create or replace procedure proc_init_debt_report_of_month 
as 
month_var number;
year_var number;
cursor c1 is select makhachhang, tongno from khachhang order by makhachhang;
begin
    year_var :=  EXTRACT(YEAR FROM sysdate);
    month_var :=  EXTRACT(MONTH FROM sysdate);
    for kh in c1
    loop
        insert into baocaocongno values 
        (kh.makhachhang, month_var, year_var, kh.tongno, kh.tongno, 0, 0);
    end loop;
end;

-- WHen new customer is created, add to debt report 
create or replace trigger add_new_customer_to_debt_report
after insert
on KHACHHANG
for each row
declare
month_var number;
year_var number;
begin
    year_var :=  EXTRACT(YEAR FROM sysdate);
    month_var :=  EXTRACT(MONTH FROM sysdate);
    insert into baocaocongno values 
    (:new.makhachang, month_var, year_var, 0, 0, 0, 0);
end;

-- Update baocaocongno when create hoadon
create or replace procedure update_baocaocongno
(makhachhang_var khachhang.makhachhang%type, mahoadon_var hoadon.mahoadon%type)
as 
month_var number;
year_var number;
tongtien_var number;
sotientra_var number;
begin
    year_var :=  EXTRACT(YEAR FROM sysdate);
    month_var :=  EXTRACT(MONTH FROM sysdate);
    
    select tongtien, sotientra into tongtien_var, sotientra_var
    from HOADON
    where MaHoaDon = mahoadon_var;

    update baocaocongno
    set tongtienmua = tongtienmua + tongtien_var,
    tongtientra = tongtientra + sotientra_var,
    nocuoi = nocuoi + tongtien_var - sotientra_var
    where makhachhang = makhachhang_var and nam = year_var and thang = month_var;
end;

-- Update baocaocongno when create phieuthu
create or replace procedure update_baocaocongno_when_create_phieuthu
(makhachhang_var khachhang.makhachhang%type, sotienthu phieuthu.sotienthu%type)
as 
month_var number;
year_var number;
begin
    year_var :=  EXTRACT(YEAR FROM sysdate);
    month_var :=  EXTRACT(MONTH FROM sysdate);
    
    update baocaocongno
    set  tongtientra = tongtientra + sotienthu,
    nocuoi = nocuoi - sotienthu
    where makhachhang = makhachhang_var and nam = year_var and thang = month_var;
end;


