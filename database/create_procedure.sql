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

exec proc_update_total_PhieuNhap(39);

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
