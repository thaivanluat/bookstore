create or replace NONEDITIONABLE trigger check_debt_customer 
before insert on HOADON
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

  if no >= tongnotoida then
    raise_application_error(-20003,'khach hang nay vuot qua muc no!');
  end if;
end;

create or replace NONEDITIONABLE trigger check_inventory_after_sale
before insert on CHITIETHOADON
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
  WHERE ROWNUM = 1;

  if (Slg_ton - Slg_ban) < luongtonsaukhiban then
    raise_application_error(-20004,'so luong ton cua sach sau khi ban khong duoc duoi 20!');
  end if;
end;


create or replace NONEDITIONABLE trigger trg_check_books_import 
before insert on CHITIETPHIEUNHAPSACH
for each row
declare
  Slg_ton number;
  soluongnhaptoithieu number;
  soluongtondenhaptoida number;
begin
  select soluongnhaptoithieu, soluongtondenhaptoida into soluongnhaptoithieu,soluongtondenhaptoida
  from thamso
  WHERE ROWNUM = 1;

  select SoLuongTon into Slg_ton
  from SACH 
  where MaSach = :new.MaSach;

  if :new.Soluong <= soluongnhaptoithieu then
    raise_application_error(-20001,'S? lý?ng nh?p ít nh?t là 150!');
  end if;

  if Slg_ton >= soluongtondenhaptoida then
    raise_application_error(-20002,'S? lý?ng t?n c?a sách ph?i ít hõn 300!');
  end if;      
end;