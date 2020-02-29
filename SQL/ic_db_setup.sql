drop database if exists InsuranceCompany;
create database InsuranceCompany;
use InsuranceCompany;

CREATE TABLE member (
  memberId integer AUTO_INCREMENT,
  fname    varchar(20) not null, 
  lname    varchar(20) not null,
  email    varchar(50) not null,
  userPassword varchar(100) not null,
  dob  date not null,
  gender      varchar(10),
  addressLine  varchar(30),
  city     varchar(20),
  state    varchar(2),
  pincode  varchar(11),
  constraint pk primary key (memberid)
) ENGINE=INNODB;

CREATE TABLE employee (
  empId integer AUTO_INCREMENT,
  fname    varchar(20) not null, 
  lname    varchar(20) not null,
  password varchar(100) not null,
  constraint pk primary key (empId)
) ENGINE=INNODB;

CREATE TABLE doctor (
  doctorId integer AUTO_INCREMENT,
  fname    varchar(20) not null, 
  lname    varchar(20) not null,
  hospital varchar(30),
  licenseDate    date,
  Institution varchar(40),
  address  varchar(30),
  gender     varchar(10),
  constraint pk primary key (doctorid)
) ENGINE=INNODB;

CREATE TABLE plan (
  planId integer AUTO_INCREMENT,
  planType varchar(30) not null,
  MonthlyPremium decimal(10,2) not null,
  Deductible decimal(10,2) not null,
  CoInsurance decimal (10,2) not null,
  OutOfPocketLimit decimal (10,2) not null,
  tenure integer,
  constraint pk primary key (planId)
) ENGINE=INNODB;

CREATE TABLE memberRecord (
  recordNo integer AUTO_INCREMENT,
  memberID integer not null,
  planId integer,
  deductibleSpent decimal(10,2) default 0.0,
  outOfPocketSpent decimal(10,2) default 0.0,
  startDate date,
  premiumPaymentStatus ENUM('Paid', 'UnPaid') NOT NULL,
  constraint pk primary key (recordNo,memberID),  
  constraint fk1_memberrecord foreign key (memberID) references member(memberId),
  constraint fk2_memberrecord foreign key (planId) references plan(planId)
) ENGINE=INNODB;

CREATE TABLE updates (
  memberID integer,
  recordNo integer,
  empId integer,
  constraint pk primary key(memberId,recordNo,empId),
  constraint fk1_updates foreign key (empId) references employee(empId),
  constraint fk2_updates foreign key(memberId,recordNo) references memberrecord(memberId,recordNo)
) ENGINE=INNODB;

CREATE TABLE claim (
  claimId integer AUTO_INCREMENT,
  memberid integer not null,
  doctorId  integer not null,
  claimStatus varchar(20) not null default 'Pending', 
  claimAmount   decimal(10,2) not null,
  treatment varchar(50),
  claimDate date not null,
  billId  integer not null,
  constraint pk primary key (claimId),
  constraint uk unique key (billid, memberid, doctorid),
  constraint fk1_claim foreign key (memberId) references member(memberId),
  constraint fk2_claim foreign key (doctorId) references doctor(doctorId)
) ENGINE=INNODB;

CREATE TABLE statement (
  statementNo  integer not null AUTO_INCREMENT,
  memberId integer not null,
  empId integer not null,
  claimId integer,
  AmountCovered integer,
  constraint pk primary key (statementNo),
  constraint fk1_statement foreign key (memberId) references member(memberId),
  constraint fk2_statement foreign key (empId) references employee(empId),
  constraint fk3_statement foreign key (claimId) references claim(claimId)
) ENGINE=INNODB;

CREATE TABLE memberNo (
  memberId integer,
  PhoneNumber varchar(15),
  constraint pk primary key(memberId,PhoneNumber),
  constraint fk_memberno foreign key(memberId) references member(memberId)
) ENGINE=INNODB;

CREATE TABLE doctorNo (
  doctorId integer,
  PhoneNumber varchar(15),
  constraint pk primary key(doctorId,PhoneNumber),
  constraint fk_doctorno foreign key(doctorId) references doctor(doctorId)
) ENGINE=INNODB;

