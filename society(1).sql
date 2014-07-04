-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 04, 2014 at 03:41 PM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `society`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `blockDetail`(OUT `BlockId` INT, OUT `CostTypeMode` INT, OUT `CostId` INT, OUT `AmountUnity` CHAR(10), OUT `CountUnity` INT, OUT `SortNumber` INT, OUT `AmountSharje` INT, OUT `AmountIncome` INT, OUT `Sharje` INT, OUT `Income` INT, OUT `Unity` INT, OUT `UnityStatus` INT)
BEGIN


SELECT	TC.block_code ,
		TCT.cost_type_mode_code	,
		TC.amount_unity ,
		TC.id		,
		TB.count_unity ,
		TB.sort_number,
        TC.amount_sharje,
        TC.amount_income,
        TC.sharje,
        TC.income,
        TC.unity,
        TC.unity_status
		INTO 
			BlockId			,
			CostTypeMode	,
			AmountUnity		,
			CostId			,
			CountUnity		,
			SortNumber		,
            AmountSharje	,
            AmountIncome	,
            Sharje			,
            Income			,
            Unity			,
			UnityStatus
			
FROM tbl_cost TC
JOIN tbl_cost_type TCT ON (TC.cost_type_code =TCT.id)
JOIN tbl_block TB ON (TC.block_code =TB.id)
ORDER BY TC.id DESC
LIMIT 1;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `chargeBaseDetail`(OUT `BlockId` INT	,	OUT `ChargeBaseId` INT)
BEGIN
SELECT	id , block_code INTO ChargeBaseId,BlockId					
FROM tbl_charge_base
ORDER BY id DESC
LIMIT 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `chargeBaseDetailInsert`(IN `BlockId` INT	,	IN `ChargeBaseId` INT)
BEGIN
declare	UserId int;
DECLARE	counter int;
DECLARE	UnitId int;
DECLARE listUnity	CURSOR FOR SELECT id  FROM tbl_unity where block_code	=	BlockId ;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET counter = TRUE;
OPEN listUnity;
mainLoop : LOOP

FETCH listUnity INTO UnitId;
IF counter	THEN
	LEAVE mainloop;
END IF;	
	call	getUserId(UnitId	,	UserId	,	1);
	INSERT INTO tbl_charge_base_detail (id,  	charge_base_code 	,user_code, unity_code) VALUES (NULL, ChargeBaseId, UserId,UnitId);

END LOOP;
CLOSE listUnity;
	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `chargeBaseDetailMain`()
BEGIN
declare BlockId				int;
declare ChargeBaseId		int;
call chargeBaseDetail(BlockId	,	ChargeBaseId);
call chargeBaseDetailInsert(BlockId	,	ChargeBaseId);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ComputeCountUnityInStage`(	IN BlockId INT)
BEGIN
	DECLARE	done INT;
	DECLARE	StageNum INT;
	DECLARE listUnity	CURSOR FOR 
		SELECT 	TU.stage	as stage FROM tbl_unity TU 
		JOIN tbl_leaseholder TL ON (TU.id	=	TL.unity_code)
		where TU.block_code	=	BlockId	and TL.status	=	1 ;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
	OPEN listUnity;
	mainLoop : LOOP

	FETCH listUnity INTO 	StageNum	;
	IF done	THEN
		LEAVE mainloop;
	END IF;	
		UPDATE `tbl_compute_stage` SET `stage_count`=`stage_count`+1 WHERE `stage` =StageNum ;
	END LOOP;
	CLOSE listUnity;
		
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ComputeStage`(	IN	TotalStage	INT	,	IN	TotalStageAmount INT	)
BEGIN
	declare LoopI			int;
	declare LoopJ			int;	
	declare TempAmount		int;
	declare TempBeforeStage		int;
	
	SET LoopI	=	1;
	SET TempAmount	=	0;
	SET TempBeforeStage	=	0;
	
	LoopI : LOOP
		IF LoopI	>	TotalStage	THEN
			LEAVE LoopI;
		END IF;
		IF LoopI	=	1	THEN 
			SET LoopJ	=	1;
			LoopJ : LOOP
				IF LoopJ	>	TotalStage	THEN	
					LEAVE LoopJ;
				END IF;
				SET TempAmount	=	TotalStageAmount	/	TotalStage;				
				INSERT INTO `tbl_compute_stage` (`stage` ,`amount`)	VALUES (LoopJ, TempAmount);
				SET LoopJ	=	LoopJ	+	1;					
			END LOOP;
		ELSE
			SET	TempAmount	=	(TotalStage	-	LoopI)	+1	;
			SET	TempBeforeStage	=	LoopI	-	1;
			UPDATE `tbl_compute_stage` SET `amount`=`amount`-TempAmount WHERE `stage` =TempBeforeStage ;
			SET LoopJ	=	LoopI;
			LoopJ : LOOP
				IF LoopJ	>	TotalStage	THEN	
					LEAVE LoopJ;
				END IF;
				UPDATE `tbl_compute_stage` SET `amount`=`amount`+1 WHERE `stage` =LoopJ ;
				SET LoopJ	=	LoopJ	+	1;	
			END LOOP;			
		END IF;
	
		SET LoopI	=	LoopI	+	1;	
	END LOOP;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ComputeStageZero`(IN `TotalStage` INT)
BEGIN
	DECLARE	TotalStageZero	INT	;
	DECLARE	TotalStageAmountZero INT;
	DECLARE LoopI			int;
	DECLARE LoopJ			int;
	DECLARE TempAmount		int;
	DECLARE TempStage		int;	
	DECLARE TempAmountCom		int;
	
	SET TempStage	=	0;
	SET TempAmountCom	=	0;
	SELECT 	SUM(amount)	INTO TotalStageAmountZero FROM tbl_compute_stage WHERE	stage_count=0;	
	SELECT 	count(*) INTO TotalStageZero FROM tbl_compute_stage WHERE	stage_count=0;

SET LoopI	=	1;
	LoopI : LOOP
		IF LoopI	>	TotalStage	-	TotalStageZero	THEN
			LEAVE LoopI;
		END IF;
		IF LoopI	=	1	THEN 
			SET LoopJ	=	1;
			LoopJ : LOOP
				IF LoopJ	>	TotalStage	-	TotalStageZero	THEN
					LEAVE LoopJ;
				END IF;
				SET	TempAmount	=	TotalStageAmountZero	/	(TotalStage	-	TotalStageZero);
				call	StageSearch(LoopJ	,	TempStage);
				UPDATE `tbl_compute_stage` SET `amount`=`amount`+TempAmount WHERE `stage` =TempStage ;
				SET LoopJ	=	LoopJ	+	1;	
			END LOOP;
		ELSE
			call	StageSearch(LoopI-1	,	TempStage);
			SET	TempAmount	=	(TotalStage	-	TempStage)		;
			UPDATE `tbl_compute_stage` SET `amount`=`amount`-TempAmount WHERE `stage` =TempStage ;
			SET LoopJ	=	LoopI;
			LoopJ : LOOP
				IF LoopJ	>	TotalStage	-	TotalStageZero	THEN	
					LEAVE LoopJ;
				END IF;
				call	StageSearch(LoopJ	,	TempStage);
				SET TempAmountCom	=	(TempAmount/ ((TotalStage	-	TotalStageZero)/LoopI))	;	
				UPDATE `tbl_compute_stage` SET `amount`=`amount`+ TempAmountCom WHERE `stage` =TempStage ;
				SET LoopJ	=	LoopJ	+	1;	
			END LOOP;		
			
		END IF;
		
	SET LoopI	=	LoopI	+	1;	
	END LOOP;	

	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ComputeType1`(IN `CostId` INT, IN `BlockId` INT, IN `OneMeterCost` INT, IN `UnityStatus` INT)
