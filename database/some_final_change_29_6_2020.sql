ALTER TABLE KHACHHANG ADD solancapnhat NUMBER(3);
ALTER TABLE THAMSO ADD MASACHTANG NUMBER(9);

ALTER TABLE THAMSO
 ADD CONSTRAINT THAMSO_SACH_FK FOREIGN KEY (MASACHTANG) REFERENCES SACH(MASACH)
/
-- trg_check_books_import
--Trigger table CHITIETPHIEUNHAPSACH: Soluong at least 150. Just import books with inventory less than 300
create or replace trigger trg_check_books_import 
before insert or update on CHITIETPHIEUNHAPSACH
for each row
declare
  Slg_ton number;
  soluongnhaptoithieu number;
  soluongtondenhaptoida number;
  Slg_ton_saunhap number;
begin
  --LOCK TABLE sach IN SHARE MODE;
  select soluongnhaptoithieu, soluongtondenhaptoida into soluongnhaptoithieu,soluongtondenhaptoida
  from thamso
  where rownum = 1;

  select SoLuongTon into Slg_ton
  from SACH 
  where MaSach = :new.MaSach;

  if Slg_ton > soluongtondenhaptoida then
    raise_application_error(-2000,'so luong ton cua dau sach phai it hon '|| soluongtondenhaptoida);    
  elsif :new.Soluong < soluongnhaptoithieu then
    raise_application_error(-2000,'So luong nhap it nhat la ' || soluongnhaptoithieu);
  else
    Slg_ton_saunhap := Slg_ton + :new.SoLuong;
    
    UPDATE SACH
    SET SoLuongTon = Slg_ton_saunhap
    where MaSach = :new.MaSach;
  end if;   
end;

---- 
create or replace procedure capnhat_trangthai
(makh in KHACHHANG.makhachhang%type)
as
  tong_tien HOADON.tongtien%TYPE;
  tong_no KHACHHANG.tongno%TYPE;
  trang_thai KHACHHANG.trangthai%TYPE;
  muc_tien_vip THAMSO.muc_tien_capnhat_vip%TYPE;
  no_toida THAMSO.tongnotoida%TYPE;
  nam_ht number;
  solan number;
  sach_tang THAMSO.masachtang%TYPE;
begin
  select trangthai into trang_thai
  from KHACHHANG
  where makhachhang = makh;
  
  if trang_thai = 'normal' then
    select tongno into tong_no
    from KHACHHANG
    where makhachhang = makh;
    
    select tongnotoida into no_toida
    from THAMSO;
    
    if tong_no < no_toida then
      nam_ht :=  EXTRACT(YEAR FROM sysdate);
      
      select sum(tongtien) into tong_tien
      from HOADON
      where makhachhang = makh and extract(year from ngaylap) = nam_ht;
      
      select muc_tien_capnhat_vip into muc_tien_vip
      from THAMSO;
      
      if tong_tien >= muc_tien_vip then
        update KHACHHANG
        set trangthai = 'vip'
        where makhachhang = makh;
        
        update KHACHHANG
        set solancapnhat = solancapnhat + 1
        where makhachhang = makh;
        
        select solancapnhat into solan
        from KHACHHANG
        where makhachhang = makh;
        
        if solan = 1 then                 
          select masachtang into sach_tang
          from thamso;
        
          update SACH
          set soluongton = soluongton - 1
          where masach = sach_tang;     
        end if;
      end if;
    end if;
  elsif trang_thai = 'vip' then
    select tongno into tong_no
    from KHACHHANG
    where makhachhang = makh;
    
    select tongnotoida into no_toida
    from THAMSO;
    
    if tong_no > no_toida then
      update KHACHHANG
      set trangthai = 'normal'
      where makhachhang = makh;
    end if;
  end if;
end;


