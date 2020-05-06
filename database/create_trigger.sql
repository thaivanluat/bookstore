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
create or replace trigger trg_decrease_debt_PHIEUTHU
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