BEGIN
DECLARE	counter int;
DECLARE	UnitId int;
DECLARE	MeterNum int;
DECLARE	UserId int;
DECLARE	mul int;
DECLARE listUnity	CURSOR FOR SELECT id ,	 meter FROM tbl_unity where block_code	=	BlockId ;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET counter = TRUE;
OPEN listUnity;
mainLoop : LOOP

FETCH listUnity INTO UnitId	,	MeterNum;
IF counter	THEN
	LEAVE mainloop;
END IF;	
	call	getUserId(UnitId	,	UserId	,	UnityStatus);
	SET mul	=	OneMeterCost	* MeterNum;
	INSERT INTO tbl_cost_unity (id, cost_code, unity_code, `amount`, `create_date`	, `user_code`) VALUES (NULL, CostId, UnitId, mul, CURRENT_TIMESTAMP	,	UserId);

END LOOP;
CLOSE listUnity;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ComputeType2`(IN `CostId` INT, IN `BlockId` INT, IN `UnityCost` INT, IN `UnityStatus` INT)
BEGIN
DECLARE	counter int;
DECLARE	UnitId int;
DECLARE	UserId int;
DECLARE listUnity	CURSOR FOR SELECT id  FROM tbl_unity where block_code	=	BlockId ;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET counter = TRUE;
OPEN listUnity;
mainLoop : LOOP

FETCH listUnity INTO UnitId	;
IF counter	THEN
	LEAVE mainloop;
END IF;	
	call	getUserId(UnitId	,	UserId	,	UnityStatus);
	INSERT INTO tbl_cost_unity (id, cost_code, unity_code, `amount`, `create_date`, `user_code`) VALUES (NULL, CostId, UnitId, UnityCost, CURRENT_TIMESTAMP	,	UserId);

END LOOP;
CLOSE listUnity;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ComputeType3`(IN `CostId` INT, IN `BlockId` INT, IN `OnePersonCost` INT, IN `UnityStatus` INT)
BEGIN
DECLARE	counter int;
DECLARE	UnitId int;
DECLARE	Mul		int;
DECLARE	UserId	int;
DECLARE	PersonCount		int;
DECLARE listUnity	CURSOR FOR 

SELECT TU.id as id	,	TP.person_count	as person_count FROM tbl_unity TU 
JOIN tbl_leaseholder TL ON (TU.id	=	TL.unity_code)
JOIN tbl_profiles TP ON (TL.user_code	=	TP.user_id)
where TU.block_code	=	BlockId	and TL.status	=	1 ;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET counter = TRUE;
OPEN listUnity;
mainLoop : LOOP

FETCH listUnity INTO UnitId	,	PersonCount	;
IF counter	THEN
	LEAVE mainloop;
END IF;	
	SET	Mul	=		OnePersonCost	*	PersonCount;
	call	getUserId(UnitId	,	UserId	,	UnityStatus);
	INSERT INTO tbl_cost_unity (id, cost_code, unity_code, `amount`, `create_date`	,	`user_code`) VALUES (NULL, CostId, UnitId, Mul, CURRENT_TIMESTAMP	,	UserId);

END LOOP;
CLOSE listUnity;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ComputeType4`(IN `CostId` INT, IN `BlockId` INT, IN `UnityStatus` INT)
BEGIN
DECLARE	done int;
DECLARE	UnitId int;
DECLARE	StageNum		int;
DECLARE	AmountStage		int;
DECLARE	StageCount		int;
DECLARE	CostUnity		int;
DECLARE	UserId			int;

DECLARE listUnity	CURSOR FOR SELECT id ,	 stage FROM tbl_unity where block_code	=	BlockId ;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
OPEN listUnity;
mainLoop : LOOP

FETCH listUnity INTO UnitId	,	StageNum	;
IF done	THEN
	LEAVE mainloop;
END IF;	
	SELECT amount	,		stage_count	INTO AmountStage	,	StageCount	 FROM tbl_compute_stage WHERE stage	=	StageNum;	
	SET	CostUnity	=		AmountStage	/	StageCount;
	call	getUserId	(UnitId	,	UserId	,	UnityStatus);
	INSERT INTO tbl_cost_unity (id, cost_code, unity_code, `amount`, `create_date`	,	`user_code`) VALUES (NULL, CostId, UnitId, CostUnity, CURRENT_TIMESTAMP	,	UserId);
END LOOP;
CLOSE listUnity;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getOneMeterCost`(IN BlockId INT	,	IN TotalAmount INT	,	OUT OneMeterCost INT)
BEGIN
	declare TotalMeter	INT;
	select sum(meter) INTO TotalMeter FROM tbl_unity  WHERE block_code	=	BlockId ;
	SET	OneMeterCost	=	TotalAmount	/	TotalMeter;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getOnePersonCost`(IN `BlockId` INT, IN `TotalAmount` INT, OUT `OnePersonCost` INT)
BEGIN
	declare TotalPerson	INT;
	SELECT SUM(TP.person_count) INTO TotalPerson FROM tbl_leaseholder TL  
	JOIN tbl_profiles TP	ON (TP.user_id	=	TL.user_code)	
	WHERE TL.status	=	1 ;
	SET	OnePersonCost	=	TotalAmount	/	TotalPerson;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUserId`(IN `UnitId` INT, OUT `UserId` INT, IN `UnityStatus` INT)
BEGIN
	DECLARE	countNum int;

IF UnityStatus	=	1	THEN
	SELECT	count(*)	INTO	countNum	FROM	`tbl_leaseholder` 	WHERE	`unity_code`	=	UnitId		AND		`status` =	1	LIMIT 1;
	IF countNum	>=	1	THEN
		SELECT	`user_code`	INTO	UserId	FROM	`tbl_leaseholder` 	WHERE	`unity_code`	=	UnitId		AND		`status` =	1	LIMIT 1;
	ELSE
		SELECT	`user_code`	INTO UserId	FROM	`tbl_householder`		WHERE	`unity_code` 	=	UnitId		AND		`status` =1	LIMIT 1;
	END IF;	
END IF;
IF UnityStatus	=	2	THEN
	SELECT	`user_code`	INTO UserId	FROM	`tbl_householder`		WHERE	`unity_code` 	=	UnitId		AND		`status` =1	LIMIT 1;
END IF;



END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertLea`()
BEGIN
declare ID_L		int;
declare	STATUS_L	int;
declare	UNITY_ID	int;
declare	USER_ID		int;
call	leaDetail(ID_L	,	STATUS_L	,	UNITY_ID	,	USER_ID); 
IF STATUS_L	=	1	THEN
	call insertUpLea(	ID_L	,	UNITY_ID	,	USER_ID); 
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertUpLea`(IN `ID_L` INT, IN `UNITY_ID` INT, IN `USER_ID` INT)
BEGIN
	UPDATE `tbl_leaseholder` SET `status`=0 WHERE `user_code`	=	USER_ID	and `unity_code`=	UNITY_ID and id !=ID_L;
	UPDATE `tbl_leaseholder` SET `status`=1 WHERE `id`	=	ID_L;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `leaDetail`(OUT `ID_L` INT, OUT `STATUS_L` INT, OUT `UNITY_ID` INT, OUT `USER_ID` INT)
