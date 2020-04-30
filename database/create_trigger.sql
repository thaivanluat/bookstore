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

