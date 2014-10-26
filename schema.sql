use test;
create table raptor_data (
sample_id INTEGER,
light_name VARCHAR(1000), 
state VARCHAR(1000), 
color1 VARCHAR(1000),
color2 VARCHAR(1000),
time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP table raptor_data;

select count(*) from raptor_data;

SELECT hour(time_stamp)  FROM raptor_data;

select * from raptor_data;

SELECT light_name, state, color1, color2, time_stamp FROM raptor_data where sample_id = 2;