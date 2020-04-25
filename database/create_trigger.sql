-- trg_xoa_DauSach
create or replace trigger trg_xoa_DauSach
before delete
on DAUSACH
for each row
begin
    delete from CHITIETTACGIA where MaDauSach = :old.MaDauSach;
end;