create or replace NONEDITIONABLE procedure proc_after_create_hoadon (makh khachhang.makhachhang%type, mahd hoadon.mahoadon%type)
as
no_dau khachhang.tongno%type;
maxno thamso.tongnotoida%type;
tong_tien hoadon.tongtien%type;
nothem khachhang.tongno%type;
tong_no_moi khachhang.tongno%type;
stien_tra hoadon.sotientra%type;
trang_thai khachhang.trangthai%type;
tile_giam_gia thamso.tilegiamgia%type;
han_no thamso.hanno%type;
ngay_phai_tra date;
begin     
      --cap nhat don gia cho chi tiet hoa don va so luong ton cua sach
      tong_tien := 0;
      for item in (select CTHD.mahoadon, S.dongiaban, CTHD.soluong, CTHD.masach
                  from CHITIETHOADON CTHD 
                  inner join SACH S on S.masach = CTHD.masach
                  where CTHD.mahoadon = mahd)
      loop
          update CHITIETHOADON
          set dongia = item.dongiaban
          where mahoadon = item.mahoadon AND masach = item.masach;

          update SACH
          set soluongton = soluongton - item.soluong
          where masach = item.masach;

          tong_tien := tong_tien + item.dongiaban*item.soluong; 
      end loop;

      --cap nhat tong tien cua hoa don
      select trangthai into trang_thai
      from KHACHHANG
      where makhachhang = makh;

      if trang_thai = 'vip' then
        select tilegiamgia into tile_giam_gia
        from THAMSO;

        tong_tien := tong_tien*(tile_giam_gia/100);
      end if;
      
    update HOADON 
    set TongTien = tong_tien
    where MaHoaDon = mahd;

      --cap nhat tong no va han no cho khach hang
      select sotientra into stien_tra
      from HOADON
      where mahoadon = mahd; 

      nothem := tong_tien - stien_tra;
      if nothem > 0 then   
        select tongno into no_dau
        from khachhang 
        where makhachhang = makh;
        tong_no_moi := no_dau + nothem;

        update KHACHHANG
        set tongno = tong_no_moi
        where makhachhang = makh;          

        select tongnotoida into maxno
        from thamso;
        if tong_no_moi >= maxno then         
          select hanno into han_no
          from thamso;

          select sysdate+han_no into ngay_phai_tra
          from dual;

          update khachhang
          set hanno = ngay_phai_tra
          where makhachhang = makh;
        end if;
      end if;
end;


create or replace procedure proc_after_create_phieunhap (mapn phieunhapsach.maphieunhapsach%type)
as
tong_tien phieunhapsach.tongtien%type;
begin
    --cap nhat don gia cho chi tiet sach va so luong ton cua sach
    tong_tien := 0;
    for item in (select CTPN.maphieunhapsach, s.dongiaban, CTPN.soluong, CTPN.masach
                from chitietphieunhapsach CTPN 
                inner join SACH S on S.masach = CTPN.masach
                where CTPN.maphieunhapsach = mapn)
    loop
        update CHITIETPHIEUNHAPSACH
        set dongianhap = item.dongiaban
        where maphieunhapsach = item.maphieunhapsach AND masach = item.masach;
        
        tong_tien := tong_tien + item.dongiaban*item.soluong; 
    end loop;

    update PHIEUNHAPSACH 
    set TongTien = tong_tien
    where MaPhieuNhapSach = mapn;
end;

create or replace procedure proc_after_create_phieuthu (mapt phieuthu.maphieuthu%type)
as
begin
    --cap nhat don gia cho chi tiet sach va so luong ton cua sach
    tong_tien := 0;
    for item in (select CTPN.maphieunhapsach, s.dongiaban, CTPN.soluong, CTPN.masach
                from chitietphieunhapsach CTPN 
                inner join SACH S on S.masach = CTPN.masach
                where CTPN.maphieunhapsach = mapn)
    loop
        update CHITIETPHIEUNHAPSACH
        set dongianhap = item.dongiaban
        where maphieunhapsach = item.maphieunhapsach AND masach = item.masach;
        
        tong_tien := tong_tien + item.dongiaban*item.soluong; 
    end loop;

    update PHIEUNHAPSACH 
    set TongTien = tong_tien
    where MaPhieuNhapSach = mapn;
end;
