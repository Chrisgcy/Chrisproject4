-- MySQL dump 10.13  Distrib 5.6.16, for osx10.7 (x86_64)
--
-- Host: localhost    Database: communitynetwork
-- ------------------------------------------------------
-- Server version	5.6.16
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping routines for database 'communitynetwork'
--
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `checkPwd`(
OUT result BOOL, 
IN username VARCHAR(40), 
IN pwd VARCHAR(16))
BEGIN  
IF exists (
select * from Users where uname = username and password = pwd) THEN
SET result = 1;
ELSE 
SET result = 0;
END IF; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `commentDiary`(
IN username VARCHAR(40), 
IN diary_id INT(16),
IN content varchar(160))
BEGIN  
insert into Comment (uname, did, ccontent) 
values (username, diary_id, content);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `confirmFriend`(
IN username VARCHAR(40), 
IN friendname VARCHAR(40))
BEGIN  
IF EXISTS(
SELECT * FROM Friends 
WHERE uname=username and funame=friendname and accept<>'yes')
THEN
update Friends set accept="yes", ts_con=CURRENT_TIMESTAMP 
where uname=username and funame=friendname;
END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `likeDiary`(
IN username VARCHAR(40), 
IN did INT(16))
BEGIN  
insert into Like_Diary values (username, did);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `listDiaryByFriendsWithLikes`(IN username VARCHAR(40))
BEGIN
select d.*, L.cnt from 
(select Diary.*, nid, ncontent, iid, icontent, aid, acontent, vid, vcontent, aname, lname, longitude, latitude 
from Diary 
left join Note on Diary.did=Note.did
left join Image on Diary.did=Image.did
left join Audio on Diary.did=Audio.did
left join Video on Diary.did=Video.did 
left join Activity on Diary.actid=Activity.actid
left join Location on Diary.lid= Location.lid 

ORDER BY did DESC
) as d
left join 
(select did, count(*) as cnt from Like_diary group by did) AS L
on d.did=L.did
where d.uname in 
(select * from (
(select funame from Friends where uname=username and accept="yes")
union 
(select uname from Friends where funame=username and accept="yes")
) as f);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `listDiaryByUser`(IN username VARCHAR(40))
BEGIN  
select * from Diary left join Note on Diary.did=Note.did
left join Image on Diary.did=Image.did
left join Audio on Diary.did=Audio.did
left join Video on Diary.did=Video.did 
where Diary.uname=username;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `listDiaryByUserWithLikes`(IN username VARCHAR(40))
BEGIN 
select D.*, L.cnt from 
(select Diary.*, nid, ncontent, iid, icontent, aid, acontent, vid, vcontent, aname, lname, longitude, latitude from Diary 
left join Note on Diary.did=Note.did
left join Image on Diary.did=Image.did
left join Audio on Diary.did=Audio.did
left join Video on Diary.did=Video.did 
left join Activity on Diary.actid=Activity.actid
left join Location on Diary.lid= Location.lid 
where Diary.uname=username) AS D
left join 
(
select did, count(*) as cnt from Like_diary group by did
) AS L
on D.did=L.did;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `listFOFs`(IN username VARCHAR(40))
BEGIN  
SELECT * FROM ((SELECT F2.funame FROM Friends AS F1 JOIN Friends AS F2 ON F1.funame=F2.uname WHERE F1.uname=username AND F1.accept="yes" AND F2.accept="yes")
UNION
(SELECT F2.uname FROM Friends AS F1 JOIN Friends AS F2 ON F1.funame=F2.funame 
WHERE F1.uname=username AND F1.accept="yes" AND F2.accept="yes" AND F2.uname<>username)
UNION
(SELECT F2.funame FROM Friends AS F1 JOIN Friends AS F2 ON F1.uname=F2.uname 
WHERE F1.funame=username AND F1.accept="yes" AND F2.accept="yes" AND F2.funame<>username)
UNION
(SELECT F2.uname FROM Friends AS F1 join Friends AS F2 ON F1.uname=F2.funame 
WHERE F1.funame=username AND F1.accept="yes" AND F2.accept="yes")) AS F3 
WHERE F3.funame NOT IN (SELECT funame FROM Friends WHERE uname=username AND accept="yes")
AND
F3.funame NOT IN (SELECT uname FROM Friends WHERE funame=username AND accept="yes");
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `listFriends`(IN username VARCHAR(40))
BEGIN  
(select funame from Friends where uname="Tim" and accept="yes")
union 
(select uname from Friends where funame="Tim" and accept="yes");
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `listUserInfo`(IN username VARCHAR(40))
BEGIN  
select * from Users where uname=username;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `login`(
OUT result BOOL, 
IN username VARCHAR(40), 
IN pwd VARCHAR(16))
BEGIN  
call checkPwd(result, username, pwd);
IF result THEN
update Users set lastlogin=CURRENT_TIMESTAMP 
where uname = username;
END IF; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `requestFriend`(
IN username VARCHAR(40), 
IN friendname VARCHAR(40))
BEGIN  
IF NOT EXISTS(
(SELECT * FROM Friends 
WHERE uname=username and funame=friendname) 
UNION 
(Select * from Friends 
where uname= friendname and funame= username))
THEN
insert into Friends (uname, funame) 
values (username, friendname);
END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `searchDiaryByActKey`(
                              IN username VARCHAR(40),
                              IN keyword VARCHAR(160))