INSERT INTO `member` VALUES ('101', 'Isaac', 'McMahon', 'isaac.m@email.com',sha1('isaac123'), '1959-01-08', 'M', '109 Mammoth Street', 'San Jose', 'CA', '95002');
INSERT INTO `member` VALUES ('102', 'Amari', 'Miller', 'amari.m@email.com', sha1('amari123'), '1961-01-30', 'M', '9260 Deerfield Street', 'San Francisco', 'CA', '94105');
INSERT INTO `member` VALUES ('103', 'Roberto', 'Medina', 'roberto.m@email.com', sha1('roberto123'), '1961-06-14', 'M', '492 Mammoth St.', 'San Francisco', 'CA', '94016');
INSERT INTO `member` VALUES ('104', 'Kareem', 'Salazar', 'kareem.s@email.com', sha1('kareem123'), '1962-11-19', 'M', '97 1st Court', 'San Jose', 'CA', '95037');
INSERT INTO `member` VALUES ('105', 'Jazmine', 'Kelley', 'jazmine.k@email.com', sha1('jazmine123'), '1964-01-24', 'F', '9930 Homewood Dr.', 'Sacramento', 'CA', '94235');
INSERT INTO `member` VALUES ('106', 'Erica', 'Brown', 'erica.b@email.com', sha1('erica123'), '1967-12-06', 'F', '168 Blue Spring St.', 'Oakland', 'CA', '94615');
INSERT INTO `member` VALUES ('107', 'George', 'Humphrey', 'george.h@email.com', sha1('george123'), '1969-07-18', 'M', '311 S. Smith Store Street', 'San Diego', 'CA', '92029');
INSERT INTO `member` VALUES ('108', 'Keon', 'Blair', 'keon.b@email.com', sha1('keon123'), '1971-03-23', 'M', '251 Adams Road', 'San Diego', 'CA', '92117');
INSERT INTO `member` VALUES ('109', 'Abagail', 'Mcdonald', 'abagail.m@email.com', sha1('abagail123'), '1980-06-19', 'F', '8 6th St.', 'Oakland', 'CA', '94621');
INSERT INTO `member` VALUES ('110', 'Dakota', 'Watkins', 'dakota.w@email.com', sha1('dakota123'), '1980-09-17', 'F', '256 Ivy Lane', 'Sacramento', 'CA', '94229');
INSERT INTO `member` VALUES ('111', 'Bradley', 'Martins', 'bradley.m@email.com', sha1('bradley123'), '1980-09-24', 'M', '800 E. Longbranch Avenue', 'Los Angeles', 'CA', '90001');
INSERT INTO `member` VALUES ('112', 'Isaac', 'Burns', 'isaac.b@email.com', sha1('peyton123'), '1984-03-21', 'M', '15 Mayfield St.', 'Fresno', 'CA', '93650');
INSERT INTO `member` VALUES ('113', 'Shriya', 'Das', 'shriya.d@email.com', sha1('shriya123'), '1994-07-20', 'F', '90 South Crescent Street', 'Anaheim', 'CA', '92812');
INSERT INTO `member` VALUES ('114', 'Regan', 'Hurst', 'regan.h@email.com', sha1('regan123'), '1996-05-31', 'M', '9985 Bank Dr.', 'Anaheim', 'CA', '92808');
INSERT INTO `member` VALUES ('115', 'Sierra', 'Tate', 'sierra.t@email.com', sha1('sierra123'), '1998-08-06', 'F', '11 Talbot Street', 'San Jose', 'CA', '95110');
INSERT INTO `member` VALUES ('116', 'Rory', 'Jones', 'rory.j@email.com', sha1('rory123'), '1998-10-16', 'M', '73 Mulberry Circle', 'San Francisco', 'CA', '94129');
INSERT INTO `member` VALUES ('117', 'Chloe', 'Levine', 'chloe.l@email.com', sha1('chloe123'), '2000-01-26', 'F', '9714 Rockland Street', 'Oakland', 'CA', '94604');
INSERT INTO `member` VALUES ('118', 'Armani', 'Haas', 'armani.h@email.com', sha1('armani123'), '2000-02-15', 'M', '573 Fremont Street', 'Sacramento', 'CA', '94234');
INSERT INTO `member` VALUES ('119', 'Van', 'Robertson', 'van.r@email.com', sha1('van123'), '2006-08-14', 'M', '369 Broad Road', 'Fresno', 'CA', '93711');
INSERT INTO `member` VALUES ('120', 'Khalil', 'Ware', 'khalil.w@email.com', sha1('khalil123'), '2006-11-14', 'M', '800 E. Longbranch Avenue', 'Los Angeles', 'CA', '90021');