BEGIN
SELECT `id`,`status`,`unity_code`,`user_code` INTO	ID_L , STATUS_L , UNITY_ID , USER_ID FROM `tbl_leaseholder` order by id desc limit 1;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `main`()
BEGIN
	declare BlockId			int;
	declare CostTypeMode	int;
	declare	AmountUnity		char(10);
	declare CostId			int;
	declare	OneMeterCost	int;
	declare	CountUnity		int;
	declare	UnityCost		int;
	declare	OnePersonCost	INT;
	declare	SortNumber		INT;
	declare	AmountSharje	INT;
	declare	AmountIncome	INT;
	declare	Sharje			INT;
	declare	Income			INT;
	declare	Unity			INT;
	declare	UnityStatus		INT;
	
	/*	Get info block */
	call blockDetail( BlockId , CostTypeMode 	, CostId ,	 AmountUnity,	CountUnity	,	SortNumber	,	AmountSharje	,	AmountIncome	,	Sharje	,	Income	,	Unity	,	UnityStatus);
	
IF 	Unity	=	1	THEN

	CASE CostTypeMode
	WHEN 1 THEN 
		/*	Get Cost For One Meter */
		call getOneMeterCost ( BlockId , AmountUnity 	, OneMeterCost );
		call ComputeType1	( CostId	,	BlockId	,	OneMeterCost	,	UnityStatus);

	WHEN 2 THEN 
		SET UnityCost	=	AmountUnity	/	CountUnity	;
		call ComputeType2	( CostId	,	BlockId	,	UnityCost	,	UnityStatus);


	WHEN 3 THEN 
		call getOnePersonCost ( BlockId , AmountUnity 	, OnePersonCost );
		call ComputeType3	( CostId	,	BlockId	,	OnePersonCost	,	UnityStatus);

	WHEN 4 THEN 

		 call	ComputeStage (	SortNumber	,	AmountUnity	);

	/*SortNumber is total stage */
		call	ComputeCountUnityInStage (BlockId);
		call	ComputeStageZero	(SortNumber); /* SortNumber is total stage */
		call	ComputeType4 ( CostId 	, BlockId ,UnityStatus );
		call 	truncateComputeStage();
		 
	END CASE;
END IF;
IF 	Sharje	=	1	THEN
INSERT INTO `society`.`tbl_block_stock` (`id`, `amount`, `cost_code`) VALUES (NULL, AmountSharje, CostId);
END IF;
IF 	Income	=	1	THEN
INSERT INTO `society`.`tbl_block_stock` (`id`, `amount`, `cost_code`) VALUES (NULL, AmountIncome, CostId);
END IF;



END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `StageSearch`(	IN LimitNum	INT ,	OUT TempStage	INT )
BEGIN
	DECLARE done INT;
	DECLARE list	CURSOR FOR 	SELECT 	stage	FROM tbl_compute_stage WHERE	stage_count !=0 order by stage  limit LimitNum;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
	OPEN list;
	mainLoop : LOOP
		FETCH list INTO 	TempStage	;
		IF done	THEN
			LEAVE mainloop;
		END IF;	
		END LOOP;
	CLOSE list;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `truncateComputeStage`()
    NO SQL
DELETE FROM `tbl_compute_stage` WHERE 1$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `authassignment`
--

