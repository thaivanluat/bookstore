
ALTER TABLE KHACHHANG ADD TRANGTHAI NVARCHAR2(7) ;
ALTER TABLE KHACHHANG ADD SINHNHAT DATE;

ALTER TABLE KHACHHANG MODIFY ( SINHNHAT NOT NULL);

create or replace NONEDITIONABLE procedure cap_nhat_trang_thai_kh (makh in KHACHHANG.makhachhang%type)
as
  tong_tien HOADON.tongtien%TYPE;
  tong_no KHACHHANG.tongno%TYPE;
  trang_thai KHACHHANG.trangthai%TYPE;
  muc_tien_vip THAMSO.muc_tien_capnhat_vip%TYPE;
  no_toida THAMSO.tongnotoida%TYPE;
  nam_ht number;
begin
  select trangthai into trang_thai
  from KHACHHANG
  where makhachhang = makh;

  if trang_thai = 'normal' then
    select tongno into tong_no
    from KHACHHANG
    where makhachhang = makh;

    select tongnotoida into no_toida
    from THAMSO
    WHERE ROWNUM = 1;

    if tong_no < no_toida then
      nam_ht :=  EXTRACT(YEAR FROM sysdate);

      select sum(tongtien) into tong_tien
      from HOADON
      where makhachhang = makh and extract(year from ngaylap) = nam_ht;

      select muc_tien_capnhat_vip into muc_tien_vip
      from THAMSO
      WHERE ROWNUM = 1;

      if tong_tien >= muc_tien_vip then
        update KHACHHANG
        set trangthai = 'vip'
        where makhachhang = makh;
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

create or replace NONEDITIONABLE PROCEDURE "PROC_UPDATE_TOTAL_HOADON" (mahd HOADON.MaHoaDon%TYPE)
as 
total number;
discount thamso.tilegiamgia%type;
v_trangthai KHACHHANG.TRANGTHAI%TYPE;
begin
    total:=0;
    select tilegiamgia into discount from THAMSO WHERE ROWNUM = 1;
    select trangthai into v_trangthai 
    from HOADON inner join KHACHHANG ON KHACHHANG.MaKhachHang = HOADON.MaKhachHang 
    WHERE MaHoaDon = mahd;
    
    for item in (select soluong, dongia 
                    from CHITIETHOADON CTHD 
                    inner join SACH S ON S.MaSach = CTHD.MaSach
                    where MaHoaDon = mahd)
    LOOP
    total:= total + item.dongia*item.soluong;
    END LOOP;
    IF v_trangthai = 'vip'
    THEN 
        total:= total - (total*(discount/100));
    END IF;
    update HOADON 
    set TongTien = total
    where MaHoaDon = mahd;
end;

