-- trg_delete_DauSach
-- trigger delete all relate author before delete book
create or replace trigger trg_delete_DauSach
before delete
on DAUSACH
for each row
begin
    delete from CHITIETTACGIA where MaDauSach = :old.MaDauSach;
end;

-- trg_add_ChiTietPhieuNhap 
-- trigger add book quantity when input receipt is create
create or replace trigger trg_add_ChiTietPhieuNhap
after insert
on CHITIETPHIEUNHAPSACH
for each row
begin
    UPDATE SACH
    SET SoLuongTon = SoLuongTon + :new.SoLuong
    where MaSach = :new.MaSach;
end;

-- trg_delete_PHIEUNHAPSACH
-- trigger delete all relate CHITIETPHIEUNHAPSACH before delete PHIEUNHAPSACH
create or replace trigger trg_delete_PhieuNhapSach
before delete
on PHIEUNHAPSACH
for each row
begin
    delete from CHITIETPHIEUNHAPSACH where MaPhieuNhapSach = :old.MaPhieuNhapSach;
end;

-- trg_delete_HOADDON
-- trigger delete all relate CHITIETHOADON before delete HOADON
create or replace trigger trg_delete_HoaDon
before delete
on HOADON
for each row
begin
    delete from CHITIETHOADON where MaHoaDon = :old.MaHoaDon;
end;

--trg_add_debt_Customer
create or replace trigger trg_add_debt_Customer
after update
on HOADON
for each row
declare
v_debt khachhang.tongno%type;
begin
        UPDATE KHACHHANG
        SET TongNo = :new.TongTien
        WHERE MaKhachHang = :new.MaKhachHang;
end;

-- trg_add_ChiTietHoaDon
-- trigger decrease book quantity when invoice is create
create or replace trigger trg_add_ChiTietHoaDon
after insert
on CHITIETHOADON
for each row
begin
    UPDATE SACH
    SET SoLuongTon = SoLuongTon - :new.SoLuong
    where MaSach = :new.MaSach;
end;

--trg_decrease_debt_PHIEUTHU
--trigger decrease debt of customer when create receipt of that customer
create or replace trigger trg_decrease_debt_PHIEUTHU
after insert
on PHIEUTHU
for each row
begin
    UPDATE KHACHHANG
    SET TongNo = TongNo - :new.SoTienThu
    WHERE MaKhachHang = :new.MaKhachHang;
end;   

--trg_check_debt_before_create
--trigger check receipt can only be created when its value smaller than or equal customer debt
create or replace trigger trg_check_debt_PHIEUTHU
before insert
on PHIEUTHU
for each row
declare v_debt KHACHHANG.TongNo%TYPE;
begin
    select tongno into v_debt
    from KHACHHANG 
    where MaKhachhang = :new.MaKhachHang;

    if v_debt < :new.SoTienThu then
    raise_application_error(-20000
                , 'Error');
    end if;
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

--Trigger table CHITIETPHIEUNHAPSACH: Soluong at least 150. Just import books with inventory less than 300
create or replace trigger trg_check_books_import 
before insert or update on CHITIETPHIEUNHAPSACH
for each row
declare
  Ma_DS DAUSACH.MaDauSach%TYPE;
  Slg_ton number;
  soluongnhaptoithieu number;
  soluongtondenhaptoida number;
begin
  select MaDauSach into Ma_DS
  from SACH
  where MaSach = :new.MaSach;

  select soluongnhaptoithieu, soluongtondenhaptoida into soluongnhaptoithieu,soluongtondenhaptoida
  from thamso
  WHERE ROWNUM = 1;

  select sum(SoLuongTon) into Slg_ton
  from SACH S join DAUSACH DS on  DS.MaDauSach = S.MaDauSach
  where S.MaDauSach = Ma_DS;

  if :new.Soluong < soluongnhaptoithieu then
    raise_application_error(-2000,'S? lý?ng nh?p ít nh?t là 150!');
  end if;
  
  if Slg_ton > soluongtondenhaptoida then
    raise_application_error(-2000,'S? lý?ng t?n c?a sách ph?i ít hõn 300!');
  end if;      
end;


--Trigger table HOADON: Just sell for customer with debt less than 20000 vnd
create or replace trigger check_debt_customer 
before insert or update on HOADON
for each row
declare
  no KHACHHANG.TongNo%TYPE;
  tongnotoida number;
begin
  select tongnotoida into tongnotoida
  from thamso
  WHERE ROWNUM = 1;

  select TongNo into no
  from KHACHHANG
  where MaKhachHang = :new.MaKhachHang;
  
  if no > 20000 then
    raise_application_error(-2000,'khach hang nay vuot qua muc no!');
  end if;
end;

--Trigger table CHITIETHOADON: Inventory of books after sale must be at least 20
create or replace trigger check_inventory_after_sale
before insert or update on CHITIETHOADON
for each row
declare
 Slg_ban Number := :new.SoLuong;
 Slg_ton Number;
 luongtonsaukhiban number;
begin
  select SoLuongTon into Slg_ton
  from SACH
  where MaSach = :new.MaSach;

  select luongtonsaukhibantoithieu into luongtonsaukhiban
  from thamso
  WHERE ROWNUM = 1
  
  if (Slg_ton - Slg_ban) < luongtonsaukhiban then
    raise_application_error(-2000,'so luong ton cua sach sau khi ban khong duoc duoi 20!');
  end if;
