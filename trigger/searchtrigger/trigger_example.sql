BEGIN
update tlkvhg9 set tlkvhg9_id = old.Tjyedts_bsWITR where tlkvhg9_id = old.Tjyedts_bsWITR;
END

update dung cot can chon

+lay 2 dua lieu trong chinh bang do(bang tlkvhg9) va ghep voi nhau (chinh la cai concat)

begin
Declare mahoso1 varchar(255);
set mahoso1 = (select T61r5ki_qG2cXH from t61r5ki  where t61r5ki_id = new.Tlkvhg9_6NkZWK);
set new.Tlkvhg9_XC9zbN = concat(mahoso1,'_',new.Tlkvhg9_VXyCIK); 
end


set phantramht = (select Tjyedts_Caq3ul  from tjyedts where  Tjyedts_bsWITR = new.tlkvhg9_id order by Tjyedts_IbdQc9 desc limit 1);
set new.Tlkvhg9_YVkRbg = phantramht; dang viet trong bang tlkvhg9

BEGIN
update tlkvhg9 set tlkvhg9_id = tlkvhg9_id where tlkvhg9_id = tlkvhg9_id; vao trong new query 
END

viet chinh bang do, left join nhieu bang
declare tien int;
declare tienconlai int;
set tien = (select sum(Tq3kpwh_v7DGp5) from tq3kpwh left join tyzh5in on tyzh5in_id = Tq3kpwh_gSxdrQ left join tyj7o9k on tyj7o9k_id = Tyzh5in_yBpzNV left join t8i7smn on t8i7smn_id = Tyj7o9k_CIxaNf where Tyj7o9k_CIxaNf = new.T8i7smn_id  and Tq3kpwh_v35dqh = 100);
set new.T8i7smn_z5T8c2 = tien;
set new.T8i7smn_aVJdv4 = new.T8i7smn_z5T8c2 - new.T8i7smn_MJDQ1c;

khi muon reload lai trang cap nhat ca bang thi viet 

update tlkvhg9 set tlkvhg9_id = new.tlkvhg9_id where tlkvhg9_id = new.tlkvhg9_id; 

BEGIN

update tdue2sa set tdue2sa_id = new.tdue2sa_id where tdue2sa_id = new.tdue2sa_id;

END

declare tienpb int;
set tienpb = (select sum (Tdue2sa_iHIgcj) from tdue2sa where Tg6jm1t_id = new.Tdue2sa_MZxWd0);
set new.Tg6jm1t_0PebI8 = tienpb;

update tdue2sa set tdue2sa_id = new.tdue2sa_id where tdue2sa_id = new.tdue2sa_id;

update tdue2sa set tdue2sa_id = old.tdue2sa_id  where tdue2sa_id = old.tdue2sa_id;

declare tongtien int;

dang viet trong cai tg6jm1t:
+cai nay viet trong cai delete after delete
set tongtien = (select sum(Tdue2sa_iHIgcj) from tdue2sa where Tdue2sa_MZxWd0 = old.Tdue2sa_MZxWd0);
update tg6jm1t set Tg6jm1t_0PebI8 = tongtien where tg6jm1t_id = old.Tdue2sa_MZxWd0;

+cai nay viet trong after update 
declare tongtien int;
set tongtien = (select sum(Tg6jm1t_fkBcAb) from tg6jm1t where Tg6jm1t_2gJZiq = new.Tg6jm1t_2gJZiq);
update tezkhax set Tezkhax_7nW9QN = tongtien where tezkhax_id = new.Tg6jm1t_2gJZiq

+cai nay viet trong before update,insert...
set new.Tg6jm1t_oJilOv = (new.Tg6jm1t_AF4iRn * new.Tg6jm1t_Y1IoWE) * (new.Tg6jm1t_I9CFHw / 100);
set new.Tg6jm1t_g2KQNh = (new.Tg6jm1t_AF4iRn * new.Tg6jm1t_Y1IoWE) - new.Tg6jm1t_oJilOv;

