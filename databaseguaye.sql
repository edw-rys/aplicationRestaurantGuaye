DROP DATABASE IF EXISTS guaye;
create DATABASE guaye;
use guaye;

-- PROCEDIMIENTOS
DELIMITER $$

DELIMITER $$
-- Borrado Lógico
DROP PROCEDURE IF EXISTS `deleteStatusUser`$$
CREATE PROCEDURE deleteStatusUser(
	IN iduser INT,
	IN usname VARCHAR(20),
	IN psswd VARCHAR(20)
	)
BEGIN
	UPDATE user_
	set  status=0 where id_user=iduser and password=psswd;
END$$

DROP PROCEDURE IF EXISTS `deleteStatusEvent`$$
CREATE PROCEDURE deleteStatusEvent(
		IN idevt int
	)
BEGIN
	UPDATE event_
	set  status=0
	where id_event=idevt;
END$$


-- borrado lógico del blog
-- actualizar ingredientes
DROP PROCEDURE IF EXISTS `deleteStatusIngredient`$$
CREATE PROCEDURE deleteStatusIngredient(
		IN id_i int
	)
BEGIN
	UPDATE ingredients
	set  status=0
	where id_ingredient=id_i;
END$$
	-- actualizar links de redes sociales
DROP PROCEDURE IF EXISTS `deleteStatusSocialNetwork`$$
CREATE PROCEDURE deleteStatusSocialNetwork(
	IN id_link_ INT
	)
BEGIN
	UPDATE link_social_network_blog
	set  status=0
	where id_link=id_link_;
END$$

	-- actualizar ingredientes
DROP PROCEDURE IF EXISTS `deleteStatusRecipe`$$
CREATE PROCEDURE deleteStatusRecipe(
	IN id_recipe_ INT
	)
BEGIN
	UPDATE recipe
	set  status=0
	where id_recipe=id_recipe_;
END$$
DROP PROCEDURE IF EXISTS `deleteStatusBlog`$$
CREATE PROCEDURE deleteStatusBlog(
	IN id_blog_ int,
	IN id_user_ int
)
BEGIN
	UPDATE blog
	set  status=0
	where id_blog=id_blog_ and id_user=id_user_;
END$$

DROP PROCEDURE IF EXISTS `deleteStatusBlogbyROL`$$
CREATE PROCEDURE deleteStatusBlogbyROL(
	IN id_blog_ int
)
BEGIN
	UPDATE blog
	set  status=0
	where id_blog=id_blog_ ;
END$$
-- comida
DROP PROCEDURE IF EXISTS `deleteStatusFoodMenu`$$
CREATE PROCEDURE deleteStatusFoodMenu(
	IN id_food_control INT
	)
BEGIN
	UPDATE foodControl
	set status=0
	where id_control=id_food_control;
END$$




DELIMITER $$

-- INSERTS
	-- insertar usuario
DROP PROCEDURE IF EXISTS `insertUser`$$
CREATE PROCEDURE insertUser(
	IN usname VARCHAR(20),
	IN name VARCHAR(20),
	IN lastname VARCHAR(20),
	IN psswd VARCHAR(20),
	IN phone VARCHAR(11),
	IN idtypeus INT
	)
BEGIN
	INSERT INTO 
		user_(username, name_user, last_name, password, phone_number, id_TypeUser,date_create) 
	values
		(usname,name,lastname,psswd,phone,idtypeus,now());
END$$

	-- insertar evento
DROP PROCEDURE IF EXISTS `insertEvent`$$
CREATE PROCEDURE insertEvent(
	IN affair_ VARCHAR(20),
	IN execution_date_ DATE,
	IN start_time_ int,
	IN end_time_ int,
	IN comment_ VARCHAR(40),
	IN id_user_ INT
	)
BEGIN
	INSERT INTO 
		event_( affair,execution_date, start_time, end_time, comment, id_user, creation_date) 
    VALUES 
		(affair_,execution_date_,start_time_,end_time_,comment_,id_user_,now());
END$$

	-- insertar Datos del blog
DROP PROCEDURE IF EXISTS `insertBlog`$$
CREATE PROCEDURE insertBlog(
	IN url_image_ VARCHAR(70),
	IN name_ VARCHAR(40),
	IN preparation_ VARCHAR(900),

	IN id_user_ INT
	)
BEGIN
	-- insertar datos de las recetas
	INSERT INTO recipe( url_image, name, preparation)
	values(url_image_,name_,preparation_);
		
	INSERT INTO blog( id_user,id_recipe,creation_date)
    values(id_user_,(SELECT MAX(id_recipe) FROM recipe) ,now());