end;

--Trigger table PHIEUTHU: Amount of receipt mustn't be greater than the total debt
-- create or replace trigger check_receipt 
-- before insert or update on PHIEUTHU
-- for each row
-- declare
--   no KHACHHANG.TongNo%TYPE;
-- begin
--   select TongNo into no
--   from KHACHHANG
--   where MaKhachHang = :new.MaKhachHang;
  
--   if :new.SoTienThu > no then
--     raise_application_error(-2000,'S? ti?n thu không h?p l?!');
--   end if;
-- end;

CREATE OR REPLACE PROCEDURE CAPNHATVIP
AS
    v_tongtien HOADON.TONGTIEN%TYPE;
    v_mskh HOADON.MAKHACHHANG%TYPE;
    
    CURSOR UPVIP IS SELECT SUM(TONGTIEN), MAKHACHHANG FROM HOADON
                    GROUP BY MAKHACHHANG;
BEGIN
    OPEN UPVIP;
    LOOP
        FETCH UPVIP INTO v_tongtien, v_mskh;
        EXIT WHEN UPVIP%FOUND = FALSE;
        
        IF v_tongtien >=100000
        THEN UPDATE KHACHHANG
            SET TRANGTHAI = 'VIP'
            WHERE MAKHACHHANG = v_mskh;
        END IF;
    END LOOP;
END;

CREATE OR REPLACE PROCEDURE GIAMGIA (v_mskh IN KHACHHANG.MAKHACHHANG%TYPE)
AS
    v_trangthai KHACHHANG.TRANGTHAI%TYPE;
    
    CURSOR GIAM IS SELECT TRANGTHAI INTO v_trangthai FROM KHACHHANG
    WHERE MAKHACHHANG = v_mskh;
    
BEGIN
    OPEN GIAM;
    IF v_trangthai = 'VIP'
    THEN UPDATE HOADON
         SET TONGTIEN = TONGTIEN - (TONGTIEN*0.05)
         WHERE MAKHACHHANG = v_mskh;
         DBMS_OUTPUT.PUT_LINE('Quy khach duoc giam gia 5%');
    END IF;
    CLOSE GIAM;
END;

-- proc_update_total_PhieuNhap
-- procedure calculate total of input receipt 
create or replace procedure proc_update_total_PhieuNhap(mapn PHIEUNHAPSACH.MaPhieuNhapSach%TYPE)
as 
total number;
begin
    total:=0;
    for item in (select soluong, dongianhap 
                    from CHITIETPHIEUNHAPSACH CTPN 
                    inner join SACH S ON S.MaSach = CTPN.MaSach
                    where MaPhieuNhapSach = mapn)
    LOOP
    total:= total + item.dongianhap*item.soluong;
    END LOOP;
    update PHIEUNHAPSACH 
    set TongTien = total
    where MaPhieuNhapSach = mapn;
end;

-- proc_update_price_CHITIETPHIEUNHAPSACH
-- procedure update price of each CHITIETPHIEUNHAPSACH of input receipt
create or replace procedure proc_update_price_CHITIETPHIEUNHAPSACH (mapn PHIEUNHAPSACH.MaPhieuNhapSach%TYPE)
as 
begin
    for item in (select CTPN.MaPhieuNhapSach, S.DonGiaBan, CTPN.MaSach
                from CHITIETPHIEUNHAPSACH CTPN 
                inner join SACH S on S.MaSach = CTPN.MaSach
                where CTPN.MaPhieuNhapSach = mapn)
    loop
        UPDATE CHITIETPHIEUNHAPSACH
        SET DonGiaNhap = item.DonGiaBan
        WHERE MaPhieuNhapSach = item.MaPhieuNhapSach AND MaSach = item.MaSach;
    end loop;
end;

-- proc_update_total_HoaDon
-- procedure calculate total of invoice
create or replace procedure proc_update_total_HoaDon(mahd HOADON.MaHoaDon%TYPE)
as 
total number;
begin
    total:=0;
    for item in (select soluong, dongia 
                    from CHITIETHOADON CTHD 
                    inner join SACH S ON S.MaSach = CTHD.MaSach
                    where MaHoaDon = mahd)
    LOOP
    total:= total + item.dongia*item.soluong;
    END LOOP;
    update HOADON 
    set TongTien = total
    where MaHoaDon = mahd;
end;


-- proc_update_price_CHITIETHOADON
-- procedure update price of each proc_update_price_CHITIETHOADON of invoice
create or replace procedure proc_update_price_CHITIETHOADON (mahd HOADON.MaHoaDon%TYPE)
as 
begin
    for item in (select CTHD.MaHoaDon, S.DonGiaBan, CTHD.MaSach
                from CHITIETHOADON CTHD 
                inner join SACH S on S.MaSach = CTHD.MaSach
                where CTHD.MaHoaDon = mahd)
    loop
        UPDATE CHITIETHOADON
        SET DonGia = item.DonGiaBan
        WHERE MaHoaDon = item.MaHoaDon AND MaSach = item.MaSach;
    end loop;
end;

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
