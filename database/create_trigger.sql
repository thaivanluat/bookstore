-- trg_delete_DauSach
create or replace trigger trg_delete_DauSach
before delete
on DAUSACH
for each row
begin
    delete from CHITIETTACGIA where MaDauSach = :old.MaDauSach;
end;