END$$

-- insertar ingredientes
DROP PROCEDURE IF EXISTS `insertIngredient`$$
CREATE PROCEDURE insertIngredient(
	IN name_ingredient_ VARCHAR(900),
	IN id_recipe_ INT
)
BEGIN
    INSERT INTO ingredients( name_ingredient , id_recipe )
    values( name_ingredient_, id_recipe_);
END$$

-- insertar links de redes sociales
DROP PROCEDURE IF EXISTS `insertSocialNetwork`$$
CREATE PROCEDURE insertSocialNetwork(
	IN link_ VARCHAR(800),
	IN id_socialNetwork_ INT,
	IN id_blog_ int
)
BEGIN
    INSERT INTO link_social_network_blog( link, id_socialNetwork , id_blog)
    values(link_, id_socialNetwork_, id_blog_);
END$$



-- Menu diario 

DROP PROCEDURE IF EXISTS `insertDailyMenu`$$
CREATE PROCEDURE insertDailyMenu()
BEGIN
	DECLARE menu_diario_id int;
	set menu_diario_id=0;
	SELECT id_menu into menu_diario_id from DailyMenu where date_create=CURDATE() and status =1; 
	if menu_diario_id = 0 THEN
    	INSERT INTO DailyMenu(date_create) values(now());
		SELECT id_menu into menu_diario_id from DailyMenu where date_create=CURDATE() and status =1; 
	end if;
	SELECT menu_diario_id;
END$$


DROP PROCEDURE IF EXISTS `insertFood`$$
CREATE PROCEDURE insertFood(
	IN name_food_ varchar(50),
	IN description_food_ varchar(150),
	IN price_ decimal(5,2),
	IN id_ctgfood_ INT,
	IN id_type_food_ int,
	IN id_schedule_ INT,
	IN id_admin_ int,
	IN id_menu_ int
)
BEGIN

    INSERT INTO Food( name_food, description_food , price, id_ctgfood)
    values(name_food_, description_food_, price_,id_ctgfood_);
	
	INSERT INTO foodControl( id_TypeFood, id_schedule, id_admin,id_menu,id_food ) 
	VALUES(id_type_food_, id_schedule_, id_admin_, 
		id_menu_,
		(SELECT MAX(id_food) FROM Food) );
	select MAX(id_control) as id_control FROM foodControl;
END$$

DELIMITER $$
-- Query
DROP PROCEDURE IF EXISTS `getTypeUser`$$
-- obtener usuario después de verificar
CREATE PROCEDURE getTypeUser()
BEGIN
    select *
        from TypeUser
        where status=1;
END$$
DROP PROCEDURE IF EXISTS `getTypeUserForId`$$
CREATE PROCEDURE getTypeUserForId(IN id_t int)
BEGIN
    select *
        from TypeUser
        where status=1 and id_TypeUser=id_t;
END$$
DROP PROCEDURE IF EXISTS `getUserCheck`$$
-- obtener usuario después de verificar
CREATE PROCEDURE getUserCheck(IN usname VARCHAR(20),IN psswd VARCHAR(20))
BEGIN
    select id_user, username,name_user, last_name, phone_number,date_create,t.id_TypeUser, t.name_TypeUser, g.name_gender, g.id_gender 
    	from user_ as u
        inner join typeuser as t on u.id_TypeUser= t.id_TypeUser
        inner join gender as g on u.gender = g.id_gender
    	where u.status=1 and username=usname and password=psswd;
END$$


-- obtener datos básicos del usuario por id
DROP PROCEDURE IF EXISTS `getUserForId`$$
CREATE PROCEDURE getUserForId(IN id int)
BEGIN
    select id_user,username,name_user,last_name,phone_number,id_TypeUser
    	from user_
    	where status=1 and id_user=id;
END$$


-- obtener todos los eventos
DROP PROCEDURE IF EXISTS `getEventAll`$$
CREATE PROCEDURE getEventAll()
BEGIN
    select evt.id_event, evt.affair,evt.creation_date ,
    	evt.execution_date,evt.start_time, evt.end_time, evt.is_accepted,
    	evt.comment, us.username,us.name_user,us.last_name
    	from event_ as evt 
    	inner join user_ as us on us.id_user=evt.id_user where evt.status=1;
END$$

-- obtener evento por id y valor de asunto
DROP PROCEDURE IF EXISTS `getEventAllByValue`$$
CREATE PROCEDURE getEventAllByValue(IN value_ varchar(40))
BEGIN
    select evt.id_event, evt.affair,evt.creation_date , evt.is_accepted,
    	evt.execution_date,evt.start_time, evt.end_time,
    	evt.comment, us.username, us.name_user,us.last_name
    	from event_ as evt 
        inner join user_ us on us.id_user=evt.id_user
    	where evt.status=1 and (evt.affair like CONCAT('%', value_,'%') or execution_date LIKE concat("%",value_,"%"));