BEGIN
select * from
    (select * from activity where aname like keyword) as A,
    (select Diary.*, nid, ncontent, iid, icontent, aid, acontent, vid, vcontent, lname, longitude, latitude from
        Diary
        left join Note on Diary.did=Note.did
        left join Image on Diary.did=Image.did
        left join Audio on Diary.did=Audio.did
        left join Video on Diary.did=Video.did
        left join Location on Diary.lid= Location.lid
        ORDER BY did DESC
    ) as D
    where
    A.actid=D.actid and
    (D.uname=username or
     D.visible='everyone' or
     (D.uname in (
                  select * from ((select funame from Friends where uname=username and accept="yes")
                                 union
                                 (select uname from Friends where funame=username and accept="yes")
                                 ) as F
                  )
      ) or
     (D.visible='fof' and
      D.uname in (
                  SELECT * FROM (
                                 (SELECT F2.funame FROM Friends AS F1
                                  JOIN Friends AS F2 ON F1.funame=F2.uname
                                  WHERE F1.uname=username AND F1.accept="yes"
                                  AND F2.accept="yes")
                                 UNION
                                 (SELECT F2.uname FROM Friends AS F1
                                  JOIN Friends AS F2 ON F1.funame=F2.funame
                                  WHERE F1.uname=username AND F1.accept="yes"
                                  AND F2.accept="yes")
                                 UNION
                                 (SELECT F2.funame FROM Friends AS F1
                                  JOIN Friends AS F2 ON F1.uname=F2.uname
                                  WHERE F1.funame=username AND F1.accept="yes"
                                  AND F2.accept="yes")
                                 UNION
                                 (SELECT F2.uname FROM Friends AS F1 
                                  join Friends AS F2 ON F1.uname=F2.funame 
                                  WHERE F1.funame=username AND F1.accept="yes"
                                  AND F2.accept="yes")
                                 ) AS F3 
                 )
     )
     );
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `searchDiaryByLocation`(
                              IN username VARCHAR(40),
                              IN locationid VARCHAR(160))
BEGIN
select * from
    (select * from Location where lid=locationid) as L,
    (select Diary.*, nid, ncontent, iid, icontent, aid, acontent, vid, vcontent, lname, longitude, latitude from
        Diary
        left join Note on Diary.did=Note.did
        left join Image on Diary.did=Image.did
        left join Audio on Diary.did=Audio.did
        left join Video on Diary.did=Video.did
        left join Location on Diary.lid= Location.lid
        ORDER BY did DESC
    ) as D
    where
    L.lid=D.lid and
    (D.uname="Tim" or
     D.visible='everyone' or
     (D.uname in (
                  select * from ((select funame from Friends where uname="Tim" and accept="yes")
                                 union
                                 (select uname from Friends where funame="Tim" and accept="yes")
                                 ) as F
                  )
      ) or
     (D.visible='fof' and
      D.uname in (
                  SELECT * FROM (
                                 (SELECT F2.funame FROM Friends AS F1
                                  JOIN Friends AS F2 ON F1.funame=F2.uname
                                  WHERE F1.uname="Tim" AND F1.accept="yes"
                                  AND F2.accept="yes")
                                 UNION
                                 (SELECT F2.uname FROM Friends AS F1
                                  JOIN Friends AS F2 ON F1.funame=F2.funame
                                  WHERE F1.uname="Tim" AND F1.accept="yes"
                                  AND F2.accept="yes")
                                 UNION
                                 (SELECT F2.funame FROM Friends AS F1
                                  JOIN Friends AS F2 ON F1.uname=F2.uname
                                  WHERE F1.funame="Tim" AND F1.accept="yes"
                                  AND F2.accept="yes")
                                 UNION
                                 (SELECT F2.uname FROM Friends AS F1 
                                  join Friends AS F2 ON F1.uname=F2.funame 
                                  WHERE F1.funame="Tim" AND F1.accept="yes"
                                  AND F2.accept="yes")
                                 ) AS F3 
                 )
     )
     );
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `userlikeActivity`(
in username varchar(40),
out id int(16))
begin
select actid into id from Like_activity where uname=username; end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `whoLikesDiary`(IN diary_id INT(16))
BEGIN  
select uname from Like_diary where did=diary_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-10 20:02:40