CREATE TABLE IF NOT EXISTS `authassignment` (
  `itemname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `userid` int(11) NOT NULL,
  `bizrule` text COLLATE utf8_unicode_ci,
  `data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`itemname`,`userid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `authassignment`
--

INSERT INTO `authassignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('accountant', 10, NULL, NULL),
('accountant', 21, NULL, NULL),
('admin', 1, NULL, NULL),
('manage', 2, NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `authitem`
--

CREATE TABLE IF NOT EXISTS `authitem` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `bizrule` text COLLATE utf8_unicode_ci,
  `data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `authitem`
--

INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('accountant', 2, 'accountant block', NULL, 'N;'),
('admin', 1, NULL, NULL, NULL),
('Bank.*', 1, NULL, NULL, 'N;'),
('Bank.Admin', 0, NULL, NULL, 'N;'),
('Bank.Create', 0, NULL, NULL, 'N;'),
('Bank.Delete', 0, NULL, NULL, 'N;'),
('Bank.Index', 0, NULL, NULL, 'N;'),
('Bank.Update', 0, NULL, NULL, 'N;'),
('Bank.View', 0, NULL, NULL, 'N;'),
('bazress', 2, 'bazress', NULL, 'N;'),
('Block.*', 1, NULL, NULL, 'N;'),
('Block.Admin', 0, NULL, NULL, 'N;'),
('Block.Create', 0, NULL, NULL, 'N;'),
('Block.Delete', 0, NULL, NULL, 'N;'),
('Block.Index', 0, NULL, NULL, 'N;'),
('Block.Update', 0, NULL, NULL, 'N;'),
('Block.View', 0, NULL, NULL, 'N;'),
('Charge.*', 1, NULL, NULL, 'N;'),
('Charge.Admin', 0, NULL, NULL, 'N;'),
('Charge.Create', 0, NULL, NULL, 'N;'),
('Charge.Delete', 0, NULL, NULL, 'N;'),
('Charge.Index', 0, NULL, NULL, 'N;'),
('Charge.Update', 0, NULL, NULL, 'N;'),
('Charge.View', 0, NULL, NULL, 'N;'),
('ChargeBase.*', 1, NULL, NULL, 'N;'),
('ChargeBase.Admin', 0, NULL, NULL, 'N;'),
('ChargeBase.Create', 0, NULL, NULL, 'N;'),
('ChargeBase.Delete', 0, NULL, NULL, 'N;'),
('ChargeBase.Index', 0, NULL, NULL, 'N;'),
('ChargeBase.Update', 0, NULL, NULL, 'N;'),
('ChargeBase.View', 0, NULL, NULL, 'N;'),
('Cost.*', 1, NULL, NULL, 'N;'),
('Cost.Admin', 0, NULL, NULL, 'N;'),
('Cost.Create', 0, NULL, NULL, 'N;'),
('Cost.Delete', 0, NULL, NULL, 'N;'),
('Cost.Index', 0, NULL, NULL, 'N;'),
('Cost.Update', 0, NULL, NULL, 'N;'),
('Cost.View', 0, NULL, NULL, 'N;'),
('CostType.*', 1, NULL, NULL, 'N;'),
('CostType.Admin', 0, NULL, NULL, 'N;'),
('CostType.Create', 0, NULL, NULL, 'N;'),
('CostType.Delete', 0, NULL, NULL, 'N;'),
('CostType.Index', 0, NULL, NULL, 'N;'),
('CostType.Update', 0, NULL, NULL, 'N;'),
('CostType.View', 0, NULL, NULL, 'N;'),
('CostTypeMode.*', 1, NULL, NULL, 'N;'),
('CostTypeMode.Admin', 0, NULL, NULL, 'N;'),
('CostTypeMode.Create', 0, NULL, NULL, 'N;'),
('CostTypeMode.Delete', 0, NULL, NULL, 'N;'),
('CostTypeMode.Index', 0, NULL, NULL, 'N;'),
('CostTypeMode.Update', 0, NULL, NULL, 'N;'),
('CostTypeMode.View', 0, NULL, NULL, 'N;'),
('Householder.*', 1, NULL, NULL, 'N;'),
('Householder.Admin', 0, NULL, NULL, 'N;'),
('Householder.Create', 0, NULL, NULL, 'N;'),
('Householder.Delete', 0, NULL, NULL, 'N;'),
('Householder.Index', 0, NULL, NULL, 'N;'),
('Householder.Update', 0, NULL, NULL, 'N;'),
('Householder.View', 0, NULL, NULL, 'N;'),
('Income.*', 1, NULL, NULL, 'N;'),
('Income.Admin', 0, NULL, NULL, 'N;'),
('Income.Create', 0, NULL, NULL, 'N;'),
('Income.Delete', 0, NULL, NULL, 'N;'),
('Income.Index', 0, NULL, NULL, 'N;'),
('Income.Update', 0, NULL, NULL, 'N;'),
('Income.View', 0, NULL, NULL, 'N;'),
('Leaseholder.*', 1, NULL, NULL, 'N;'),
('Leaseholder.Admin', 0, NULL, NULL, 'N;'),
('Leaseholder.Create', 0, NULL, NULL, 'N;'),
('Leaseholder.Delete', 0, NULL, NULL, 'N;'),
('Leaseholder.Index', 0, NULL, NULL, 'N;'),
('Leaseholder.Update', 0, NULL, NULL, 'N;'),
('Leaseholder.View', 0, NULL, NULL, 'N;'),
('manage', 2, 'manage system', NULL, 'N;'),
('manage_block', 2, 'manage_block', NULL, 'N;'),
('mostager', 2, 'mostager', NULL, 'N;'),
('Municipality.*', 1, NULL, NULL, 'N;'),
('Municipality.Admin', 0, NULL, NULL, 'N;'),
('Municipality.Create', 0, NULL, NULL, 'N;'),
('Municipality.Delete', 0, NULL, NULL, 'N;'),
('Municipality.Index', 0, NULL, NULL, 'N;'),
('Municipality.Update', 0, NULL, NULL, 'N;'),
('Municipality.View', 0, NULL, NULL, 'N;'),
('ReportUnity.BlockReport', 0, NULL, NULL, 'N;'),
('ReportUnity.NormalReport', 0, NULL, NULL, 'N;'),
('sahebkhaneh', 2, 'sahebkhaneh', NULL, 'N;'),
('Site.*', 1, NULL, NULL, 'N;'),
('Site.Contact', 0, NULL, NULL, 'N;'),
('Site.Error', 0, NULL, NULL, 'N;'),
('Site.Index', 0, NULL, NULL, 'N;'),
('Site.Login', 0, NULL, NULL, 'N;'),
('Site.Logout', 0, NULL, NULL, 'N;'),
('Unity.*', 1, NULL, NULL, 'N;'),
('Unity.Admin', 0, NULL, NULL, 'N;'),
('Unity.Create', 0, NULL, NULL, 'N;'),
('Unity.Delete', 0, NULL, NULL, 'N;'),
('Unity.Index', 0, NULL, NULL, 'N;'),
('Unity.Update', 0, NULL, NULL, 'N;'),
('Unity.View', 0, NULL, NULL, 'N;'),
('User.Admin.*', 1, NULL, NULL, 'N;'),
('User.Admin.Admin', 0, NULL, NULL, 'N;'),
('User.Admin.AssginRole', 0, NULL, NULL, 'N;'),
('User.Admin.Create', 0, NULL, NULL, 'N;'),
('User.Admin.Delete', 0, NULL, NULL, 'N;'),
('User.Admin.RoleManage', 0, NULL, NULL, 'N;'),
('User.Admin.Update', 0, NULL, NULL, 'N;'),
('User.Admin.View', 0, NULL, NULL, 'N;'),
('User.Default.*', 1, NULL, NULL, 'N;'),
('User.Default.Index', 0, NULL, NULL, 'N;'),
('User.Login.*', 1, NULL, NULL, 'N;'),
('User.Login.Login', 0, NULL, NULL, 'N;'),
('User.Logout.*', 1, NULL, NULL, 'N;'),
('User.Logout.Logout', 0, NULL, NULL, 'N;'),
('User.Profile.*', 1, NULL, NULL, 'N;'),
('User.Profile.Changepassword', 0, NULL, NULL, 'N;'),
('User.Profile.Edit', 0, NULL, NULL, 'N;'),
('User.Profile.Profile', 0, NULL, NULL, 'N;'),
('User.ProfileField.*', 1, NULL, NULL, 'N;'),
('User.ProfileField.Admin', 0, NULL, NULL, 'N;'),
('User.ProfileField.Create', 0, NULL, NULL, 'N;'),
('User.ProfileField.Delete', 0, NULL, NULL, 'N;'),
('User.ProfileField.Update', 0, NULL, NULL, 'N;'),
('User.ProfileField.View', 0, NULL, NULL, 'N;'),
('User.Recovery.*', 1, NULL, NULL, 'N;'),
('User.Recovery.Recovery', 0, NULL, NULL, 'N;'),
('User.Registration.*', 1, NULL, NULL, 'N;'),
('User.Registration.Registration', 0, NULL, NULL, 'N;'),
('User.User.*', 1, NULL, NULL, 'N;'),
('User.User.Index', 0, NULL, NULL, 'N;'),
('User.User.View', 0, NULL, NULL, 'N;'),
('Year.*', 1, NULL, NULL, 'N;'),
('Year.Admin', 0, NULL, NULL, 'N;'),
('Year.Create', 0, NULL, NULL, 'N;'),
('Year.Delete', 0, NULL, NULL, 'N;'),
('Year.Index', 0, NULL, NULL, 'N;'),
('Year.Update', 0, NULL, NULL, 'N;'),
('Year.View', 0, NULL, NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `authitemchild`
--

CREATE TABLE IF NOT EXISTS `authitemchild` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `authitemchild`
--

INSERT INTO `authitemchild` (`parent`, `child`) VALUES
('manage', 'Bank.*'),
('manage', 'Block.*'),
('accountant', 'Charge.*'),
('accountant', 'ChargeBase.*'),
('accountant', 'Cost.*'),
('manage', 'CostType.*'),
('accountant', 'Householder.*'),
('accountant', 'Income.*'),
('accountant', 'Leaseholder.*'),
('mostager', 'Leaseholder.*'),
('manage', 'Municipality.*'),
('accountant', 'ReportUnity.BlockReport'),
('manage', 'Unity.*'),
('manage', 'User.Admin.*'),
('manage', 'User.Default.*'),
('manage', 'User.Login.*'),
('manage', 'User.Logout.*'),
('manage', 'User.Profile.*'),
('manage', 'User.Registration.*'),
('manage', 'User.User.*'),
('manage', 'Year.*');

-- --------------------------------------------------------

--
-- Table structure for table `rights`
--

CREATE TABLE IF NOT EXISTS `rights` (
  `itemname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bank`
--

CREATE TABLE IF NOT EXISTS `tbl_bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول بانک' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_bank`
--

INSERT INTO `tbl_bank` (`id`, `title`) VALUES
(1, 'ملی'),
(2, 'ملت');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_block`
--

CREATE TABLE IF NOT EXISTS `tbl_block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'نام بلوک',
  `municipality_code` int(11) NOT NULL COMMENT 'شهرداری',
  `sort_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'تعداد طبقات',
  `gas_meter_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'شماره کنتور گاز',
  `water_meter_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'شماره کنتور آب',
  `common_elect_meter_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'شماره کنتور برق مشترک',
  `count_unity` int(11) NOT NULL COMMENT 'تعداد واحد',
  PRIMARY KEY (`id`),
  KEY `municipality_code` (`municipality_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='بلوک' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_block`
--

INSERT INTO `tbl_block` (`id`, `name`, `municipality_code`, `sort_number`, `gas_meter_num`, `water_meter_num`, `common_elect_meter_num`, `count_unity`) VALUES
(3, 'بلوک A', 1, '5', '360', '361', '362', 10),
(4, 'بلوک B', 1, '6', '460', '461', '462', 12);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_block_stock`
--

CREATE TABLE IF NOT EXISTS `tbl_block_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` int(11) NOT NULL COMMENT 'میزان',
  `cost_code` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cost_code` (`cost_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='جدول موجودی بلاک' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_charge`
--

CREATE TABLE IF NOT EXISTS `tbl_charge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unity_code` int(11) NOT NULL COMMENT 'واحد',
  `user_code` int(11) NOT NULL,
  `month_code` int(11) NOT NULL,
  `year_code` int(11) NOT NULL,
  `payment_code` int(11) NOT NULL COMMENT 'طریقه پرداخت',
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'مبلغ',
  `transaction_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'شماره برگه تراکنش',
  `date_cheque` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'تاریخ چک',
  `bank_code` int(11) DEFAULT NULL COMMENT 'بانک یا موسسه',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `month_code` (`month_code`,`year_code`),
  KEY `year_code` (`year_code`),
  KEY `payment_code` (`payment_code`),
  KEY `bank_code` (`bank_code`),
  KEY `unity_code` (`unity_code`),
  KEY `user_code` (`user_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول پرداخت شارژ' AUTO_INCREMENT=19 ;

--
-- Dumping data for table `tbl_charge`
--

INSERT INTO `tbl_charge` (`id`, `unity_code`, `user_code`, `month_code`, `year_code`, `payment_code`, `amount`, `transaction_num`, `date_cheque`, `bank_code`, `create_date`) VALUES
(17, 6, 10, 1, 2, 1, '20000', '', '0000-00-00 00:00:00', NULL, '2014-06-04 16:53:24'),
(18, 7, 12, 1, 2, 1, '10000', '', '0000-00-00 00:00:00', NULL, '2014-07-04 13:58:43');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_charge_base`
--

CREATE TABLE IF NOT EXISTS `tbl_charge_base` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `block_code` int(11) NOT NULL,
  `month_code` int(11) NOT NULL,
  `year_code` int(11) NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_persian_ci NOT NULL COMMENT 'میزان',
  `description` text COLLATE utf8mb4_persian_ci COMMENT 'توضیحات',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'تاریخ ایجاد',
  PRIMARY KEY (`id`),
  KEY `month_code` (`month_code`),
  KEY `year_code` (`year_code`),
  KEY `block_code` (`block_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci COMMENT='جدول پایه شارژ' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_charge_base`
--

INSERT INTO `tbl_charge_base` (`id`, `block_code`, `month_code`, `year_code`, `amount`, `description`, `create_date`) VALUES
(4, 3, 1, 2, '788', '', '2014-06-05 08:32:52');

--
-- Triggers `tbl_charge_base`
--
DROP TRIGGER IF EXISTS `mainInsert`;
DELIMITER //
CREATE TRIGGER `mainInsert` AFTER INSERT ON `tbl_charge_base`
 FOR EACH ROW CALL chargeBaseDetailMain()
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_charge_base_detail`
--

CREATE TABLE IF NOT EXISTS `tbl_charge_base_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `charge_base_code` int(11) NOT NULL,
  `user_code` int(11) NOT NULL,
  `unity_code` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_code` (`user_code`),
  KEY `unity_code` (`unity_code`),
  KEY `charge_base_code` (`charge_base_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci COMMENT='جدول که مشخص می کند شارژ به چه کسانی می خورد' AUTO_INCREMENT=43 ;

--
-- Dumping data for table `tbl_charge_base_detail`
--

INSERT INTO `tbl_charge_base_detail` (`id`, `charge_base_code`, `user_code`, `unity_code`) VALUES
(33, 4, 18, 5),
(34, 4, 10, 6),
(35, 4, 12, 7),
(36, 4, 13, 8),
(37, 4, 19, 9),
(38, 4, 14, 10),
(39, 4, 20, 11),
(40, 4, 15, 12),
(41, 4, 16, 13),
(42, 4, 17, 14);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_compute_stage`
--

CREATE TABLE IF NOT EXISTS `tbl_compute_stage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stage` int(11) NOT NULL,
  `amount` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `stage_count` int(11) NOT NULL DEFAULT '0' COMMENT 'تعداد واحد',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='جدول موقت برای محسابه هزینه طبقات' AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cost`
--

CREATE TABLE IF NOT EXISTS `tbl_cost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `block_code` int(11) NOT NULL COMMENT 'بلوک',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'شرح',
  `cost_type_code` int(11) NOT NULL,
  `amount_sharje` int(11) NOT NULL COMMENT 'میزانی که از شارژ خرج شود',
  `amount_income` int(11) NOT NULL COMMENT 'میزانی که از درآمد خرج شود',
  `amount_unity` int(11) NOT NULL COMMENT 'میزانی که از  واحدها گرفته شود',
  `sharje` int(11) NOT NULL DEFAULT '0' COMMENT 'شارژ',
  `income` int(11) NOT NULL DEFAULT '0' COMMENT 'درآمد',
  `unity` int(11) NOT NULL DEFAULT '0' COMMENT 'از واحد ها',
  `unity_status` int(11) NOT NULL DEFAULT '0' COMMENT '0 is none , 1 is har kasi ke saken ast , 2 is sabehkhaneh ha',
  `payment_code` int(11) NOT NULL COMMENT 'طریقه پرداخت',
  `transaction_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'شماره برگ تراکنش',
  `date_cheque` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'تاریخ چک',
  `bank_code` int(11) DEFAULT NULL COMMENT 'بانک یا موسسه',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `block_code` (`block_code`),
  KEY `cost_type_code` (`cost_type_code`),
  KEY `payment_code` (`payment_code`),
  KEY `bank_code` (`bank_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='هزینه ها' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_cost`
--

INSERT INTO `tbl_cost` (`id`, `block_code`, `description`, `cost_type_code`, `amount_sharje`, `amount_income`, `amount_unity`, `sharje`, `income`, `unity`, `unity_status`, `payment_code`, `transaction_num`, `date_cheque`, `bank_code`, `create_date`) VALUES
(1, 3, 'هزینه x', 1, 0, 0, 100000, 0, 0, 1, 1, 1, '', '2014-07-03 19:30:00', NULL, '2014-07-04 14:23:16'),
(4, 3, 'هزینه U', 5, 0, 0, 100000, 0, 0, 1, 1, 1, '', '2014-07-03 19:30:00', NULL, '2014-07-04 15:14:48');

--
-- Triggers `tbl_cost`
--
DROP TRIGGER IF EXISTS `mainRoute`;
DELIMITER //
CREATE TRIGGER `mainRoute` AFTER INSERT ON `tbl_cost`
 FOR EACH ROW CALL main()
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cost_type`
--

CREATE TABLE IF NOT EXISTS `tbl_cost_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cost_type_mode_code` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cost_type_mode_code` (`cost_type_mode_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='نوع هزینه ها' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_cost_type`
--

INSERT INTO `tbl_cost_type` (`id`, `cost_type_mode_code`, `title`) VALUES
(1, 1, 'برق مشاء'),
(2, 4, 'آب'),
(3, 1, 'گاز'),
(4, 4, 'آسانسور'),
(5, 2, 'سرایداری'),
(6, 3, 'شوفاژ خانه');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cost_type_mode`
--

CREATE TABLE IF NOT EXISTS `tbl_cost_type_mode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'عنوان واحد',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='جدول واحد نوع هزینه' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_cost_type_mode`
--

INSERT INTO `tbl_cost_type_mode` (`id`, `title`) VALUES
(1, 'متراژی'),
(2, 'واحدی'),
(3, 'نفری'),
(4, 'طبقاتی');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cost_unity`
--

CREATE TABLE IF NOT EXISTS `tbl_cost_unity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cost_code` int(11) NOT NULL,
  `user_code` int(11) NOT NULL COMMENT 'نام کاربری',
  `unity_code` int(11) NOT NULL,
  `amount` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'مبلغ',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `cost_code` (`cost_code`),
  KEY `unity_code` (`unity_code`),
  KEY `user_code` (`user_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='جدول ریز هزینه واحد' AUTO_INCREMENT=28 ;

--
-- Dumping data for table `tbl_cost_unity`
--

INSERT INTO `tbl_cost_unity` (`id`, `cost_code`, `user_code`, `unity_code`, `amount`, `create_date`) VALUES
(1, 1, 18, 5, '7750', '2014-07-04 14:23:16'),
(2, 1, 10, 6, '11625', '2014-07-04 14:23:16'),
(3, 1, 12, 7, '9300', '2014-07-04 14:23:16'),
(4, 1, 13, 8, '12400', '2014-07-04 14:23:16'),
(5, 1, 19, 9, '10075', '2014-07-04 14:23:16'),
(6, 1, 14, 10, '11625', '2014-07-04 14:23:16'),
(7, 1, 20, 11, '9300', '2014-07-04 14:23:16'),
(8, 1, 15, 12, '7750', '2014-07-04 14:23:16'),
(9, 1, 16, 13, '9300', '2014-07-04 14:23:16'),
(10, 1, 17, 14, '10850', '2014-07-04 14:23:16'),
(15, 4, 18, 5, '10000', '2014-07-04 15:14:48'),
(16, 4, 10, 6, '10000', '2014-07-04 15:14:48'),
(17, 4, 12, 7, '10000', '2014-07-04 15:14:48'),
(18, 4, 13, 8, '10000', '2014-07-04 15:14:48'),
(19, 4, 19, 9, '10000', '2014-07-04 15:14:48'),
(20, 4, 14, 10, '10000', '2014-07-04 15:14:48'),
(21, 4, 20, 11, '10000', '2014-07-04 15:14:48'),
(22, 4, 15, 12, '10000', '2014-07-04 15:14:48'),
(23, 4, 16, 13, '10000', '2014-07-04 15:14:48'),
(24, 4, 17, 14, '10000', '2014-07-04 15:14:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_householder`
--

CREATE TABLE IF NOT EXISTS `tbl_householder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 is active 0 is deactive',
  `unity_code` int(11) NOT NULL COMMENT 'واحد',
  `user_code` int(11) NOT NULL COMMENT 'شخصیت صاحب ملک',
  `begin_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'تاریخ شروع',
  `end_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'تاریخ پایان',
  PRIMARY KEY (`id`),
  KEY `unity_code` (`unity_code`),
  KEY `user_code` (`user_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول صاحب خانه ها' AUTO_INCREMENT=47 ;

--
-- Dumping data for table `tbl_householder`
--

INSERT INTO `tbl_householder` (`id`, `status`, `unity_code`, `user_code`, `begin_date`, `end_date`) VALUES
(24, 1, 5, 10, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(25, 1, 6, 10, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(26, 1, 7, 12, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(27, 1, 8, 13, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(28, 1, 9, 14, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(29, 1, 10, 14, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(30, 1, 11, 14, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(31, 1, 12, 15, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(32, 1, 13, 16, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(33, 1, 14, 17, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(34, 1, 15, 21, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(35, 1, 16, 21, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(37, 1, 17, 22, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(38, 1, 18, 23, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(39, 1, 19, 23, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(40, 1, 20, 23, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(41, 1, 21, 24, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(42, 1, 22, 25, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(43, 1, 23, 26, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(44, 1, 24, 27, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(45, 1, 25, 28, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(46, 1, 26, 29, '2014-06-03 20:30:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_income`
--

CREATE TABLE IF NOT EXISTS `tbl_income` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `block_code` int(11) NOT NULL COMMENT 'بلوک',
  `description` text COLLATE utf8mb4_unicode_ci COMMENT 'شرح',
  `amount` int(11) NOT NULL,
  `payment_code` int(11) NOT NULL COMMENT 'طریقه پرداخت',
  `transaction_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'شماره برگه تراکنش',
  `date_cheque` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'تاریخ چک',
  `bank_code` int(11) DEFAULT NULL COMMENT 'بانک یا موسسه',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `payment_code` (`payment_code`),
  KEY `bank_code` (`bank_code`),
  KEY `block_code` (`block_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول درآمد' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leaseholder`
--

CREATE TABLE IF NOT EXISTS `tbl_leaseholder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 is active , 0 is deactive',
  `unity_code` int(11) NOT NULL COMMENT 'واحد',
  `user_code` int(11) NOT NULL COMMENT 'فرد',
  `begin_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `unity_code` (`unity_code`),
  KEY `user_code` (`user_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='مستاجرین' AUTO_INCREMENT=50 ;

--
-- Dumping data for table `tbl_leaseholder`
--

INSERT INTO `tbl_leaseholder` (`id`, `status`, `unity_code`, `user_code`, `begin_date`, `end_date`) VALUES
(43, 1, 15, 30, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, 1, 19, 31, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(46, 1, 20, 32, '2014-06-10 20:30:00', '0000-00-00 00:00:00'),
(47, 1, 5, 18, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(48, 1, 9, 19, '2014-06-03 20:30:00', '0000-00-00 00:00:00'),
(49, 1, 11, 20, '2014-06-03 20:30:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_month`
--

CREATE TABLE IF NOT EXISTS `tbl_month` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول ماه' AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tbl_month`
--

INSERT INTO `tbl_month` (`id`, `title`) VALUES
(1, 'فروردین'),
(2, 'اردیبهشت'),
(3, 'خرداد'),
(4, 'تیر'),
(5, 'مرداد'),
(6, 'شهریور'),
(7, 'مهر'),
(8, 'آبان'),
(9, 'آذر'),
(10, 'دی'),
(11, 'بهمن'),
(12, 'اسفند');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_municipality`
--

CREATE TABLE IF NOT EXISTS `tbl_municipality` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'نام شهرداری',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='شهرداری' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_municipality`
--

INSERT INTO `tbl_municipality` (`id`, `name`) VALUES
(1, 'شهرداری مرکزی');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

CREATE TABLE IF NOT EXISTS `tbl_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول نحوه پرداخت' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_payment`
--

INSERT INTO `tbl_payment` (`id`, `title`) VALUES
(1, 'نقدی'),
(2, 'با کارت عابر بانک'),
(3, 'چک');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profiles`
--

CREATE TABLE IF NOT EXISTS `tbl_profiles` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `person_count` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `tbl_profiles`
--

INSERT INTO `tbl_profiles` (`user_id`, `lastname`, `firstname`, `person_count`) VALUES
(1, 'Admin', 'Administrator', 3),
(2, 'خواجه حسینی', 'یدالله ', 4),
(10, 'صفری', 'مچمد', 4),
(11, 'امامی', 'احمد', 4),
(12, 'حسنی', 'نیما', 4),
(13, 'هاشمی', 'امیر', 4),
(14, 'بیات', 'حسن', 4),
(15, 'افتخاری', 'محمود', 4),
(16, 'همتی', 'مازیار', 4),
(17, 'آزادی', 'حسین', 4),
(18, 'اکبری', 'محمد', 4),
(19, 'عبادی', 'ارسلان', 4),
(20, 'پورسعید', 'فرید', 4),
(21, 'آریا', 'امین', 4),
(22, 'هاشمی', 'اکبر', 4),
(23, 'حمیدی', 'احسان', 4),
(24, 'احمدی', 'افشین', 4),
(25, 'محمودی', 'علی', 4),
(26, 'حسنی', 'اکبر', 4),
(27, 'عزیزی', 'علیرضا', 4),
(28, 'دهقان', 'مسعود', 4),
(29, 'تیموری', 'امیرحسین', 4),
(30, 'کردی', 'ابراهیم', 4),
(31, 'گلوردی', 'اصغر', 4),
(32, 'مرادی', 'ایمان', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profiles_fields`
--

CREATE TABLE IF NOT EXISTS `tbl_profiles_fields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `field_size` varchar(15) NOT NULL DEFAULT '0',
  `field_size_min` varchar(15) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` varchar(5000) NOT NULL DEFAULT '',
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` varchar(5000) NOT NULL DEFAULT '',
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `varname` (`varname`,`widget`,`visible`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_profiles_fields`
--

INSERT INTO `tbl_profiles_fields` (`id`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `widget`, `widgetparams`, `position`, `visible`) VALUES
(1, 'lastname', 'نام خانوادگی', 'VARCHAR', '50', '3', 1, '', '', 'Incorrect Last Name (length between 3 and 50 characters).', '', '', '', '', 1, 3),
(2, 'firstname', 'نام', 'VARCHAR', '50', '3', 1, '', '', 'Incorrect First Name (length between 3 and 50 characters).', '', '', '', '', 0, 3),
(3, 'person_count', 'تعداد افراد خانواده', 'INTEGER', '10', '0', 1, '', '', '', '', '0', '', '', 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role`
--

CREATE TABLE IF NOT EXISTS `tbl_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'شخصیت',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='شخصیت ها' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_role`
--

INSERT INTO `tbl_role` (`id`, `title`) VALUES
(3, 'بازرس'),
(4, 'مدیربلوک'),
(5, 'حسابدار');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_unity`
--

CREATE TABLE IF NOT EXISTS `tbl_unity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'شماره واحد',
  `block_code` int(11) NOT NULL COMMENT 'بلوک',
  `elect_meter_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'شماره کنتور برق',
  `meter` int(11) NOT NULL COMMENT 'متراژ خانه',
  `stage` int(11) NOT NULL COMMENT 'طبقه',
  PRIMARY KEY (`id`),
  KEY `block_code` (`block_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='واحد' AUTO_INCREMENT=27 ;

--
-- Dumping data for table `tbl_unity`
--

INSERT INTO `tbl_unity` (`id`, `name`, `block_code`, `elect_meter_num`, `meter`, `stage`) VALUES
(5, 'واحد  A 1', 3, '321', 50, 1),
(6, 'واحد A 2', 3, '322', 75, 1),
(7, 'واحد A3', 3, '323', 60, 2),
(8, 'واحد A4', 3, '324', 80, 2),
(9, 'واحد A5', 3, '325', 65, 3),
(10, 'واحد A6', 3, '326', 75, 3),
(11, 'واحد  A7', 3, '327', 60, 4),
(12, 'واحد A8', 3, '328', 50, 4),
(13, 'واحد A9', 3, '329', 60, 5),
(14, 'واحد A10', 3, '330', 70, 5),
(15, 'واحد  B1', 4, '421', 51, 1),
(16, 'واحد B2', 4, '422', 76, 1),
(17, 'واحد B3', 4, '423', 61, 2),
(18, 'واحد B4', 4, '424', 81, 2),
(19, 'واحد B5', 4, '425', 65, 3),
(20, 'واحد B6', 4, '426', 75, 3),
(21, 'واحد  B7', 4, '427', 60, 4),
(22, 'واحد B8', 4, '428', 50, 4),
(23, 'واحد B9', 4, '429', 60, 5),
(24, 'واحد B10', 4, '430', 70, 5),
(25, 'واحد B11', 4, '431', 60, 6),
(26, 'واحد B12', 4, '432', 70, 6);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`),
  KEY `superuser_2` (`superuser`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `username`, `password`, `email`, `activkey`, `create_at`, `lastvisit_at`, `superuser`, `status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'webmaster@example.com', '9a24eff8c15a6a141ece27eb6947da0f', '2013-12-03 10:16:26', '2014-06-05 03:46:04', 1, 1),
(2, 'khajehossini', 'e10adc3949ba59abbe56e057f20f883e', 'khajehossini@gmail.com5', 'c577fa5e0de9361458fc92fee6238af4', '2013-12-17 06:38:52', '2014-07-04 10:49:54', 0, 1),
(10, 'mohammadsafari', 'e10adc3949ba59abbe56e057f20f883e', 'mohammadsafari@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 05:34:32', '2014-07-04 10:51:56', 0, 1),
(11, 'ahmmademami', 'e10adc3949ba59abbe56e057f20f883e', 'ahmmademami@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '2014-07-04 09:19:59', 0, 1),
(12, 'nimahasani', 'e10adc3949ba59abbe56e057f20f883e', 'nimahasani@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '2014-07-04 09:26:19', 0, 1),
(13, 'amirhashemi', 'e10adc3949ba59abbe56e057f20f883e', 'amirhashemi@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '0000-00-00 00:00:00', 0, 1),
(14, 'hasanbayat', 'e10adc3949ba59abbe56e057f20f883e', 'hasanbayat@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '2014-06-04 11:52:07', 0, 1),
(15, 'mahmodeftekhari', 'e10adc3949ba59abbe56e057f20f883e', 'mahmodeftekhari@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '0000-00-00 00:00:00', 0, 1),
(16, 'maziyarhemati', 'e10adc3949ba59abbe56e057f20f883e', 'maziyarhemati@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '0000-00-00 00:00:00', 0, 1),
(17, 'hosseinazadi', 'e10adc3949ba59abbe56e057f20f883e', 'hosseinazadi@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '0000-00-00 00:00:00', 0, 1),
(18, 'mohammadakbari', 'e10adc3949ba59abbe56e057f20f883e', 'mohammadakbari@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '0000-00-00 00:00:00', 0, 1),
(19, 'arsalanebadi', 'e10adc3949ba59abbe56e057f20f883e', 'arsalanebadi@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '0000-00-00 00:00:00', 0, 1),
(20, 'faridpursaeed', 'e10adc3949ba59abbe56e057f20f883e', 'faridpursaeed@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '0000-00-00 00:00:00', 0, 1),
(21, 'aminariya', 'e10adc3949ba59abbe56e057f20f883e', 'aminariya@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '2014-06-04 11:14:45', 0, 1),
(22, 'akbarhashemi', 'e10adc3949ba59abbe56e057f20f883e', 'akbarhashemi@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '0000-00-00 00:00:00', 0, 1),
(23, 'ehsanhamidi', 'e10adc3949ba59abbe56e057f20f883e', 'ehsanhamidi@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '0000-00-00 00:00:00', 0, 1),
(24, 'afshinahmmadi', 'e10adc3949ba59abbe56e057f20f883e', 'afshinahmmadi@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '0000-00-00 00:00:00', 0, 1),
(25, 'alimahmodi', 'e10adc3949ba59abbe56e057f20f883e', 'alimahmodi@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '0000-00-00 00:00:00', 0, 1),
(26, 'akbarhasani', 'e10adc3949ba59abbe56e057f20f883e', 'akbarhasani@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '0000-00-00 00:00:00', 0, 1),
(27, 'alirezaazizi', 'e10adc3949ba59abbe56e057f20f883e', 'alirezaazizi@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '0000-00-00 00:00:00', 0, 1),
(28, 'masooddehghan', 'e10adc3949ba59abbe56e057f20f883e', 'masooddehghan@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '0000-00-00 00:00:00', 0, 1),
(29, 'amirhosseinteymori', 'e10adc3949ba59abbe56e057f20f883e', 'amirhosseinteymori@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '0000-00-00 00:00:00', 0, 1),
(30, 'ebrahimkordi', 'e10adc3949ba59abbe56e057f20f883e', 'ebrahimkordi@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '0000-00-00 00:00:00', 0, 1),
(31, 'asghargolverdi', 'e10adc3949ba59abbe56e057f20f883e', 'asghargolverdi@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '0000-00-00 00:00:00', 0, 1),
(32, 'emanmoradi', 'e10adc3949ba59abbe56e057f20f883e', 'emanmoradi@gmail.com', '0792755fc311c4cf831d0ca17be13e24', '2014-05-03 01:04:32', '0000-00-00 00:00:00', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_role`
--

CREATE TABLE IF NOT EXISTS `tbl_user_role` (
  `user_code` int(11) NOT NULL,
  `role_code` int(11) NOT NULL,
  `block_code` int(11) DEFAULT NULL,
  UNIQUE KEY `user_code_2` (`user_code`,`role_code`),
  KEY `user_code` (`user_code`),
  KEY `role_code` (`role_code`),
  KEY `block_code` (`block_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ثبت کاربر به شخصیت';

--
-- Dumping data for table `tbl_user_role`
--

INSERT INTO `tbl_user_role` (`user_code`, `role_code`, `block_code`) VALUES
(10, 5, 3),
(21, 5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_year`
--

CREATE TABLE IF NOT EXISTS `tbl_year` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول سال' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_year`
--

INSERT INTO `tbl_year` (`id`, `title`) VALUES
(1, 1392),
(2, 1393);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `authassignment`
--
ALTER TABLE `authassignment`
  ADD CONSTRAINT `authassignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `authassignment_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `authitemchild`
--
ALTER TABLE `authitemchild`
  ADD CONSTRAINT `authitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `authitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rights`
--
ALTER TABLE `rights`
  ADD CONSTRAINT `rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_block`
--
ALTER TABLE `tbl_block`
  ADD CONSTRAINT `tbl_block_ibfk_1` FOREIGN KEY (`municipality_code`) REFERENCES `tbl_municipality` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_block_stock`
--
ALTER TABLE `tbl_block_stock`
  ADD CONSTRAINT `tbl_block_stock_ibfk_1` FOREIGN KEY (`cost_code`) REFERENCES `tbl_cost` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_charge`
--
ALTER TABLE `tbl_charge`
  ADD CONSTRAINT `tbl_charge_ibfk_10` FOREIGN KEY (`payment_code`) REFERENCES `tbl_payment` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_charge_ibfk_11` FOREIGN KEY (`bank_code`) REFERENCES `tbl_bank` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `tbl_charge_ibfk_12` FOREIGN KEY (`user_code`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_charge_ibfk_7` FOREIGN KEY (`unity_code`) REFERENCES `tbl_unity` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_charge_ibfk_8` FOREIGN KEY (`month_code`) REFERENCES `tbl_month` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_charge_ibfk_9` FOREIGN KEY (`year_code`) REFERENCES `tbl_year` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_charge_base`
--
ALTER TABLE `tbl_charge_base`
  ADD CONSTRAINT `tbl_charge_base_ibfk_1` FOREIGN KEY (`month_code`) REFERENCES `tbl_month` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_charge_base_ibfk_2` FOREIGN KEY (`year_code`) REFERENCES `tbl_year` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_charge_base_ibfk_3` FOREIGN KEY (`block_code`) REFERENCES `tbl_block` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_charge_base_detail`
--
ALTER TABLE `tbl_charge_base_detail`
  ADD CONSTRAINT `tbl_charge_base_detail_ibfk_1` FOREIGN KEY (`charge_base_code`) REFERENCES `tbl_charge_base` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_charge_base_detail_ibfk_2` FOREIGN KEY (`user_code`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_charge_base_detail_ibfk_3` FOREIGN KEY (`unity_code`) REFERENCES `tbl_unity` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_cost`
--
ALTER TABLE `tbl_cost`
  ADD CONSTRAINT `tbl_cost_ibfk_10` FOREIGN KEY (`block_code`) REFERENCES `tbl_block` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_cost_ibfk_11` FOREIGN KEY (`cost_type_code`) REFERENCES `tbl_cost_type` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_cost_ibfk_12` FOREIGN KEY (`payment_code`) REFERENCES `tbl_payment` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_cost_ibfk_13` FOREIGN KEY (`bank_code`) REFERENCES `tbl_bank` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_cost_type`
--
ALTER TABLE `tbl_cost_type`
  ADD CONSTRAINT `tbl_cost_type_ibfk_1` FOREIGN KEY (`cost_type_mode_code`) REFERENCES `tbl_cost_type_mode` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_cost_unity`
--
ALTER TABLE `tbl_cost_unity`
  ADD CONSTRAINT `tbl_cost_unity_ibfk_1` FOREIGN KEY (`cost_code`) REFERENCES `tbl_cost` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_cost_unity_ibfk_2` FOREIGN KEY (`unity_code`) REFERENCES `tbl_unity` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_cost_unity_ibfk_3` FOREIGN KEY (`user_code`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_householder`
--
ALTER TABLE `tbl_householder`
  ADD CONSTRAINT `tbl_householder_ibfk_1` FOREIGN KEY (`unity_code`) REFERENCES `tbl_unity` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_householder_ibfk_2` FOREIGN KEY (`user_code`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_income`
--
ALTER TABLE `tbl_income`
  ADD CONSTRAINT `tbl_income_ibfk_3` FOREIGN KEY (`block_code`) REFERENCES `tbl_block` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_income_ibfk_4` FOREIGN KEY (`payment_code`) REFERENCES `tbl_payment` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_income_ibfk_5` FOREIGN KEY (`bank_code`) REFERENCES `tbl_bank` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_leaseholder`
--
ALTER TABLE `tbl_leaseholder`
  ADD CONSTRAINT `tbl_leaseholder_ibfk_1` FOREIGN KEY (`unity_code`) REFERENCES `tbl_unity` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_leaseholder_ibfk_2` FOREIGN KEY (`user_code`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_profiles`
--
ALTER TABLE `tbl_profiles`
  ADD CONSTRAINT `tbl_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_unity`
--
ALTER TABLE `tbl_unity`
  ADD CONSTRAINT `tbl_unity_ibfk_1` FOREIGN KEY (`block_code`) REFERENCES `tbl_block` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_user_role`
--
ALTER TABLE `tbl_user_role`
  ADD CONSTRAINT `tbl_user_role_ibfk_2` FOREIGN KEY (`user_code`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_user_role_ibfk_3` FOREIGN KEY (`role_code`) REFERENCES `tbl_role` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_user_role_ibfk_4` FOREIGN KEY (`block_code`) REFERENCES `tbl_block` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