END$$

-- obtener evento por id y valor de asunto
DROP PROCEDURE IF EXISTS `getEventByIdUsByValue`$$
CREATE PROCEDURE getEventByIdUsByValue(IN id_user int, IN value_ varchar(40))
BEGIN
    select evt.id_event, evt.affair,evt.creation_date , evt.is_accepted,
    	evt.execution_date,evt.start_time, evt.end_time,
    	evt.comment, us.username, us.name_user,us.last_name
    	from event_ as evt 
        inner join user_ us on us.id_user=evt.id_user
    	where evt.status=1 and evt.id_user=id_user and evt.affair like CONCAT('%', value_,'%');
END$$
-- obtener evento por id
DROP PROCEDURE IF EXISTS `getEventById`$$
CREATE PROCEDURE getEventById(IN id_e int)
BEGIN
    select evt.id_event, evt.affair,evt.creation_date ,
    	evt.execution_date,evt.start_time, evt.end_time, evt.is_accepted,
    	evt.comment, us.username,us.name_user,us.last_name,us.id_user
        from event_ as evt 
    inner join user_ as us on us.id_user=evt.id_user
        where evt.status=1 and evt.id_event=id_e;
END$$


-- verificar dueño del evento por id de evento y id de dueño
DROP PROCEDURE IF EXISTS `getEventByIdEvtForUser`$$
CREATE PROCEDURE getEventByIdEvtForUser(IN id_e int,IN id_us int)
BEGIN
    select *
        from event_ as evt 
        where evt.status=1 and evt.id_event=id_e and evt.id_user=id_us;
END$$
-- obtener los eventos por usuario
DROP PROCEDURE IF EXISTS `getEventByIdUser`$$
CREATE PROCEDURE getEventByIdUser(IN id_user INT)
BEGIN
    select evt.id_event, evt.affair,evt.creation_date , evt.is_accepted,
    	evt.execution_date,evt.start_time, evt.end_time,
    	evt.comment, us.username, us.name_user,us.last_name
    	from event_ as evt 
        inner join user_ us on us.id_user=evt.id_user
    	where evt.status=1 and evt.id_user=id_user;
END$$

-- Obtener evento por fecha
DROP PROCEDURE IF EXISTS `getEventForDate`$$
CREATE PROCEDURE getEventForDate(IN _date DATE, IN hour_in int, IN hour_out int)
BEGIN
    select evt.id_event, evt.affair,evt.creation_date , evt.is_accepted,
    	evt.execution_date,evt.start_time, evt.end_time,
    	evt.comment
    	from event_ as evt 
    	where 
            evt.status=1 and _date=evt.execution_date 
            and (
                    (hour_in>=evt.start_time and hour_out<=evt.end_time)
                    or
                    (hour_in<=evt.start_time and hour_out>=evt.end_time)
                )
            ;
END$$


-- obtener todos los datos del blog



DROP PROCEDURE IF EXISTS `getIngredients`$$

CREATE PROCEDURE getIngredients(IN recipe_id int)
BEGIN
    select  *
    	from ingredients 
    	where id_recipe=recipe_id and status=1;
END$$


-- obtener los tipos de redes sociales
DROP PROCEDURE IF EXISTS `getTypeSocialNetwork`$$
CREATE PROCEDURE getTypeSocialNetwork()
BEGIN
    select  *
    	from TypeSocialNetwork 
    	where status=1;
END$$

-- obtener redes sociales por blog
DROP PROCEDURE IF EXISTS `getlink_social_network_blog`$$
CREATE PROCEDURE getlink_social_network_blog(IN blog_id int)
BEGIN
    select  ls.id_link, ls.link, ls.id_blog, 
        ts.id_socialNetwork ,ts.name_socialNetwork, ts.name_class
    	from link_social_network_blog  as ls
        inner join TypeSocialNetwork as ts on ls.id_socialNetwork = ts.id_socialNetwork
    	where id_blog=blog_id and ls.status=1;
END$$

DROP PROCEDURE IF EXISTS `getAllDataBlog`$$
CREATE PROCEDURE getAllDataBlog()
BEGIN
    select b.id_blog,b.creation_date,b.destacado,
            u.id_user, u.username, u.name_user,u.last_name, 
    		r.id_recipe, r.url_image, r.name, r.preparation
    	from blog as b 
		inner join user_ as u on u.id_user=b.id_user 
		inner join recipe as r on b.id_recipe=r.id_recipe
    	where b.status=1 and r.status=1 ;