INSERT INTO employee VALUES
    (1,'Lauren','Paul',sha1('lauren123')),
    (2,'Edward','Norton',sha1('edward123')),
    (3,'Anirudh','Shetty',sha1('anirudh123'));
	
INSERT INTO doctor VALUES
    (142,'Phoenix','Diaz','FlowerHill General Hospital','1994-01-05','Calgary Medical Institute','846 Oakwood Ave.','M'),
    (203,'Colin','Benson','Riverside Clinic','2005-06-17','United Health Academy','281 Evergreen St.','M'),
    (405,'Karissa','Patrick','FlowerHill General Hospital','2006-11-13 00:00:00','United Health Academy','281 Evergreen St.','F'),
    (416,'Marc','Jenson','FlowerHill General Hospital','2013-01-08 00:00:00','National Institute for Medicine','732 Manor Ave.','M'),
    (591,'Trace','Giles','Riverside Clinic','2015-10-20 00:00:00','John Hopkins University','8279 Bow Ridge St.','F'),
    (608,'Alisa','Townsend','Mercy Vale Hospital','2001-05-14 00:00:00','John Hopkins University','8279 Bow Ridge St.','F');
	
INSERT INTO plan (planid, plantype, monthlypremium, deductible, coinsurance, outofpocketlimit,tenure)
VALUES
	(111,'Bronze',150,7500,25,10000,6),
    (222,'Silver',200,6500,25,8600,12),
    (333,'Gold',250,5000,20,7000,12),
    (444,'Platinum',350,4000,15,6000,12);
    
INSERT INTO memberRecord VALUES
	(1,101,111,6000,6000,'2019-02-01','Paid'),
    (11,111,222,6500,6500,'2019-04-03','Paid'),
    (12,112,222,6500,7000,'2019-05-06','Paid'),
    (13,113,333,3000,3000,'2019-06-07','Paid'),
    (18,118,444,3900,3900,'2019-01-21','Paid'),
    (19,119,111,7500,7500,'2019-10-24','Paid');

INSERT INTO updates VALUES
    (101,1,1),
    (113,13,2),
    (118,18,3),
    (112,12,3),
    (111,11,2),
    (119,19,1);
	
INSERT INTO claim VALUES
    (165,101,142,'Pending',4000,'Bone Fracture','2019-11-22',1067),
    (166,113,405,'Pending',200,'Face Swelling','2019-10-15',1168),
    (177,118,591,'Pending',70,'X-Ray','2019-01-08',1169),
    (178,112,608,'Pending',250,'UTI Scan','2019-04-09',1070),
    (179,111,203,'Pending',30000,'Heart Surgery','2018-12-12',1136),
    (201,113,416,'Pending',25000,'Heart Surgery','2018-11-04',1257),
	(202,119,608,'Pending',4000,'Bone Fracture','2019-06-07',1257);

INSERT INTO memberno VALUES
    (101,'209-200-7986'),
    (102,'209-201-8170'),
    (103,'209-202-9047'),
    (104,'209-204-1815'),
    (105,'209-205-3948'),
    (106,'209-206-6089'),
    (107,'209-207-4749'),
    (108,'209-208-6382'),
    (109,'209-210-8692'),
    (110,'209-212-0789'),
    (111,'209-213-0532'),
    (112,'209-214-9636'),
    (113,'209-215-0949'),
    (114,'209-216-5392'),
    (115,'209-220-5210'),
    (116,'209-218-2788'),
    (117,'209-219-4248'),
    (118,'209-221-5537'),
    (119,'209-222-5050'),
    (120,'209-223-2514'),
    (101,'209-224-1054'),
    (103,'209-225-4929'),
    (104,'209-226-3153'),
    (107,'209-227-3671'),
    (109,'209-228-4654'),
    (110,'209-229-6515'),
    (113,'209-230-1197'),
    (115,'209-231-6428'),
    (119,'209-233-8955'),
    (120,'209-236-2507');

