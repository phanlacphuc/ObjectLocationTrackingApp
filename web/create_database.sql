CREATE TABLE IF NOT EXISTS data (
  id int(11) NOT NULL AUTO_INCREMENT,
  object_id int(11) NOT NULL,
  latitude double NOT NULL,
  longitude double NOT NULL,
  time_stamp TIME NOT NULL,
  distance double NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;