END$$

-- obtener todos los datos del blog de un usuario
DROP PROCEDURE IF EXISTS `getAllDataBlogForUser`$$
CREATE PROCEDURE getAllDataBlogForUser(
	IN id_user_ int
)
BEGIN
    select  b.id_blog,b.creation_date,b.destacado,
            u.id_user, u.username, u.name_user,u.last_name, 
    		r.id_recipe, r.url_image, r.name, r.preparation
    	from blog as b 
		inner join user_ as u on u.id_user=b.id_user 
		inner join recipe as r on b.id_recipe=r.id_recipe
    	where b.status=1 and b.id_user=id_user_;
END$$

-- obtener todos los datos del blog por id del blog verificado por id del usuario
DROP PROCEDURE IF EXISTS `getBlogForIdCheck`$$
CREATE PROCEDURE getBlogForIdCheck(
    IN id_blog_ int,
	IN id_user_ int
)
BEGIN
    select  b.id_blog,b.creation_date,b.destacado,
            u.id_user, u.username, u.name_user,u.last_name, 
    		r.id_recipe, r.url_image, r.name, r.preparation
    	from blog as b 
		inner join user_ as u on u.id_user=b.id_user 
		inner join recipe as r on b.id_recipe=r.id_recipe
    	where b.status=1 and b.id_user=id_user_ 
        and b.id_blog = id_blog_;
END$$


-- obtener todos los datos del blog por id del blog
DROP PROCEDURE IF EXISTS `getBlogForId`$$
CREATE PROCEDURE getBlogForId(
    IN id_blog_ int
)
BEGIN
    select  b.id_blog,b.creation_date,b.destacado,
            u.id_user, u.username, u.name_user,u.last_name, 
    		r.id_recipe, r.url_image, r.name, r.preparation
    	from blog as b 
		inner join user_ as u on u.id_user=b.id_user 
		inner join recipe as r on b.id_recipe=r.id_recipe
    	where b.status=1 and b.id_blog = id_blog_;
END$$
-- obtener id de la última receta guardada

DROP PROCEDURE IF EXISTS `getIdLastRecipe`$$
CREATE PROCEDURE getIdLastRecipe()
BEGIN
    SELECT MAX(id_recipe) as id_recipe FROM recipe;
END$$

-- obtener id del último blog guardado

DROP PROCEDURE IF EXISTS `getIdLastBlog`$$
CREATE PROCEDURE getIdLastBlog()
BEGIN
    SELECT MAX(id_blog) as id_blog FROM blog;
END$$
-- Menu diario

DROP PROCEDURE IF EXISTS `getSchedule`$$
CREATE PROCEDURE getSchedule()
BEGIN
    select * from schedule where status=1;
END$$
-- CATEGORIA DE COMIDA
DROP PROCEDURE IF EXISTS `getCtgFood`$$
CREATE PROCEDURE getCtgFood()
BEGIN
    select * from CtgFood where status=1;
END$$
-- TIPO DE COMIDA
DROP PROCEDURE IF EXISTS `getTypeFood`$$
CREATE PROCEDURE getTypeFood()
BEGIN
    select * from typefood where status=1;
END$$



-- COMIDA
DROP PROCEDURE IF EXISTS `getFood`$$
CREATE PROCEDURE getFood(
    in id_menu_ int
)
BEGIN
    select fc.id_control,
        tf.id_TypeFood,tf.name_TypeFood,
        sch.id_schedule, sch.name_schedule,
        us.id_user, us.username, us.name_user, us.last_name,
        f.id_food, f.name_food, f.description_food, f.price,
        ctg.id_ctgfood, ctg.name_ctgfood
    from foodcontrol as fc
        
    inner join typefood as tf on tf.id_TypeFood=fc.id_TypeFood
    inner join schedule as sch on sch.id_schedule=fc.id_schedule
    inner join user_ as us on us.id_user=fc.id_admin
    inner join food as f on fc.id_food = f.id_food
    inner join ctgfood as ctg on ctg.id_ctgfood=f.id_ctgfood
    where fc.id_menu = id_menu_;