INSERT INTO doctorno VALUES
    (142,'209-248-7331'),
    (203,'209-249-5853'),
    (405,'209-250-1330'),
    (416,'209-251-9335'),
    (591,'209-252-7405'),
    (608,'209-253-7363'),
    (203,'209-254-5973'),
    (416,'209-255-6620'),
    (591,'209-256-1514');
	
drop table if exists claim_audit;

CREATE TABLE claim_audit (
  Id integer AUTO_INCREMENT,
  claimid integer not null, 
  memberid integer not null,
  empid integer not null,
  recordno int not null,
  claimAmount   decimal(10,2) not null,
  oopSpent DEC(10,2),
  olddeductibleSpent DEC(10,2),
  deductibleSpent DEC(10,2),
  approvedAmount DEC(10,2),
  balanceOop DEC(10,2),
  coInsurance DEC(10,2),
  balanceDeductible DEC(10,2),
  oopPlan DEC(10,2),
  deductiblePlan DEC(10,2),
  coInsurancePlan INT,
  tobePaidByCust DEC(10,2),
  constraint pk primary key (Id)
) ENGINE=INNODB;

DROP TRIGGER IF EXISTS trig_claim_before_update;

DELIMITER $$

CREATE TRIGGER trig_claim_before_update
BEFORE UPDATE ON claim
FOR EACH ROW
BEGIN

    IF (NEW.claimstatus = 'Approved') THEN
	  call proc_update_memberrecord( OLD.claimid,OLD.memberid, OLD.claimamount);
    END IF;
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS proc_update_memberrecord;

DELIMITER $$
 
CREATE PROCEDURE proc_update_memberrecord
( IN var_claimID integer,
  IN var_memberid integer, 
  IN var_bill integer ) 