END$$
-- 
DROP PROCEDURE IF EXISTS `getFoodForID`$$
CREATE PROCEDURE getFoodForID(
    in id_fc int
)
BEGIN
    select fc.id_control,
        tf.id_TypeFood,tf.name_TypeFood,
        sch.id_schedule, sch.name_schedule,
        us.id_user, us.username, us.name_user, us.last_name,
        f.id_food, f.name_food, f.description_food, f.price,
        ctg.id_ctgfood, ctg.name_ctgfood
    from foodcontrol as fc
        
    inner join typefood as tf on tf.id_TypeFood=fc.id_TypeFood
    inner join schedule as sch on sch.id_schedule=fc.id_schedule
    inner join user_ as us on us.id_user=fc.id_admin
    inner join food as f on fc.id_food = f.id_food
    inner join ctgfood as ctg on ctg.id_ctgfood=f.id_ctgfood
    where fc.id_control = id_fc;
END$$

-- check

DROP PROCEDURE IF EXISTS `checkUserForPostAndDate`$$
CREATE PROCEDURE checkUserForPostAndDate(
    IN id_admin_ int,
    IN id_foodc int
)
BEGIN
    select *
        from foodcontrol as fc
        inner join dailymenu as d on d.id_menu=fc.id_menu
        where fc.id_admin=id_admin_ and d.date_create=CURDATE() and fc.id_control=id_foodc;
END$$


DROP PROCEDURE IF EXISTS `getAllDailyMenuFood`$$
CREATE PROCEDURE getAllDailyMenuFood()
BEGIN
    select *
        from DailyMenu 
        where status=1
        ;
END$$


DROP PROCEDURE IF EXISTS `getAllDailyMenuForId`$$
CREATE PROCEDURE getAllDailyMenuForId(IN id_m int)
BEGIN
    select *
        from DailyMenu 
        where status=1 and id_menu=id_m;
END$$

DELIMITER $$

-- UPDATES
 -- ACTUALIZAR USUARIO
DROP PROCEDURE IF EXISTS `updateUser`$$
CREATE PROCEDURE updateUser(
	IN iduser INT,
	IN usname VARCHAR(20),
	IN name VARCHAR(20),
	IN lastname VARCHAR(20),
	IN psswd VARCHAR(20),
	IN phone VARCHAR(11)
	
	)
BEGIN
	UPDATE user_
	set  username=usname, name_user=name, last_name=lastname
		, password=psswd, phone_number=phone where id_user=iduser;
END$$
-- actualizar evento
DROP PROCEDURE IF EXISTS `updateEvent`$$
CREATE PROCEDURE updateEvent(
		IN idevt int,
		IN affair_ VARCHAR( 20 ),
		IN execution_date_ DATE,
		IN start_time_ int,
		IN end_time_ int,
		IN comment_ VARCHAR(40),
		IN id_user_ INT
	)
BEGIN
	UPDATE event_
	set  affair=affair_, execution_date=execution_date_, start_time=start_time_
		, end_time=end_time_, comment=comment_ 
	where id_event=idevt and id_user=id_user_;
END$$

-- accept event
DROP PROCEDURE IF EXISTS `acceptEvent`$$
CREATE PROCEDURE acceptEvent(
		IN id_evt int
	)
BEGIN
	UPDATE event_
	set  is_accepted=1 
	where id_event=id_evt;
END$$

-- actualizar Blog
DROP PROCEDURE IF EXISTS `updateBlogDescatacado`$$
CREATE PROCEDURE updateBlogDescatacado(
		IN idblog int
	)
BEGIN
	DECLARE statusDestacado int;
	set statusDestacado=0;
	SELECT destacado into statusDestacado from blog where  id_blog=idblog;

	IF statusDestacado=0 THEN
		UPDATE blog
		set  destacado=1
		where id_blog=idblog;
	END IF;
	IF statusDestacado=1 THEN
		UPDATE blog
		set  destacado=0
		where id_blog=idblog;
	end if;
END$$	

	-- actualizar ingredientes
DROP PROCEDURE IF EXISTS `updateIngredient`$$
CREATE PROCEDURE updateIngredient(
		IN id_i int,
		IN ingr VARCHAR(20)
	)
BEGIN
	UPDATE ingredients
	set  name_ingredient=ingr
	where id_ingredient=id_i;
END$$
	-- actualizar links de redes sociales
DROP PROCEDURE IF EXISTS `updateSocialNetwork`$$
CREATE PROCEDURE updateSocialNetwork(
	IN id_link_ INT,
	IN link_ VARCHAR(800),
	IN id_socialNetwork_ INT
	)
BEGIN
	UPDATE link_social_network_blog
	set  link=link_, id_socialNetwork=id_socialNetwork_
	where id_link=id_link_;
END$$

	-- actualizar ingredientes
DROP PROCEDURE IF EXISTS `updateRecipe`$$
CREATE PROCEDURE updateRecipe(
	IN id_recipe_ INT,
	IN url_image_ VARCHAR(70),
	IN name_ VARCHAR(40),
	IN preparation_ VARCHAR(900)
	)
BEGIN
	UPDATE recipe
	set  url_image=url_image_, name=name_, preparation=preparation_
	where id_recipe=id_recipe_;
END$$


DROP PROCEDURE IF EXISTS `updateFood`$$
CREATE PROCEDURE updateFood(
	IN id_food_ int,
	IN id_Control_ int,
	IN name_food_ varchar(50),
	IN description_food_ varchar(150),
	IN price_ decimal(5,2),
	IN id_ctgfood_ INT,
	IN id_type_food_ int,
	IN id_schedule_ INT
)
BEGIN

	UPDATE Food
	set  name_food=name_food_, description_food=description_food_, 
		price=price_, id_ctgfood=id_ctgfood_
	where id_food=id_food_;
	UPDATE foodControl
	SET id_TypeFood=id_type_food_, id_schedule=id_schedule_
	where id_control=id_Control_;
END$$
DELIMITER ;





-- TABLAS


-- tabla del tipo de usuario
CREATE TABLE TypeUser(
    id_TypeUser int AUTO_INCREMENT,
    name_TypeUser varchar(15) not null,
    status int DEFAULT 1,
    PRIMARY KEY (id_TypeUser)
);
-- insercion de 3 tipos de usuarios
INSERT INTO TypeUser(id_TypeUser, name_TypeUser) VALUES (101,'admin'),(102,'cliente'), (303,'Moderador');

CREATE TABLE gender(
    id_gender int AUTO_INCREMENT,
    name_gender varchar(20) not null,
    status int DEFAULT 1,
    PRIMARY KEY (id_gender)
);
insert into gender values(1,"masculino",1) , (2,"femenino",1);
-- tabla de usuario
CREATE TABLE user_(
    id_user int AUTO_INCREMENT,
    username varchar(30) not null,
    name_user varchar(20) not null,
    last_name varchar(20) not null,
    password varchar(20) not null,
    phone_number varchar(11),
    date_create date not null,
    id_TypeUser int not null,
    gender int not null,
    status int DEFAULT 1,
    PRIMARY KEY (id_user),
    FOREIGN KEY (id_TypeUser) REFERENCES TypeUser(id_TypeUser),
    FOREIGN KEY (gender) REFERENCES gender(id_gender)
);
-- insercion de 6 usuarios
INSERT INTO user_(id_user, username, name_user, last_name, password, phone_number, id_TypeUser,date_create,gender)
    VALUES 
        (1,'tnx',"tnx nx","last name","tnx","",101,'2019-06-27',1),
        (2,'edw','Edward', "Reyes","edw01","",102,'2019-06-27',1),
        (3,'lozado','Cristian', "Lozado","lozado","",102,'2019-06-27',1),
        (4,'kelvin','Kelvin', "Castro","kelvin","",102,'2019-06-27',1),
        (5,'admin','admin', "ADMIN","admin","",101,'2019-06-27',1),
        (6,"moderador","moderador","moderador","moderador","",303,'2019-06-27',1),
        (7,'Ka','Pi', "Kar","Piv","",101,'2019-06-27',2);


CREATE TABLE event_(
    id_event int AUTO_INCREMENT,
    affair varchar(20) not null, -- asunto
    creation_date DATE not null ,
    execution_date DATE not null,
    start_time int not null,
    end_time int not null,
    comment varchar(70),
    id_user int not null,
    is_accepted int DEFAULT 0,
    status int DEFAULT 1,
    PRIMARY KEY (id_event),
    FOREIGN KEY (id_user) REFERENCES user_(id_user)
);

-- insercion de 3 eventos
INSERT INTO event_(id_event, affair,creation_date,execution_date, start_time, end_time, comment, id_user) 
    VALUES 
        (1,'Asunto evento 1','2019-06-27','2019-07-27', 9 ,11,"ningun comentario",2),
        (2,'Asunto evento 2','2019-06-27','2019-07-27',13,15,"comentario",2),
        (3,'Asunto evento 3','2019-06-27','2019-07-27',15,17,"comentario",3);