BEGIN
    declare var_empid int;
	declare var_recordno int;
	
    DECLARE var_oopSpent DEC(10,2) DEFAULT 0.0;
	DECLARE var_olddeductibleSpent DEC(10,2) DEFAULT 0.0;
    DECLARE var_deductibleSpent DEC(10,2) DEFAULT 0.0;
    DECLARE var_approvedAmount DEC(10,2) DEFAULT 0.0;
	
    DECLARE var_balanceOop DEC(10,2) DEFAULT 0.0;
    DECLARE var_coInsurance DEC(10,2) DEFAULT 0.0;
    DECLARE var_balanceDeductible DEC(10,2) DEFAULT 0.0;
	
    DECLARE var_oopPlan DEC(10,2) DEFAULT 0.0;
    DECLARE var_deductiblePlan DEC(10,2) DEFAULT 0.0;
    DECLARE var_coInsurancePlan INT DEFAULT 0;
	
    DECLARE var_tobePaidByCust DEC(10,2) DEFAULT 0.0;
    
    SELECT u.empid, mr.deductibleSpent , mr.outOfPocketSpent, mr.recordno 
	INTO var_empid, var_olddeductibleSpent , var_oopSpent, var_recordno
	FROM memberrecord mr, updates u
	where u.recordno = mr.recordno
	and u.memberid = mr.memberid
	and mr.memberID=var_memberid;
	  
	SELECT p.Deductible, p.OutOfPocketLimit,p.CoInsurance 
	INTO var_deductiblePlan,var_oopPlan,var_coInsurancePlan 
	FROM memberrecord mr, plan p
	where mr.planid= p.planId 
	and mr.memberID= var_memberid;
    
        IF var_olddeductibleSpent <= var_deductiblePlan THEN
		SET var_deductibleSpent = var_olddeductibleSpent + var_bill;
        IF var_deductibleSpent >  var_deductiblePlan THEN
			SET var_balanceDeductible = var_deductibleSpent - var_deductiblePlan;
            SET var_deductibleSpent = var_deductiblePlan;
			IF var_balanceDeductible > 0  THEN
				SET var_coInsurance= (var_balanceDeductible * (100-var_coInsurancePlan))/100;
				SET var_tobePaidByCust = (var_balanceDeductible * var_coInsurancePlan)/100;
                
				SET var_oopSpent = var_oopSpent + var_deductiblePlan - var_olddeductibleSpent  + var_tobePaidByCust;
				IF var_oopSpent >  var_oopPlan THEN
					SET var_balanceOop = var_oopSpent - var_oopPlan;
					SET var_oopSpent = var_oopPlan;
					SET var_approvedAmount = var_coInsurance+ var_balanceOop;
				ELSE
					SET var_approvedAmount = var_coInsurance;
				END IF;
			END IF;
		ELSE
			SET var_oopSpent = var_deductibleSpent;
		END IF;
		
	ELSE
        BEGIN
			IF var_oopSpent <=  var_oopPlan THEN
				SET var_coInsurance= (var_bill * (100-var_coInsurancePlan))/100;
                SET var_tobePaidByCust = (var_bill * var_coInsurancePlan)/100;
				SET var_oopSpent = var_oopSpent+ var_deductibleSpent+ var_tobePaidByCust;
               
				IF var_oopSpent > var_oopPlan THEN
					SET var_balanceOop = var_oopSpent- var_oopPlan;
					SET var_approvedAmount = var_balanceOop + var_coInsurance;
					SET var_oopSpent = var_oopPlan;
				END IF;
			ELSE
				SET var_approvedAmount = var_bill;
			END IF;
		END;
	END IF;
	 
	update memberrecord 
	set deductiblespent = var_deductibleSpent,
		outOfPocketSpent = var_oopSpent
	where recordno = var_recordno;

	insert into statement(memberid, empid, claimid, amountcovered)
	values (var_memberid, var_empid, var_claimid, var_approvedAmount);
	
	insert into claim_audit( claimid, memberid, empid, recordno, claimAmount, 
	                         oopSpent, olddeductibleSpent, deductibleSpent,approvedAmount, 
							 balanceOop,coInsurance, balanceDeductible,
							 oopPlan, deductiblePlan, coInsurancePlan, tobePaidByCust)
	values( var_claimid, var_memberid, var_empid, var_recordno, var_bill, 
	        var_oopSpent, var_olddeductibleSpent,var_deductibleSpent,var_approvedAmount,
			var_balanceOop,var_coInsurance, var_balanceDeductible,
			var_oopPlan, var_deductiblePlan, var_coInsurancePlan, var_tobePaidByCust);
  
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS proc_update_memberprofile;

DELIMITER $$
 
CREATE PROCEDURE proc_update_memberprofile
( IN  var_memberid int,
  IN var_email varchar(70),
  IN var_address varchar(30), 
  IN var_city varchar(20),
  IN var_state varchar(20),
  IN  var_zipcode varchar(11)  ) 
BEGIN
    update member
	set email = var_email, 
	addressline = var_address,
	city = var_city, 
	state = upper(var_state), 
	pincode = var_zipcode
	where memberid = var_memberid;
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS proc_update_planinfo;

DELIMITER $$
 
CREATE PROCEDURE proc_update_planinfo
( IN  var_planid int, in var_plantype varchar(20),
  IN var_monthlypremium dec(10,2),
  IN var_deductible dec(10,2), 
  IN var_coinsurance dec(10,2),
  IN var_outofpocket dec(10,2),
  IN  var_tenure int(11)  ) 
BEGIN
    update plan
	set plantype = var_plantype,
	    monthlypremium =var_monthlypremium,
		deductible = var_deductible,
		coinsurance = var_coinsurance,
		outofpocketlimit = var_outofpocket,
		tenure = var_tenure
	where planid = var_planid;
	
	
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS proc_update_doctorinfo;

DELIMITER $$
 
CREATE PROCEDURE proc_update_doctorinfo
( IN  var_doctorid int, in var_fname varchar(20),
  IN var_lname varchar(20),
  IN var_hospital varchar(30), 
  IN var_licensedate date,
  IN var_institution varchar(40),
  IN  var_address varchar(30)  ) 
BEGIN
    update doctor
	set fname = var_fname,
	    lname =var_lname,
		hospital = var_hospital,
		licensedate = var_licensedate,
		institution = var_institution,
		address = var_address
	where doctorid = var_doctorid;
	
	
END$$

DELIMITER ;