-- tabla de recetas
create table recipe(
    id_recipe int AUTO_INCREMENT,
    url_image varchar(70) NOT null,
    name varchar(40) not null,
    preparation varchar(900) not null,
    status int DEFAULT 1,
    PRIMARY KEY (id_recipe)
);
-- insertar datos de las recetas
INSERT INTO recipe(id_recipe, url_image, name, preparation)
    values (1,"assets/img/blog/encebollado.jpg","Encebollado de pescado",
        "Prepare un refrito con la cebolla, el tomate, al comino, el aji y la sal.\n
        Añada el agua y las ramitas de cilantro.\n
        Añada el atún cuando el agua empiece a hervir, cocine hasta que el atún esté listo, aproximadamente unos 15 minutos.\n
        Cierna el caldo donde se cocinó el agua y guárdelo para cocinar la yuca.\n
        Separe el atún en lonjas, guarde para añadir más tarde.\n
        Separe el atún en lonjas, guarde para añadir más tarde.\n
        Saque las yucas y córtelos en pedazos pequeños.\n
        Vuelva a poner las yucas picadas y las lonjas de atún en el caldo, rectifique la sal y caliente hasta que esté listo para servir. Para darle más sabor, también se puede preparar una porción adicional de refrito y licuarlo con un poco del caldo, e incorporar esta mezcla a la sopa.\n
        Para servir el encebollado de pescado se pone una buena porción del curtido de cebolla y tomate encima de cada plato de sopa."),
    (2,"assets/img/pictures/menu/menu_2.jpg","Receta","La preparacion de esta receta es...."),
    (3,"assets/img/pictures/menu/menu_3.jpg","Receta","La preparacion de esta receta es....");


-- tabla de blogs
create table blog(
    id_blog int AUTO_INCREMENT,
    creation_date DATE  ,
    id_user int not null,
    id_recipe int not null,
    destacado int DEFAULT 0,
    status int DEFAULT 1,
    PRIMARY KEY (id_blog),
    FOREIGN KEY (id_user) REFERENCES user_(id_user),
    FOREIGN KEY (id_recipe) REFERENCES recipe(id_recipe)
);

-- insertar datos del blog 
INSERT INTO blog(id_blog, creation_date, id_user,id_recipe)
    values(1,"2019-07-27",2,1),(2,"2019-07-27",3,2),(3,"2019-07-27",2,3);

-- tabla del tipo de red social
CREATE TABLE TypeSocialNetwork(
    id_socialNetwork int AUTO_INCREMENT,
    name_socialNetwork varchar(25) not null,
    name_class varchar(40) not null,
    status int DEFAULT 1,
    PRIMARY KEY (id_socialNetwork)
);
-- insercion de 3 redes sociales
INSERT INTO TypeSocialNetwork(id_socialNetwork, name_socialNetwork,name_class) 
    VALUES 
        (70,"FACEBOOK","fab fa-facebook-f"),
        (71,"TWITTER","fab fa-twitter"),
        (72,"PINTEREST","fab fa-pinterest"),
        (73,"INSTAGRAM","fab fa-instagram");



-- tabla link_social_network_blog
CREATE TABLE link_social_network_blog(
    id_link int AUTO_INCREMENT,
    link varchar(1000) not null,
    id_socialNetwork int not null,
    id_blog int not null,
    status int DEFAULT 1,
    PRIMARY KEY (id_link),
    FOREIGN KEY (id_socialNetwork) REFERENCES TypeSocialNetwork(id_socialNetwork),
    FOREIGN KEY (id_blog) REFERENCES blog(id_blog)
);
INSERT INTO link_social_network_blog(id_link, link, id_socialNetwork, id_blog)
    values (1,"https://www.facebook.com/",70,1),
    (2,"https://www.instagram.com/",73,1),
    (3,"https://www.facebook.com/",71,2),
    (4,"https://www.instagram.com/",73,2),
    (5,"https://www.pinterest.com/",72,2),
    (6,"https://www.twitter.com/",71,3),
    (7,"https://www.pinteres.com/",72,3);


-- tabla de ingredientes
CREATE TABLE ingredients(
	id_ingredient int AUTO_INCREMENT,
    name_ingredient varchar(70) not null,
    id_recipe int not null,
    status int DEFAULT 1,
    PRIMARY KEY (id_ingredient),
    FOREIGN KEY (id_recipe) REFERENCES recipe(id_recipe)
);
INSERT INTO ingredients(id_ingredient, name_ingredient,id_recipe ) 
    values(1,"2 libras de atún fresco",1),(2,"1 libra de yuca fresca o congelada",1),
    (3,"2 cucharadas de aceite",1),(4,"2 tomates picados",1),(5,"½ cebolla picada",1),
    (6,"1 cucharadita de aji no picante en polvo se puede usar pimentón molido",1),
    (7,"2 cucharaditas de comino molido",1),(8,"8 tazas de agua",1),
    (9,"5 ramitas de cilantro o culantro",1),(10,"Sal al gusto",1),
    (11,"Ingrediente",2),(12,"Ingrediente",2),(13,"Ingrediente",2),(14,"Ingrediente",2),
    (15,"Ingrediente",3),(16,"Ingrediente",3),(17,"Ingrediente",3),(18,"Ingrediente",3);

-- ----------------
-- tabla de horarios
CREATE TABLE schedule(
    id_schedule int AUTO_INCREMENT,
    name_schedule varchar(70) not null,
    name_icon varchar(20) not null,
    status int DEFAULT 1,
    PRIMARY KEY (id_schedule)
);

INSERT INTO schedule(id_schedule,name_schedule,name_icon) values(30,"MAÑANA","fas fa-mug-hot"),(31,"TARDE","fas fa-utensils");


-- TABLA DE LA CATEGORIA DE COMIDA
CREATE TABLE CtgFood(
    id_ctgfood int AUTO_INCREMENT,
    name_ctgfood varchar(70) not null,
    status int DEFAULT 1,
    PRIMARY KEY (id_ctgfood)
);

INSERT INTO CtgFood(id_ctgfood,name_ctgfood) 
    values(1,"ENSALADA"),(2,"DIETA"),(3,"PROTEINA"),(4,"LIQUIDO"),(5,"OTROS");



-- TABLA DE TIPO DE COMIDA
CREATE TABLE TypeFood(
    id_TypeFood int AUTO_INCREMENT,
    name_TypeFood varchar(70) not null,
    status int DEFAULT 1,
    PRIMARY KEY (id_TypeFood)
);

INSERT INTO TypeFood(id_TypeFood,name_TypeFood) 
    values(10,"PARA EMPEZAR"),(11,"SEGUNDO"),(12,"POSTRE"),(13,"TODO");

-- TABLA DEL MENU DE COMIDA
CREATE TABLE DailyMenu(
    id_menu int AUTO_INCREMENT,
    date_create DATE ,
    status int DEFAULT 1,
    PRIMARY KEY (id_menu)
    
);
INSERT INTO DailyMenu(id_menu, date_create) 
    values(1,"2019-07-07"),(2,"2019-08-7"),(3,"2019-08-09"),(4,"2019-08-09");
-- Tabla de comidas del menú

CREATE TABLE Food(
    id_food int AUTO_INCREMENT,
    name_food varchar(50) not null,
    description_food varchar(200) not null,
    price decimal(5,2) not null,
    id_ctgfood int not null,

    PRIMARY KEY (id_food),
    FOREIGN KEY (id_ctgfood) REFERENCES CtgFood(id_ctgfood)
);

INSERT INTO Food(id_food, name_food, description_food, price, id_ctgfood) 
    VALUES (1,"Arroz con pollo","Pruebe el arroz con pollo",1.25,5 ),
    (2,"Desayuno","Ensalada de frutas + yogurt + granola",1.25,5 ),
    (3,"Postre","Postre",1.25,5 ),
    (4,"Sopa","Sopa de mariscos",2.25,5 ),
    (5,"Desayuno","Tostada + café",1.25,5 ),
    (6,"Postre","Postre 2",5.25,5 ),
    (7,"Tigrillo","desc 6",6.25,5 ),
    (8,"MARISCOS","Arroz marinero",1.25,4 ),
    (9,"Encebollado + arroz","desc 8o",7,5 ),
    (10,"Bolón + café","desc 9",2.50,5 );

CREATE TABLE foodControl(
    id_control int AUTO_INCREMENT,
    id_TypeFood int not null,
    id_schedule int not null,
    id_admin int not null,
    id_menu int not null,
    id_food int not null,
    PRIMARY KEY (id_control),
    FOREIGN KEY (id_TypeFood) REFERENCES TypeFood(id_TypeFood),
    FOREIGN KEY (id_schedule) REFERENCES schedule(id_schedule),
    FOREIGN KEY (id_admin) REFERENCES user_(id_user),
    FOREIGN KEY (id_menu) REFERENCES DailyMenu(id_menu),
    FOREIGN KEY (id_food) REFERENCES Food(id_food)
);


INSERT INTO foodControl( id_control, id_TypeFood, id_schedule, id_admin,id_menu,id_food ) 
VALUES (1, 11,30 , 1,1 ,1),
    (2,12 ,31 , 1,1 ,2),
    (3, 10, 31, 1,2 ,3),
    (4, 13 , 31, 5,2 ,4),
    (5,11 , 31, 5, 2,5),
    (6,12 , 31, 5,3 ,6),
    (7, 11, 31, 5,3 ,7),
    (8, 10, 31, 1, 3,8),
    (9,11 , 30, 1,4 ,9),
    (10, 13,30 , 5, 4,10);

